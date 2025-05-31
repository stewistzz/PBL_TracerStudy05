<?php

namespace App\Http\Controllers;

use App\Models\TracerStudyModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
// kirim token
use App\Models\SurveyToken;
use App\Models\SurveyTokenModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
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
                    return '
                        <button class="btn btn-warning btn-sm btn-edit" data-id="' . $row->tracer_id . '">Kirim</button>
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

        // dd($tracer);

        // Validasi email atasan wajib ada
        if (empty($tracer->email_atasan_langsung)) {
            return response()->json(['message' => 'Email atasan tidak tersedia. Tidak bisa mengirim token.'], 422);
        }

        // Cek apakah sudah pernah dikirim
        $existing = SurveyTokenModel::where('pengguna_id', $tracer->alumni_id)->first();
        if ($existing) {
            return response()->json(['message' => 'Token sudah dikirim sebelumnya.'], 400);
        }

        // Generate token
        $token = Str::uuid()->toString();

        // Simpan token
        SurveyTokenModel::create([
            'pengguna_id' => $tracer->alumni_id,
            'token' => $token,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        // Kirim data ke frontend untuk EmailJS
        return response()->json([
            'message' => 'Token berhasil dibuat.',
            'email_data' => [
                'to_email' => $tracer->email_atasan_langsung,
                'to_name' => $tracer->nama_atasan_langsung ?? 'Bapak/Ibu',
                'survey_link' => url('/survey/access/' . $token),
            ]
        ]);
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


}
