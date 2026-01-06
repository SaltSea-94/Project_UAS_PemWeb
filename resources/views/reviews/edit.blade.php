@extends('layouts.app')
@section('title', 'Edit Ulasan')
@section('content')
<div class="container mt-5">
    <div class="card shadow-sm adaptive-card col-md-8 mx-auto">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-4 adaptive-text">Edit Ulasan Anda</h4>
            <form action="{{ route('review.update', $review->id) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label adaptive-text">Rating</label>
                    <select name="rating" class="form-select">
                        <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐</option>
                        <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐</option>
                        <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>⭐⭐⭐</option>
                        <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>⭐⭐</option>
                        <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>⭐</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label adaptive-text">Pendapat</label>
                    <textarea name="body" class="form-control" rows="4" required>{{ old('body', $review->body) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection