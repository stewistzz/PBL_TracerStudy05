<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pertanyaan')->insert([
            [
                'role_target' => 'pengguna',
                'isi_pertanyaan' => 'Alumni rajin??',
                'jenis_pertanyaan' => 'ya_tidak',
                'created_by' => 1,
                'kode_kategori' => 'K02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
           /*
[
    'role_target' => 'alumni',
    'isi_pertanyaan' => 'Berapa lama waktu yang dibutuhkan untuk mendapatkan pekerjaan pertama?',
    'jenis_pertanyaan' => 'isian',
    'created_by' => 1,
    'kode_kategori' => 'K01',
    'created_at' => now(),
    'updated_at' => now(),
],
*/
        ]);
    }
}
