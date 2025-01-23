<?php

namespace Database\Seeders;

use App\Models\Ortu;
use App\Models\Siswa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::create([
        //     'username' => 'admin',
        //     'password' => Hash::make("123123qweqwe")
        // ]);

        for ($i = 1; $i <= 50; $i++) {
            $ortu = Ortu::create([
                'no_telepon' => '0812' . rand(10000000, 99999999),
                'nama_ayah' => 'Ayah ' . $i,
                'nama_ibu' => 'Ibu ' . $i,
                'pekerjaan_ayah' => 'Pekerjaan Ayah ' . $i,
                'pekerjaan_ibu' => 'Pekerjaan Ibu ' . $i,
            ]);

            Siswa::create([
                'name' => 'Siswa ' . $i,
                'nisn' => str_pad($i, 10, '0', STR_PAD_LEFT),
                'nik' => str_pad(rand(1, 999999999999), 16, '0', STR_PAD_LEFT),
                'tempat_lahir' => 'Kota ' . $i,
                'tanggal_lahir' => now()->subYears(rand(10, 18))->subDays(rand(1, 365)),
                'jenis_kelamin' => rand(0, 1) ? true : false,
                'agama' => ['Islam', 'Kristen', 'Hindu', 'Budha', 'Konghucu'][rand(0, 4)],
                'alamat_lengkap' => 'Alamat Lengkap Siswa ' . $i,
                'no_telepon' => '0813' . rand(10000000, 99999999),
                'status' => (bool)rand(0, 1),
                'asal_sekolah' => 'Sekolah ' . $i,
                'jurusan_id' => rand(1, 9),
                'ortu_id' => $ortu->id,
            ]);
        }
    }
}
