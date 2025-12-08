<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WriterController;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK (Bisa Diakses Siapa Saja)
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/search', [PageController::class, 'search'])->name('search');
Route::get('/story/{slug}', [PageController::class, 'showStory'])->name('story.show');
Route::get('/story/{story_slug}/{chapter_slug}', [PageController::class, 'readChapter'])->name('chapter.read');


/*
|--------------------------------------------------------------------------
| 2. RUTE TAMU (Hanya untuk yang BELUM Login)
|--------------------------------------------------------------------------
| Menggunakan middleware 'guest'. Jika user sudah login, mereka tidak bisa
| masuk ke sini (akan di-redirect ke halaman utama).
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


/*
|--------------------------------------------------------------------------
| 3. RUTE MEMBER (Hanya untuk yang SUDAH Login)
|--------------------------------------------------------------------------
| Menggunakan middleware 'auth'. Orang luar tidak bisa akses halaman ini.
*/
Route::middleware('auth')->group(function () {
    
    // --- FITUR AKUN (CRUD USER) ---
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
    
    Route::delete('/profil/photo', [ProfileController::class, 'deletePhoto'])->name('profil.delete_photo');
    Route::delete('/profil/account', [ProfileController::class, 'destroy'])->name('profil.destroy');

});

Route::middleware('auth')->prefix('marinulis')->group(function () {
    
    // Halaman Utama Dashboard Penulis
    Route::get('/', [WriterController::class, 'index'])->name('writer.index');
    
    // Tambah Cerita Baru
    Route::get('/buat-cerita', [WriterController::class, 'create'])->name('writer.create');
    Route::post('/buat-cerita', [WriterController::class, 'store'])->name('writer.store');
    
    // Hapus Cerita
    Route::delete('/hapus/{id}', [WriterController::class, 'destroy'])->name('writer.destroy');

    // Manajemen Bab (Nanti bisa dikembangkan)
    Route::get('/{slug}/bab', [WriterController::class, 'chapters'])->name('writer.chapters');

    // Tampilkan Form Tambah Bab
    Route::get('/{slug}/tambah-bab', [WriterController::class, 'createChapter'])->name('writer.chapter.create');
    
    // Proses Simpan Bab
    Route::post('/{slug}/tambah-bab', [WriterController::class, 'storeChapter'])->name('writer.chapter.store');

    // Proses Edit Chapter
    Route::get('/{story_slug}/bab/{chapter_slug}/edit', [WriterController::class, 'editChapter'])->name('writer.chapter.edit');
    Route::put('/{story_slug}/bab/{chapter_slug}/update', [WriterController::class, 'updateChapter'])->name('writer.chapter.update');
    
    // Fitur Hapus BAB
    Route::delete('/{story_slug}/bab/{chapter_slug}/hapus', [WriterController::class, 'destroyChapter'])->name('writer.chapter.destroy');

    // Rute Edit Cerita
    Route::get('/cerita/{slug}/edit', [WriterController::class, 'edit'])->name('writer.edit');
    Route::put('/cerita/{slug}/update', [WriterController::class, 'update'])->name('writer.update');
});