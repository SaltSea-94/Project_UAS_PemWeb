@extends('layouts.app')

@section('title', $chapter->title)

@section('content')
<div class="container mt-5 mb-5" style="max-width: 800px;">
    
    <a href="{{ route('story.show', $story->slug) }}" class="btn btn-outline-secondary mb-4">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Isi
    </a>

    <h2 class="fw-bold mb-4 text-center">{{ $chapter->title }}</h2>
    
    <div class="content-text" style="font-size: 1.2rem; line-height: 2; text-align: justify;">
        {!! $chapter->content !!}
    </div>

    <hr class="my-5 opacity-25">

            <div class="d-flex justify-content-between align-items-center mt-5 mb-5 pb-5">
                
                @if($previousChapter)
                    <a href="{{ route('chapter.read', [$story->slug, $previousChapter->slug]) }}" 
                       class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">
                        <i class="bi bi-arrow-left me-2"></i> Bab Sebelumnya
                    </a>
                @else
                    <button class="btn btn-outline-secondary rounded-pill px-4 py-2 disabled" disabled>
                        <i class="bi bi-slash-circle me-2"></i> Awal Cerita
                    </button>
                @endif

                <a href="{{ route('story.show', $story->slug) }}" class="btn btn-secondary rounded-circle shadow-sm" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;" title="Daftar Isi">
                    <i class="bi bi-list-ul"></i>
                </a>

                @if($nextChapter)
                    <a href="{{ route('chapter.read', [$story->slug, $nextChapter->slug]) }}" 
                       class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow">
                        Bab Selanjutnya <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                @else
                    <a href="{{ route('story.show', $story->slug) }}" 
                       class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow">
                        Selesai Membaca <i class="bi bi-check-circle-fill ms-2"></i>
                    </a>
                @endif
            </div>
@endsection