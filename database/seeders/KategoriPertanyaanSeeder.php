<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriPertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_pertanyaan')->insert([
            [
                'kode_kategori' => 'K01',
                'nama_kategori' => 'essai',
                'deskripsi' => 'Pertanyaan terkait text.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_kategori' => 'K02',
                'nama_kategori' => 'choice',
                'deskripsi' => 'Pertanyaan berupa skala dan berupa multiple jawaban.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
