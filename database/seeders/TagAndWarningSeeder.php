<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\ContentWarning;

class TagAndWarningSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DAFTAR TAG LENGKAP
        $tags = [
            // --- Karakter Utama & Sifat ---
            'Anti-Hero Lead', 
            'Anti-Villain Lead',
            'Artificial Intelligence', 
            'Attractive Lead',
            'Female Lead', 
            'Male Lead', 
            'Non-Human Lead',
            'Non-Humanoid Lead',
            'Strong Lead', 
            'Smart Character',
            'Villainous Lead',
            'Multiple Lead Characters',
            'Genetically Engineered',
            'Local Protagonist',

            // --- Romansa & Hubungan ---
            'Competing Love Interest',
            'Lesbian Romance',
            'Male Gay Romance',
            'Multiple Lovers',
            'Romance Subplot',
            'Slow Burn',

            // --- Tema & Setting ---
            'Cyberpunk',
            'Dungeon',
            'Dystopia',
            'GameLit',
            'Grimdark',
            'High Fantasy',
            'Low Fantasy',
            'Magic',
            'Magical Girl',
            'Martial Arts',
            'Modern Knowledge',
            'Post Apocalyptic',
            'School Life',
            'Sci-Fi',
            'Hard Sci-fi',
            'Soft Sci-fi',
            'Secret Identity',
            'Slice of Life',
            'Space Opera',
            'Steampunk',
            'Super Heroes',
            'Urban Fantasy',
            'Virtual Reality',
            'Wuxia',
            'Xianxia',
            'Cultivation',
            'Mythos',
            'Otome',

            // --- Plot & Mekanisme ---
            'Apocalypse',
            'Base Building',
            'Kingdom Building',
            'Deck Building', 
            'Dungeon Core',
            'Dungeon Crawler',
            'Evolution',
            'First Contact', 
            'Loop',
            'Time Travel',
            'Portal Fantasy / Isekai',
            'Progression',
            'LitRPG',
            'Reincarnation',
            'Returner',
            'Summoned',
            'Survival',
            'System',
            'System Invasion',
            'Technologically Engineered',
            'Tower Climbing',
            'War and Military',
            'Strategy',
            'Politics',
            'Ruling Class',
            'Cozy',
            'Chivalry',
            'Crafting',
            'Magitech',
            'Mecha',
            'Reader Interactive', 
            'Gender Bender', 
            'Gore',
            'Supernatural'
        ];

        foreach ($tags as $t) { 
            Tag::firstOrCreate(['name' => $t]);
        }

        // 2. DAFTAR PERINGATAN KONTEN (Content Warnings)
        $warnings = [
            [
                'name' => 'Profanity (Kata Kasar)', 
                'desc' => 'Penggunaan bahasa kasar, makian, atau sumpah serapah yang kuat.'
            ],
            [
                'name' => 'Sexual Content (Konten Seksual)', 
                'desc' => 'Adegan seksual atau situasi dewasa.'
            ],
            [
                'name' => 'Gore / Graphic Violence (Kekerasan Grafis)', 
                'desc' => 'Deskripsi mendetail tentang darah, mutilasi, dan kekerasan fisik.'
            ],
            [
                'name' => 'Traumatizing Content (Konten Traumatis)', 
                'desc' => 'Penyiksaan, pelecehan berat, atau konten psikologis yang mengganggu.'
            ],
            [
                'name' => 'AI-Generated (Dibuat AI)', 
                'desc' => 'Cerita ini ditulis dengan bantuan kecerdasan buatan.'
            ],
        ];

        foreach ($warnings as $w) { 
            ContentWarning::firstOrCreate(
                ['name' => $w['name']], 
                ['description' => $w['desc']]
            );
        }
    }
}