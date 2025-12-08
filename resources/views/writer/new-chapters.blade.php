@extends('layouts.app')

@section('title', 'Tulis Bab Baru')

{{-- 1. Load CSS Editor (Summernote) --}}
<head>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
    <style>
        .note-editor .note-editing-area .note-editable {
            background-color: #ffffff !important;
            color: #000000 !important;
            text-align: left !important;
            padding-left: 20px !important;
            line-height: 1.5 !important;
            font-family: 'Arial', sans-serif !important;
        }

        .note-btn-group .dropdown-menu, .note-dropdown-menu {
            background-color: #ffffff !important;
            border: 1px solid #000000 !important;
            padding: 5px 0 !important;
            
            max-height: 300px !important;
            overflow-y: auto !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3) !important;
        }

        .note-btn-group .dropdown-menu a, 
        .note-btn-group .dropdown-menu .dropdown-item {
            color: #000000 !important;
            background-color: transparent !important;
            display: block !important;
            padding: 5px 15px !important;
            text-decoration: none !important;
            font-size: 14px !important;
        }

        .note-btn-group .dropdown-menu a *, 
        .note-btn-group .dropdown-menu .dropdown-item * {
            color: #000000 !important;
            margin: 0 !important;
        }

        .note-btn-group .dropdown-menu a:hover,
        .note-btn-group .dropdown-menu .dropdown-item:hover {
            background-color: #007bff !important;
            color: #ffffff !important;
        }

        .note-btn-group .dropdown-menu a:hover *,
        .note-btn-group .dropdown-menu .dropdown-item:hover * {
            color: #ffffff !important;
            background-color: transparent !important;
        }

        .note-toolbar {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #ccc !important;
            color: #333 !important;
        }
        
        .note-btn {
            background-color: #ffffff !important;
            color: #333333 !important;
            border: 1px solid #dddddd !important;
        }
        
        .note-btn.active {
            background-color: #e2e6ea !important;
            color: #000000 !important;
            border: 1px solid #aaaaaa !important;
        }

        .note-placeholder {
            color: #999999 !important;
        }
        
        .note-statusbar {
            display: none !important;
        }
    </style>
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
                            <i class="bi bi-arrow-left"></i> Batal & Kembali
                        </a>
                    </div>

                    <div class="alert alert-primary d-flex align-items-center">
                        <i class="bi bi-pen-fill me-2"></i>
                        <div>
                            Menulis untuk cerita: <strong>{{ $story->title }}</strong>
                        </div>
                    </div>

                    <form action="{{ route('writer.chapter.store', $story->slug) }}" method="POST">
                        @csrf 

                        <div class="mb-4">
                            <label class="form-label fw-bold">Judul Bab</label>
                            <input type="text" name="title" class="form-control form-control-lg" placeholder="Contoh: Bab 1: Pertemuan Pertama" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Isi Cerita</label>
                            
                            <textarea id="summernote" name="content" required>{{ old('content') }}</textarea>
                            
                            <div class="form-text text-muted mt-2">
                                <i class="bi bi-info-circle"></i> Tips: Klik toolbar paragraf (garis-garis) untuk mengatur rata kiri/tengah/kanan.
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                <i class="bi bi-send-check-fill me-2"></i> Terbitkan Bab Ini
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
            placeholder: 'Mulai mengetik ceritamu di sini... (Format MS Word Didukung)',
            tabsize: 2,
            height: 600,
            focus: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'help']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Georgia', 'Times New Roman', 'Verdana', 'Tahoma', 'Trebuchet MS'],
            fontNamesIgnoreCheck: ['Merriweather', 'Arial'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48']
        });
    });
</script>
@endsection