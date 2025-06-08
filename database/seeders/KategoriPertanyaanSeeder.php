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
                'nama_kategori' => 'Kerjasama TIM',
                'deskripsi' => 'Pertanyaan terkait Kerjasama TIM berupa skala.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_kategori' => 'K02',
                'nama_kategori' => 'Keahlian Bidang IT',
                'deskripsi' => 'Pertanyaan berupa skala Keahlian Bidang IT.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_kategori' => 'K03',
                'nama_kategori' => 'Kemampuan Berbahasa Asing(Inggris)',
                'deskripsi' => 'Pertanyaan berupa skala Kemampuan Berbahasa Asing(Inggris).',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_kategori' => 'K04',
                'nama_kategori' => 'Kemampuan Berkomunikasi',
                'deskripsi' => 'Pertanyaan berupa skala Kemampuan Berkomunikasi.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_kategori' => 'K05',
                'nama_kategori' => 'Pengembangan Diri',
                'deskripsi' => 'Pertanyaan berupa skala Pengembangan Diri.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_kategori' => 'K06',
                'nama_kategori' => 'Kepemimpinan',
                'deskripsi' => 'Pertanyaan berupa skala Kepemimpinan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_kategori' => 'K07',
                'nama_kategori' => 'Etos Kerja',
                'deskripsi' => 'Pertanyaan berupa skala Etos Kerja.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
