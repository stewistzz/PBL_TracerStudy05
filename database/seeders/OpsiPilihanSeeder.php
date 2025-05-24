<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpsiPilihanSeeder extends Seeder
{
    public function run(): void
    {
        $opsiByPertanyaan = [
            5 => [ // ID 5 = ya_tidak
                'Ya',
                'Tidak',
            ],
            // 6 tidak perlu karena jenis_pertanyaan = isian
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
