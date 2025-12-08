@extends('layouts.app')

@section('title', 'Edit Cerita - ' . $story->title)

@section('content')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0">Edit Detail Cerita</h3>
                        <a href="{{ route('writer.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Batal & Kembali
                        </a>
                    </div>

                    <form action="{{ route('writer.update', $story->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="row">
                            <div class="col-md-4 mb-4 text-center">
                                <label class="form-label fw-bold">Sampul Cerita</label>
                                <div class="mb-3">
                                    @if($story->cover_image)
                                        <img src="{{ asset('storage/' . $story->cover_image) }}" class="img-thumbnail shadow-sm" style="max-height: 300px; width: 100%; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center border rounded" style="height: 300px;">
                                            <span class="text-muted">Tidak ada sampul</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="cover_image" class="form-control form-control-sm" accept="image/*">
                                <div class="form-text small">Upload baru untuk mengganti (Maks 20MB).</div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Cerita</label>
                                    <input type="text" name="title" class="form-control form-control-lg fw-bold" value="{{ old('title', $story->title) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Sinopsis / Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="6" required>{{ old('description', $story->description) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-primary">Genre (Maksimal 4)</label>
                                    <div class="card p-3 bg-light border-0" style="max-height: 150px; overflow-y: auto;">
                                        <div class="row g-2">
                                            @foreach($genres as $genre)
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input genre-check" type="checkbox" name="genres[]" value="{{ $genre->id }}" id="g{{ $genre->id }}"
                                                            {{ $story->genres->contains($genre->id) ? 'checked' : '' }}>
                                                        <label class="form-check-label small" for="g{{ $genre->id }}">{{ $genre->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4">
                            <label class="form-label fw-bold text-info">Tags (Label Tambahan)</label>
                            <div class="card p-3 border-0 shadow-sm" style="max-height: 200px; overflow-y: auto;">
                                <div class="row g-2">
                                    @foreach($tags as $tag)
                                        <div class="col-6 col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="t{{ $tag->id }}"
                                                    {{ $story->tags->contains($tag->id) ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="t{{ $tag->id }}">{{ $tag->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-danger">⚠️ Peringatan Konten</label>
                            <div class="card p-3 border-danger bg-danger bg-opacity-10">
                                @foreach($warnings as $w)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="warnings[]" value="{{ $w->id }}" id="w{{ $w->id }}"
                                            {{ $story->contentWarnings->contains($w->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="w{{ $w->id }}">
                                            <strong>{{ $w->name }}</strong> 
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Pembatas Genre (Max 4) --}}
<script>
    const checkboxes = document.querySelectorAll('.genre-check');
    const max = 4;
    checkboxes.forEach(box => {
        box.addEventListener('change', () => {
            const checked = document.querySelectorAll('.genre-check:checked').length;
            if (checked >= max) {
                checkboxes.forEach(cb => { if(!cb.checked) cb.disabled = true; });
            } else {
                checkboxes.forEach(cb => cb.disabled = false);
            }
        });
    });
</script>
@endsection