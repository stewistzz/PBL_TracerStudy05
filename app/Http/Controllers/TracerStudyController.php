<?php
// app/Http/Controllers/TracerStudyController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniModel;
use App\Models\TracerStudyModel;
use App\Models\InstansiModel;
use App\Models\KategoriProfesiModel;
use App\Models\ProfesiModel;
use App\Models\PenggunaLulusanModel;
use App\Models\AlumniPenggunaLulusanModel;
use App\Models\SurveyTokenModel;
use App\Models\PertanyaanModel;
use App\Models\JawabanAlumniModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TracerStudyController extends Controller
{
    public function index()
    {
        // Asumsi alumni sudah login, ambil dari session/auth
        $alumni_id = auth()->user()->alumni->alumni_id; // sesuaikan dengan auth system
        
        // Cek apakah sudah ada tracer study
        $tracerStudy = TracerStudyModel::where('alumni_id', $alumni_id)->first();
        
        // Cek progress
        $progress = $this->getProgress($alumni_id, $tracerStudy);
        
        return view('tracer_study.index', compact('tracerStudy', 'progress'));
    }

    
    
    // STEP 1: Data Diri
    // Modifikasi method showDataDiri
public function showDataDiri()
{
    $alumni_id = auth()->user()->alumni->alumni_id;
    $alumni = AlumniModel::find($alumni_id);
    $tracerStudy = TracerStudyModel::where('alumni_id', $alumni_id)->first();
    
    // Data untuk dropdown
    $instansi = InstansiModel::all();
    $kategoriProfesi = KategoriProfesiModel::all();
    $profesi = ProfesiModel::all();
    
    return view('tracer_study.data_diri', compact(
        'alumni', 'tracerStudy', 'instansi', 'kategoriProfesi', 'profesi'
    ));
}

// Modifikasi method storeDataDiri
public function storeDataDiri(Request $request)
{
    // Validasi input
    
    $request->validate([
        'tanggal_pertama_kerja' => 'required|date',
        'tanggal_mulai_kerja_instansi_saat_ini' => 'required|date',
        'pilihan_instansi' => 'required|in:existing,baru',
        'instansi_id' => 'required_if:pilihan_instansi,existing|nullable|exists:instansi,instansi_id',
        'instansi_baru' => 'required_if:pilihan_instansi,baru|nullable|string|max:255',
        'jenis_instansi' => 'required_if:pilihan_instansi,baru|nullable|in:Pendidikan Tinggi,Pemerintah,Swasta,BUMN',
        'skala' => 'required_if:pilihan_instansi,baru|nullable|in:nasional,internasional,wirausaha',
        'lokasi' => 'required_if:pilihan_instansi,baru|nullable|string|max:100',
        'no_hp_instansi' => 'nullable|string|max:15',
        'kategori_profesi_id' => 'required|exists:kategori_profesi,kategori_id',
        'profesi_id' => 'required|exists:profesi,profesi_id',
    ], [
        'pilihan_instansi.required' => 'Pilih opsi instansi (existing atau baru).',
        'instansi_id.required_if' => 'Pilih instansi dari daftar yang tersedia.',
        'instansi_baru.required_if' => 'Masukkan nama instansi baru.',
        'jenis_instansi.required_if' => 'Jenis instansi wajib diisi untuk instansi baru.',
        'skala.required_if' => 'Skala instansi wajib diisi untuk instansi baru.',
        'lokasi.required_if' => 'Lokasi instansi wajib diisi untuk instansi baru.',
    ]);

    // Ambil alumni_id dari pengguna yang login
    $alumni_id = auth()->user()->alumni->alumni_id;

    DB::transaction(function () use ($request, $alumni_id) {
        $instansi_id = $request->instansi_id;

        // Jika memilih instansi baru
        if ($request->pilihan_instansi == 'baru') {
            // Cek apakah instansi dengan nama yang sama sudah ada
            $existingInstansi = InstansiModel::where('nama_instansi', $request->instansi_baru)->first();

            if ($existingInstansi) {
                $instansi_id = $existingInstansi->instansi_id;
            } else {
                // Buat instansi baru
                $newInstansi = InstansiModel::create([
                    'nama_instansi' => $request->instansi_baru,
                    'jenis_instansi' => $request->jenis_instansi,
                    'skala' => $request->skala,
                    'lokasi' => $request->lokasi,
                    'no_hp' => $request->no_hp_instansi,
                ]);
                $instansi_id = $newInstansi->instansi_id;
            }
        }

        // Update atau create tracer study
        TracerStudyModel::updateOrCreate(
            ['alumni_id' => $alumni_id],
            [
                'tanggal_pengisian' => now(),
                'tanggal_pertama_kerja' => $request->tanggal_pertama_kerja,
                'tanggal_mulai_kerja_instansi_saat_ini' => $request->tanggal_mulai_kerja_instansi_saat_ini,
                'instansi_id' => $instansi_id,
                'kategori_profesi_id' => $request->kategori_profesi_id,
                'profesi_id' => $request->profesi_id,
            ]
        );
    });

    return redirect()->route('tracer-study.data-atasan')
                    ->with('success', 'Data diri berhasil disimpan!');
}
    
    // STEP 2: Data Atasan
    public function showDataAtasan()
    {
        $alumni_id = auth()->user()->alumni->alumni_id;
        $tracerStudy = TracerStudyModel::where('alumni_id', $alumni_id)->first();
        
        if (!$tracerStudy) {
            return redirect()->route('tracer-study.data-diri')
                           ->with('error', 'Silakan isi data diri terlebih dahulu');
        }
        
        return view('tracer_study.data_atasan', compact('tracerStudy'));
    }
    
   public function storeDataAtasan(Request $request)
{
    $request->validate([
        'nama_atasan_langsung' => 'required|string|max:255',
        'jabatan_atasan_langsung' => 'required|string|max:100',
        'no_hp_atasan_langsung' => 'required|string|max:20',
        'email_atasan_langsung' => 'required|email|max:255',
    ]);
    
    $alumni_id = auth()->user()->alumni->alumni_id;
    
    DB::transaction(function () use ($request, $alumni_id) {
        // 1. Update tracer study dengan data atasan
        $tracerStudy = TracerStudyModel::where('alumni_id', $alumni_id)->first();
        $tracerStudy->update([
            'nama_atasan_langsung' => $request->nama_atasan_langsung,
            'jabatan_atasan_langsung' => $request->jabatan_atasan_langsung,
            'no_hp_atasan_langsung' => $request->no_hp_atasan_langsung,
            'email_atasan_langsung' => $request->email_atasan_langsung,
        ]);
        
        // 2. Cek apakah atasan sudah ada berdasarkan email (atau kombinasi nama dan email)
        $pengguna = PenggunaLulusanModel::firstOrCreate(
            ['email' => $request->email_atasan_langsung],
            [
                'nama' => $request->nama_atasan_langsung,
                'instansi' => $tracerStudy->instansi->nama_instansi ?? 'Tidak diketahui',
                'jabatan' => $request->jabatan_atasan_langsung,
                'no_hp' => $request->no_hp_atasan_langsung,
            ]
        );
        
        // 3. Cek apakah relasi alumni-pengguna sudah ada
        $relasi = AlumniPenggunaLulusanModel::firstOrCreate(
            [
                'alumni_id' => $alumni_id,
                'pengguna_id' => $pengguna->pengguna_id,
            ]
        );
        
        // 4. Jika relasi baru dibuat, generate token baru
        if ($relasi->wasRecentlyCreated) {
            $token = Str::random(64);
            SurveyTokenModel::create([
                'pengguna_id' => $pengguna->pengguna_id,
                'alumni_id' => $alumni_id,
                'token' => $token,
                'expires_at' => Carbon::now()->addMonths(3),
                'used' => false,
            ]);
            
            // TODO: Kirim email ke atasan dengan link survey
            // Mail::to($request->email_atasan_langsung)->send(new SurveyInvitation($token));
        }
    });
    
    return redirect()->route('tracer-study.kuesioner')
                    ->with('success', 'Data atasan berhasil disimpan!');
}
    
    // STEP 3: Kuesioner Alumni
    public function showKuesioner()
    {
        $alumni_id = auth()->user()->alumni->alumni_id;
        $tracerStudy = TracerStudyModel::where('alumni_id', $alumni_id)->first();
        
        if (!$tracerStudy || !$tracerStudy->nama_atasan_langsung) {
            return redirect()->route('tracer-study.data-atasan')
                           ->with('error', 'Silakan isi data atasan terlebih dahulu');
        }
        
        // Ambil pertanyaan untuk alumni
        $pertanyaan = PertanyaanModel::where('role_target', 'alumni')
                               ->with('opsiPilihan')
                               ->get();
        
        // Ambil jawaban yang sudah ada
        $jawabanExisting = JawabanAlumniModel::where('alumni_id', $alumni_id)
                                       ->pluck('jawaban', 'pertanyaan_id')
                                       ->toArray();
        
        return view('tracer_study.kuesioner', compact('pertanyaan', 'jawabanExisting'));
    }
    
    public function storeKuesioner(Request $request)
{
    $request->validate([
        'jawaban' => 'required|array',
        'jawaban.*' => 'required' // Pastikan semua jawaban diisi
    ]);

    $alumni_id = auth()->user()->alumni->alumni_id;
    
    DB::transaction(function () use ($request, $alumni_id) {
        // Hapus jawaban lama
        JawabanAlumniModel::where('alumni_id', $alumni_id)->delete();
        
        // Simpan jawaban baru
        foreach ($request->jawaban as $pertanyaan_id => $jawaban) {
            if (!empty($jawaban)) {
                JawabanAlumniModel::create([
                    'alumni_id' => $alumni_id,
                    'pertanyaan_id' => $pertanyaan_id,
                    'jawaban' => is_array($jawaban) ? implode(', ', $jawaban) : $jawaban,
                    'tanggal' => now()->toDateString(),
                ]);
            }
        }
        
        // Update status tracer study
        TracerStudyModel::where('alumni_id', $alumni_id)
                  ->update(['status' => 'draft']);
    });
    
    return redirect()->route('tracer-study.success')
                    ->with('success', 'Tracer Study berhasil diselesaikan!');
}
    
    public function success()
    {
        return view('tracer_study.success');
    }
    
    // Helper function untuk cek progress
    private function getProgress($alumni_id, $tracerStudy)
    {
        $progress = [
            'data_diri' => false,
            'data_atasan' => false,
            'kuesioner' => false,
        ];
        
        if ($tracerStudy) {
            // Cek data diri
            $progress['data_diri'] = !empty($tracerStudy->tanggal_pertama_kerja) && 
                                   !empty($tracerStudy->instansi_id) && 
                                   !empty($tracerStudy->profesi_id);
            
            // Cek data atasan
            $progress['data_atasan'] = !empty($tracerStudy->nama_atasan_langsung) && 
                                     !empty($tracerStudy->email_atasan_langsung);
            
            // Cek kuesioner
            $progress['kuesioner'] = JawabanAlumniModel::where('alumni_id', $alumni_id)->exists();
        }
        
        return $progress;
    }
}