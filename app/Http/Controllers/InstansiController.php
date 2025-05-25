<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\InstansiModel;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InstansiController extends Controller
{
    public function index()
    {
        return view('instansi.index', [
            'instansis' => InstansiModel::all()
        ]);
    }

    public function list()
    {
        $data = InstansiModel::select([
            'instansi_id', 'nama_instansi', 'jenis_instansi', 'skala', 'lokasi', 'no_hp'
        ]);
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-warning btn-sm btn-edit" data-id="'.$row->instansi_id.'">Edit</button>
                    <button class="btn btn-danger btn-sm btn-hapus" data-id="'.$row->instansi_id.'">Hapus</button>
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
            'jenis_instansi' => 'required|in:Pendidikan Tinggi,Pemerintah,Swasta',
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
            'jenis_instansi' => 'required|in:Pendidikan Tinggi,Pemerintah,Swasta',
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

    public function destroy_ajax($id)
    {
        $instansi = InstansiModel::findOrFail($id);
        $instansi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data instansi berhasil dihapus'
        ]);
    }
}