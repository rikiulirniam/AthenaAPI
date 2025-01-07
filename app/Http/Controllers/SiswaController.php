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
    public function index()
    {
        $siswa = Siswa::query()->with("ortu")->with('jurusan')->get();
        return Siswas::collection($siswa);
        // return response()->json(['message' => "Success", "data" => $siswa]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::validate($request->all(), [
            'nama' => "required|min:1",
            "nisn" => "required|numeric|min:10|max:10",
            "nik" => "required|numeric|min:16|max:16",
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

        function insertingNewStudent($r)
        {
            Siswa::create([
                'nama' => $r->nama,
                "nisn" => $r->nisn,
                "nik" => $r->nik,
                'tempat_lahir' => $r->tempat_lahir,
                "tanggal_lahir" => $r->tanggal_lahir,
                "jenis_kelamin" => $r->jenis_kelamin,
                "agama" => $r->agama,
                "alamat_lengkap" => $r->alamat_lengkap,
                "no_telepon" => $r->no_telepon,
                "asal_sekolah" => $r->asal_sekolah,
                "jurusan_id" => $r->jurusan_id
            ]);

            Ortu::create([
                'no_telepon_ortu' => "required|string|min:12|regex:/^08\d{8,}$/",
                "nama_ayah" => "required|string|min:2|max:255",
                "nama_ibu" => "required|string|min:2|max:255",
                "pekerjaan_ayah" => "required|string|min:4|max:255",
                "pekerjaan_ibu" => "required|string|min:4|max:255",
            ]);
        }

        insertingNewStudent($request->all());

        return response()->json(['message' => "Data Created"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        //
    }
}
