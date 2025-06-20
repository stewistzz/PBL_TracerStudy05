<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstansiModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;


class InstansiController extends Controller
{
    public function index()
    {
        // return view('instansi.index', [
        //     'instansis' => InstansiModel::all()
        // ]);

        // Ambil semua data instansi
        $instansis = InstansiModel::all();

        // Ambil data jumlah alumni berdasarkan jenis instansi
        $instansiData = DB::table('instansi')
            ->leftJoin('tracer_study', 'instansi.instansi_id', '=', 'tracer_study.instansi_id')
            ->select('instansi.jenis_instansi', DB::raw('COUNT(tracer_study.tracer_id) as total'))
            ->groupBy('instansi.jenis_instansi')
            ->get();

        // Kirim kedua data ke view
        return view('instansi.index', compact('instansis', 'instansiData'));
    }

    public function list()
    {
        $data = InstansiModel::select([
            'instansi_id',
            'nama_instansi',
            'jenis_instansi',
            'skala',
            'lokasi',
            'no_hp'
        ]);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm py-2 btn-warning btn-edit mr-2" data-id="' . $row->instansi_id . '">
                                <i class="mdi mdi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-hapus" data-id="' . $row->instansi_id . '">
                                <i class="mdi mdi-delete"></i> Hapus
                            </button>
                        </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('instansi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // DIPERBAIKI: Validasi harus sama dengan update
        $validator = Validator::make($request->all(), [
            'nama_instansi' => 'required|string|max:50|unique:instansi,nama_instansi',
            'jenis_instansi' => 'required|in:Pendidikan Tinggi,Pemerintah,Swasta,BUMN',
            'skala' => 'required|in:nasional,internasional,wirausaha',
            'lokasi' => 'required|string|max:100',
            // 'alamat' => 'nullable|string|max:30',
            'no_hp' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // DIPERBAIKI: Simpan semua field yang diperlukan
        InstansiModel::create($request->only([
            'nama_instansi',
            'jenis_instansi',
            'skala',
            'lokasi',
            // 'alamat', 
            'no_hp'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Data instansi berhasil ditambahkan'
        ]);
    }

    public function edit_ajax($id)
    {
        $instansi = InstansiModel::findOrFail($id);
        return view('instansi.edit_ajax', compact('instansi'));
    }

    public function update_ajax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_instansi' => 'required|string|max:50|unique:instansi,nama_instansi,' . $id . ',instansi_id',
            'jenis_instansi' => 'required|in:Pendidikan Tinggi,Pemerintah,Swasta,BUMN',
            'skala' => 'required|in:nasional,internasional,wirausaha',
            'lokasi' => 'required|string|max:100',
            // 'alamat' => 'nullable|string|max:30',
            'no_hp' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $instansi = InstansiModel::findOrFail($id);
        // dd($request->all());
        $instansi->update($request->only([
            'nama_instansi',
            'jenis_instansi',
            'skala',
            'lokasi',
            // 'alamat',
            'no_hp'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Data instansi berhasil diperbarui'
        ]);
    }

    /*public function destroy_ajax($id)
    {
        $instansi = InstansiModel::findOrFail($id);
        $instansi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data instansi berhasil dihapus'
        ]);
    } */

    public function confirm_ajax($id)
{
    $instansi = InstansiModel::findOrFail($id);
    return view('instansi.delete_ajax', compact('instansi'));
}

public function delete_ajax($id)
{
    $instansi = InstansiModel::findOrFail($id);

    try {
        $instansi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data instansi berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Gagal menghapus data instansi.',
            'error' => $e->getMessage()
        ], 500);
    }
}


}
