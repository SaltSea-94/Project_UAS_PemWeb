@extends('layouts.app')

@section('title', $story->title)

<head>
    <style>
        /* CSS Khusus Halaman Detail */
        .adaptive-text { color: #000000; }
        .adaptive-muted { color: #555555; }
        .adaptive-card { background-color: #ffffff; border: 1px solid #ddd; }
        
        /* Dark Mode Override */
        [data-bs-theme="dark"] .adaptive-text, body.dark-mode .adaptive-text { color: #ffffff !important; }
        [data-bs-theme="dark"] .adaptive-muted, body.dark-mode .adaptive-muted { color: #bbbbbb !important; }
        [data-bs-theme="dark"] .adaptive-card, body.dark-mode .adaptive-card {
            background-color: #212529 !important;
            border-color: #495057 !important;
            color: #ffffff !important;
        }
        .list-group-item { background-color: inherit; color: inherit; }
    </style>
</head>

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        
        {{-- KOLOM KIRI: COVER BUKU & TOMBOL BACA --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-lg overflow-hidden adaptive-card">
                @if($story->cover_image)
                    <img src="{{ asset('storage/' . $story->cover_image) }}" class="card-img-top" alt="{{ $story->title }}">
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height: 450px; background-color: #333; color: white;">
                        <div class="text-center p-3">
                            <h3 class="fw-bold">{{ $story->title }}</h3>
                            <p class="small">oleh {{ $story->author->name }}</p>
                        </div>
                    </div>
                @endif
            </div>

            @if($story->chapters->first())
                <div class="d-grid mt-3">
                    <a href="{{ route('chapter.read', [$story->slug, $story->chapters->first()->slug]) }}" class="btn btn-warning btn-lg fw-bold shadow">
                        <i class="bi bi-book-half me-2"></i> Mulai Membaca
                    </a>
                </div>
            @endif
        </div>

        {{-- KOLOM KANAN: DETAIL INFO, SINOPSIS, DAN ULASAN --}}
        <div class="col-md-8">
            <h1 class="fw-bold display-5 mb-2 adaptive-text">{{ $story->title }}</h1>
            
            <div class="d-flex align-items-center mb-3 flex-wrap gap-3">
                {{-- Penulis --}}
                <div class="adaptive-text">
                    <i class="bi bi-person-circle me-1"></i>
                    <span class="fw-bold">{{ $story->author->name }}</span>
                </div>
                
                {{-- Tanggal Update --}}
                <div class="adaptive-muted small">
                    <i class="bi bi-clock"></i> {{ $story->updated_at->format('d M Y') }}
                </div>

                {{-- JUMLAH PEMBACA (Live Count) --}}
                <div class="adaptive-muted small" title="Jumlah Pembaca">
                    <i class="bi bi-eye-fill text-primary"></i> 
                    <span class="fw-bold">{{ number_format($story->views) }}</span> Telah Dibaca
                </div>
            </div>

            {{-- GENRE & TAGS --}}
            <div class="mb-4">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($story->genres as $genre)
                        <span class="badge bg-primary bg-gradient px-3 py-2 rounded-pill shadow-sm">{{ $genre->name }}</span>
                    @endforeach
                    @foreach($story->tags as $tag)
                        <span class="badge bg-secondary bg-gradient px-3 py-2 rounded-pill shadow-sm opacity-75">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="mt-4 pt-3 border-top border-secondary d-flex align-items-center adaptive-muted small">
                    <i class="bi bi-c-circle me-2 fs-5"></i> <span class="fw-bold">Seluruh Hak Cipta Dilindungi Undang-Undang</span>
                </div>
            </div>

            {{-- SINOPSIS --}}
            <div class="mb-5">
                <h5 class="fw-bold border-bottom pb-2 adaptive-text">Sinopsis</h5>
                <p class="adaptive-text" style="line-height: 1.8; white-space: pre-line;">{{ $story->description }}</p>
            </div>

            {{-- WARNINGS --}}
            @if($story->contentWarnings->count() > 0)
                <div class="alert alert-danger mb-4">
                    <strong><i class="bi bi-exclamation-triangle-fill"></i> Peringatan Konten:</strong>
                    <ul class="mb-0 ps-3 mt-1 small">
                        @foreach($story->contentWarnings as $warning)
                            <li>{{ $warning->name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- DAFTAR BAB --}}
            <div class="card shadow-sm adaptive-card mb-5">
                <div class="card-header fw-bold py-3 adaptive-header">
                    <i class="bi bi-list-ol me-2"></i> Daftar Bab
                </div>
                <div class="list-group list-group-flush">
                    @forelse($story->chapters as $chapter)
                        <a href="{{ route('chapter.read', [$story->slug, $chapter->slug]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 adaptive-item">
                            
                            {{-- Judul Bab --}}
                            <div>
                                <span class="small me-2 opacity-75">Bab {{ $chapter->sort_order }}</span>
                                <span class="fw-semibold">{{ $chapter->title }}</span>
                            </div>

                            {{-- Statistik Pembaca Bab (BARU) --}}
                            <div class="d-flex align-items-center gap-3">
                                <small class="text-muted opacity-75" title="Dibaca {{ number_format($chapter->views) }} kali">
                                    <i class="bi bi-eye-fill me-1"></i> {{ number_format($chapter->views) }}
                                </small>
                                <i class="bi bi-chevron-right small opacity-50"></i>
                            </div>

                        </a>
                    @empty
                        <div class="text-center py-4 adaptive-item opacity-75">
                            <i class="bi bi-hourglass-split"></i> Belum ada bab yang dirilis.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- BAGIAN ULASAN PEMBACA --}}
            <div class="mt-5 pt-4 border-top">
                <div class="d-flex align-items-center mb-4">
                    <h3 class="fw-bold adaptive-text mb-0">Ulasan Pembaca</h3>
                    <span class="badge bg-warning text-dark ms-3 fs-6 rounded-pill shadow-sm">
                        {{ $story->reviews->count() }}
                    </span>
                </div>

                {{-- NOTIFIKASI ERROR/SUKSES --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- =================================================== --}}
                {{-- LOGIKA UTAMA FORMULIR ULASAN (PERBAIKAN ERROR) --}}
                {{-- =================================================== --}}
                @auth
                    {{-- SKENARIO 1: USER SUDAH LOGIN --}}
                    
                    @if(Auth::user()->is_banned)
                        {{-- A. JIKA BANNED: Tampilkan Pesan Error --}}
                        <div class="alert alert-danger border-danger p-4 text-center shadow-sm">
                            <i class="bi bi-slash-circle-fill display-4 mb-3 d-block text-danger"></i>
                            <h5 class="fw-bold">Akses Ulasan Ditangguhkan</h5>
                            <p class="mb-0">
                                Akun Anda sedang dalam masa penangguhan (Banned).<br>
                                Mohon tunggu keputusan Admin untuk membuka kembali akses interaksi Anda.
                            </p>
                        </div>
                    @else
                        {{-- B. JIKA AKTIF: Tampilkan Form Review --}}
                        <div class="card mb-5 adaptive-card p-4 shadow-sm border-0">
                            <h5 class="fw-bold mb-3 adaptive-text">Tulis Ulasan Anda</h5>
                            
                            <form action="{{ route('story.review.store', $story->id) }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label adaptive-text small fw-bold">Berikan Bintang</label>
                                        <select name="rating" class="form-select border-secondary bg-light text-dark">
                                            <option value="5">⭐⭐⭐⭐⭐ (Sempurna)</option>
                                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                            <option value="3">⭐⭐⭐ (Lumayan)</option>
                                            <option value="2">⭐⭐ (Kurang)</option>
                                            <option value="1">⭐ (Buruk)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-9">
                                        <label class="form-label adaptive-text small fw-bold">Pendapat Anda</label>
                                        <textarea name="body" 
                                                  class="form-control border-secondary bg-light text-dark @error('body') is-invalid @enderror" 
                                                  rows="2" 
                                                  placeholder="Ceritanya seru banget karena... (Min. 5 karakter)" 
                                                  required>{{ old('body') }}</textarea>
                                        @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">
                                            <i class="bi bi-send-fill me-2"></i> Kirim Ulasan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                @else
                    {{-- SKENARIO 2: BELUM LOGIN (GUEST) --}}
                    <div class="alert alert-secondary d-flex align-items-center mb-4 p-3 rounded-3 shadow-sm">
                        <i class="bi bi-info-circle-fill me-3 fs-4 text-primary"></i>
                        <div>
                            Ingin memberikan ulasan? Silakan <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Login</a> terlebih dahulu.
                        </div>
                    </div>
                @endauth
                {{-- =================================================== --}}

                {{-- DAFTAR ULASAN YANG SUDAH ADA --}}
                <div class="review-list mt-4">
                    @forelse($story->reviews as $review)
                        <div class="d-flex mb-4 p-3 rounded adaptive-item position-relative" style="background-color: rgba(128, 128, 128, 0.05);">
                            <div class="flex-shrink-0">
                                @if($review->user->photo)
                                    <img src="{{ asset('storage/' . $review->user->photo) }}" class="rounded-circle shadow-sm border border-2 border-white" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; font-size: 20px;">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-0 adaptive-text">{{ $review->user->name }}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            {{ $review->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                    @if(Auth::id() === $review->user_id)
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0 no-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a href="{{ route('review.edit', $review->id) }}" class="dropdown-item small">
                                                        <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('review.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item small text-danger">
                                                            <i class="bi bi-trash me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="my-2">
                                    @for($i=0; $i < $review->rating; $i++) <i class="bi bi-star-fill text-warning small"></i> @endfor
                                    @for($i=$review->rating; $i < 5; $i++) <i class="bi bi-star text-muted small opacity-25"></i> @endfor
                                </div>

                                <p class="mb-0 adaptive-text opacity-75" style="line-height: 1.5; white-space: pre-line;">{{ $review->body }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 border rounded adaptive-card border-dashed opacity-50">
                            <i class="bi bi-chat-square-quote display-4 mb-3 text-muted"></i>
                            <p class="mb-0">Belum ada ulasan. Jadilah yang pertama memberikan pendapat!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection