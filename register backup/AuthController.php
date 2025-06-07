<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsersModel;
use App\Models\AlumniModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Menampilkan form login
    public function login()
    {
        return view('auth.login');
    }

    // Menampilkan form registrasi
    public function register()
    {
        return view('auth.register'); // Buat file ini di resources/views/auth/
    }

    // Proses login
    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:10',
            'password' => 'required|string|max:100'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/alumni_i/dashboard'); // Sesuaikan dengan rute yang didefinisikan
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Proses registrasi
    public function store(Request $request)
    {
        \Log::info('Register Request Data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:50',
            'nim' => 'required|string|max:50|unique:alumni,nim',
            'email' => 'required|email|max:20|unique:alumni,email',
            'no_hp' => 'required|string|max:20',
            'program_studi' => 'nullable|string|max:20',
            'tahun_lulus' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation Errors: ', $validator->errors()->toArray());
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Buat entri di tabel users
            $user = UsersModel::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => 'alumni', // Set role default untuk alumni
            ]);

            // Buat entri di tabel alumni menggunakan user_id yang baru dibuat
            AlumniModel::create([
                'user_id' => $user->user_id,
                'nama' => $request->nama,
                'nim' => $request->nim,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'program_studi' => $request->program_studi,
                'tahun_lulus' => $request->tahun_lulus,
            ]);

            DB::commit();

            \Log::info('Registration Success for user_id: ' . $user->user_id);

            return response()->json([
                'status' => true,
                'message' => 'Registrasi berhasil! Silakan login.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan sistem!'
            ], 500);
        }
    }

    // Go To Dashboard
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function alumniDashboard()
    {
        return view('alumni.dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
