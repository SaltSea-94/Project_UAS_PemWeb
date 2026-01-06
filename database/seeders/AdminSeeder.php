<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = 'Radiohead@troyan.com';
        
        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Developer',
                'email' => $adminEmail,
                'password' => Hash::make('SungaiBengawanKudus2006'),
                'is_admin' => true,
                'is_banned' => false,
                'email_verified_at' => now(),
            ]);
        }
    }
}