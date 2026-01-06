@extends('layouts.admin')

@section('title', 'Kelola Cerita')

<head>
        <style>
        .adaptive-card { background-color: #ffffff; border: 1px solid #e0e0e0; }
        .adaptive-text { color: #000000; }
        .adaptive-item { background-color: #ffffff; border-bottom: 1px solid #e0e0e0; }
        
        [data-bs-theme="dark"] .adaptive-card, body.dark-mode .adaptive-card {
            background-color: #212529 !important; border-color: #495057 !important; color: #ffffff !important;
        }
        [data-bs-theme="dark"] .adaptive-text, body.dark-mode .adaptive-text {
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .adaptive-item, body.dark-mode .adaptive-item {
            background-color: #212529 !important; border-bottom: 1px solid #495057 !important; color: #ffffff !important;
        }
    </style>
</head>

@section('content')
<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold adaptive-text">Manajemen Cerita</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm adaptive-card">
        <div class="card-header fw-bold py-3 adaptive-item">
            Daftar Semua Cerita
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @foreach($stories as $story)
                    <div class="list-group-item d-flex justify-content-between align-items-center p-3 adaptive-item">
                        <div class="d-flex align-items-center">
                            @if($story->cover_image)
                                <img src="{{ asset('storage/' . $story->cover_image) }}" class="rounded me-3" style="width: 40px; height: 60px; object-fit: cover;">
                            @else
                                <div class="rounded bg-secondary d-flex align-items-center justify-content-center me-3 text-white" style="width: 40px; height: 60px;">
                                    <i class="bi bi-book"></i>
                                </div>
                            @endif

                            <div>
                                <h6 class="mb-0 fw-bold">{{ Str::limit($story->title, 50) }}</h6>
                                <small class="opacity-75">Penulis: <strong>{{ $story->author->name }}</strong></small>
                                <div class="small mt-1 opacity-50">
                                    <i class="bi bi-clock"></i> {{ $story->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('story.show', $story->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>

                            <form action="{{ route('admin.stories.delete', $story->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paksa cerita ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus Paksa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $stories->links() }}
    </div>
</div>
@endsection