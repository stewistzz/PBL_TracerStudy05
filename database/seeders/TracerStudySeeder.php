<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TracerStudySeeder extends Seeder
{
    public function run(): void
    {
        // Ambil satu data alumni (misal alumni_id = 1)
        $alumni = DB::table('alumni')->first();
        if (!$alumni) {
            $this->command->error('Tidak ada data alumni ditemukan, harap isi tabel alumni terlebih dahulu.');
            return;
        }

        // Ambil satu instansi, kategori_profesi dan profesi yang valid
        $instansi = DB::table('instansi')->first();
        $kategoriProfesi = DB::table('kategori_profesi')->first();
        $profesi = DB::table('profesi')->first();

        if (!$instansi || !$kategoriProfesi || !$profesi) {
            $this->command->error('Instansi, kategori profesi, atau profesi belum terisi, isi tabel tersebut terlebih dahulu.');
            return;
        }

        $now = Carbon::now();

        DB::table('tracer_study')->insert([
            'alumni_id' => $alumni->alumni_id,
            'tanggal_pengisian' => $now->toDateString(),
            'tanggal_pertama_kerja' => $now->subYears(2)->toDateString(),
            'tanggal_mulai_kerja_instansi_saat_ini' => $now->subYear()->toDateString(),
            'instansi_id' => $instansi->instansi_id,
            'kategori_profesi_id' => $kategoriProfesi->kategori_id,
            'profesi_id' => $profesi->profesi_id,
            'nama_atasan_langsung' => 'Budi Santoso',
            'jabatan_atasan_langsung' => 'Manager IT',
            'no_hp_atasan_langsung' => '081234567890',
            'email_atasan_langsung' => 'budi.santoso@example.com',
            'status' => 'completed',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
