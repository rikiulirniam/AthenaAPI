<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    /** @use HasFactory<\Database\Factories\SiswaFactory> */
    use HasFactory;

    protected $guarded = ["id"];
    public $timestamps = false;

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function ortu()
    {
        return $this->belongsTo(Ortu::class);
    }

    // public function asal_sekolah()
    // {
    //     return $this->belongsTo(AsalSekolah::class);
    // }
}
