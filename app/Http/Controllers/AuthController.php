<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- REGISTER ---
    public function showRegister() {
        return view('auth.register'); // Pastikan file view ada di folder resources/views/auth/
    }

    public function register(Request $request) {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // 2. Simpan User Baru ke Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash
        ]);

        // 3. Redirect ke halaman login
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login!');
    }

    // --- LOGIN ---
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login dengan data user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Berhasil Login!'); // Masuk ke Home
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // --- LOGOUT ---
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}