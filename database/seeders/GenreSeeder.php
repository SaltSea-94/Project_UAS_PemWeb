<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Action', 
            'Adventure', 
            'Comedy', 
            'Contemporary', 
            'Drama', 
            'Fantasy', 
            'Historical', 
            'Horror', 
            'Mystery', 
            'Psychological', 
            'Romance', 
            'Satire', 
            'Sci-Fi', 
            'Short Story', 
            'Thriller', 
            'Tragedy',
            'LitRPG', 
            'Isekai', 
            'Xianxia', 
            'Wuxia',
            'Martial Arts',
            'School Life',
            'Slice of Life',
            'Urban Fantasy'
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(['name' => $genre]);
        }
    }
}