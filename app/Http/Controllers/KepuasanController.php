<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\DataPenggunaModel;

class KepuasanController extends Controller
{
    public function index()
    {
        return view('kepuasan.index');
    }

    // menampilkan data alumni yang belum mengisi tracer
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

    // Header
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama');
    $sheet->setCellValue('C1', 'Instansi');
    $sheet->setCellValue('D1', 'Jabatan');
    $sheet->setCellValue('E1', 'No HP');
    $sheet->setCellValue('F1', 'Email');
    $sheet->setCellValue('G1', 'Status');

    $sheet->getStyle("A1:G1")->getFont()->setBold(true);

    // Data
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