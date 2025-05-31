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
            data-status="' . $row->status . '">'
            . $btnText .
        '</button>
    ';
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
}

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



