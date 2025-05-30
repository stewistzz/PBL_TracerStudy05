<?php
namespace App\Http\Controllers;

use App\Models\JawabanAlumniModel;
use App\Models\SurveyTokenModel;
use App\Models\PertanyaanModel;
use App\Models\JawabanPenggunaModel;
use App\Models\AlumniModel;
use App\Models\PenggunaLulusanModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    public function accessSurvey($token)
    {
        // Cari token di database
        $surveyToken = SurveyTokenModel::with(['pengguna', 'alumni'])
            ->where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->where('used', 0)
            ->first();

        // Debug: Log token info
        Log::info('Access Survey - Token: ' . $token);
        Log::info('Survey Token Found: ' . ($surveyToken ? 'Yes' : 'No'));
        
        if ($surveyToken) {
            Log::info('Token expires at: ' . $surveyToken->expires_at);
            Log::info('Token used: ' . $surveyToken->used);
            Log::info('Current time: ' . Carbon::now());
        }

        // Jika token tidak valid atau sudah digunakan
        if (!$surveyToken) {
            return redirect()->route('survey.invalid')->with('error', 'Token tidak valid, sudah digunakan, atau telah kadaluarsa.');
        }

        // Ambil pertanyaan untuk role_target = 'pengguna'
        $pertanyaan = PertanyaanModel::where('role_target', 'pengguna')->get();

        // Jika tidak ada pertanyaan
        if ($pertanyaan->isEmpty()) {
            return redirect()->route('survey.invalid')->with('error', 'Tidak ada pertanyaan tersedia untuk survei ini.');
        }

        // Kirim data ke view
        return view('survey.survey_form', [
            'token' => $token,
            'pertanyaan' => $pertanyaan,
            'alumni' => $surveyToken->alumni,
            'pengguna' => $surveyToken->pengguna,
        ]);
    }

    public function submitSurvey(Request $request, $token)
    {
        // Debug: Log submission attempt
        Log::info('Submit Survey - Token: ' . $token);
        Log::info('Request data: ', $request->all());

        // Cari token
        $surveyToken = SurveyTokenModel::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->where('used', 0)
            ->first();

        // Debug: Log token validation
        Log::info('Submit - Survey Token Found: ' . ($surveyToken ? 'Yes' : 'No'));
        
        if ($surveyToken) {
            Log::info('Submit - Token expires at: ' . $surveyToken->expires_at);
            Log::info('Submit - Token used: ' . $surveyToken->used);
            Log::info('Submit - Current time: ' . Carbon::now());
        } else {
            // Debug: Cek apakah token ada tapi dengan kondisi berbeda
            $tokenExists = SurveyTokenModel::where('token', $token)->first();
            if ($tokenExists) {
                Log::info('Token exists but conditions not met:');
                Log::info('- expires_at: ' . $tokenExists->expires_at);
                Log::info('- used: ' . $tokenExists->used);
                Log::info('- expired: ' . ($tokenExists->expires_at <= Carbon::now() ? 'Yes' : 'No'));
            } else {
                Log::info('Token does not exist in database');
            }
            return redirect()->route('survey.invalid')->with('error', 'Token tidak valid, sudah digunakan, atau telah kadaluarsa.');
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::info('Validation failed: ', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Simpan jawaban
            foreach ($request->jawaban as $pertanyaan_id => $jawaban) {
                JawabanPenggunaModel::create([
                    'pengguna_id' => $surveyToken->pengguna_id,
                    'alumni_id' => $surveyToken->alumni_id,
                    'pertanyaan_id' => $pertanyaan_id,
                    'jawaban' => $jawaban,
                    'tanggal' => Carbon::today(),
                ]);
            }

            // Tandai token sebagai digunakan
            $surveyToken->update(['used' => 1]);
            
            Log::info('Survey submitted successfully for token: ' . $token);

            return redirect()->route('survey.success')->with('success', 'Terima kasih, jawaban Anda telah disimpan.');
            
        } catch (\Exception $e) {
            Log::error('Error saving survey: ' . $e->getMessage());
            return redirect()->route('survey.invalid')->with('error', 'Terjadi kesalahan saat menyimpan jawaban.');
        }
    }
}