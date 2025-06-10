<?php

namespace App\Http\Controllers;

use App\Models\JawabanAlumniModel;
use App\Models\PertanyaanModel;
use App\Models\AlumniModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class JawabanAlumniController extends Controller
{
    public function index()
    {
        return view('jawaban_alumni.index');
    }

    public function list(Request $request)
    {
        $jawaban = JawabanAlumniModel::with(['alumni', 'pertanyaan'])
            ->select('jawaban_alumni.*')
            ->whereHas('pertanyaan', function ($query) {
                $query->where('role_target', 'alumni');
            });

        // Filter berdasarkan pertanyaan
        if ($request->has('pertanyaan_id') && $request->pertanyaan_id != '') {
            $jawaban->where('pertanyaan_id', $request->pertanyaan_id);
        }

        // Filter berdasarkan nama alumni
        if ($request->has('alumni') && $request->alumni != '') {
            $jawaban->whereHas('alumni', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->alumni . '%');
            });
        }

        return DataTables::of($jawaban)
            ->addColumn('alumni', function ($row) {
                return $row->alumni ? $row->alumni->nama : '-';
            })
            ->addColumn('pertanyaan', function ($row) {
                return $row->pertanyaan ? $row->pertanyaan->isi_pertanyaan : '-';
            })
            ->addColumn('action', function ($row) {
                $action = '<button class="btn btn-sm btn-danger btn-hapus" data-id="' . $row->jawaban_id . '"><i class="mdi mdi-delete"></i> Delete</button>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function filter()
    {
        return view('jawaban_alumni.filter_ajax');
    }

    public function getPertanyaan()
    {
        $pertanyaans = PertanyaanModel::where('role_target', 'alumni')->get();
        return response()->json($pertanyaans);
    }

    public function confirm_ajax($id)
    {
        $jawaban = JawabanAlumniModel::with('pertanyaan')->findOrFail($id);
        return view('jawaban_alumni.delete_ajax', compact('jawaban'));
    }

    public function delete_ajax(Request $request, $id)
    {
        $jawaban = JawabanAlumniModel::findOrFail($id);
        $jawaban->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data jawaban alumni berhasil dihapus.'
        ]);
    }

    public function export_excel(Request $request)
    {
        $jawaban = JawabanAlumniModel::with(['alumni', 'pertanyaan'])
            ->select('jawaban_alumni.*')
            ->whereHas('pertanyaan', function ($query) {
                $query->where('role_target', 'alumni');
            });

        // Filter berdasarkan pertanyaan
        if ($request->has('pertanyaan_id') && $request->pertanyaan_id != '') {
            $jawaban->where('pertanyaan_id', $request->pertanyaan_id);
        }

        // Filter berdasarkan nama alumni
        if ($request->has('alumni') && $request->alumni != '') {
            $jawaban->whereHas('alumni', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->alumni . '%');
            });
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Alumni');
        $sheet->setCellValue('C1', 'Pertanyaan');
        $sheet->setCellValue('D1', 'Jawaban');
        $sheet->setCellValue('E1', 'Tanggal');

        // Data
        $jawaban = $jawaban->get();
        $row = 2;
        foreach ($jawaban as $index => $data) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $data->alumni ? $data->alumni->nama : '-');
            $sheet->setCellValue('C' . $row, $data->pertanyaan ? $data->pertanyaan->isi_pertanyaan : '-');
            $sheet->setCellValue('D' . $row, $data->jawaban);
            $sheet->setCellValue('E' . $row, $data->tanggal);
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Output
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'jawaban_alumni_' . ($request->has('pertanyaan_id') || $request->has('alumni') ? 'filtered_' : '') . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}