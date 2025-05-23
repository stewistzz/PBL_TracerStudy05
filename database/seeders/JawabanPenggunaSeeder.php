<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JawabanPenggunaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jawaban_pengguna')->insert([
            'pengguna_id'   => 1, // Ganti dengan ID pengguna lulusan yang valid
            'pertanyaan_id' => 14, // ID pertanyaan tentang kepuasan pengguna terhadap alumni
            'jawaban'       => '3', // Skala 1-3, misal: "3" = "Puas"
            'tanggal'       => now()->toDateString(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}
