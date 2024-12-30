<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ortu extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
}
