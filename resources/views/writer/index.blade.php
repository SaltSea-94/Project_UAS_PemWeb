@extends('layouts.app')

@section('title', 'MariNulis - Dashboard Penulis')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 class="fw-bold mb-0">MariNulis <span class="text-warning fs-4">Studio</span></h2>
            <p class="text-muted small mb-0">Tempat kamu menghasilkan karyamu.</p>
        </div>
        <a href="{{ route('writer.create') }}" class="btn btn-warning fw-bold shadow-sm">
            <i class="bi bi-plus-lg"></i> Buat Cerita Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($myStories as $story)
            <div class="col-12 mb-3">
                <div class="card border-0 shadow-sm overflow-hidden hover-card">
                    <div class="row g-0">
                        <div class="col-md-2 col-3 bg-secondary d-flex align-items-center justify-content-center position-relative" style="min-height: 140px;">
                            @if($story->cover_image)
                                <img src="{{ asset('storage/' . $story->cover_image) }}" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover;">
                            @else
                                <div class="text-white text-center p-2 opacity-50">
                                    <i class="bi bi-book display-4"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-10 col-9">
                            <div class="card-body d-flex flex-column h-100 justify-content-between py-3">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="fw-bold mb-1 text-truncate">{{ $story->title }}</h5>
                                        <span class="badge bg-light text-dark border">{{ $story->is_fanfiction ? 'Fanfic' : 'Ori' }}</span>
                                    </div>
                                    <p class="text-muted small mb-2 text-truncate">{{ Str::limit($story->description, 100) }}</p>
                                    
                                    <div class="d-flex align-items-center gap-3 text-secondary small">
                                        <span><i class="bi bi-files"></i> {{ $story->chapters->count() }} Bab</span>
                                        <span><i class="bi bi-clock"></i> {{ $story->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-3 pt-2 border-top">
                                    
                                    <div class="d-flex gap-2 mt-3 pt-2 border-top">
    
                                        {{-- Kelola Bab --}}
                                        <a href="{{ route('writer.chapters', $story->slug) }}" class="btn btn-sm btn-primary px-3">
                                            <i class="bi bi-list-ul me-1"></i> Bab
                                        </a>
                                    
                                        {{-- TOMBOL EDIT DETAIL (BARU) --}}
                                        <a href="{{ route('writer.edit', $story->slug) }}" class="btn btn-sm btn-info text-white px-3" title="Edit Detail Cerita">
                                            <i class="bi bi-pencil-square"></i> Info
                                        </a>
                                    
                                        {{-- Lihat --}}
                                        <a href="{{ route('story.show', $story->slug) }}" class="btn btn-sm btn-outline-secondary px-3" target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        {{-- Hapus --}}
                                        <form action="{{ route('writer.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus cerita ini selamanya? Semua bab akan hilang.');" class="ms-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Cerita">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="mb-3 text-muted opacity-25">
                        <i class="bi bi-pencil-square display-1"></i>
                    </div>
                    <h4 class="fw-bold">Belum ada karya.</h4>
                    <p class="text-muted mb-4">Dunia sedang menunggu imajinasimu.</p>
                    <a href="{{ route('writer.create') }}" class="btn btn-warning px-4 py-2 fw-bold">
                        Buat Cerita Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>

<style>
    .hover-card:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; transition: 0.2s; }
</style>
@endsection