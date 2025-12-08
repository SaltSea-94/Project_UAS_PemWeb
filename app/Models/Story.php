<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $guarded = ['id'];

    // Relasi: Cerita milik User
    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi Genre
    public function genres() {
        return $this->belongsToMany(Genre::class, 'genre_story');
    }

    // Relasi Tags
    public function tags() {
        return $this->belongsToMany(Tag::class, 'story_tag');
    }

    // Relasi Content Warnings
    public function contentWarnings() {
        return $this->belongsToMany(ContentWarning::class, 'content_warning_story');
    }

    // Relasi Chapters
    public function chapters() {
        return $this->hasMany(Chapter::class)->orderBy('sort_order', 'asc');
    }
}