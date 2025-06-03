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
// menampilkan data alumni yang belumm mengisi tracer
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

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = TracerStudyModel::with(['alumni', 'instansi', 'kategoriProfesi', 'profesi']);

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
                ->addColumn('status', fn($row) => ucfirst($row->status))
                ->addColumn('action', function ($row) {
                    $btnClass = $row->status === 'done' ? 'btn-success' : 'btn-warning';
                    $btnText  = $row->status === 'done' ? 'Terkirim' : 'Kirim';

                    return '
                    <button class="btn btn-sm btn-edit ' . $btnClass . '"
                        data-id="' . $row->tracer_id . '"
                        data-status="' . $row->status . '">' . $btnText . '</button>

                    <button class="btn btn-sm btn-danger btn-delete"
                        data-id="' . $row->tracer_id . '"
                        onclick="deleteTracer(' . $row->tracer_id . ')">
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

        //  Cek status: hanya izinkan jika status bukan draft
        if ($tracer->status === 'draft') {
            return response()->json(['message' => 'Status masih draft. Tidak dapat mengirim token.'], 422);
        }

        // Validasi email atasan
        if (empty($tracer->email_atasan_langsung)) {
            return response()->json(['message' => 'Email atasan tidak tersedia.'], 422);
        }

        // Cari pengguna_lulusan berdasarkan email atasan
        $pengguna = PenggunaLulusanModel::where('email', $tracer->email_atasan_langsung)->first();
        if (!$pengguna) {
            return response()->json(['message' => 'Data atasan tidak ditemukan di pengguna_lulusan.'], 422);
        }

        // Cari relasi alumni-pengguna
        $relasi = AlumniPenggunaLulusanModel::where('alumni_id', $tracer->alumni_id)
            ->where('pengguna_id', $pengguna->pengguna_id)
            ->first();
        if (!$relasi) {
            return response()->json(['message' => 'Relasi antara alumni dan atasan tidak ditemukan.'], 422);
        }

        // Cari token yang sudah ada
        $token = SurveyTokenModel::where('pengguna_id', $pengguna->pengguna_id)
            ->where('alumni_id', $tracer->alumni_id)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan atau sudah kadaluarsa.'], 404);
        }

        // Ubah status tracer menjadi completed
        $tracer->status = 'completed';
        $tracer->save();

        // Kirim data ke frontend untuk EmailJS
        return response()->json([
            'message' => 'Token siap dikirim dan status diperbarui.',
            'email_data' => [
                'to_email' => $tracer->email_atasan_langsung,
                'to_name' => $tracer->nama_atasan_langsung ?? 'Bapak/Ibu',
                'survey_link' => url('/survey/access/' . $token->token),
            ]
        ]);
    }

    // melakukan delete
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

    // menampilkan data alumni yang belum mengisi tracer
    public function alumniBelumIsi()
    {
        $alumniBelumIsi = AlumniModel::doesntHave('tracerStudies')->get();

        return datatables()->of($alumniBelumIsi)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return '<span class="badge bg-danger">Belum Mengisi</span>';
            })
            // ->addColumn('action', function ($row) {
            //     return '<a href="#" class="btn btn-sm btn-info disabled">Detail</a>';
            // })
            // ->rawColumns(['status', 'action'])
            ->rawColumns(['status'])

            ->make(true);
    }

    // export excel
    public function exportBelumIsi()
    {
        // Ambil semua alumni yang belum mengisi tracer study (relasi tracer tidak ada)
        $alumni = AlumniModel::doesntHave('tracerStudies')->orderBy('tahun_lulus')->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Program Studi');
        $sheet->setCellValue('F1', 'No HP');
        $sheet->setCellValue('G1', 'Tahun Lulus');
        $sheet->setCellValue('H1', 'Status Pengisian');

        // Set bold untuk header
        $sheet->getStyle("A1:H1")->getFont()->setBold(true);

        // Tulis data ke dalam sheet
        $no = 1;
        $baris = 2;
        foreach ($alumni as $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nim);
            $sheet->setCellValue('C' . $baris, $value->nama);
            $sheet->setCellValue('D' . $baris, $value->email);
            $sheet->setCellValue('E' . $baris, $value->program_studi);
            $sheet->setCellValue('F' . $baris, $value->no_hp);
            $sheet->setCellValue('G' . $baris, $value->tahun_lulus);
            $sheet->setCellValue('H' . $baris, 'Belum Mengisi');

            $baris++;
            $no++;
        }

        // Set auto-size
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Nama Sheet
        $sheet->setTitle('Data Alumni Belum Isi');

        // Export file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Alumni_Belum_Mengisi_' . date("Y-m-d") . ".xlsx";

        // Headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Pragma: public');

        // Output file
        $writer->save('php://output');
        exit;
    }

    // eksportRekapTracer
    public function exportRekapTracer()
    {
        // Ambil semua data tracer beserta relasinya
        $tracers = TracerStudyModel::with(['alumni', 'instansi', 'kategoriProfesi', 'profesi'])->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'alumni');
        $sheet->setCellValue('C1', 'instansi');
        $sheet->setCellValue('D1', 'kategori_profesi');
        $sheet->setCellValue('E1', 'profesi');
        $sheet->setCellValue('F1', 'tanggal_pengisian');
        $sheet->setCellValue('G1', 'tanggal_pertama_kerja');
        $sheet->setCellValue('H1', 'tanggal_mulai_kerja_instansi_saat_ini');
        $sheet->setCellValue('I1', 'nama_atasan');
        $sheet->setCellValue('J1', 'jabatan_atasan');
        $sheet->setCellValue('K1', 'no_hp_atasan');
        $sheet->setCellValue('L1', 'email_atasan');
        $sheet->setCellValue('M1', 'Status Pengisian');

        // Set bold untuk header
        $sheet->getStyle("A1:H1")->getFont()->setBold(true);

        // Tulis data ke dalam sheet
        $no = 1;
        $baris = 2;
        foreach ($tracers as $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->alumni->nama);
            $sheet->setCellValue('C' . $baris, $value->instansi->nama_instansi);
            $sheet->setCellValue('D' . $baris, $value->kategoriProfesi->nama_kategori);
            $sheet->setCellValue('E' . $baris, $value->profesi->nama_profesi);
            $sheet->setCellValue('F' . $baris, $value->tanggal_pengisian);
            $sheet->setCellValue('G' . $baris, $value->tanggal_pertama_kerja);
            $sheet->setCellValue('H' . $baris, $value->tanggal_mulai_kerja_instansi_saat_ini);
            // dd($value);
            $sheet->setCellValue('I' . $baris, $value->nama_atasan_langsung);
            $sheet->setCellValue('J' . $baris, $value->jabatan_atasan_langsung);
            $sheet->setCellValue('K' . $baris, $value->no_hp_atasan_langsung);
            $sheet->setCellValue('L' . $baris, $value->email_atasan_langsung);
            $sheet->setCellValue('M' . $baris, 'Berhasil Mengisi');

            $baris++;
            $no++;
        }

        // Set auto-size
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Nama Sheet
        $sheet->setTitle('Data Alumni Belum Isi');

        // Export file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Alumni_Belum_Mengisi_' . date("Y-m-d") . ".xlsx";

        // Headers
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
