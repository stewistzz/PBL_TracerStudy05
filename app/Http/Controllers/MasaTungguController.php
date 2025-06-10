<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniModel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

class MasaTungguController extends Controller
{
    public function index(Request $request)
    {
        return view('masa_tunggu.index');
    }

    public function getData(Request $request)
    {
        $programStudi = $request->input('program_studi');
        $tahunLulusStart = $request->input('tahun_lulus_start');
        $tahunLulusEnd = $request->input('tahun_lulus_end');

        $query = AlumniModel::with(['tracerStudies']);

        if ($programStudi) {
            $query->where('program_studi', $programStudi);
        }

        if ($tahunLulusStart && $tahunLulusEnd) {
            $query->whereBetween('tahun_lulus', [$tahunLulusStart, $tahunLulusEnd]);
        } elseif ($tahunLulusStart) {
            $query->where('tahun_lulus', '>=', $tahunLulusStart);
        } elseif ($tahunLulusEnd) {
            $query->where('tahun_lulus', '<=', $tahunLulusEnd);
        }

        return DataTables::of($query)
            ->addColumn('tanggal_pertama_kerja', function ($alumni) {
                return optional($alumni->tracerStudies->first())->tanggal_pertama_kerja ?? '-';
            })
            ->addColumn('masa_tunggu', function ($alumni) {
                $tracer = $alumni->tracerStudies->first();
                if ($tracer && $tracer->tanggal_pertama_kerja && $alumni->tahun_lulus) {
                    $tanggalKerja = Carbon::parse($tracer->tanggal_pertama_kerja);
                    $tahunLulus = Carbon::createFromDate($alumni->tahun_lulus, 1, 1);
                    return $tahunLulus->diffInMonths($tanggalKerja);
                }
                return '-';
            })
            ->make(true);
    }


    public function filter_ajax()
    {
        return view('masa_tunggu.filter_ajax');
    }

    public function export_excel(Request $request)
    {
        $data = AlumniModel::with('tracerStudies')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'NIM');
        $sheet->setCellValue('D1', 'Program Studi');
        $sheet->setCellValue('E1', 'Tahun Lulus');
        $sheet->setCellValue('F1', 'Tanggal Pertama Kerja');
        $sheet->setCellValue('G1', 'Masa Tunggu (bulan)');

        $sheet->getStyle("A1:G1")->getFont()->setBold(true);

        $no = 1;
        $baris = 2;

        foreach ($data as $value) {
            $tanggalKerja = null;

            // Ambil tracer study pertama (jika ada)
            $tracer = $value->tracerStudies->first();
            if ($tracer) {
                $tanggalKerja = $tracer->tanggal_pertama_kerja;
            }

            // Hitung masa tunggu (bulan)
            $masaTunggu = '-';
            if ($value->tahun_lulus && $tanggalKerja) {
                $tahunLulus = Carbon::parse($value->tahun_lulus);
                $tanggalKerja = Carbon::parse($tanggalKerja);
                $diffInMonths = $tahunLulus->diffInMonths($tanggalKerja);
                $masaTunggu = $diffInMonths . ' bulan';
            }

            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama);
            $sheet->setCellValue('C' . $baris, $value->nim);
            $sheet->setCellValue('D' . $baris, $value->program_studi);
            $sheet->setCellValue('E' . $baris, $value->tahun_lulus ? Carbon::parse($value->tahun_lulus)->format('Y') : '-');
            $sheet->setCellValue('F' . $baris, $tanggalKerja ? Carbon::parse($tanggalKerja)->format('Y-m-d') : '-');
            $sheet->setCellValue('G' . $baris, $masaTunggu);

            $no++;
            $baris++;
        }

        // Auto-size kolom
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Nama Sheet
        $sheet->setTitle('Data Kuisioner Tracer Alumni');

        // Buat file Excel
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Masa_Tunggu_Alumni_' . date("Y-m-d") . ".xlsx";

        // Header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Pragma: public');

        // Output file
        $writer->save('php://output');
        exit;
    }
}
