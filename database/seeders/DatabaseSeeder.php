<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Jalankan Seeder Genre (Supaya pilihan Action, Romance, dll muncul)
        $this->call(GenreSeeder::class);

        $this->call(TagAndWarningSeeder::class);

        // 2. Jalankan Seeder Cerita (Supaya cerita "The Unkindled" masuk)
        //$this->call(StorySeeder::class);

        // 3. Buat 1 User Test (Opsional, buat login cepat)
        User::factory()->create([
            'name' => 'Admin Test User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}