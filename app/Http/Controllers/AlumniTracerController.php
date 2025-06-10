<?php

namespace App\Http\Controllers;

use App\Models\TracerStudyModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use App\Models\SurveyTokenModel;
use App\Models\PenggunaLulusanModel;
use App\Models\AlumniPenggunaLulusanModel;
use Illuminate\Support\Str;
use Carbon\Carbon;
// model untuk menampilkan data alumni yang belum mengisi
use App\Models\AlumniModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AlumniTracerController extends Controller
{
    public function index()
    {
        return view('alumni_tracer.index');
    }

    // Method untuk mengambil data untuk dropdown filter
    public function getFilterData()
    {
        $programStudi = AlumniModel::distinct()
            ->whereNotNull('program_studi')
            ->orderBy('program_studi')
            ->pluck('program_studi');

        return response()->json([
            'program_studi' => $programStudi,
        ]);
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = TracerStudyModel::with(['alumni', 'instansi', 'kategoriProfesi', 'profesi']);

            // Terapkan filter
            $data->when($request->filled('program_studi'), function ($query) use ($request) {
                return $query->whereHas('alumni', fn($q) => $q->where('program_studi', $request->program_studi));
            });
            $data->when($request->filled('tahun_lulus_start'), function ($query) use ($request) {
                return $query->whereHas('alumni', fn($q) => $q->whereYear('tahun_lulus', '>=', $request->tahun_lulus_start));
            });
            $data->when($request->filled('tahun_lulus_end'), function ($query) use ($request) {
                return $query->whereHas('alumni', fn($q) => $q->whereYear('tahun_lulus', '<=', $request->tahun_lulus_end));
            });

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('alumni', fn($row) => $row->alumni->nama ?? '-')
                ->addColumn('instansi', fn($row) => $row->instansi->nama_instansi ?? '-')
                ->addColumn('kategori_profesi', fn($row) => $row->kategoriProfesi->nama_kategori ?? '-')
                ->addColumn('profesi', fn($row) => $row->profesi->nama_profesi ?? '-')
                ->addColumn('tanggal_pengisian', fn($row) => optional($row->tanggal_pengisian)->format('Y-m-d'))
                ->addColumn('tanggal_pertama_kerja', fn($row) => optional($row->tanggal_pertama_kerja)->format('Y-m-d'))
                ->addColumn('tanggal_mulai_kerja_instansi_saat_ini', fn($row) => optional($row->tanggal_mulai_kerja_instansi_saat_ini)->format('Y-m-d'))
                ->addColumn('nama_atasan', fn($row) => $row->nama_atasan_langsung ?? '-')
                ->addColumn('jabatan_atasan', fn($row) => $row->jabatan_atasan_langsung ?? '-')
                ->addColumn('no_hp_atasan', fn($row) => $row->no_hp_atasan_langsung ?? '-')
                ->addColumn('email_atasan', fn($row) => $row->email_atasan_langsung ?? '-')
                ->addColumn('masa_tunggu', function ($row) {
                    if ($row->alumni && $row->alumni->tahun_lulus && $row->tanggal_pertama_kerja) {
                        $tahunLulus = \Carbon\Carbon::parse($row->alumni->tahun_lulus);
                        $tanggalKerja = \Carbon\Carbon::parse($row->tanggal_pertama_kerja);
                        $diffInMonths = $tahunLulus->diffInMonths($tanggalKerja);
                        return $diffInMonths . ' bulan';
                    }
                    return '-';
                })
                ->addColumn('status', fn($row) => ucfirst($row->status))
                ->addColumn('action', function ($row) {
                    $btnClass = $row->status === 'done' ? 'btn-success' : ($row->status === 'completed' ? 'btn-success' : 'btn-warning');
                    $btnText  = $row->status === 'done' || $row->status === 'completed' ? 'Terkirim' : 'Kirim';

                    return '
                        <button class="btn btn-sm btn-edit ' . $btnClass . '"
                            data-id="' . $row->tracer_id . '"
                            data-status="' . $row->status . '">' . $btnText . '</button>
                        <button class="btn btn-sm btn-danger btn-delete"
                            data-id="' . $row->tracer_id . '">
                            Hapus
                        </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        abort(403);
    }

    public function kirimToken($id, Request $request)
    {
        $tracer = TracerStudyModel::with('alumni')->findOrFail($id);
        if ($tracer->status === 'draft') {
            return response()->json(['message' => 'Status masih draft. Tidak dapat mengirim token.'], 422);
        }
        if (empty($tracer->email_atasan_langsung)) {
            return response()->json(['message' => 'Email atasan tidak tersedia.'], 422);
        }
        $pengguna = PenggunaLulusanModel::where('email', $tracer->email_atasan_langsung)->first();
        if (!$pengguna) {
            return response()->json(['message' => 'Data atasan tidak ditemukan di pengguna_lulusan.'], 422);
        }
        $relasi = AlumniPenggunaLulusanModel::where('alumni_id', $tracer->alumni_id)
            ->where('pengguna_id', $pengguna->pengguna_id)
            ->first();
        if (!$relasi) {
            return response()->json(['message' => 'Relasi antara alumni dan atasan tidak ditemukan.'], 422);
        }
        $token = SurveyTokenModel::where('pengguna_id', $pengguna->pengguna_id)
            ->where('alumni_id', $tracer->alumni_id)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();
        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan atau sudah kadaluarsa.'], 404);
        }
        $tracer->status = 'completed';
        $tracer->save();
        return response()->json([
            'message' => 'Token siap dikirim dan status diperbarui.',
            'email_data' => [
                'to_email' => $tracer->email_atasan_langsung,
                'to_name' => $tracer->nama_atasan_langsung ?? 'Bapak/Ibu',
                'survey_link' => url('/survey/access/' . $token->token),
            ]
        ]);
    }

    public function destroy($id)
    {
        $tracer = TracerStudyModel::findOrFail($id);
        try {
            $tracer->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data.'], 500);
        }
    }

    public function alumniBelumIsi(Request $request)
    {
        $query = AlumniModel::doesntHave('tracerStudies');

        // Terapkan filter
        if ($request->filled('program_studi')) {
            $query->where('program_studi', $request->program_studi);
        }
        if ($request->filled('tahun_lulus_start')) {
            $query->whereYear('tahun_lulus', '>=', $request->tahun_lulus_start);
        }
        if ($request->filled('tahun_lulus_end')) {
            $query->whereYear('tahun_lulus', '<=', $request->tahun_lulus_end);
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return '<span class="badge bg-danger">Belum Mengisi</span>';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function exportBelumIsi(Request $request)
    {
        $query = AlumniModel::doesntHave('tracerStudies')->orderBy('tahun_lulus');

        // Terapkan filter
        if ($request->filled('program_studi')) {
            $query->where('program_studi', $request->program_studi);
        }
        if ($request->filled('tahun_lulus_start')) {
            $query->whereYear('tahun_lulus', '>=', $request->tahun_lulus_start);
        }
        if ($request->filled('tahun_lulus_end')) {
            $query->whereYear('tahun_lulus', '<=', $request->tahun_lulus_end);
        }

        $alumni = $query->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Program Studi');
        $sheet->setCellValue('F1', 'No HP');
        $sheet->setCellValue('G1', 'Tahun Lulus');
        $sheet->setCellValue('H1', 'Status Pengisian');
        $sheet->getStyle("A1:H1")->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($alumni as $value) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $value->nim);
            $sheet->setCellValue('C' . $baris, $value->nama);
            $sheet->setCellValue('D' . $baris, $value->email);
            $sheet->setCellValue('E' . $baris, $value->program_studi);
            $sheet->setCellValue('F' . $baris, $value->no_hp);
            $sheet->setCellValue('G' . $baris, $value->tahun_lulus);
            $sheet->setCellValue('H' . $baris, 'Belum Mengisi');
            $baris++;
        }

        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->setTitle('Alumni Belum Isi Tracer');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Alumni_Belum_Mengisi_' . date("Y-m-d") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function exportRekapTracer(Request $request)
    {
        $query = TracerStudyModel::with(['alumni', 'instansi', 'kategoriProfesi', 'profesi']);

        // Terapkan filter
        $query->when($request->filled('program_studi'), function ($q) use ($request) {
            return $q->whereHas('alumni', fn($subq) => $subq->where('program_studi', $request->program_studi));
        });
        $query->when($request->filled('tahun_lulus_start'), function ($q) use ($request) {
            return $q->whereHas('alumni', fn($subq) => $subq->whereYear('tahun_lulus', '>=', $request->tahun_lulus_start));
        });
        $query->when($request->filled('tahun_lulus_end'), function ($q) use ($request) {
            return $q->whereHas('alumni', fn($subq) => $subq->whereYear('tahun_lulus', '<=', $request->tahun_lulus_end));
        });

        $tracers = $query->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['No', 'Alumni', 'Instansi', 'Kategori Profesi', 'Profesi', 'Tgl Pengisian', 'Tgl Pertama Kerja', 'Tgl Mulai Instansi', 'Nama Atasan', 'Jabatan Atasan', 'No HP Atasan', 'Email Atasan', 'Masa Tunggu (Bulan)', 'Status'];
        $sheet->fromArray($headers, null, 'A1');
        $sheet->getStyle("A1:N1")->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($tracers as $value) {
            $masaTunggu = '-';
            if ($value->alumni && $value->alumni->tahun_lulus && $value->tanggal_pertama_kerja) {
                $tahunLulus = Carbon::parse($value->alumni->tahun_lulus);
                $tanggalKerja = Carbon::parse($value->tanggal_pertama_kerja);
                $masaTunggu = $tahunLulus->diffInMonths($tanggalKerja);
            }

            $rowData = [
                $no++,
                $value->alumni->nama ?? '-',
                $value->instansi->nama_instansi ?? '-',
                $value->kategoriProfesi->nama_kategori ?? '-',
                $value->profesi->nama_profesi ?? '-',
                optional($value->tanggal_pengisian)->format('Y-m-d'),
                optional($value->tanggal_pertama_kerja)->format('Y-m-d'),
                optional($value->tanggal_mulai_kerja_instansi_saat_ini)->format('Y-m-d'),
                $value->nama_atasan_langsung ?? '-',
                $value->jabatan_atasan_langsung ?? '-',
                $value->no_hp_atasan_langsung ?? '-',
                $value->email_atasan_langsung ?? '-',
                $masaTunggu,
                'Sudah Mengisi'
            ];
            $sheet->fromArray($rowData, null, 'A' . $baris);
            $baris++;
        }

        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->setTitle('Rekap Data Tracer');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Rekap_Data_Tracer_Alumni_' . date("Y-m-d") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}


// public function list(Request $request): JsonResponse
    // {
    //     if ($request->ajax()) {
    //         $data = TracerStudyModel::with(['alumni', 'instansi', 'kategoriProfesi', 'profesi']);

    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('alumni', fn($row) => $row->alumni->nama ?? '-')
    //             ->addColumn('instansi', fn($row) => $row->instansi->nama_instansi ?? '-')
    //             ->addColumn('kategori_profesi', fn($row) => $row->kategoriProfesi->nama_kategori ?? '-')
    //             ->addColumn('profesi', fn($row) => $row->profesi->nama_profesi ?? '-')
    //             ->addColumn('tanggal_pengisian', fn($row) => optional($row->tanggal_pengisian)->format('Y-m-d'))
    //             ->addColumn('tanggal_pertama_kerja', fn($row) => optional($row->tanggal_pertama_kerja)->format('Y-m-d'))
    //             ->addColumn('tanggal_mulai_kerja_instansi_saat_ini', fn($row) => optional($row->tanggal_mulai_kerja_instansi_saat_ini)->format('Y-m-d'))
    //             ->addColumn('nama_atasan', fn($row) => $row->nama_atasan_langsung ?? '-')
    //             ->addColumn('jabatan_atasan', fn($row) => $row->jabatan_atasan_langsung ?? '-')
    //             ->addColumn('no_hp_atasan', fn($row) => $row->no_hp_atasan_langsung ?? '-')
    //             ->addColumn('email_atasan', fn($row) => $row->email_atasan_langsung ?? '-')
    //             ->addColumn('status', fn($row) => ucfirst($row->status))
    //             ->addColumn('action', function ($row) {
    //                 $btnClass = $row->status === 'done' ? 'btn-success' : 'btn-warning';
    //                 $btnText  = $row->status === 'done' ? 'Terkirim' : 'Kirim';

    //                 return '
    //     <button class="btn btn-sm btn-edit ' . $btnClass . '"
    //         data-id="' . $row->tracer_id . '"
    //         data-status="' . $row->status . '">'
    //                     . $btnText .
    //                     '</button>';})
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     abort(403);
    // }

    // mengirim survey token
    // public function kirimToken($id, Request $request)
    // {
    //     $tracer = TracerStudyModel::with('alumni')->findOrFail($id);

    //     // Cek apakah sudah pernah dikirim
    //     $existing = SurveyTokenModel::where('pengguna_id', $tracer->alumni_id)->first();
    //     if ($existing) {
    //         return response()->json(['message' => 'Token sudah dikirim sebelumnya.'], 400);
    //     }

    //     // Generate token
    //     $token = Str::uuid()->toString();

    //     // Simpan token
    //     SurveyTokenModel::create([
    //         'pengguna_id' => $tracer->alumni_id,
    //         'token' => $token,
    //         'expires_at' => Carbon::now()->addDays(7),
    //     ]);

    //     // Kirim email (ke email atasan)
    //     $email = $tracer->email_atasan_langsung;
    //     $nama = $tracer->nama_atasan_langsung;
    //     $link = url('/survey?token=' . $token);

    //     Mail::raw("Yth. $nama,\n\nSilakan isi survei melalui tautan berikut:\n$link\n\nTerima kasih.", function ($message) use ($email) {
    //         $message->to($email)->subject('Undangan Pengisian Survei Alumni');
    //     });

    //     // Update status tracer
    //     $tracer->status = 'completed';
    //     $tracer->save();

    //     return response()->json(['message' => 'Email berhasil dikirim.']);
    // }
