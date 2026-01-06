<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Story;
use App\Models\Comment;
use App\Models\Review;
use App\Models\AdminMessage;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // 1. DASHBOARD UTAMA (PUSAT DATA)
    public function index()
    {
        $totalUsers = User::count();
        $totalStories = Story::count();
        
        $stats = [
            'writers' => User::has('stories')->count(),
            'readers' => User::doesntHave('stories')->count(),
        ];

        $latestUsers = User::latest()->take(5)->get();

        $latestStories = Story::with('author')->latest()->take(5)->get();

        $activeAnnouncement = null;
        if(class_exists('\App\Models\Announcement')) {
            $activeAnnouncement = \App\Models\Announcement::where('is_active', true)->latest()->first();
        }

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalStories', 
            'stats', 
            'latestUsers', 
            'latestStories', 
            'activeAnnouncement'
        ));
    }

    // 2. KELOLA USER (Cari & Suspend)
    public function manageUsers(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('email', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
        }

        $users = $query->withCount('stories')->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function toggleBanUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->is_admin) {
            return back()->with('error', 'Tidak bisa membanned sesama Admin.');
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'diblokir' : 'diaktifkan kembali';
        return back()->with('success', "Akun pengguna berhasil {$status}.");
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->is_admin) return back();

        if ($user->photo) Storage::delete('public/' . $user->photo);
        $user->delete();

        return back()->with('success', 'User dihapus permanen.');
    }

    // 3. KELOLA CERITA
    public function manageStories()
    {
        $stories = Story::with('author')->latest()->paginate(10);
        return view('admin.stories', compact('stories'));
    }

    public function destroyStory($id)
    {
        $story = Story::findOrFail($id);
        if ($story->cover_image) Storage::delete('public/' . $story->cover_image);
        $story->delete();
        return back()->with('success', 'Cerita dihapus.');
    }

    // 4. MONITOR KOMENTAR (LIVE)
    public function manageComments()
    {
        $comments = Comment::with(['user', 'chapter.story'])->latest()->paginate(20);
        return view('admin.comments', compact('comments'));
    }

    public function destroyComment($id)
    {
        Comment::destroy($id);
        return back()->with('success', 'Komentar dihapus karena melanggar aturan.');
    }

    // 5. KIRIM PESAN KE USER
    public function createMessage($id)
    {
        $user = User::findOrFail($id);
        return view('admin.message_create', compact('user'));
    }

    // 6. PROSES KIRIM PESAN (POST) - Pastikan ini sudah ada/diupdate
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:100',
            'message' => 'required|string',
        ]);

        AdminMessage::create([
            'user_id' => $id,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('admin.users')->with('success', 'Pesan notifikasi berhasil dikirim ke user.');
    }

    // 7. FUNGSI BUAT PENGUMUMAN
    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'type' => 'required',
        ]);

        Announcement::query()->update(['is_active' => false]);

        Announcement::create([
            'message' => $request->message,
            'type' => $request->type,
            'is_active' => true,
        ]);

        return back()->with('success', 'Pengumuman berhasil dipasang!');
    }

    // 8. FUNGSI HAPUS/MATIKAN PENGUMUMAN
    public function destroyAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return back()->with('success', 'Pengumuman dihapus.');
    }
}