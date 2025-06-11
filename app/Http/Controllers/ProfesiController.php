<?php

namespace App\Http\Controllers;

use App\Models\ProfesiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoriProfesiModel; // jika kategori disimpan di tabel lain
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfesiController extends Controller
{
    public function index()
    {
        $data = DB::table('tracer_study')
            ->join('profesi', 'tracer_study.profesi_id', '=', 'profesi.profesi_id')
            ->select('profesi.nama_profesi', DB::raw('COUNT(*) as total'))
            ->groupBy('profesi.nama_profesi')
            ->get();

        $jumlah_profesi = DB::table('profesi')->count(); // Total jenis profesi (15)

        return view('profesi.index', compact('data', 'jumlah_profesi'));
    }

    public function list(Request $request)
    {
        $profesi = ProfesiModel::with('kategoriProfesi')->select('profesi_id', 'nama_profesi', 'kategori_id');

        if ($request->kategori_id) {
            $profesi->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($profesi)
            ->addIndexColumn()
            ->addColumn('kategori', function ($row) {
                return $row->kategoriProfesi->nama_kategori ?? '-';
            })
            ->addColumn('action', function ($row) {
                // $btn = '<button class="btn btn-info btn-sm viewBtn" data-id="' . $row->profesi_id . '">View</button> ';
                // warning
                $btn = '<button onclick="modalAction(\'' . url('/profesi/' . $row->profesi_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm py-1"><i class="mdi mdi-pencil"></i>edit</button> ';
                // danger
                $btn .= '<button onclick="modalAction(\'' . url('/profesi/' . $row->profesi_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm py-1"><i class="mdi mdi-delete"></i>delete</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    // create dengan ajax
    public function create_ajax()
    {
        $kategori = KategoriProfesiModel::select('kategori_id', 'nama_kategori')->get();

        return view('profesi.create_ajax')->with('kategori', $kategori);;
    }

    public function store_ajax(Request $request)
    {


        // dd($request->all());
        // dd($request->ajax() || $request->wantsJson());

        if ($request->ajax() || $request->wantsJson()) {


            // Tambahkan debug ini untuk melihat semua data yang dikirim

            $rules = [
                'nama_profesi' => 'required|string|max:50|unique:profesi,nama_profesi',
                'kategori_id' => 'required|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            ProfesiModel::create([
                'nama_profesi' => $request->nama_profesi,
                'kategori_id' => $request->kategori_id,
            ]);

            return response()->json(data: [
                'status' => true,
                'message' => 'Data profesi berhasil disimpan'
            ]);
        }
        return redirect('profesi/');
    }

    // edit
    public function edit_ajax($id)
    {
        $data = ProfesiModel::findOrFail($id);
        $kategori = KategoriProfesiModel::all();

        return view('profesi.edit_ajax', compact('data', 'kategori'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_profesi' => 'required|string|max:50|unique:profesi,nama_profesi,' . $id . ',profesi_id',
                'kategori_id' => 'required|integer',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $profesi = ProfesiModel::findOrFail($id);
            $profesi->update([
                'nama_profesi' => $request->nama_profesi,
                'kategori_id' => $request->kategori_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data profesi berhasil diperbarui'
            ]);
        }

        return redirect()->route('profesi.index');
    }

    // delete ajax
    public function confirm_ajax($id)
    {
        $data = ProfesiModel::findOrFail($id);

        return view('profesi.delete_ajax', compact('data'));
    }

    public function delete_ajax($id)
    {
        $profesi = ProfesiModel::findOrFail($id);

        try {
            $profesi->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data profesi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data profesi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // chart controller
    public function chart()
    {
        $data = DB::table('tracer_study')
            ->join('profesi', 'tracer_study.profesi_id', '=', 'profesi.profesi_id')
            ->select('profesi.nama_profesi', DB::raw('COUNT(*) as total'))
            ->groupBy('profesi.nama_profesi')
            ->get();

        return view('your_view', compact('data'));
    }
}