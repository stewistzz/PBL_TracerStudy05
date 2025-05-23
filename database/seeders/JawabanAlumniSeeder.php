<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JawabanAlumniSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jawaban_alumni')->insert([
            'alumni_id' => 1, // ganti dengan ID alumni yang sesuai
            'pertanyaan_id' => 9,
            'jawaban' => '4', // contoh skala 4 (Puas)
            'tanggal' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
