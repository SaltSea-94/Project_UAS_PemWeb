<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'views',
    ];

    protected $casts = [
        'views' => 'integer',
    ];

    // Relasi: Cerita milik User (Penulis)
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

    // Relasi Chapters (Bab)
    public function chapters() {
        return $this->hasMany(Chapter::class)->orderBy('sort_order', 'asc');
    }

    // Relasi Reviews (Ulasan)
    public function reviews(){
        return $this->hasMany(Review::class)->latest();
    }

    // Relasi Comments (Komentar)
    public function comments(){
        return $this->hasMany(Comment::class)->latest();
    }
}