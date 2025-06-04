<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JawabanPenggunaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KepuasanController extends Controller
{
    public function index()
    {
        return view('kepuasan.index');
    }
     public function exportExcel()
    {
        // Ambil data kategori
        $categories = DB::table('kategori_pertanyaan')
            ->whereIn('kode_kategori', ['K01', 'K02', 'K03', 'K04', 'K05', 'K06', 'K07'])
            ->get();

        $pertanyaanToKategori = [
            11 => 'K01',
            12 => 'K02',
            13 => 'K03',
            14 => 'K04',
            15 => 'K05',
            16 => 'K06',
            17 => 'K07',
        ];

        $responses = DB::table('jawaban_pengguna')
            ->whereIn('pertanyaan_id', array_keys($pertanyaanToKategori))
            ->select('pertanyaan_id', 'jawaban', 'pengguna_id')
            ->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Jenis Kemampuan');
        $sheet->setCellValue('C1', 'Sangat Baik (%)');
        $sheet->setCellValue('D1', 'Baik (%)');
        $sheet->setCellValue('E1', 'Cukup (%)');
        $sheet->setCellValue('F1', 'Kurang (%)');

        // Bikin header tebal
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        // Isi data dan simpan nilai untuk rata-rata
        $no = 1;
        $baris = 2;
        $totalSangatBaik = 0;
        $totalBaik = 0;
        $totalCukup = 0;
        $totalKurang = 0;
        $totalCategories = count($categories);

        foreach ($categories as $category) {
            $pertanyaan_id = array_search($category->kode_kategori, $pertanyaanToKategori);
            $categoryResponses = $responses->where('pertanyaan_id', $pertanyaan_id);
            $totalCategoryResponses = $categoryResponses->count();

            $counts = [
                'sangat_baik' => $categoryResponses->where('jawaban', 5)->count(),
                'baik' => $categoryResponses->where('jawaban', 4)->count(),
                'cukup' => $categoryResponses->where('jawaban', 3)->count(),
                'kurang' => $categoryResponses->whereIn('jawaban', [1, 2])->count(),
            ];

            $sangatBaik = $totalCategoryResponses ? number_format(($counts['sangat_baik'] / $totalCategoryResponses) * 100, 2) : '0.00';
            $baik = $totalCategoryResponses ? number_format(($counts['baik'] / $totalCategoryResponses) * 100, 2) : '0.00';
            $cukup = $totalCategoryResponses ? number_format(($counts['cukup'] / $totalCategoryResponses) * 100, 2) : '0.00';
            $kurang = $totalCategoryResponses ? number_format(($counts['kurang'] / $totalCategoryResponses) * 100, 2) : '0.00';

            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $category->nama_kategori);
            $sheet->setCellValue('C' . $baris, $sangatBaik);
            $sheet->setCellValue('D' . $baris, $baik);
            $sheet->setCellValue('E' . $baris, $cukup);
            $sheet->setCellValue('F' . $baris, $kurang);

            // Tambah ke total untuk rata-rata
            $totalSangatBaik += (float) $sangatBaik;
            $totalBaik += (float) $baik;
            $totalCukup += (float) $cukup;
            $totalKurang += (float) $kurang;

            $baris++;
            $no++;
        }

        // Hitung rata-rata total
        $avgSangatBaik = $totalCategories ? number_format($totalSangatBaik / $totalCategories, 2) : '0.00';
        $avgBaik = $totalCategories ? number_format($totalBaik / $totalCategories, 2) : '0.00';
        $avgCukup = $totalCategories ? number_format($totalCukup / $totalCategories, 2) : '0.00';
        $avgKurang = $totalCategories ? number_format($totalKurang / $totalCategories, 2) : '0.00';

        // Tambah baris rata-rata total
        $sheet->setCellValue('A' . $baris, '');
        $sheet->setCellValue('B' . $baris, 'Rata-rata Total');
        $sheet->setCellValue('C' . $baris, $avgSangatBaik);
        $sheet->setCellValue('D' . $baris, $avgBaik);
        $sheet->setCellValue('E' . $baris, $avgCukup);
        $sheet->setCellValue('F' . $baris, $avgKurang);

        // Bikin baris rata-rata tebal
        $sheet->getStyle('A' . $baris . ':F' . $baris)->getFont()->setBold(true);

        // Autosize kolom
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set nama sheet
        $sheet->setTitle('Kepuasan Pengguna');

        // Buat writer dan nama file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Kepuasan_Pengguna_K01-K07_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }




















public function list(Request $request)
{
    // Query original yang sudah berjalan
    $categories = DB::table('kategori_pertanyaan')
        ->whereIn('kode_kategori', ['K01', 'K02', 'K03', 'K04', 'K05', 'K06', 'K07'])
        ->get();
        
    $pertanyaanToKategori = [
        11 => 'K01',
        12 => 'K02',
        13 => 'K03',
        14 => 'K04',
        15 => 'K05',
        16 => 'K06',
        17 => 'K07',
    ];
    
    $responses = DB::table('jawaban_pengguna')
        ->whereIn('pertanyaan_id', array_keys($pertanyaanToKategori))
        ->select('pertanyaan_id', 'jawaban', 'pengguna_id')
        ->get();
        
    $data = [];
    $totalResponses = $responses->count();
    $overallCounts = [
        'sangat_baik' => 0,
        'baik' => 0,
        'cukup' => 0,
        'kurang' => 0,
    ];
    
    foreach ($categories as $index => $category) {
        $pertanyaan_id = array_search($category->kode_kategori, $pertanyaanToKategori);
        $categoryResponses = $responses->where('pertanyaan_id', $pertanyaan_id);
        $totalCategoryResponses = $categoryResponses->count();
        
        if ($totalCategoryResponses == 0) {
            $data[] = [
                'DT_RowIndex' => $index + 1,
                'jenis' => $category->nama_kategori,
                'sangat_baik' => '0.00',
                'baik' => '0.00',
                'cukup' => '0.00',
                'kurang' => '0.00',
            ];
            continue;
        }
        
        $counts = [
            'sangat_baik' => $categoryResponses->where('jawaban', 5)->count(),
            'baik' => $categoryResponses->where('jawaban', 4)->count(),
            'cukup' => $categoryResponses->where('jawaban', 3)->count(),
            'kurang' => $categoryResponses->whereIn('jawaban', [1, 2])->count(),
        ];
        
        $overallCounts['sangat_baik'] += $counts['sangat_baik'];
        $overallCounts['baik'] += $counts['baik'];
        $overallCounts['cukup'] += $counts['cukup'];
        $overallCounts['kurang'] += $counts['kurang'];
        
        $data[] = [
            'DT_RowIndex' => $index + 1,
            'jenis' => $category->nama_kategori,
            'sangat_baik' => number_format(($counts['sangat_baik'] / $totalCategoryResponses) * 100, 2),
            'baik' => number_format(($counts['baik'] / $totalCategoryResponses) * 100, 2),
            'cukup' => number_format(($counts['cukup'] / $totalCategoryResponses) * 100, 2),
            'kurang' => number_format(($counts['kurang'] / $totalCategoryResponses) * 100, 2),
        ];
    }
    
    // Hitung total responden unik berdasarkan pengguna_id
    $totalRespondents = $responses->pluck('pengguna_id')->unique()->count();
    
    // Debug: Cek struktur tabel jawaban_pengguna dulu
    $sampleJawaban = DB::table('jawaban_pengguna')->first();
    \Log::info('Sample jawaban_pengguna:', (array)$sampleJawaban);
    
    // Cek apakah ada kolom jawaban_text
    $columns = \Schema::getColumnListing('jawaban_pengguna');
    \Log::info('Kolom jawaban_pengguna:', $columns);
    
    // Coba beberapa kemungkinan nama kolom untuk jawaban teks
    $textResponses = [];
    
    // Kemungkinan 1: Ada kolom jawaban_text
    if (in_array('jawaban_text', $columns)) {
        \Log::info('Using jawaban_text column');
        $textResponses = DB::table('jawaban_pengguna')
            ->whereIn('pertanyaan_id', [18, 19]) // Asumsi ID untuk K08 dan K09
            ->where('jawaban_text', '!=', '')
            ->whereNotNull('jawaban_text')
            ->select('pertanyaan_id', 'jawaban_text as jawaban', 'pengguna_id')
            ->get();
    }
    // Kemungkinan 2: Jawaban teks disimpan di kolom 'jawaban' (sebagai string)
    else {
        \Log::info('Using jawaban column for text');
        $textResponses = DB::table('jawaban_pengguna')
            ->whereIn('pertanyaan_id', [18, 19]) // Asumsi ID untuk K08 dan K09
            ->where('jawaban', 'NOT REGEXP', '^[0-9]+$') // Bukan angka
            ->whereNotNull('jawaban')
            ->select('pertanyaan_id', 'jawaban', 'pengguna_id')
            ->get();
    }
    
    \Log::info('Text responses found:', $textResponses->toArray());
    
    // Kelompokkan jawaban berdasarkan pertanyaan_id
    $groupedTextResponses = [
        'K08' => [],
        'K09' => []
    ];
    
    foreach ($textResponses as $response) {
        if ($response->pertanyaan_id == 18) { // Asumsi pertanyaan_id 18 = K08
            $groupedTextResponses['K08'][] = [
                'jawaban' => $response->jawaban,
                'pengguna_id' => $response->pengguna_id
            ];
        } elseif ($response->pertanyaan_id == 19) { // Asumsi pertanyaan_id 19 = K09
            $groupedTextResponses['K09'][] = [
                'jawaban' => $response->jawaban,
                'pengguna_id' => $response->pengguna_id
            ];
        }
    }
    
    $footer = [
        'sangat_baik' => $totalResponses ? number_format(($overallCounts['sangat_baik'] / $totalResponses) * 100, 2) : '0.00',
        'baik' => $totalResponses ? number_format(($overallCounts['baik'] / $totalResponses) * 100, 2) : '0.00',
        'cukup' => $totalResponses ? number_format(($overallCounts['cukup'] / $totalResponses) * 100, 2) : '0.00',
        'kurang' => $totalResponses ? number_format(($overallCounts['kurang'] / $totalResponses) * 100, 2) : '0.00',
        'responden' => $totalRespondents,
    ];
    
    \Log::info('Final grouped text responses:', $groupedTextResponses);
    
    return response()->json([
        'data' => $data,
        'footer' => $footer,
        'text_responses' => $groupedTextResponses
    ]);
}

    
    public function grafik()
{
    // Ambil data jawaban dengan relasi pertanyaan untuk pertanyaan skala
    $jawaban = JawabanPenggunaModel::with(['pertanyaan', 'pengguna', 'alumni'])
        ->whereHas('pertanyaan', function($query) {
            $query->where('jenis_pertanyaan', 'skala')
                  ->where('role_target', 'pengguna');
        })
        ->get();

    // Kelompokkan data berdasarkan kategori
    $dataKategori = [];
    foreach ($jawaban as $item) {
        $kategori = $item->pertanyaan->kode_kategori;
        $nilai = (int) $item->jawaban; // Convert jawaban text ke integer
        
        if (!isset($dataKategori[$kategori])) {
            $dataKategori[$kategori] = [
                'nama_kategori' => $this->getNamaKategori($kategori),
                'total_jawaban' => 0,
                'total_nilai' => 0,
                'distribusi' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
                'pertanyaan' => $item->pertanyaan->isi_pertanyaan
            ];
        }
        
        if ($nilai >= 1 && $nilai <= 5) {
            $dataKategori[$kategori]['total_jawaban']++;
            $dataKategori[$kategori]['total_nilai'] += $nilai;
            $dataKategori[$kategori]['distribusi'][$nilai]++;
        }
    }

    // Hitung rata-rata untuk setiap kategori
    $rataRataKategori = [];
    $distribusiData = [];
    
    foreach ($dataKategori as $kode => $data) {
        if ($data['total_jawaban'] > 0) {
            $rataRata = round($data['total_nilai'] / $data['total_jawaban'], 2);
            $rataRataKategori[] = [
                'kategori' => $data['nama_kategori'],
                'kode' => $kode,
                'rata_rata' => $rataRata,
                'total_responden' => $data['total_jawaban'],
                'pertanyaan' => $data['pertanyaan']
            ];
            
            $distribusiData[$kode] = [
                'nama' => $data['nama_kategori'],
                'distribusi' => $data['distribusi']
            ];
        }
    }

    // Data untuk Chart.js
    $chartData = [
        'labels' => array_column($rataRataKategori, 'kode'),
        'datasets' => [
            [
                'label' => 'Rata-rata Kepuasan',
                'data' => array_column($rataRataKategori, 'rata_rata'),
                'backgroundColor' => [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(199, 199, 199, 0.8)',
                    'rgba(83, 102, 255, 0.8)',
                    'rgba(255, 99, 255, 0.8)'
                ],
                'borderColor' => [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)',
                    'rgba(255, 99, 255, 1)'
                ],
                'borderWidth' => 1
            ]
        ]
    ];

    // Hitung statistik keseluruhan
    $totalJawaban = collect($rataRataKategori)->sum('total_responden');
    $rataRataKeseluruhan = $totalJawaban > 0 ? 
        round(collect($rataRataKategori)->avg('rata_rata'), 2) : 0;

    return view('kepuasan.grafik', compact(
        'rataRataKategori', 
        'distribusiData', 
        'chartData', 
        'totalJawaban', 
        'rataRataKeseluruhan'
    ));
}

