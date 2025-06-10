<?php

namespace App\Http\Controllers;

use App\Models\JawabanPenggunaModel;
use App\Models\PertanyaanModel;
use App\Models\PenggunaLulusanModel;
use App\Models\AlumniModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class JawabanPenggunaController extends Controller
{
    public function index()
    {
        return view('jawaban_pengguna.index');
    }

    public function list(Request $request)
    {
        $jawaban = JawabanPenggunaModel::with(['pengguna', 'alumni', 'pertanyaan'])->select('jawaban_pengguna.*');

        // Filter berdasarkan pertanyaan (dropdown)
        if ($request->has('pertanyaan_id') && $request->pertanyaan_id != '') {
            $jawaban->where('pertanyaan_id', $request->pertanyaan_id);
        }

        // Filter berdasarkan nama pengguna (search)
        if ($request->has('pengguna') && $request->pengguna != '') {
            $jawaban->whereHas('pengguna', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->pengguna . '%');
            });
        }

        // Filter berdasarkan nama alumni (search)
        if ($request->has('alumni') && $request->alumni != '') {
            $jawaban->whereHas('alumni', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->alumni . '%');
            });
        }

        return DataTables::of($jawaban)
            ->addColumn('pengguna', function ($row) {
                return $row->pengguna ? $row->pengguna->nama : '-';
            })
            ->addColumn('alumni', function ($row) {
                return $row->alumni ? $row->alumni->nama : '-';
            })
            ->addColumn('pertanyaan', function ($row) {
                return $row->pertanyaan ? $row->pertanyaan->isi_pertanyaan : '-';
            })
            ->addColumn('action', function ($row) {
                $action = '<button class="btn btn-sm btn-danger btn-hapus py-2" data-id="' . $row->jawaban_id . '"><i class="mdi mdi-delete"></i> Delete</button>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function filter()
    {
        return view('jawaban_pengguna.filter_ajax');
    }

    public function getPertanyaan()
    {
        $pertanyaans = PertanyaanModel::all();
        return response()->json($pertanyaans);
    }

    public function confirm_ajax($id)
    {
        $jawaban = JawabanPenggunaModel::with('pertanyaan')->findOrFail($id);
        return view('jawaban_pengguna.delete_ajax', compact('jawaban'));
    }

    public function delete_ajax(Request $request, $id)
    {
        $jawaban = JawabanPenggunaModel::findOrFail($id);
        $jawaban->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data jawaban berhasil dihapus.'
        ]);
    }

    public function export_excel(Request $request)
    {
        $jawaban = JawabanPenggunaModel::with(['pengguna', 'alumni', 'pertanyaan'])->select('jawaban_pengguna.*');

        // Filter berdasarkan pertanyaan (dropdown)
        if ($request->has('pertanyaan_id') && $request->pertanyaan_id != '') {
            $jawaban->where('pertanyaan_id', $request->pertanyaan_id);
        }

        // Filter berdasarkan nama pengguna (search)
        if ($request->has('pengguna') && $request->pengguna != '') {
            $jawaban->whereHas('pengguna', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->pengguna . '%');
            });
        }

        // Filter berdasarkan nama alumni (search)
        if ($request->has('alumni') && $request->alumni != '') {
            $jawaban->whereHas('alumni', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->alumni . '%');
            });
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Pengguna');
        $sheet->setCellValue('C1', 'Alumni');
        $sheet->setCellValue('D1', 'Pertanyaan');
        $sheet->setCellValue('E1', 'Jawaban');
        $sheet->setCellValue('F1', 'Tanggal');

        // Data
        $jawaban = $jawaban->get();
        $row = 2;
        foreach ($jawaban as $index => $data) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $data->pengguna ? $data->pengguna->nama : '-');
            $sheet->setCellValue('C' . $row, $data->alumni ? $data->alumni->nama : '-');
            $sheet->setCellValue('D' . $row, $data->pertanyaan ? $data->pertanyaan->isi_pertanyaan : '-');
            $sheet->setCellValue('E' . $row, $data->jawaban);
            $sheet->setCellValue('F' . $row, $data->tanggal);
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Output
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'jawaban_pengguna_' . ($request->has('pertanyaan_id') || $request->has('pengguna') || $request->has('alumni') ? 'filtered_' : '') . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}