<?php

namespace App\Http\Controllers;

use App\Models\AlumniModel;
use App\Models\DataPenggunaModel;
use App\Models\InstansiModel;
use App\Models\TracerStudyModel;
use App\Models\JawabanPenggunaModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class DashboardController extends Controller
{

    private function getNamaKategori($kode)
    {
        $kategoriMap = [
            'K01' => 'Kerja Sama Tim',
            'K02' => 'Keterampilan TI',
            'K03' => 'Bahasa Inggris',
            'K04' => 'Komunikasi',
            'K05' => 'Inisiatif Belajar',
            'K06' => 'Potensi Kepemimpinan',
            'K07' => 'Etos Kerja',
            'K08' => 'Kompetensi Harapan',
            'K09' => 'Saran Kurikulum'
        ];

        return $kategoriMap[$kode] ?? $kode;
    }


    public function index()
    {
        /* ---------- 1. Kartu ringkasan ---------- */
        $jumlahAlumni   = AlumniModel::count();
        $jumlahPengguna = DataPenggunaModel::count();
        $jumlahTracer   = TracerStudyModel::count();
        $jumlahSurvei   = JawabanPenggunaModel::distinct()->count('pengguna_id');

        // grafik bar
        // Ambil data jawaban dengan relasi pertanyaan untuk pertanyaan skala
        $jawaban = JawabanPenggunaModel::with('pertanyaan')
            ->whereHas('pertanyaan', function ($query) {
                $query->where('jenis_pertanyaan', 'skala')
                    ->where('role_target', 'pengguna');
            })->get();

        // Kelompokkan data berdasarkan kategori
        $dataKategori = [];
        foreach ($jawaban as $item) {
            $kategori = $item->pertanyaan->kode_kategori;
            $nilai = (int) $item->jawaban;

            if (!isset($dataKategori[$kategori])) {
                $dataKategori[$kategori] = [
                    'nama_kategori' => $this->getNamaKategori($kategori),
                    'total_jawaban' => 0,
                    'total_nilai' => 0
                ];
            }

            if ($nilai >= 1 && $nilai <= 5) {
                $dataKategori[$kategori]['total_jawaban']++;
                $dataKategori[$kategori]['total_nilai'] += $nilai;
            }
        }

        // Hitung rata-rata per kategori
        $rataRataKategori = [];
        foreach ($dataKategori as $kode => $data) {
            $rataRata = $data['total_jawaban'] > 0
                ? round($data['total_nilai'] / $data['total_jawaban'], 2)
                : 0;

            $rataRataKategori[] = [
                'kategori' => $data['nama_kategori'],
                'kode' => $kode,
                'rata_rata' => $rataRata
            ];
        }

        // Siapkan data untuk Chart.js
        $chartData = [
            'labels' => array_column($rataRataKategori, 'kategori'),
            'data' => array_column($rataRataKategori, 'rata_rata'),
        ];

        // Ambil data jumlah alumni berdasarkan jenis instansi
        $instansiData = DB::table('instansi')
            ->leftJoin('tracer_study', 'instansi.instansi_id', '=', 'tracer_study.instansi_id')
            ->select('instansi.jenis_instansi', DB::raw('COUNT(tracer_study.tracer_id) as total'))
            ->groupBy('instansi.jenis_instansi')
            ->get();


        // MASA TUNGGU
        // Pie chart data masa tunggu
        $alumni = AlumniModel::with('tracerStudies')->get();
        $kategoriMasaTunggu = [
            '≤ 3 Bulan' => 0,
            '4–6 Bulan' => 0,
            '7–12 Bulan' => 0,
            '> 12 Bulan' => 0,
            'Belum Kerja' => 0,
        ];

        foreach ($alumni as $item) {
            $tracer = $item->tracerStudies->first();
            if ($tracer && $tracer->tanggal_pertama_kerja && $item->tahun_lulus) {
                $tglKerja = Carbon::parse($tracer->tanggal_pertama_kerja);
                $thnLulus = Carbon::createFromDate($item->tahun_lulus, 1, 1);
                $bulan = $thnLulus->diffInMonths($tglKerja);

                if ($bulan <= 3) {
                    $kategoriMasaTunggu['≤ 3 Bulan']++;
                } elseif ($bulan <= 6) {
                    $kategoriMasaTunggu['4–6 Bulan']++;
                } elseif ($bulan <= 12) {
                    $kategoriMasaTunggu['7–12 Bulan']++;
                } else {
                    $kategoriMasaTunggu['> 12 Bulan']++;
                }
            } else {
                $kategoriMasaTunggu['Belum Kerja']++;
            }
        }
        return view('admin.dashboard', compact(
            'jumlahAlumni',
            'jumlahPengguna',
            'jumlahTracer',
            'jumlahSurvei',
            'instansiData',
            'chartData',
            'kategoriMasaTunggu'
        ));
    }
}
