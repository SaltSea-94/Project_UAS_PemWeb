<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WriterController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\AdminController;

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
    Route::get('/notifikasi', [ProfileController::class, 'inbox'])->name('user.inbox');
    
    Route::delete('/profil/photo', [ProfileController::class, 'deletePhoto'])->name('profil.delete_photo');
    Route::delete('/profil/account', [ProfileController::class, 'destroy'])->name('profil.destroy');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');

    Route::post('/cerita/{id}/review', [InteractionController::class, 'storeReview'])->name('story.review.store');
    Route::post('/cerita/{id}/review', [InteractionController::class, 'storeReview'])->name('story.review.store');
    Route::get('/review/{id}/edit', [InteractionController::class, 'editReview'])->name('review.edit');
    Route::put('/review/{id}', [InteractionController::class, 'updateReview'])->name('review.update');
    Route::delete('/review/{id}', [InteractionController::class, 'destroyReview'])->name('review.destroy');

    Route::post('/bab/{id}/komentar', [InteractionController::class, 'storeComment'])->name('chapter.comment.store');
    Route::post('/bab/{id}/komentar', [InteractionController::class, 'storeComment'])->name('chapter.comment.store');
    Route::get('/komentar/{id}/edit', [InteractionController::class, 'editComment'])->name('comment.edit');
    Route::put('/komentar/{id}', [InteractionController::class, 'updateComment'])->name('comment.update');
    Route::delete('/komentar/{id}', [InteractionController::class, 'destroyComment'])->name('comment.destroy');

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

Route::middleware(['auth', 'admin'])->prefix('admin-panel')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::get('/users/{id}/message', [AdminController::class, 'createMessage'])->name('admin.message.create');
    Route::post('/users/{id}/message', [AdminController::class, 'sendMessage'])->name('admin.message.send');
    Route::post('/users/{id}/ban', [AdminController::class, 'toggleBanUser'])->name('admin.users.ban');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.delete');
    
    Route::get('/stories', [AdminController::class, 'manageStories'])->name('admin.stories');
    Route::delete('/stories/{id}', [AdminController::class, 'destroyStory'])->name('admin.stories.delete');

    Route::get('/comments', [AdminController::class, 'manageComments'])->name('admin.comments');
    Route::delete('/comments/{id}', [AdminController::class, 'destroyComment'])->name('admin.comments.delete');

    Route::post('/announcement', [AdminController::class, 'storeAnnouncement'])->name('admin.announcement.store');
    Route::delete('/announcement/{id}', [AdminController::class, 'destroyAnnouncement'])->name('admin.announcement.delete');
});

Route::middleware(['not.banned'])->group(function () {
        
    Route::get('/writer', [WriterController::class, 'index'])->name('writer.index');
    Route::get('/writer/create', [WriterController::class, 'create'])->name('writer.create');
    Route::post('/cerita/{id}/review', [InteractionController::class, 'storeReview'])->name('story.review.store');
    Route::post('/bab/{id}/komentar', [InteractionController::class, 'storeComment'])->name('chapter.comment.store');
});