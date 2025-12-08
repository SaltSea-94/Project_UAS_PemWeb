<?php

namespace Database\Seeders;

use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        $story = Story::create([
            'title' => '',
            'slug' => '',
            'description' => '',
            'cover_image' => '',
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'title' => '',
            'slug' => '',
            'content' =>  '',
            'sort_order' => 1
        ]);

        Chapter::create([
            'story_id' => $story->id,
            'title' => '',
            'slug' => '',
            'content' => '',
            'sort_order' => 2
        ]);
    }
}