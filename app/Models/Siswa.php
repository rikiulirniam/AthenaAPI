<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    /** @use HasFactory<\Database\Factories\SiswaFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $keyType = 'string';
    
    public $incrementing = false; 
    public $timestamps = false;

    // Boot method untuk generate ID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = self::generateUniqueId();
        });
    }

    private static function generateUniqueId()
    {
        do {
            $id = str_pad(random_int(0, 99999999999), 11, '0', STR_PAD_LEFT);
        } while (self::where('id', $id)->exists());

        return $id;
    }

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
