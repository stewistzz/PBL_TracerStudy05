<?php

namespace App\Http\Controllers;

use App\Models\KategoriPertanyaanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriPertanyaanController extends Controller
{
    public function index()
    {
        return view('kategori_pertanyaan.index');
    }

    public function list(Request $request)
    {
        $kategori = KategoriPertanyaanModel::select('kode_kategori', 'nama_kategori', 'deskripsi');

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/kategori_pertanyaan/' . $row->kode_kategori . '/edit_ajax') . '\')" class="btn btn-warning py-2 btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori_pertanyaan/' . $row->kode_kategori . '/delete_ajax') . '\')" class="btn btn-danger py-2 btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('kategori_pertanyaan.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'kode_kategori' => 'required|string|max:50|unique:kategori_pertanyaan,kode_kategori',
                'nama_kategori' => 'required|string|max:100',
                'deskripsi' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            KategoriPertanyaanModel::create($request->only('kode_kategori', 'nama_kategori', 'deskripsi'));

            return response()->json(['status' => true, 'message' => 'Data berhasil disimpan']);
        }
    }

    public function edit_ajax($id)
    {
        $data = KategoriPertanyaanModel::findOrFail($id);
        return view('kategori_pertanyaan.edit_ajax', compact('data'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $rules = [
                'kode_kategori' => 'required|string|max:50,kode_kategori',
                'nama_kategori' => 'required|string|max:100',
                'deskripsi' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $kategori = KategoriPertanyaanModel::findOrFail($id);
            $kategori->update($request->only('kode_kategori','nama_kategori', 'deskripsi'));

            return response()->json(['status' => true, 'message' => 'Data berhasil diperbarui']);
        }
    }

    public function confirm_ajax($id)
    {
        $data = KategoriPertanyaanModel::findOrFail($id);
        return view('kategori_pertanyaan.delete_ajax', compact('data'));
    }

    public function delete_ajax($id)
    {
        $kategori = KategoriPertanyaanModel::findOrFail($id);

        try {
            $kategori->delete();
            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data', 'error' => $e->getMessage()], 500);
        }
    }
}
