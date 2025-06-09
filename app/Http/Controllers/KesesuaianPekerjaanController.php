<?php

// app/Http/Controllers/KesesuaianPekerjaanController.php
namespace App\Http\Controllers;

use App\Models\AlumniModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KesesuaianPekerjaanController extends Controller
{

    /**
     * Menampilkan halaman kesesuaian pekerjaan dengan data yang dapat difilter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $currentYear = Carbon::now()->year;

        $query = DB::table('alumni')
            ->selectRaw('YEAR(tahun_lulus) as tahun_lulus')
            ->addSelect([
                DB::raw('COUNT(alumni.alumni_id) as total_alumni'),
                DB::raw('COUNT(tracer_study.tracer_id) as alumni_isi_tracer'),
                DB::raw("SUM(CASE WHEN kategori_profesi.nama_kategori = 'Infokom' THEN 1 ELSE 0 END) as infokom"),
                DB::raw("SUM(CASE WHEN kategori_profesi.nama_kategori != 'Infokom' THEN 1 ELSE 0 END) as non_infokom"),
                DB::raw("SUM(CASE WHEN instansi.skala = 'internasional' THEN 1 ELSE 0 END) as internasional"),
                DB::raw("SUM(CASE WHEN instansi.skala = 'nasional' THEN 1 ELSE 0 END) as nasional"),
                DB::raw("SUM(CASE WHEN instansi.skala = 'wirausaha' THEN 1 ELSE 0 END) as wirausaha"),
            ])
            ->leftJoin('tracer_study', 'alumni.alumni_id', '=', 'tracer_study.alumni_id')
            ->leftJoin('kategori_profesi', 'tracer_study.kategori_profesi_id', '=', 'kategori_profesi.kategori_id')
            ->leftJoin('instansi', 'tracer_study.instansi_id', '=', 'instansi.instansi_id')
            ->whereYear('tahun_lulus', '>=', $currentYear - 3);

        // Tambahkan filter dinamis
        $query->when($request->filled('program_studi'), function ($q) use ($request) {
            return $q->where('alumni.program_studi', $request->program_studi);
        });

        $query->when($request->filled('tahun_lulus_start'), function ($q) use ($request) {
            return $q->whereYear('alumni.tahun_lulus', '>=', $request->tahun_lulus_start);
        });

        $query->when($request->filled('tahun_lulus_end'), function ($q) use ($request) {
            return $q->whereYear('alumni.tahun_lulus', '<=', $request->tahun_lulus_end);
        });

        $data = $query->groupBy(DB::raw('YEAR(alumni.tahun_lulus)'))
            ->orderBy(DB::raw('YEAR(alumni.tahun_lulus)'), 'asc')
            ->get();

        $programStudiOptions = AlumniModel::distinct()
            ->whereNotNull('program_studi')
            ->orderBy('program_studi')
            ->pluck('program_studi');

        return view('kesesuaian.index', compact('data', 'programStudiOptions', 'request'));
    }
}
