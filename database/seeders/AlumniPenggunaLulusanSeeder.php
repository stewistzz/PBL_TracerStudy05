<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniPenggunaLulusanSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh: hubungkan alumni dengan id=1 ke pengguna_lulusan dengan id=1
        DB::table('alumni_pengguna_lulusan')->insert([
            'pengguna_id' => 1,
            'alumni_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
