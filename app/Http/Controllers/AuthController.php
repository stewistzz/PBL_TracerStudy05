<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function login()
    {
        return view('auth.login'); // Buat file ini di resources/views/auth/
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
            return redirect()->intended('/alumni/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
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
