<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Story;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'title',
        'slug',
        'content',
        'sort_order',
        'views',
    ];
    
    protected $casts = [
        'views' => 'integer',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
    
    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}