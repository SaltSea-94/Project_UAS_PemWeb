@extends('layouts.app')

@section('title', 'Buat Cerita Baru')

@section('content')
<div class="container mt-4 mb-5">
    <div class="card shadow border-0">
        <div class="card-body p-4">
            <h2 class="mb-4 fw-bold">Buat Cerita Baru</h2>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5 class="fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> Ada Masalah:</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('writer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold">Sampul Cerita (Opsional)</label>
                    <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" accept="image/*">
                    
                    <div class="form-text">Maksimal ukuran file 20MB. Jika kosong, akan menggunakan gambar default.</div>
                    
                    @error('cover_image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Cerita</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Tulis judul yang menarik..." required>
                    @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Sinopsis / Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Ceritakan garis besar ceritamu di sini..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <div class="mb-4">
                    <label class="form-label fw-bold d-block text-warning">Pilih Genre (Wajib, Maksimal 4)</label>
                    <div class="row">
                        @foreach($genres as $genre)
                        <div class="col-md-3 col-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input genre-check" type="checkbox" name="genres[]" value="{{ $genre->id }}" id="genre{{ $genre->id }}" {{ (is_array(old('genres')) && in_array($genre->id, old('genres'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="genre{{ $genre->id }}">{{ $genre->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('genres')
                        <div class="alert alert-danger py-2 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold d-block text-info">Tag (Label Tambahan)</label>
                    <p class="small text-muted mb-2">Pilih elemen spesifik yang ada dalam ceritamu.</p>
                    <div class="row" style="max-height: 200px; overflow-y: auto;">
                        @foreach($tags as $tag)
                        <div class="col-md-3 col-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}" {{ (is_array(old('tags')) && in_array($tag->id, old('tags'))) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="tag{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <hr class="my-4">

                <div class="mb-4 p-3 border border-danger rounded">
                    <label class="form-label fw-bold d-block text-danger">⚠️ Peringatan Konten (Content Warnings)</label>
                    <p class="small text-muted mb-2">Centang jika ceritamu mengandung unsur sensitif di bawah ini.</p>
                    @foreach($warnings as $warning)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="warnings[]" value="{{ $warning->id }}" id="warn{{ $warning->id }}" {{ (is_array(old('warnings')) && in_array($warning->id, old('warnings'))) ? 'checked' : '' }}>
                        <label class="form-check-label" for="warn{{ $warning->id }}">
                            <span class="fw-bold">{{ $warning->name }}</span> 
                            <span class="text-muted small">- {{ $warning->description }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold mb-3">Pengaturan Cerita</label>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_fanfiction" id="fanficCheck" {{ old('is_fanfiction') ? 'checked' : '' }}>
                        <label class="form-check-label" for="fanficCheck">
                            <strong>Fanfiksi (Fanfiction)</strong> 
                            <div class="text-muted small">Apakah ceritamu menggunakan karakter atau dunia milik orang lain?</div>
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="public_schedule" id="scheduleCheck" checked>
                        <label class="form-check-label" for="scheduleCheck">
                            <strong>Tampilkan Jadwal Rilis</strong> 
                            <div class="text-muted small">Apakah pembaca boleh melihat kapan bab selanjutnya dijadwalkan rilis?</div>
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="allow_comments" id="commentCheck" checked>
                        <label class="form-check-label" for="commentCheck">
                            <strong>Aktifkan Bantuan Saran (Suggestions Helper)</strong> 
                            <div class="text-muted small">
                                Mengizinkan pembaca memberikan koreksi atau saran perbaikan pada teks cerita.
                            </div>
                        </label>
                    </div>
                </div>

                <div class="d-grid mt-5">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">Simpan & Mulai Menulis Bab</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const genreChecks = document.querySelectorAll('.genre-check');
    const maxGenres = 4;

    genreChecks.forEach(check => {
        check.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.genre-check:checked').length;
            
            if (checkedCount >= maxGenres) {
                genreChecks.forEach(box => {
                    if (!box.checked) box.disabled = true;
                });
            } else {
                genreChecks.forEach(box => {
                    box.disabled = false;
                });
            }
        });
    });
</script>
@endsection