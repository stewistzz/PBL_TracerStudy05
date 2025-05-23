<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asumsikan admin dengan role 'alumni' sudah dibuat di adminSeeder
        $user = DB::table('users')->where('role', 'admin')->first();

        if ($user) {
            DB::table('admin')->insert([
                'user_id' => $user->user_id,
                'nama' => 'Admin Pertama',
                'email' => 'admin01@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
