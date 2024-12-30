<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $guarded = ['id'];
    public $timstamps = false;

    public function siswas(){
        return $this->hasMany(Siswa::class);
    }
}
