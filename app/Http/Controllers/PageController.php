<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    /**
     * Menampilkan halaman profil pengguna.
     */
    public function profil()
    {
        return view('auth.profil');
    }

    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman register.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function logout()
    {
        return redirect('/login');
    }

    /**
     * Menampilkan halaman detail novel.
     */
    public function showDetail()
    {
        return view('story.detail');
    }

    /**
     * Menampilkan halaman baca Prolog.
     */
    public function showChapter()
    {
        return view('story.baca');
    }

    /**
     * Menampilkan halaman baca Bab 1.
     */
    public function showChapterOne()
    {
        return view('story.baca-bab-1');
    }

    /**
     * Menampilkan halaman baca Bab 2.
     */
    public function showChapterTwo()
    {
        return view('story.baca-bab-2');
    }

    /**
     * Menampilkan halaman baca Bab 3.
     */
    public function showChapterThree()
    {
        return view('story.baca-bab-3');
    }

    /**
     * Menampilkan halaman baca Bab 4.
     */
    public function showChapterFour()
    {
        return view('story.baca-bab-4');
    }

    /**
     * Menampilkan halaman baca Bab 5.
     */
    public function showChapterFive()
    {
        return view('story.baca-bab-5');
    }
}