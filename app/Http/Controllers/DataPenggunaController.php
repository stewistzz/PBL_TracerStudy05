<?php

namespace App\Http\Controllers;

use App\Models\DataPenggunaModel;
use Illuminate\Http\Request;
use App\Models\PenggunaLulusan;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataPenggunaController extends Controller
{
    public function index()
    {
        return view('data_pengguna.index');
    }

    public function list(Request $request)
    {
        try {
            Log::info('DataTables request received', [
                'is_ajax' => $request->ajax(),
                'request_data' => $request->all()
            ]);

            if (!$request->ajax()) {
                return response()->json([
                    'error' => 'This endpoint only accepts AJAX requests',
                    'is_ajax' => false
                ], 400);
            }

            $count = DataPenggunaModel::count();
            Log::info('Total records in database: ' . $count);

            $data = DataPenggunaModel::select([
                'pengguna_id',
                'nama',
                'instansi',
                'jabatan',
                'no_hp',
                'email'
            ]);

            $dataTable = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm py-2 btn-warning btn-edit mr-2" data-id="' . $row->pengguna_id . '">
                                <i class="mdi mdi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-hapus" data-id="' . $row->pengguna_id . '">
                                <i class="mdi mdi-delete"></i> Hapus
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);

            Log::info('DataTables response prepared successfully');
            return $dataTable;
        } catch (\Exception $e) {
            Log::error('DataTables error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'error' => 'Server error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create_ajax()
    {
        return view('data_pengguna.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        try {
            Log::info('Store request received', $request->all());

            $validator = Validator::make($request->all(), [
                'nama'     => 'required|string|max:50',
                'instansi' => 'required|string|max:255',
                'jabatan'  => 'required|string|max:100',
                'no_hp'    => 'required|string|max:20',
                'email'    => 'required|email|max:255|unique:pengguna_lulusan,email',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed', $validator->errors()->toArray());
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $pengguna = DataPenggunaModel::create($request->only([
                'nama',
                'instansi',
                'jabatan',
                'no_hp',
                'email'
            ]));

            Log::info('Data created successfully', ['id' => $pengguna->pengguna_id]);

            return response()->json([
                'status' => true,
                'message' => 'Data pengguna lulusan berhasil ditambahkan',
                'data' => $pengguna
            ]);
        } catch (\Exception $e) {
            Log::error('Store error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit_ajax($id)
    {
        try {
            $pengguna = DataPenggunaModel::findOrFail($id);
            return view('data_pengguna.edit_ajax', compact('pengguna'));
        } catch (\Exception $e) {
            abort(404, 'Data tidak ditemukan');
        }
    }

    public function update_ajax(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama'     => 'required|string|max:50',
                'instansi' => 'required|string|max:255',
                'jabatan'  => 'required|string|max:100',
                'no_hp'    => 'required|string|max:20',
                'email'    => 'required|email|max:255|unique:pengguna_lulusan,email,' . $id . ',pengguna_id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $pengguna = DataPenggunaModel::findOrFail($id);
            $pengguna->update($request->only([
                'nama',
                'instansi',
                'jabatan',
                'no_hp',
                'email'
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data pengguna lulusan berhasil diperbarui',
                'data' => $pengguna
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy_ajax($id)
    {
        try {
            $pengguna = DataPenggunaModel::findOrFail($id);
            $pengguna->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data pengguna lulusan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function import()
    {
        return view('data_pengguna.import');
    }

    public function import_ajax(Request $request)
    {
        $rules = [
            'file_pengguna' => ['required', 'mimes:xlsx,xls', 'max:1024'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            $file = $request->file('file_pengguna');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (count($rows) > 0) {
                $header = array_shift($rows);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'File kosong atau tidak ada data.',
                ]);
            }

            $insert = [];
            foreach ($rows as $row) {
                if (!empty($row[0])) {
                    $insert[] = [
                        'nama' => $row[0] ?? null,
                        'instansi' => $row[1] ?? null,
                        'jabatan' => $row[2] ?? null,
                        'no_hp' => $row[3] ?? null,
                        'email' => $row[4] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($insert)) {
                DataPenggunaModel::insertOrIgnore($insert);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimpor: ' . count($insert) . ' pengguna',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data valid untuk diimpor dari file.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat proses impor: ' . $e->getMessage(),
            ]);
        }
    }

    public function penggunaBelumIsi()
    {
        $data = DataPenggunaModel::whereDoesntHave('jawaban')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function () {
                return '<span class="badge bg-danger">Belum Mengisi</span>';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function exportPenggunaBelumIsi()
    {
        $pengguna = DataPenggunaModel::whereDoesntHave('jawaban')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Instansi');
        $sheet->setCellValue('D1', 'Jabatan');
        $sheet->setCellValue('E1', 'No_HP');
        $sheet->setCellValue('F1', 'Email');
        $sheet->setCellValue('G1', 'Status');
        $sheet->getStyle("A1:G1")->getFont()->setBold(true);

        $row = 2;
        $no = 1;
        foreach ($pengguna as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->nama);
            $sheet->setCellValue('C' . $row, $item->instansi);
            $sheet->setCellValue('D' . $row, $item->jabatan);
            $sheet->setCellValue('E' . $row, $item->no_hp);
            $sheet->setCellValue('F' . $row, $item->email);
            $sheet->setCellValue('G' . $row, 'Belum Mengisi');
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Pengguna_Belum_Mengisi_' . now()->format('Ymd_His') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
