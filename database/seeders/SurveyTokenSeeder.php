<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SurveyTokenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('survey_tokens')->insert([
            'pengguna_id' => 1, // pastikan pengguna_id=1 sudah ada
            'token' => Str::uuid(), // generate token unik
            'expires_at' => Carbon::now()->addDays(7), // token berlaku 7 hari dari sekarang
            'used' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
