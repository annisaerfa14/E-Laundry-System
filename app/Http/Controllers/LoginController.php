<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. Menampilkan halaman login
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // 2. Memproses data saat tombol Login ditekan
    public function login(Request $request)
    {
        // Validasi inputan tidak boleh kosong
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek kecocokan data dengan database
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Jika berhasil, arahkan ke halaman dashboard
            return redirect()->intended('admin/dashboard');
        }

        // Jika salah, kembalikan ke halaman login dengan pesan error dan mengosongkan password
        return back()->withErrors([
            'username' => 'Username atau Password yang Anda masukkan salah.',
        ])->withInput($request->except('password')); // Input password dikosongkan
    }

    // 3. Fungsi untuk Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}