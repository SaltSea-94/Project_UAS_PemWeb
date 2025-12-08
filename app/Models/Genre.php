<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;

class Genre extends Model
{

    protected $guarded = ['id'];

    public function createStory()
    {
        $genres = Genre::all();
        return view('writer.create', compact('genres'));
    }

    // Ubah fungsi storeStory
    public function storeStory(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'genres' => 'required|array',
        ]);

        $story = Story::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'cover_image' => 'images/placeholder.jpg',
        ]);

        $story->genres()->attach($request->genres);

        return redirect()->route('writer.create', $story->slug)
                        ->with('success', 'Detail cerita disimpan! Sekarang tulis bab pertamamu.');
    }
}