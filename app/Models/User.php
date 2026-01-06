<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /**
     * PERBAIKAN:
     * Saya menghapus 'HasApiTokens' dari sini agar tidak error lagi.
     */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',      
        'is_admin',   
        'is_banned',  
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'is_banned' => 'boolean',
    ];

    // --- RELASI (TETAP ADA) ---

    // 1. User punya banyak Cerita
    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    // 2. User punya banyak Komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 3. User punya banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}