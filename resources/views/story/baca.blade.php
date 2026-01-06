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

            <div class="container mt-5 pt-5 border-top">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h4 class="fw-bold mb-4 adaptive-text">
                            <i class="bi bi-chat-left-text me-2"></i> Komentar Bab Ini ({{ $chapter->comments->count() }})
                        </h4>
            
                        @auth
                            <form action="{{ route('chapter.comment.store', $chapter->id) }}" method="POST" class="mb-5">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="body" class="form-control" placeholder="Tulis komentar untuk bab ini..." required>
                                    <button class="btn btn-primary" type="submit">Kirim</button>
                                </div>
                            </form>
                        @else
                            <div class="text-center mb-4 p-3 bg-light rounded text-dark">
                                Ingin berkomentar? <a href="{{ route('login') }}">Masuk akun</a> dulu yuk!
                            </div>
                        @endauth
            
                        <div class="comment-list mt-4">
                            @forelse($chapter->comments as $comment)
                                <div class="d-flex mb-3 p-3 rounded adaptive-item position-relative" style="background-color: rgba(128, 128, 128, 0.05);">
                                    
                                    <div class="flex-shrink-0">
                                        @if($comment->user->photo)
                                            <img src="{{ asset('storage/' . $comment->user->photo) }}" class="rounded-circle shadow-sm border border-2 border-white" style="width: 45px; height: 45px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; font-size: 18px;">
                                                {{ substr($comment->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
            
                                    <div class="flex-grow-1 ms-3">
                                        
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold mb-0 adaptive-text">{{ $comment->user->name }}</h6>
                                                
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            
                                            
                                            @auth
                                            @if(Auth::id() === $comment->user_id)
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-muted p-0 no-arrow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                            @if(Auth::user()->is_banned)
                                                <div class="alert alert-danger text-center mt-4">
                                                    <i class="bi bi-exclamation-triangle-fill"></i> Anda sedang dalam masa hukuman (Banned). Akses komentar dimatikan.
                                                </div>
                                            @else
                                                <form action="{{ route('chapter.comment.store', $chapter->id) }}" method="POST" class="mb-5">
                                                </form>
                                            @endif
                                        @else
                                        @endauth
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        <li>
                                                            <a href="{{ route('comment.edit', $comment->id) }}" class="dropdown-item small">
                                                                <i class="bi bi-pencil-square me-2 text-warning"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?');">
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
            
                                        <p class="mt-2 mb-0 adaptive-text opacity-75 text-break" style="line-height: 1.5; white-space: pre-line;">{{ $comment->body }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted opacity-75">
                                    <i class="bi bi-chat-square-text fs-3 mb-2 d-block"></i>
                                    <small>Belum ada komentar di bab ini.</small>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
@endsection