<?php

namespace App\Http\Controllers;

use App\Models\Ortu;
use App\Models\Siswa;
use App\Http\Resources\Siswas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jurusan = $request->query("jurusan_id");
        $siswa = !$jurusan ? Siswa::query()->with("ortu")->with('jurusan')->get() : Siswa::query()->with('ortu')->with('jurusan')->where("jurusan_id", $jurusan)->get();

        return Siswas::collection($siswa);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return response()->json("miau");
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
            "jurusan_id" => "required"
        ]);

        $ortu = Ortu::create([
            'no_telepon' => $request->no_telepon_ortu,
            "nama_ayah" => $request->nama_ayah,
            "nama_ibu" => $request->nama_ibu,
            "pekerjaan_ayah" => $request->pekerjaan_ayah,
            "pekerjaan_ibu" => $request->pekerjaan_ibu,
        ]);

        Siswa::create([
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
}
