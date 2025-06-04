<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniModel;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AlumniController extends Controller
{
    public function index()
    {
        return view('alumni.index');
    }

    public function filter_ajax()
    {
        return view('alumni.filter_ajax');
    }

    public function list(Request $request)
    {
        $data = AlumniModel::with('user')->select([
            'alumni_id',
            'user_id',
            'nama',
            'nim',
            'email',
            'no_hp',
            'program_studi',
            'tahun_lulus'
        ]);

        if ($request->has('program_studi') && $request->program_studi != '') {
            $data->where('program_studi', $request->program_studi);
        }

        if ($request->has('tahun_lulus_start') && $request->tahun_lulus_start != '') {
            $data->whereYear('tahun_lulus', '>=', $request->tahun_lulus_start);
        }

        if ($request->has('tahun_lulus_end') && $request->tahun_lulus_end != '') {
            $data->whereYear('tahun_lulus', '<=', $request->tahun_lulus_end);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('username', function ($row) {
                return $row->user ? $row->user->username : '-';
            })
            ->addColumn('tahun_lulus_formatted', function ($row) {
                return $row->tahun_lulus ? $row->tahun_lulus->format('Y') : '-';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm py-2 btn-primary btn-edit mr-2" data-id="' . $row->alumni_id . '">
                            <i class="mdi mdi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger btn-hapus" data-id="' . $row->alumni_id . '">
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
        $users = UsersModel::whereDoesntHave('alumni')->get();
        return view('alumni.create_ajax', compact('users'));
    }

    public function store_ajax(Request $request)
    {
        \Log::info('Store Request Data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id|unique:alumni,user_id',
            'nama' => 'nullable|string|max:50',
            'nim' => 'nullable|string|max:50',
            'email' => 'required|email|max:20|unique:alumni,email',
            'no_hp' => 'required|string|max:20',
            'program_studi' => 'nullable|string|max:20',
            'tahun_lulus' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation Errors: ', $validator->errors()->toArray());
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            AlumniModel::create($request->only([
                'user_id',
                'nama',
                'nim',
                'email',
                'no_hp',
                'program_studi',
                'tahun_lulus'
            ]));
            \Log::info('Create Success for user_id: ' . $request->user_id);

            return response()->json([
                'status' => true,
                'message' => 'Data alumni berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            \Log::error('Create Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan sistem!'
            ], 500);
        }
    }

    public function edit_ajax($id)
    {
        $alumni = AlumniModel::with('user')->where('alumni_id', $id)->firstOrFail();
        $users = UsersModel::all();
        \Log::info('Alumni Data: ', $alumni->toArray());
        return view('alumni.edit_ajax', compact('alumni', 'users'));
    }

    public function update_ajax(Request $request, $id)
    {
        \Log::info('Update Request Data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id|unique:alumni,user_id,' . $id . ',alumni_id',
            'nama' => 'nullable|string|max:50',
            'nim' => 'nullable|string|max:50',
            'email' => 'required|email|max:20|unique:alumni,email,' . $id . ',alumni_id',
            'no_hp' => 'required|string|max:20',
            'program_studi' => 'nullable|string|max:20',
            'tahun_lulus' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation Errors: ', $validator->errors()->toArray());
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $alumni = AlumniModel::where('alumni_id', $id)->firstOrFail();
            $alumni->update($request->only([
                'nama',
                'nim',
                'email',
                'no_hp',
                'program_studi',
                'tahun_lulus'
            ]));
            \Log::info('Update Success for alumni_id: ' . $id);

            return response()->json([
                'status' => true,
                'message' => 'Data alumni berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            \Log::error('Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan sistem!'
            ], 500);
        }
    }

    public function destroy_ajax($id)
    {
        $alumni = AlumniModel::where('alumni_id', $id)->firstOrFail();
        $alumni->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data alumni berhasil dihapus'
        ]);
    }

    public function confirm_ajax($id)
    {
        $data = AlumniModel::where('alumni_id', $id)->firstOrFail();
        return view('alumni.delete_ajax', compact('data'));
    }

    public function delete_ajax($id)
    {
        $alumni = AlumniModel::where('alumni_id', $id)->firstOrFail();

        try {
            $alumni->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data alumni berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data alumni.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     public function export_excel(Request $request)
    {
        $data = AlumniModel::select([
            'alumni_id',
            'user_id',
            'nama',
            'nim',
            'email',
            'no_hp',
            'program_studi',
            'tahun_lulus'
        ]);

        // Terapkan filter jika ada
        if ($request->has('program_studi') && $request->program_studi != '') {
            $data->where('program_studi', $request->program_studi);
        }

        if ($request->has('tahun_lulus_start') && $request->tahun_lulus_start != '') {
            $data->whereYear('tahun_lulus', '>=', $request->tahun_lulus_start);
        }

        if ($request->has('tahun_lulus_end') && $request->tahun_lulus_end != '') {
            $data->whereYear('tahun_lulus', '<=', $request->tahun_lulus_end);
        }

        $alumni = $data->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Alumni');

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'NIM');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'No HP');
        $sheet->setCellValue('F1', 'Program Studi');
        $sheet->setCellValue('G1', 'Tahun Lulus');

        // Isi data
        $row = 2;
        foreach ($alumni as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->nama ?? '-');
            $sheet->setCellValue('C' . $row, $item->nim ?? '-');
            $sheet->setCellValue('D' . $row, $item->email);
            $sheet->setCellValue('E' . $row, $item->no_hp);
            $sheet->setCellValue('F' . $row, $item->program_studi ?? '-');
            $sheet->setCellValue('G' . $row, $item->tahun_lulus ? $item->tahun_lulus->format('Y') : '-');
            $row++;
        }

        // Auto-size kolom
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Header untuk download
        $filename = 'Data_Alumni_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Simpan ke output
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}