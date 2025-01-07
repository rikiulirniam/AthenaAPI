<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Siswas extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "name" => $this->name,
            "nisn" => $this->nisn,
            "nik" => $this->nik,
            "tempat_lahir" => $this->tempat_lahir,
            "tanggal_lahir" => $this->tanggal_lahir,
            "jenis_kelamin" => $this->jenis_kelamin,
            "agama" => $this->agama,
            "alamat_lengkap" => $this->alamat_lengkap,
            "no_telepon" => $this->no_telepon,
            "asal_sekolah" => $this->asal_sekolah,
            "ortu" => [
                "no_telepon" => $this->ortu->no_telepon,
                "nama_ayah" => $this->ortu->nama_ayah,
                "nama_ibu" => $this->ortu->nama_ibu,
                "pekerjaan_ayah" => $this->ortu->pekerjaan_ayah,
                "pekerjaan_ibu" => $this->ortu->pekerjaan_ibu,
            ],
            "jurusan" => $this->jurusan->name,
            "created_at" => $this->created_at,
        ];
    }
}
