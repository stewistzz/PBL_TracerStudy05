<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanModel;
use App\Models\KategoriPertanyaanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PertanyaanController extends Controller
{
    public function index()
    {
        return view('pertanyaan.index');
    }

    // list function
    public function list(Request $request)
{
    $roleTarget = $request->query('role_target'); // alumni atau pengguna

    $pertanyaan = PertanyaanModel::with('kategoriPertanyaan', 'admin')
        ->select('pertanyaan_id', 'role_target', 'isi_pertanyaan', 'jenis_pertanyaan', 'created_by', 'kode_kategori');

    if ($roleTarget) {
        $pertanyaan->where('role_target', $roleTarget);
    }

    return DataTables::of($pertanyaan)
        ->addIndexColumn()
        ->addColumn('kategori', function ($row) {
            return $row->kategoriPertanyaan->nama_kategori ?? '-';
        })
        ->addColumn('admin', function ($row) {
            return $row->admin->nama ?? '-';
        })
        ->addColumn('action', function ($row) {
            $btn = '<button onclick="modalAction(\'' . url('/pertanyaan/' . $row->pertanyaan_id . '/edit_ajax') . '\')" class="btn btn-warning py-1 btn-sm">
                <i class="mdi mdi-pencil"></i>edit
            </button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/pertanyaan/' . $row->pertanyaan_id . '/delete_ajax') . '\')" class="btn btn-danger py-1 btn-sm">
                <i class="mdi mdi-delete"></i>delete
            </button>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
}


    // create ajax
    public function create_ajax()
    {
        $kategori = KategoriPertanyaanModel::select('kode_kategori', 'nama_kategori')->get();

        return view('pertanyaan.create_ajax', compact('kategori'));
    }

    // store ajax
    public function store_ajax(Request $request)
    {
        // dd(auth()->user());
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'role_target' => 'required|in:alumni,pengguna',
                'isi_pertanyaan' => 'required|string',
                'jenis_pertanyaan' => 'required|in:isian,pilihan_ganda,skala,ya_tidak',
                'kode_kategori' => 'required|exists:kategori_pertanyaan,kode_kategori',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            PertanyaanModel::create([
                'role_target' => $request->role_target,
                'isi_pertanyaan' => $request->isi_pertanyaan,
                'jenis_pertanyaan' => $request->jenis_pertanyaan,
                'kode_kategori' => $request->kode_kategori,
                'created_by' => auth()->user()->user_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Pertanyaan berhasil disimpan'
            ]);
        }
        return redirect()->route('pertanyaan.index');
    }

    // Controller untuk Pertanyaan

    // Edit (AJAX)
    public function edit_ajax($id)
    {
        $data = PertanyaanModel::findOrFail($id);
        $kategori = KategoriPertanyaanModel::all();

        return view('pertanyaan.edit_ajax', compact('data', 'kategori'));
    }

    // Update (AJAX)
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'isi_pertanyaan' => 'required|string|max:255|unique:pertanyaan,isi_pertanyaan,' . $id . ',pertanyaan_id',
                'role_target' => 'required|in:alumni,pengguna',
                'jenis_pertanyaan' => 'required|in:isian,pilihan_ganda,skala,ya_tidak',
                'kode_kategori' => 'required|exists:kategori_pertanyaan,kode_kategori'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $pertanyaan = PertanyaanModel::findOrFail($id);
            $pertanyaan->update([
                'isi_pertanyaan' => $request->isi_pertanyaan,
                'role_target' => $request->role_target,
                'jenis_pertanyaan' => $request->jenis_pertanyaan,
                'kode_kategori' => $request->kode_kategori,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data pertanyaan berhasil diperbarui'
            ]);
        }

        return redirect()->route('pertanyaan.index');
    }


    // Konfirmasi hapus (AJAX)
    public function confirm_ajax($id)
    {
        $data = PertanyaanModel::findOrFail($id);

        return view('pertanyaan.delete_ajax', compact('data'));
    }

    // Hapus (AJAX)
    public function delete_ajax($id)
    {
        $pertanyaan = PertanyaanModel::findOrFail($id);

        try {
            $pertanyaan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data pertanyaan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data pertanyaan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function edit_ajax($id)
    // {
    //     $data = PertanyaanModel::findOrFail($id);
    //     $kategori = KategoriPertanyaanModel::all();
    //     return view('pertanyaan.edit_ajax', compact('data', 'kategori'));
    // }

    // public function update_ajax(Request $request, $id)
    // {
    //     if ($request->ajax()) {
    //         $rules = [
    //             'isi_pertanyaan' => 'required|string',
    //             'role_target' => 'required|in:alumni,pengguna',
    //             'jenis_pertanyaan' => 'required|in:isian,pilihan_ganda,skala,ya_tidak',
    //             'kode_kategori' => 'required|string|exists:kategori_pertanyaan,kode_kategori',
    //             'created_by' => 'required|exists:admin,admin_id',
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validasi Gagal',
    //                 'msgField' => $validator->errors(),
    //             ]);
    //         }

    //         $pertanyaan = PertanyaanModel::findOrFail($id);
    //         $pertanyaan->update($request->only([
    //             'isi_pertanyaan', 'role_target', 'jenis_pertanyaan', 'kode_kategori', 'created_by'
    //         ]));

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data pertanyaan berhasil diperbarui'
    //         ]);
    //     }
    // }

    // public function confirm_ajax($id)
    // {
    //     $data = PertanyaanModel::findOrFail($id);
    //     return view('pertanyaan.delete_ajax', compact('data'));
    // }

    // public function delete_ajax($id)
    // {
    //     $pertanyaan = PertanyaanModel::findOrFail($id);

    //     try {
    //         $pertanyaan->delete();
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data pertanyaan berhasil dihapus.'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Gagal menghapus data pertanyaan.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
}
