<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Http\Request;

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
        $story = Story::with(['chapters', 'genres', 'tags', 'author', 'contentWarnings'])
                      ->where('slug', $slug)
                      ->firstOrFail();

        return view('story.detail', compact('story'));
    }

    // 3. HALAMAN BACA BAB (Tampilan Baca Bersih)
    public function readChapter($story_slug, $chapter_slug)
    {
        // Ambil data cerita
        $story = Story::where('slug', $story_slug)->firstOrFail();
        
        // Ambil bab yang sedang dibaca
        $chapter = Chapter::where('story_id', $story->id)
                          ->where('slug', $chapter_slug)
                          ->firstOrFail();

        // Logika Tombol Next / Previous
        $previousChapter = Chapter::where('story_id', $story->id)
                                  ->where('sort_order', '<', $chapter->sort_order)
                                  ->orderBy('sort_order', 'desc')
                                  ->first();

        $nextChapter = Chapter::where('story_id', $story->id)
                              ->where('sort_order', '>', $chapter->sort_order)
                              ->orderBy('sort_order', 'asc')
                              ->first();

        // Sesuaikan dengan nama file kamu: 'story.baca'
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