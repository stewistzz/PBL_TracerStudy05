<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfesiSeeder extends Seeder
{
    public function run(): void
    {
        // Data profesi untuk tiap kategori_id
        $profesiData = [
            // Bidang Infokom (kategori_id = 1)
            ['nama_profesi' => 'Developer/Programmer/Software Engineer', 'kategori_id' => 1],
            ['nama_profesi' => 'IT Support/IT Administrator', 'kategori_id' => 1],
            ['nama_profesi' => 'Infrastructure Engineer', 'kategori_id' => 1],
            ['nama_profesi' => 'Digital Marketing Specialist', 'kategori_id' => 1],
            ['nama_profesi' => 'Graphic Designer/Multimedia Designer', 'kategori_id' => 1],
            ['nama_profesi' => 'Business Analyst', 'kategori_id' => 1],
            ['nama_profesi' => 'QA Engineer/Tester', 'kategori_id' => 1],
            ['nama_profesi' => 'IT Enterpreneur', 'kategori_id' => 1],
            ['nama_profesi' => 'Trainer/Guru/Dosen (IT)', 'kategori_id' => 1],
            ['nama_profesi' => 'Lainnya', 'kategori_id' => 1],

            // Bidang Non Infokom (kategori_id = 2)
            ['nama_profesi' => 'Procurement & Operational Team', 'kategori_id' => 2],
            ['nama_profesi' => 'Wirausahawan (Non IT)', 'kategori_id' => 2],
            ['nama_profesi' => 'Trainer/Guru/Dosen (Non IT)', 'kategori_id' => 2],
            ['nama_profesi' => 'Lainnya', 'kategori_id' => 2],

            // Belum Bekerja (kategori_id = 3)
            ['nama_profesi' => 'Belum Bekerja', 'kategori_id' => 3],
        ];

        $now = Carbon::now();

        foreach ($profesiData as &$profesi) {
            $profesi['created_at'] = $now;
            $profesi['updated_at'] = $now;
        }

        DB::table('profesi')->insert($profesiData);
    }
}
