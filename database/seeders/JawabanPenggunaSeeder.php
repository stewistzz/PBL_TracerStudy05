<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JawabanPenggunaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jawaban_pengguna')->insert([
            'pengguna_id'   => 1, // Pastikan ID ini valid di tabel pengguna_lulusan
            'pertanyaan_id' => 7, // Ganti dengan ID pertanyaan yang valid dan sesuai
            'jawaban'       => 'ya', // Misal skala 1-3
            'tanggal'       => now()->toDateString(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}
