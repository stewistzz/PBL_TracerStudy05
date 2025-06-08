<?php

namespace App\Http\Controllers;

use App\Models\ProfesiModel;
use App\Models\InstansiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoriProfesiModel; // jika kategori disimpan di tabel lain
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class LandingController extends Controller
{
    public function landing_page()
    {
        $data = DB::table('tracer_study')
            ->join('profesi', 'tracer_study.profesi_id', '=', 'profesi.profesi_id')
            ->select('profesi.nama_profesi', DB::raw('COUNT(*) as total'))
            ->groupBy('profesi.nama_profesi')
            ->get();

        $jumlah_profesi = DB::table('profesi')->count(); // Total jenis profesi (15)


        // Ambil semua data instansi
        $instansis = InstansiModel::all();

        // Ambil data jumlah alumni berdasarkan jenis instansi
        $instansiData = DB::table('instansi')
            ->leftJoin('tracer_study', 'instansi.instansi_id', '=', 'tracer_study.instansi_id')
            ->select('instansi.jenis_instansi', DB::raw('COUNT(tracer_study.tracer_id) as total'))
            ->groupBy('instansi.jenis_instansi')
            ->get();

        // Kirim kedua data ke view
        return view('landing_page', compact('instansis', 'instansiData','data', 'jumlah_profesi'));
    }
}
