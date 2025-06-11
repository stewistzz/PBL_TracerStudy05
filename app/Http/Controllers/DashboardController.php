<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JawabanPenggunaModel;
use App\Models\AlumniModel;
use App\Models\PenggunaLulusanModel;
use App\Models\TracerStudyModel;
use App\Models\KategoriPertanyaanModel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori yang dipilih dari request, default null (tampilkan semua)
        $selectedKategori = $request->input('kategori', null);

        // Ambil data jawaban dengan relasi pertanyaan untuk pertanyaan skala
        $query = JawabanPenggunaModel::with(['pertanyaan', 'pengguna', 'alumni'])
            ->whereHas('pertanyaan', function ($query) {
                $query->where('jenis_pertanyaan', 'skala')
                    ->where('role_target', 'pengguna');
            });

        // Jika ada kategori yang dipilih, filter berdasarkan kode_kategori
        if ($selectedKategori) {
            $query->whereHas('pertanyaan', function ($query) use ($selectedKategori) {
                $query->where('kode_kategori', $selectedKategori);
            });
        }

        $jawaban = $query->get();

        // Kelompokkan data berdasarkan kategori untuk chart
        $dataKategori = [];
        foreach ($jawaban as $item) {
            $kategori = $item->pertanyaan->kode_kategori;
            $nilai = (int) $item->jawaban;

            if (!isset($dataKategori[$kategori])) {
                $namaKategori = DB::table('kategori_pertanyaan')
                    ->where('kode_kategori', $kategori)
                    ->value('nama_kategori') ?? $kategori;

                $dataKategori[$kategori] = [
                    'nama_kategori' => $namaKategori,
                    'total_jawaban' => 0,
                    'total_nilai' => 0,
                    'distribusi' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
                    'pertanyaan' => $item->pertanyaan->isi_pertanyaan
                ];
            }

            if ($nilai >= 1 && $nilai <= 5) {
                $dataKategori[$kategori]['total_jawaban']++;
                $dataKategori[$kategori]['total_nilai'] += $nilai;
                $dataKategori[$kategori]['distribusi'][$nilai]++;
            }
        }

        // Hitung rata-rata dan siapkan data distribusi untuk chart
        $rataRataKategori = [];
        $distribusiData = [];

        foreach ($dataKategori as $kode => $data) {
            if ($data['total_jawaban'] > 0) {
                $rataRata = round($data['total_nilai'] / $data['total_jawaban'], 2);
                $rataRataKategori[] = [
                    'kategori' => $data['nama_kategori'],
                    'kode' => $kode,
                    'rata_rata' => $rataRata,
                    'total_responden' => $data['total_jawaban'],
                    'pertanyaan' => $data['pertanyaan']
                ];

                $distribusiData[$kode] = [
                    'nama' => $data['nama_kategori'],
                    'distribusi' => $data['distribusi']
                ];
            }
        }

        // Hitung statistik keseluruhan
        $totalJawaban = collect($rataRataKategori)->sum('total_responden');
        $rataRataKeseluruhan = $totalJawaban > 0 ?
            round(collect($rataRataKategori)->avg('rata_rata'), 2) : 0;

        // Ambil semua kategori untuk dropdown filter
        $kategoriList = DB::table('kategori_pertanyaan')
            ->join('pertanyaan', 'kategori_pertanyaan.kode_kategori', '=', 'pertanyaan.kode_kategori')
            ->where('pertanyaan.jenis_pertanyaan', 'skala')
            ->where('pertanyaan.role_target', 'pengguna')
            ->select('kategori_pertanyaan.kode_kategori', 'kategori_pertanyaan.nama_kategori')
            ->distinct()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->kode_kategori => $item->nama_kategori];
            })->toArray();

        // Ambil data distribusi instansi
        $instansiData = DB::table('instansi')
            ->leftJoin('tracer_study', 'instansi.instansi_id', '=', 'tracer_study.instansi_id')
            ->select('instansi.jenis_instansi', DB::raw('COUNT(tracer_study.tracer_id) as total'))
            ->groupBy('instansi.jenis_instansi')
            ->get();

        // Ambil 10 profesi teratas
        $profesiData = DB::table('tracer_study')
            ->join('profesi', 'tracer_study.profesi_id', '=', 'profesi.profesi_id')
            ->select('profesi.nama_profesi', DB::raw('COUNT(*) as total'))
            ->groupBy('profesi.nama_profesi')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Hitung jumlah alumni, pengguna lulusan, tracer study, dan pengguna survei
        $jumlahAlumni = AlumniModel::count();
        $jumlahPenggunaLulusan = PenggunaLulusanModel::count();
        $jumlahTracerStudy = TracerStudyModel::count();
        $jumlahPenggunaSurvei = DB::table('jawaban_pengguna')->distinct('pengguna_id')->count('pengguna_id');

        // Data untuk tabel kategori pertanyaan
        $kategoriJawaban = DB::table('kategori_pertanyaan')
            ->join('pertanyaan', 'kategori_pertanyaan.kode_kategori', '=', 'pertanyaan.kode_kategori')
            ->join('jawaban_pengguna', 'pertanyaan.pertanyaan_id', '=', 'jawaban_pengguna.pertanyaan_id')
            ->where('pertanyaan.jenis_pertanyaan', 'skala')
            ->where('pertanyaan.role_target', 'pengguna')
            ->select(
                'kategori_pertanyaan.kode_kategori',
                'kategori_pertanyaan.nama_kategori',
                DB::raw('COUNT(*) as total_jawaban'),
                DB::raw('SUM(CASE WHEN jawaban_pengguna.jawaban = 5 THEN 1 ELSE 0 END) as sangat_baik'),
                DB::raw('SUM(CASE WHEN jawaban_pengguna.jawaban = 4 THEN 1 ELSE 0 END) as baik'),
                DB::raw('SUM(CASE WHEN jawaban_pengguna.jawaban = 3 THEN 1 ELSE 0 END) as cukup'),
                DB::raw('SUM(CASE WHEN jawaban_pengguna.jawaban = 2 THEN 1 ELSE 0 END) as kurang')
            )
            ->groupBy('kategori_pertanyaan.kode_kategori', 'kategori_pertanyaan.nama_kategori')
            ->get()
            ->map(function ($item) {
                $total = $item->total_jawaban;
                return [
                    'kode_kategori' => $item->kode_kategori,
                    'nama_kategori' => $item->nama_kategori,
                    'total_jawaban' => $total,
                    'sangat_baik' => $total > 0 ? round(($item->sangat_baik / $total) * 100, 2) : 0,
                    'baik' => $total > 0 ? round(($item->baik / $total) * 100, 2) : 0,
                    'cukup' => $total > 0 ? round(($item->cukup / $total) * 100, 2) : 0,
                    'kurang' => $total > 0 ? round(($item->kurang / $total) * 100, 2) : 0
                ];
            });

        // Hitung rata-rata total untuk footer
        $rataRataTabel = [
            'sangat_baik' => $kategoriJawaban->avg('sangat_baik'),
            'baik' => $kategoriJawaban->avg('baik'),
            'cukup' => $kategoriJawaban->avg('cukup'),
            'kurang' => $kategoriJawaban->avg('kurang')
        ];

        // Kembalikan view dashboard
        return view('admin.dashboard', compact(
            'rataRataKategori',
            'distribusiData',
            'totalJawaban',
            'rataRataKeseluruhan',
            'kategoriList',
            'selectedKategori',
            'instansiData',
            'profesiData',
            'jumlahAlumni',
            'jumlahPenggunaLulusan',
            'jumlahTracerStudy',
            'jumlahPenggunaSurvei',
            'kategoriJawaban',
            'rataRataTabel'
        ));
    }
}