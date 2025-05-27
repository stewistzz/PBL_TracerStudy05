<?php
// app/Http/Controllers/KategoriProfesiController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriProfesiModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class KategoriProfesiController extends Controller
{
    public function index()
    {
        return view('kategori_profesi.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriProfesiModel::select(['kategori_id', 'nama_kategori']);

            return DataTables::of($data)
                ->addIndexColumn() // otomatis buat kolom "No"
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm py-2 btn-warning btn-edit" data-id="' . $row->kategori_id . '">
                                <i class="mdi mdi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-hapus" data-id="' . $row->kategori_id . '">
                                <i class="mdi mdi-delete"></i> Hapus
                            </button>
                        </div>
                        ';
                })

                ->rawColumns(['action']) // biar button tidak di-escape
                ->make(true);
        }
    }

    public function store_ajax(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:100|unique:kategori_profesi,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.string' => 'Nama kategori harus berupa teks',
            'nama_kategori.max' => 'Nama kategori maksimal 10 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            KategoriProfesiModel::create([
                'nama_kategori' => $request->nama_kategori
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil ditambahkan'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan kategori'
            ], 500);
        }
    }

    public function create_ajax()
    {
        return view('kategori_profesi.create_ajax');
    }

    public function edit_ajax($id)
    {
        try {
            $kategori = KategoriProfesiModel::findOrFail($id);
            return view('kategori_profesi.edit_ajax', compact('kategori'));
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }
    }

    public function show_ajax($id)
    {
        try {
            $data = KategoriProfesiModel::findOrFail($id);
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update_ajax(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:100|unique:kategori_profesi,nama_kategori,' . $id . ',kategori_id',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.string' => 'Nama kategori harus berupa teks',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kategori = KategoriProfesiModel::findOrFail($id);
            $kategori->update([
                'nama_kategori' => $request->nama_kategori
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil diperbarui'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui kategori'
            ], 500);
        }
    }

    public function destroy_ajax($id)
    {
        try {
            $kategori = KategoriProfesiModel::findOrFail($id);
            $kategori->delete();

            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus kategori'
            ], 500);
        }
    }
}
