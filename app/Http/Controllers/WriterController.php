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
    public function index()
    {
        $myStories = Story::where('user_id', Auth::id())->latest()->get();
        return view('writer.index', compact('myStories'));
    }

    public function create()
    {
        $genres = Genre::all();
        $tags = Tag::all();
        $warnings = ContentWarning::all();
        return view('writer.create', compact('genres', 'tags', 'warnings'));
    }

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
            $file = $request->file('cover_image');
            
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            $file->move(public_path('storage/covers'), $fileName);
            
            $coverPath = 'covers/' . $fileName;
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

    public function destroy($id)
    {
        $story = Story::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($story->cover_image) {
            Storage::delete('public/' . $story->cover_image);
        }
        
        $story->delete();
        return redirect()->route('writer.index')->with('success', 'Cerita berhasil dihapus.');
    }

    public function chapters($story_slug)
    {
        $story = Story::where('slug', $story_slug)->where('user_id', Auth::id())->firstOrFail();
        return view('writer.chapters', compact('story'));
    }

    public function createChapter($story_slug)
    {
        $story = Story::where('slug', $story_slug)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return view('writer.new-chapters', compact('story'));
    }

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

    public function editChapter($story_slug, $chapter_slug)
    {
        $story = Story::where('slug', $story_slug)->where('user_id', Auth::id())->firstOrFail();
        
        $chapter = Chapter::where('story_id', $story->id)
                          ->where('slug', $chapter_slug)
                          ->firstOrFail();

        return view('writer.edit-chapter', compact('story', 'chapter'));
    }

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

    public function edit($slug)
    {
        $story = Story::with(['genres', 'tags', 'contentWarnings'])
                      ->where('slug', $slug)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        $genres = Genre::all();
        $tags = Tag::all();
        $warnings = ContentWarning::all();

        return view('writer.edit', compact('story', 'genres', 'tags', 'warnings'));
    }

    public function update(Request $request, $slug)
    {
        $story = Story::where('slug', $slug)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'genres' => 'required|array|max:4',
            'cover_image' => 'nullable|image|max:20480',
        ]);

        if ($request->hasFile('cover_image')) {

            if ($story->cover_image && file_exists(public_path('storage/' . $story->cover_image))) {
                unlink(public_path('storage/' . $story->cover_image));
            }

            $file = $request->file('cover_image');
            
            $namaFile = time() . '_' . $file->getClientOriginalName();
            
            $file->move(public_path('storage/covers'), $namaFile);
            
            $story->cover_image = 'covers/' . $namaFile;
        }

        $story->title = $request->title;
        $story->description = $request->description;
        $story->save();

        $story->genres()->sync($request->genres);
        
        if ($request->has('tags')) {
            $story->tags()->sync($request->tags);
        } else {
            $story->tags()->detach();
        }

        if ($request->has('warnings')) {
            $story->contentWarnings()->sync($request->warnings);
        } else {
            $story->contentWarnings()->detach();
        }

        return redirect()->route('writer.index')->with('success', 'Detail cerita berhasil diperbarui!');
    }
}