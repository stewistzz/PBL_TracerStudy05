<?php

namespace App\Http\Controllers;

use App\Models\TracerStudyModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;

class AlumniTracerController extends Controller
{
    public function index()
    {
        return view('alumni_tracer.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = TracerStudyModel::with(['alumni', 'instansi', 'kategoriProfesi', 'profesi']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('alumni', fn($row) => $row->alumni->nama ?? '-')
                ->addColumn('instansi', fn($row) => $row->instansi->nama_instansi ?? '-')
                ->addColumn('kategori_profesi', fn($row) => $row->kategoriProfesi->nama_kategori ?? '-')
                ->addColumn('profesi', fn($row) => $row->profesi->nama_profesi ?? '-')
                ->addColumn('tanggal_pengisian', fn($row) => optional($row->tanggal_pengisian)->format('Y-m-d'))
                ->addColumn('tanggal_pertama_kerja', fn($row) => optional($row->tanggal_pertama_kerja)->format('Y-m-d'))
                ->addColumn('tanggal_mulai_kerja_instansi_saat_ini', fn($row) => optional($row->tanggal_mulai_kerja_instansi_saat_ini)->format('Y-m-d'))
                ->addColumn('nama_atasan', fn($row) => $row->nama_atasan_langsung ?? '-')
                ->addColumn('jabatan_atasan', fn($row) => $row->jabatan_atasan_langsung ?? '-')
                ->addColumn('no_hp_atasan', fn($row) => $row->no_hp_atasan_langsung ?? '-')
                ->addColumn('email_atasan', fn($row) => $row->email_atasan_langsung ?? '-')
                ->addColumn('status', fn($row) => ucfirst($row->status))
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-warning btn-sm btn-edit" data-id="'.$row->tracer_id.'">Kirim</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        abort(403);
    }
}
