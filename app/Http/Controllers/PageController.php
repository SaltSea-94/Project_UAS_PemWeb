<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // 1. HALAMAN HOME (Daftar Cerita)
    public function home()
    {
        $stories = Story::with(['genres', 'author'])->latest()->get();
        return view('home', compact('stories'));
    }

    // 2. HALAMAN DETAIL CERITA (Daftar Isi untuk Pembaca)
    public function showStory($slug)
    {
        // 1. Ambil Data Cerita
        $story = Story::with(['author', 'genres', 'chapters', 'reviews.user'])
                      ->where('slug', $slug)
                      ->firstOrFail();

        // 2. LOGIKA HITUNG PEMBACA (VIEW COUNTER)
        $shouldCount = false;

        if (Auth::check()) {
            // SKENARIO A: User Login
            if (Auth::id() != $story->user_id) {
                $shouldCount = true;
            }
        } else {
            // SKENARIO B: Tamu (Guest)
            $shouldCount = true;
        }

        // 3. EKSEKUSI PENAMBAHAN + ANTI REFRESH SPAM
        $sessionKey = 'viewed_story_' . $story->id;

        if ($shouldCount && !session()->has($sessionKey)) {
            $story->increment('views');
            session()->put($sessionKey, true);
        }

        // 4. Kirim ke View
        return view('story.detail', compact('story'));
    }

    // 3. HALAMAN BACA BAB (Tampilan Baca Bersih)
    public function readChapter($story_slug, $chapter_slug)
    {
        $story = Story::where('slug', $story_slug)->firstOrFail();
        
        $chapter = Chapter::where('story_id', $story->id)
                          ->where('slug', $chapter_slug)
                          ->firstOrFail();

        $shouldCount = false;

        if (Auth::check()) {
            if (Auth::id() != $story->user_id) {
                $shouldCount = true;
            }
        } else {
            $shouldCount = true;
        }

        $sessionKey = 'viewed_chapter_' . $chapter->id;

        if ($shouldCount && !session()->has($sessionKey)) {
            $chapter->increment('views');
            session()->put($sessionKey, true);
        }

        $previousChapter = Chapter::where('story_id', $story->id)
                              ->where('sort_order', '<', $chapter->sort_order)
                              ->orderBy('sort_order', 'desc')
                              ->first();

        $nextChapter = Chapter::where('story_id', $story->id)
                              ->where('sort_order', '>', $chapter->sort_order)
                              ->orderBy('sort_order', 'asc')
                              ->first();

        return view('story.baca', compact('story', 'chapter', 'previousChapter', 'nextChapter'));
    }

    // 4. Pencarian Cerita LiveSearch
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        $stories = Story::where('title', 'LIKE', "%{$query}%")
                        ->select('title', 'slug', 'cover_image')
                        ->limit(5)
                        ->get();

        return response()->json($stories);
    }
}