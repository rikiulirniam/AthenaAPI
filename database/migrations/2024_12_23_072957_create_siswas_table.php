<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("nisn")->unique();
            $table->string('nik')->unique();
            $table->string("tempat_lahir");
            $table->date('tanggal_lahir');
            $table->boolean('jenis_kelamin');
            $table->string('agama');
            $table->string('alamat_lengkap');
            $table->string('no_telepon');
            $table->foreignId('asal_sekolah');
            $table->foreignId('ortu_id');
            $table->foreignId("jurusan_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
