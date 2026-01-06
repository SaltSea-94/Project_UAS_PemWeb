@extends('layouts.app')
@section('title', 'Edit Komentar')
@section('content')
<div class="container mt-5">
    <div class="card shadow-sm adaptive-card col-md-8 mx-auto">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-4 adaptive-text">Edit Komentar</h4>
            <div class="alert alert-light mb-3">
                <small class="text-muted">Bab: {{ $comment->chapter->title }}</small>
            </div>
            
            <form action="{{ route('comment.update', $comment->id) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="mb-3">
                    <textarea name="body" class="form-control" rows="3" required>{{ old('body', $comment->body) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success fw-bold">Update Komentar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection