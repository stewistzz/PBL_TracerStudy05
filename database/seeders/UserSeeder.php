<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'adminuser',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '2341766001',
                'password' => Hash::make('2341766001'),
                'role' => 'alumni',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '2341766009',
                'password' => Hash::make('2341766009'),
                'role' => 'alumni',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => '2341766010',
                'password' => Hash::make('2341766010'),
                'role' => 'alumni',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