/**
 * Helper function untuk mapping nama kategori
 */
private function getNamaKategori($kode)
{
    $kategoriMap = [
        'K01' => 'Kerja Sama Tim',
        'K02' => 'Keterampilan TI',
        'K03' => 'Bahasa Inggris', 
        'K04' => 'Komunikasi',
        'K05' => 'Inisiatif Belajar',
        'K06' => 'Potensi Kepemimpinan',
        'K07' => 'Etos Kerja',
        'K08' => 'Kompetensi Harapan',
        'K09' => 'Saran Kurikulum'
    ];
    
    return $kategoriMap[$kode] ?? $kode;
}

    public function create_ajax()
    {
        // Placeholder for creating new satisfaction records
        return response()->json(['message' => 'Create form not implemented']);
    }

    public function store_ajax(Request $request)
    {
        // Placeholder for storing new satisfaction records
        return response()->json(['message' => 'Store functionality not implemented']);
    }

    public function edit_ajax($id)
    {
        // Placeholder for editing satisfaction records
        return response()->json(['message' => 'Edit form not implemented']);
    }

    public function update_ajax(Request $request, $id)
    {
        // Placeholder for updating satisfaction records
        return response()->json(['message' => 'Update functionality not implemented']);
    }

    public function destroy_ajax($id)
    {
        // Placeholder for deleting satisfaction records
        return response()->json(['message' => 'Delete functionality not implemented']);
    }


}