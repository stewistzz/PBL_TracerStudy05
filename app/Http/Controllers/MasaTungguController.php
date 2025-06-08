<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniModel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MasaTungguController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data alumni dengan tracer studies
        $alumniList = AlumniModel::with(['tracerStudies'])->get();

        $data = $alumniList->map(function ($alumni) {
            $tracer = $alumni->tracerStudies->first();
            $masaTunggu = null;

            if ($tracer && $tracer->tanggal_pertama_kerja && $alumni->tahun_lulus) {
                $tanggalKerja = Carbon::parse($tracer->tanggal_pertama_kerja);
                // Ambil awal tahun kelulusan
                $tahunLulus = Carbon::createFromDate($alumni->tahun_lulus, 1, 1);
                $masaTunggu = $tahunLulus->diffInMonths($tanggalKerja);
            }

            return [
                'nama' => $alumni->nama,
                'nim' => $alumni->nim,
                'program_studi' => $alumni->program_studi,
                'tahun_lulus' => $alumni->tahun_lulus ?? '-',
                'tanggal_pertama_kerja' => $tracer && $tracer->tanggal_pertama_kerja
                    ? Carbon::parse($tracer->tanggal_pertama_kerja)->format('Y-m-d')
                    : '-',
                'masa_tunggu' => $masaTunggu !== null ? $masaTunggu . ' bulan' : 'Belum tersedia'
            ];
        });

        return view('masa_tunggu.index', compact('data'));
    }

    public function filter_ajax()
    {
        return view('alumni.filter_ajax');
    }

    public function export_excel(Request $request)
    {
        $data = AlumniModel::with('tracerStudies')
            ->when($request->program_studi, fn($q) => $q->where('program_studi', $request->program_studi))
            ->when($request->tahun_lulus_start, fn($q) => $q->whereYear('tahun_lulus', '>=', $request->tahun_lulus_start))
            ->when($request->tahun_lulus_end, fn($q) => $q->whereYear('tahun_lulus', '<=', $request->tahun_lulus_end))
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Alumni');

        // Header kolom
        $sheet->fromArray([
            ['No', 'Nama', 'NIM', 'Program Studi', 'Tahun Lulus', 'Tanggal Pertama Kerja', 'Masa Tunggu (bulan)']
        ], NULL, 'A1');

        // Isi data
        foreach ($data as $index => $item) {
            // Hitung masa tunggu jika memungkinkan
            $masaTunggu = '-';
            if ($item->tahun_lulus && $item->tanggal_pertama_kerja) {
                try {
                    $tahunLulus = \Carbon\Carbon::parse($item->tahun_lulus);
                    $tanggalKerja = \Carbon\Carbon::parse($item->tanggal_pertama_kerja);
                    $masaTunggu = $tahunLulus->diffInMonths($tanggalKerja) . ' bulan';
                } catch (\Exception $e) {
                    $masaTunggu = '-';
                }
            }

            $sheet->fromArray([
                $index + 1,
                $item->nama ?? '-',
                $item->nim ?? '-',
                $item->program_studi ?? '-',
                $item->tahun_lulus ?? '-',
                $item->tanggal_pertama_kerja ?? '-',
                $masaTunggu
            ], NULL, 'A' . ($index + 2));
        }

        // Auto-size kolom
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Buat file Excel dan kirim sebagai download
        $filename = 'Data_Masa_Tunggu_' . now()->format('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    
}
