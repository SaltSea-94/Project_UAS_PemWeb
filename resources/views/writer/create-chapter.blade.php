@extends('layouts.app')

@section('title', 'Tulis Bab Baru')

{{-- 1. Load CSS Summernote --}}
<head>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
</head>

@section('content')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0">Tulis Bab Baru</h3>
                        <a href="{{ route('writer.chapters', $story->slug) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>
                            Menulis untuk: <strong>{{ $story->title }}</strong>
                        </div>
                    </div>

                    <form action="{{ route('writer.chapter.store', $story->slug) }}" method="POST">
                        @csrf 

                        <div class="mb-4">
                            <label class="form-label fw-bold">Judul Bab</label>
                            <input type="text" name="title" class="form-control form-control-lg" placeholder="Contoh: Bab 1: Awal Mula" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Isi Cerita</label>
                            <textarea id="summernote" name="content" required>{{ old('content') }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                <i class="bi bi-send-fill me-2"></i> Terbitkan Bab
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. Load Script Summernote --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Silakan ketik atau tempel (paste) tulisan dari Word di sini...',
            tabsize: 2,
            height: 500, // Tinggi editor
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'help']]
            ]
        });
    });
</script>
@endsection