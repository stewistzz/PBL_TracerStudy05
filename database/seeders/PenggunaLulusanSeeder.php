<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaLulusanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengguna_lulusan')->insert([
            'nama' => 'Budi Santoso',
            'instansi' => 'Manager IT',       // Jika 'instansi' maksudnya adalah nama perusahaan, sebaiknya diganti sesuai konteks
            'jabatan' => 'Manager IT',
            'no_hp' => '081234567890',
            'email' => 'budi.santoso@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
