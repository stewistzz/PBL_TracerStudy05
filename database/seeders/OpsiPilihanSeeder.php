<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpsiPilihanSeeder extends Seeder
{
    public function run(): void
    {
        $opsiByPertanyaan = [
            9 => [ // Skala 1–5
                '1 - Sangat Tidak Puas',
                '2 - Tidak Puas',
                '3 - Cukup Puas',
                '4 - Puas',
                '5 - Sangat Puas',
            ],
            14 => [ // Skala 1–3
                '1 - Tidak Puas',
                '2 - Cukup Puas',
                '3 - Puas',
            ]
        ];

        foreach ($opsiByPertanyaan as $pertanyaanId => $opsiList) {
            foreach ($opsiList as $isi) {
                DB::table('opsi_pilihan')->insert([
                    'pertanyaan_id' => $pertanyaanId,
                    'isi_opsi' => $isi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
