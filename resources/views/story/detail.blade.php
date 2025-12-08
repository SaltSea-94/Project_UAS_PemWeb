@extends('layouts.app')

@section('title', $story->title)

<head>
    <style>
        
        /* 1. Setting Dasar Teks & Background */
        .adaptive-text { color: #000000; }
        .adaptive-muted { color: #555555; }
        .adaptive-card { background-color: #ffffff; border: 1px solid #ddd; }
        
        /* 2. Setting Khusus DARK MODE */
        [data-bs-theme="dark"] .adaptive-text, body.dark-mode .adaptive-text {
            color: #ffffff !important;
        }
        
        [data-bs-theme="dark"] .adaptive-muted, body.dark-mode .adaptive-muted {
            color: #bbbbbb !important;
        }

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

        <div class="col-md-8">
            <h1 class="fw-bold display-5 mb-2 adaptive-text">{{ $story->title }}</h1>
            
            <div class="d-flex align-items-center mb-3">
                <div class="me-3 adaptive-text">
                    <i class="bi bi-person-circle me-1"></i>
                    <span class="fw-bold">{{ $story->author->name }}</span>
                </div>
                <div class="adaptive-muted small">
                    <i class="bi bi-clock"></i> Update: {{ $story->updated_at->format('d M Y') }}
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex flex-wrap gap-2">
                    
                    @foreach($story->genres as $genre)
                        <span class="badge bg-primary bg-gradient px-3 py-2 rounded-pill shadow-sm">
                            {{ $genre->name }}
                        </span>
                    @endforeach

                    @foreach($story->tags as $tag)
                        <span class="badge bg-secondary bg-gradient px-3 py-2 rounded-pill shadow-sm opacity-75">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-4 pt-3 border-top border-secondary d-flex align-items-center adaptive-muted small">
                    <i class="bi bi-c-circle me-2 fs-5"></i> <span class="fw-bold">Seluruh Hak Cipta Dilindungi Undang-Undang</span>
                </div>
            </div>

            <div class="mb-5">
                <h5 class="fw-bold border-bottom pb-2 adaptive-text">Sinopsis</h5>
                <p class="adaptive-text" style="line-height: 1.8; white-space: pre-line;">{{ $story->description }}</p>
            </div>

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

            <div class="card shadow-sm adaptive-card">
                <div class="card-header fw-bold py-3 adaptive-card">
                    <i class="bi bi-list-ol me-2"></i> Daftar Bab
                </div>
                <div class="list-group list-group-flush">
                    @forelse($story->chapters as $chapter)
                        <a href="{{ route('chapter.read', [$story->slug, $chapter->slug]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 adaptive-card">
                            <div>
                                <span class="small me-2 opacity-75">Bab {{ $chapter->sort_order }}</span>
                                <span class="fw-semibold">{{ $chapter->title }}</span>
                            </div>
                            <i class="bi bi-chevron-right small opacity-50"></i>
                        </a>
                    @empty
                        <div class="text-center py-4 adaptive-muted">
                            <i class="bi bi-hourglass-split"></i> Belum ada bab yang dirilis.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection