<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * LOGIKA PENGALIHAN KHUSUS (REDIRECT)
     * * 1. Jika User adalah ADMIN -> Masuk ke Admin Panel
     * 2. Jika User BIASA -> Masuk ke Beranda / Dashboard Penulis
     */
    protected function redirectTo()
    {
        if (auth()->user()->is_admin) {
            return route('admin.dashboard');
        }

        return '/';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}