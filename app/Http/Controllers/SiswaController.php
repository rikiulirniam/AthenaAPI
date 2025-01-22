<?php

namespace App\Http\Controllers;

use App\Models\Ortu;
use App\Models\Siswa;
use App\Http\Resources\Siswas;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.x
     */
    public function index(Request $request)
    {
        $startIn = $request->query("startIn", 0);
        $length = $request->query("length", 10);
        $jurusan = $request->query("jurusan_id");
        $sort = $request->query("sort", "asc");
        $search = $request->query("search");

        $query = Siswa::query()->with(['ortu', 'jurusan']);

        if ($jurusan) {
            $query->where('jurusan_id', $jurusan);
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $query->orderBy('created_at', $sort === "desc" ? 'desc' : 'asc');
        $siswa = $query->skip($startIn)->take($length)->get();

        return Siswas::collection($siswa);
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        // Validasi data
        Validator::validate($request->all(), [
            'name' => "required|min:1",
            "nisn" => "required|string|size:10|unique:siswas,nisn",
            "nik" => "required|string|size:16|unique:siswas,nik",
            'tempat_lahir' => "required|string|min:3|max:255",
            "tanggal_lahir" => "required|date",
            "jenis_kelamin" => "required|boolean",
            "agama" => "required|string|min:4|max:255",
            "alamat_lengkap" => "required|string|max:255",
            "no_telepon" => "required|string|min:12|regex:/^08\d{8,}$/",
            'no_telepon_ortu' => "required|string|min:12|regex:/^08\d{8,}$/",
            "nama_ayah" => "required|string|min:2|max:255",
            "nama_ibu" => "required|string|min:2|max:255",
            "pekerjaan_ayah" => "required|string|min:4|max:255",
            "pekerjaan_ibu" => "required|string|min:4|max:255",
            "asal_sekolah" => "required|string|min:4|max:255",
            "jurusan_id" => "required",
            "email" => "required|email"
        ]);

        $ortu = Ortu::create([
            'no_telepon' => $request->no_telepon_ortu,
            "nama_ayah" => $request->nama_ayah,
            "nama_ibu" => $request->nama_ibu,
            "pekerjaan_ayah" => $request->pekerjaan_ayah,
            "pekerjaan_ibu" => $request->pekerjaan_ibu,
        ]);

        $siswa = Siswa::create([
            'name' => $request->name,
            "nisn" => $request->nisn,
            "nik" => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            "tanggal_lahir" => $request->tanggal_lahir,
            "jenis_kelamin" => $request->jenis_kelamin,
            "agama" => $request->agama,
            "alamat_lengkap" => $request->alamat_lengkap,
            "no_telepon" => $request->no_telepon,
            "status" => false,
            "asal_sekolah" => $request->asal_sekolah,
            "jurusan_id" => $request->jurusan_id,
            "ortu_id" => $ortu->id,
        ]);

        // Membuat QR Code
        //  $builder = new Builder(
        //      writer: new PngWriter(),
        //      data: $siswa->id, // Data yang akan di-encode
        //      encoding: new Encoding('UTF-8'),
        //      errorCorrectionLevel: ErrorCorrectionLevel::High, // Level koreksi error
        //      size: 300, // Ukuran QR Code
        //      margin: 10  // Margin QR Code
        //  );

        // Bangun QR Code
        //  $result = $builder->build();

        // Simpan QR Code ke Object Storage (misalnya S3)
        //  $filePath = "qrcodes/{$siswa->id}.png";
        //  Storage::disk('public')->put($filePath, $result->getString());

        // Kirim email dengan QR Code
        try {
            //  $qrCodeUrl = Storage::disk('public')->url($filePath);
            Mail::send('emails.qr-with-view', ['number' => $siswa->id], function ($message) use ($request) {
                $message->to($request->email)->subject('QR Code Anda');
            });
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send email'], 500);
        }

        return response()->json(['message' => "Data Created"], 200);
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Siswa::find($id);
        if (!$data) {
            return response()->json([
                'message' => "Siswa tidak ditemukan",
            ], 404);
        }
        return new Siswas($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Validator::validate($request->all(), [
            'name' => "required|min:1",
            "nisn" => "required|string|size:10",
            "nik" => "required|string|size:16",
            'tempat_lahir' => "required|string|min:3|max:255",
            "tanggal_lahir" => "required|date",
            "jenis_kelamin" => "required|boolean",
            "agama" => "required|string|min:4|max:255",
            "alamat_lengkap" => "required|string|max:255",
            "no_telepon" => "required|string|min:12|regex:/^08\d{8,}$/",
            'no_telepon_ortu' => "required|string|min:12|regex:/^08\d{8,}$/",
            "nama_ayah" => "required|string|min:2|max:255",
            "nama_ibu" => "required|string|min:2|max:255",
            "pekerjaan_ayah" => "required|string|min:4|max:255",
            "pekerjaan_ibu" => "required|string|min:4|max:255",
            "asal_sekolah" => "required|string|min:4|max:255",
            "jurusan_id" => "required"
        ]);

        $siswa = Siswa::find($id);
        $ortu = Ortu::where("id", $siswa->ortu_id)->first();

        $ortu->update([
            'no_telepon' => $request->no_telepon_ortu,
            "nama_ayah" => $request->nama_ayah,
            "nama_ibu" => $request->nama_ibu,
            "pekerjaan_ayah" => $request->pekerjaan_ayah,
            "pekerjaan_ibu" => $request->pekerjaan_ibu,
        ]);

        $siswa->update([
            'name' => $request->name,
            "nisn" => $request->nisn,
            "nik" => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            "tanggal_lahir" => $request->tanggal_lahir,
            "jenis_kelamin" => $request->jenis_kelamin,
            "agama" => $request->agama,
            "alamat_lengkap" => $request->alamat_lengkap,
            "no_telepon" => $request->no_telepon,
            "asal_sekolah" => $request->asal_sekolah,
            "jurusan_id" => $request->jurusan_id,
            "ortu_id" => $ortu->id,
        ]);

        return response()->json(["message" => 'Data Updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            return response()->json([
                "message" => "Siswa not found"
            ], 404);
        }
        $siswa->delete();
        return response()->json(['message' => "Siswa deleted"]);
    }

    public function verifyEnrollment(Request $request)
    {
        Validator::validate($request->all(), [
            "id" => "required"
        ]);

        $siswa = Siswa::find($request->id);
        if (!$siswa) {
            return response()->json([
                "message" => "Siswa tidak ditemukan",
            ], 404);
        }
        if (!$siswa->status == 1) {
            return response()->json([
                "message" => "Siswa sudah terverifikasi"
            ], 422);
        }

        $siswa->update([
            "status" => true
        ]);

        return response()->json([
            "message" => "Siswa bernama $siswa->name berhasil daftar ulang!"
        ], 200);
    }
}
