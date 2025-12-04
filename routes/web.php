<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Route untuk Homepage
Route::get('/', [PageController::class, 'home']);

// Route untuk Logout
Route::get('/logout', [PageController::class, 'logout']);

// Route untuk Halaman Profil
Route::get('/profil', [PageController::class, 'profil']);

// Route untuk Halaman Login
Route::get('/login', [PageController::class, 'showLoginForm']);

// Route untuk Halaman Register
Route::get('/register', [PageController::class, 'showRegisterForm']);

// Route untuk Halaman Detail Cerita
Route::get('/story/the-unkindled', [PageController::class, 'showDetail']);

// Route untuk Halaman Baca
Route::get('/story/the-unkindled/prolog', [PageController::class, 'showChapter']);

// Route untuk Halaman Baca Bab Satu
Route::get('/story/the-unkindled/bab-satu', [PageController::class, 'showChapterOne']);

// Route untuk Halaman Baca Bab Dua
Route::get('/story/the-unkindled/bab-dua', [PageController::class, 'showChapterTwo']);

// Route untuk Halaman Baca Bab tiga
Route::get('/story/the-unkindled/bab-tiga', [PageController::class, 'showChapterThree']);

// Route untuk Halaman Baca Bab Empat
Route::get('/story/the-unkindled/bab-empat', [PageController::class, 'showChapterFour']);

// Route untuk Halaman Baca Bab Lima
Route::get('/story/the-unkindled/bab-lima', [PageController::class, 'showChapterFive']);