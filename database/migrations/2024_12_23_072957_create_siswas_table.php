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
            $table->string('id', 16)->primary();
            $table->string('name');
            $table->string("nisn")->unique();
            $table->string('nik')->unique();
            $table->string("tempat_lahir");
            $table->date('tanggal_lahir');
            $table->boolean('jenis_kelamin');
            $table->string('agama');
            $table->string('alamat_lengkap');
            $table->string('no_telepon');
            $table->string('asal_sekolah');
            $table->boolean('status');
            $table->foreignId('ortu_id');
            $table->foreignId("jurusan_id");
            $table->timestamp("created_at");
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
