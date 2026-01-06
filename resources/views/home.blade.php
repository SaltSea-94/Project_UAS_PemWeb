@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<div class="container mt-4 mb-5">
    
    {{-- A. HEADER (Hanya muncul jika ADA cerita) --}}
    @if($stories->count() > 0)
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold adaptive-text">Cerita Terbaru</h3>
            
            {{-- Tombol Tambah di Header (Hanya untuk User Aktif & Bukan Admin) --}}
            @auth
                @if(!Auth::user()->is_admin && !Auth::user()->is_banned)
                <a href="{{ route('writer.create') }}" class="btn fw-bold shadow-sm" 
                   style="background-color: #ffc107; color: #000000; border: 1px solid #e0a800;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Cerita Baru
                </a>
                @endif
            @endauth
        </div>
    @endif

    <div class="row">
        {{-- B. LOOPING CERITA --}}
        @forelse($stories as $story)
            <div class="col-6 col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-card adaptive-card" style="transition: transform 0.2s;">
                    <div class="position-relative" style="height: 300px; overflow: hidden; border-radius: 8px 8px 0 0;">
                        <a href="{{ route('story.show', $story->slug) }}">
                            @if($story->cover_image)
                                <img src="{{ asset('storage/' . $story->cover_image) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white">
                                    <span class="fw-bold px-2 text-center">{{ $story->title }}</span>
                                </div>
                            @endif
                        </a>
                        <div class="position-absolute top-0 start-0 p-2">
                            @if($story->genres->first())
                                <span class="badge bg-warning text-dark shadow-sm">{{ $story->genres->first()->name }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="card-title fw-bold mb-1">
                            <a href="{{ route('story.show', $story->slug) }}" class="text-decoration-none adaptive-text">
                                {{ Str::limit($story->title, 40) }}
                            </a>
                        </h6>
                        <small class="text-muted mb-2">
                            <i class="bi bi-pen"></i> {{ $story->author ? $story->author->name : 'Admin' }}
                        </small>
                    </div>
                </div>
            </div>

        @empty
            {{-- C. EMPTY STATE (Jika Tidak Ada Cerita) --}}
            <div class="col-12">
                @if(Auth::check() && Auth::user()->is_admin)
                    {{-- TAMPILAN ADMIN --}}
                    <div class="text-center py-5">
                        <div class="text-muted opacity-50 mb-3"><i class="bi bi-folder2-open display-1"></i></div>
                        <h3 class="fw-bold adaptive-text">Database Cerita Kosong</h3>
                        <p class="text-muted">Belum ada user yang menerbitkan cerita.</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warning mt-2">
                            <i class="bi bi-speedometer2 me-2"></i> Kembali ke Dashboard
                        </a>
                    </div>
                @else
                    {{-- TAMPILAN USER / TAMU --}}
                    <div class="card border-0 shadow-lg py-5 text-center adaptive-card" style="border-radius: 20px;">
                        <div class="card-body py-5">
                            <div class="mb-4">
                                <div class="d-inline-block p-4 rounded-circle bg-warning bg-opacity-10">
                                    <i class="bi bi-feather text-warning" style="font-size: 5rem;"></i>
                                </div>
                            </div>
                            <h1 class="fw-bold mb-3 display-5 adaptive-text">Dunia Ini Masih Kosong...</h1>
                            <p class="text-muted mb-5 fs-5 mx-auto" style="max-width: 700px; line-height: 1.6;">
                                Belum ada tinta yang tertumpah di atas kertas digital ini. 
                                Jadilah <strong>yang pertama</strong> untuk menuliskan ceritamu di MariBaca!
                            </p>
                            
                            {{-- LOGIKA TOMBOL AKSI --}}
                            @auth
                                @if(Auth::user()->is_banned)
                                    {{-- JIKA USER KENA BAN --}}
                                    <div class="alert alert-danger d-inline-block px-4">
                                        <i class="bi bi-lock-fill me-2"></i> <strong>Akun Ditangguhkan:</strong> Anda tidak dapat membuat cerita baru.
                                    </div>
                                @else
                                    {{-- JIKA USER AKTIF --}}
                                    <a href="{{ route('writer.create') }}" class="btn btn-warning btn-lg fw-bold px-5 py-3 rounded-pill shadow hover-scale">
                                        <i class="bi bi-pen-fill me-2"></i> Mulai Menulis Cerita Pertamamu
                                    </a>
                                @endif
                            @else
                                {{-- JIKA TAMU (BELUM LOGIN) --}}
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg fw-bold px-5 py-3 rounded-pill shadow">
                                        <i class="bi bi-person-plus-fill me-2"></i> Gabung Jadi Penulis
                                    </a>
                                </div>
                                <p class="mt-4 text-muted small">
                                    Sudah punya akun? <a href="{{ route('login') }}" class="text-warning fw-bold text-decoration-none">Masuk di sini</a>
                                </p>
                            @endauth

                        </div>
                    </div>
                @endif
            </div>
        @endforelse
    </div>
</div>

<style>
    .hover-card:hover { transform: translateY(-5px); }
    .hover-scale:hover { transform: scale(1.05); transition: transform 0.2s; }
</style>
@endsection