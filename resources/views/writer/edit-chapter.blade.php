@extends('layouts.app')

@section('title', 'Edit Bab - ' . ($chapter->title ?? 'Judul'))

{{-- 1. Load CSS Editor (Summernote) --}}
<head>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
    <style>
        .note-editor .note-editing-area .note-editable {
            background-color: #ffffff !important;
            color: #000000 !important;
            text-align: left !important;
            padding-left: 20px !important;
            font-family: 'Arial', sans-serif !important;
            line-height: 1.5 !important;
        }

        .note-btn-group .dropdown-menu {
            background-color: #ffffff !important;
            border: 2px solid #000000 !important;
            max-height: 300px !important;
            overflow-y: auto !important;
        }

        .note-btn-group .dropdown-item, 
        .note-btn-group .dropdown-item *,
        .note-btn-group .dropdown-menu a,
        .note-btn-group .dropdown-menu a * {
            color: #000000 !important;
            text-decoration: none !important;
            background-color: transparent !important;
        }

        .note-btn-group .dropdown-item:hover,
        .note-btn-group .dropdown-menu a:hover {
            background-color: #007bff !important;
        }
        
        .note-btn-group .dropdown-item:hover *,
        .note-btn-group .dropdown-menu a:hover * {
            color: #ffffff !important;
        }

        .note-toolbar {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #ccc !important;
        }
        
        .note-btn {
            color: #333 !important;
            background-color: #fff !important;
            border: 1px solid #ccc !important;
        }

        input[name="title"] {
            background-color: #2c2c2c !important;
            color: #ffffff !important;
            border: 1px solid #555 !important;
        }

        input[name="title"]:focus {
            background-color: #1a1a1a !important;
            color: #ffffff !important;
            border-color: #007bff !important;
        }
    </style>
</head>

@section('content')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0" style="background-color: #212529; color: white;">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0 text-white">Edit Bab</h3>
                        <a href="{{ route('writer.chapters', $story->slug) }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                    </div>

                    <div class="alert alert-dark border-secondary d-flex align-items-center text-white small py-2">
                        <i class="bi bi-pencil-square me-2"></i>
                        <div>Anda sedang mengedit: <strong>{{ $chapter->title }}</strong></div>
                    </div>

                    <form action="{{ route('writer.chapter.update', [$story->slug, $chapter->slug]) }}" method="POST">
                        @csrf 
                        @method('PUT') 

                        <div class="mb-4">
                            <label class="form-label fw-bold text-white">Judul Bab</label>
                            <input type="text" name="title" class="form-control form-control-lg" value="{{ $chapter->title }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-white">Isi Cerita</label>
                            
                            <textarea id="summernote" name="content" required>{!! $chapter->content !!}</textarea>
                            
                            <div class="form-text text-light mt-2 opacity-75">
                                <i class="bi bi-info-circle"></i> Tips: Gunakan toolbar untuk mengatur gaya teks (Bold, Italic, Font).
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg fw-bold">
                                <i class="bi bi-check-circle-fill me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. Script Editor (Javascript) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tulis ceritamu di sini...',
            tabsize: 2,
            height: 600,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']], 
                ['view', ['fullscreen', 'help']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Georgia', 'Times New Roman', 'Verdana', 'Tahoma'],
            fontNamesIgnoreCheck: ['Merriweather', 'Arial'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48']
        });
    });
</script>
@endsection