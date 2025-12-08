@extends('layouts.app')

@section('title', 'Kelola Bab - ' . $story->title)

<head>
    <style>
        .adaptive-card { background-color: #ffffff; color: #000000; border: 1px solid #e0e0e0; }
        .adaptive-item { background-color: #ffffff; color: #000000; border-bottom: 1px solid #e0e0e0; }
        .adaptive-title { color: #000000; }
        
        [data-bs-theme="dark"] .adaptive-card, body.dark-mode .adaptive-card {
            background-color: #212529 !important; color: #ffffff !important; border-color: #495057 !important;
        }
        [data-bs-theme="dark"] .adaptive-item, body.dark-mode .adaptive-item {
            background-color: #212529 !important; color: #ffffff !important; border-bottom: 1px solid #495057 !important;
        }
        [data-bs-theme="dark"] .adaptive-title, body.dark-mode .adaptive-title {
            color: #ffffff !important;
        }

        .btn-square {
            width: 36px;
            height: 36px;
            padding: 0;      
            display: inline-flex;
            align-items: center;
            justify-content: center; 
            border-radius: 6px;  
            transition: all 0.2s ease-in-out;
        }
        .btn-square i {
            font-size: 1.1rem;   
            line-height: 0;       
        }
        .btn-square:hover {
            transform: scale(1.1);
        }
    </style>
</head>

@section('content')
<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('writer.index') }}" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
            <h2 class="fw-bold mt-2 adaptive-title">Manajemen Bab</h2>
            <p class="text-secondary mb-0">Cerita: <strong class="text-warning">{{ $story->title }}</strong></p>
        </div>
        
        <a href="{{ route('writer.chapter.create', $story->slug) }}" class="btn btn-primary fw-bold shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Bab Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm adaptive-card">
        <div class="card-header border-bottom py-3 adaptive-item">
            <h6 class="mb-0 fw-bold adaptive-title">
                <i class="bi bi-list-ol me-2"></i> Daftar Bab Terbit
            </h6>
        </div>
        
        <div class="card-body p-0">
            @if($story->chapters->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($story->chapters as $chapter)
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3 adaptive-item">
                            
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-3">Bab {{ $chapter->sort_order }}</span>
                                <div>
                                    <h6 class="mb-0 fw-bold adaptive-title">{{ $chapter->title }}</h6>
                                    <small class="text-muted">
                                        Update: {{ $chapter->updated_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('chapter.read', [$story->slug, $chapter->slug]) }}" 
                                   class="btn btn-outline-secondary btn-square" 
                                   target="_blank" 
                                   title="Lihat Tampilan">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('writer.chapter.edit', [$story->slug, $chapter->slug]) }}" 
                                   class="btn btn-warning btn-square text-dark" 
                                   title="Edit Bab">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('writer.chapter.destroy', [$story->slug, $chapter->slug]) }}" method="POST" onsubmit="return confirm('Hapus bab ini selamanya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-square" 
                                            title="Hapus Bab">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3 text-muted opacity-25"><i class="bi bi-file-earmark-x display-1"></i></div>
                    <h5 class="adaptive-title">Belum ada bab.</h5>
                    <a href="{{ route('writer.chapter.create', $story->slug) }}" class="btn btn-outline-primary mt-2">Buat Bab Pertama</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection