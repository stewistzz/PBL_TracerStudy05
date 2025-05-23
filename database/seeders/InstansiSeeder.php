<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('instansi')->insert([
            'nama_instansi' => 'Universitas Contoh',
            'jenis_instansi' => 'Pendidikan Tinggi',
            'skala' => 'nasional',
            'lokasi' => 'Malang, Indonesia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
