<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\Tag;
use App\Models\ContentWarning;

class WriterController extends Controller
{
    // 1. HALAMAN UTAMA MARINULIS
    public function index()
    {
        $myStories = Story::where('user_id', Auth::id())->latest()->get();
        return view('writer.index', compact('myStories'));
    }

    // 2. FORM TAMBAH CERITA
    public function create()
    {
        $genres = Genre::all();
        $tags = Tag::all();
        $warnings = ContentWarning::all();
        return view('writer.create', compact('genres', 'tags', 'warnings'));
    }

    // 3. PROSES SIMPAN CERITA
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'genres' => 'required|array|max:4',
            'cover_image' => 'nullable|image|max:20480',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        $story = Story::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'description' => $request->description,
            'cover_image' => $coverPath,
            'is_fanfiction' => $request->has('is_fanfiction'),
            'public_schedule' => $request->has('public_schedule'),
            'allow_comments' => $request->has('allow_comments'),
        ]);

        if($request->genres) $story->genres()->attach($request->genres);
        if($request->tags) $story->tags()->attach($request->tags);
        if($request->warnings) $story->contentWarnings()->attach($request->warnings);

        return redirect()->route('writer.chapter.create', $story->slug)
                     ->with('success', 'Cerita berhasil dibuat! Sekarang silakan tulis bab pertamamu.');
    }

    // 4. HAPUS CERITA
    public function destroy($id)
    {
        $story = Story::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($story->cover_image) {
            Storage::delete('public/' . $story->cover_image);
        }
        
        $story->delete();
        return redirect()->route('writer.index')->with('success', 'Cerita berhasil dihapus.');
    }

    // 5. HALAMAN EDIT BAB
    public function chapters($story_slug)
    {
        $story = Story::where('slug', $story_slug)->where('user_id', Auth::id())->firstOrFail();
        return view('writer.chapters', compact('story'));
    }

    // 6. FORM TAMBAH BAB
    public function createChapter($story_slug)
    {
        // Cari cerita berdasarkan slug
        $story = Story::where('slug', $story_slug)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return view('writer.new-chapters', compact('story'));
    }

    // 7. SIMPAN BAB BARU
    public function storeChapter(Request $request, $story_slug)
    {
        $story = Story::where('slug', $story_slug)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
            'sort_order' => $story->chapters->count() + 1,
        ]);

        return redirect()->route('writer.index')
                         ->with('success', 'Bab berhasil ditambahkan ke cerita ' . $story->title);
    }

    // 8. FORM EDIT BAB
    public function editChapter($story_slug, $chapter_slug)
    {
        $story = Story::where('slug', $story_slug)->where('user_id', Auth::id())->firstOrFail();
        
        $chapter = Chapter::where('story_id', $story->id)
                          ->where('slug', $chapter_slug)
                          ->firstOrFail();

        return view('writer.edit-chapter', compact('story', 'chapter'));
    }

    // 9. PROSES UPDATE BAB
    public function updateChapter(Request $request, $story_slug, $chapter_slug)
    {
        $story = Story::where('slug', $story_slug)->where('user_id', Auth::id())->firstOrFail();
        
        $chapter = Chapter::where('story_id', $story->id)
                          ->where('slug', $chapter_slug)
                          ->firstOrFail();

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $chapter->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
        ]);

        return redirect()->route('writer.chapters', $story->slug)
                         ->with('success', 'Bab berhasil diperbarui!');
    }

    // 10. HAPUS BAB
    public function destroyChapter($story_slug, $chapter_slug)
    {
        $story = Story::where('slug', $story_slug)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        $chapter = Chapter::where('story_id', $story->id)
                          ->where('slug', $chapter_slug)
                          ->firstOrFail();

        $chapter->delete();

        return redirect()->route('writer.chapters', $story->slug)
                         ->with('success', 'Bab berhasil dihapus selamanya.');
    }

    // ... kode controller lainnya ...

    // A. TAMPILKAN HALAMAN EDIT CERITA
    public function edit($slug)
    {
        // 1. Cari cerita milik user yang sedang login
        $story = Story::with(['genres', 'tags', 'contentWarnings'])
                      ->where('slug', $slug)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        // 2. Ambil data pendukung (Genre, Tag, Warning) untuk pilihan
        $genres = Genre::all();
        $tags = Tag::all();
        $warnings = ContentWarning::all();

        return view('writer.edit', compact('story', 'genres', 'tags', 'warnings'));
    }

    // B. PROSES UPDATE CERITA
    public function update(Request $request, $slug)
    {
        // 1. Cari cerita
        $story = Story::where('slug', $slug)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        // 2. Validasi Input
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'genres' => 'required|array|max:4', // Wajib pilih genre, maks 4
            'cover_image' => 'nullable|image|max:20480', // Maks 20MB
        ]);

        // 3. Cek apakah ada upload cover baru
        if ($request->hasFile('cover_image')) {
            // Hapus cover lama jika ada
            if ($story->cover_image) {
                Storage::delete('public/' . $story->cover_image);
            }
            // Simpan yang baru
            $path = $request->file('cover_image')->store('covers', 'public');
            $story->cover_image = $path;
        }

        // 4. Update Data Teks
        $story->title = $request->title;
        // Opsional: Update slug jika judul berubah (hati-hati link lama bisa mati)
        // $story->slug = Str::slug($request->title) . '-' . uniqid(); 
        $story->description = $request->description;
        $story->save();

        // 5. Sinkronisasi Genre, Tag, Warning (Hapus lama, pasang baru)
        $story->genres()->sync($request->genres);
        
        if ($request->has('tags')) {
            $story->tags()->sync($request->tags);
        } else {
            $story->tags()->detach(); // Jika semua tag dihapus
        }

        if ($request->has('warnings')) {
            $story->contentWarnings()->sync($request->warnings);
        } else {
            $story->contentWarnings()->detach();
        }

        return redirect()->route('writer.index')->with('success', 'Detail cerita berhasil diperbarui!');
    }
}