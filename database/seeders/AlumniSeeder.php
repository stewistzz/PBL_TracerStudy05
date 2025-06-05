<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        // Asumsikan user dengan role 'alumni' sudah dibuat di UserSeeder
        $user = DB::table('users')->where('role', 'alumni')->first();

        if ($user) {
            DB::table('alumni')->insert([
                'user_id' => $user->user_id,
                'nama' => 'Ahmad Yudi',
                'nim' => '2341766001',
                'email' => 'yudi@example.com',
                'no_hp' => '081234567890',
                'program_studi' => 'TI',
                'tahun_lulus' => Carbon::createFromDate(2023, 7, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
