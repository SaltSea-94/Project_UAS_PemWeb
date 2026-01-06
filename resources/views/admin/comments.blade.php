@extends('layouts.admin')

@section('content')
<h2 class="fw-bold mb-4">Pantauan Komentar (Live)</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card">
    <table class="table table-dark table-hover admin-table mb-0">
        <thead>
            <tr>
                <th style="width: 15%">User</th>
                <th style="width: 50%">Isi Komentar</th>
                <th style="width: 20%">Lokasi (Cerita/Bab)</th>
                <th style="width: 10%">Waktu</th>
                <th style="width: 5%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
            <tr>
                <td class="fw-bold text-info">{{ $comment->user->name }}</td>
                <td class="text-break">{{ $comment->body }}</td>
                <td>
                    <small class="d-block text-warning">{{ $comment->chapter->story->title }}</small>
                    <small class="text-muted">Bab {{ $comment->chapter->sort_order }}</small>
                </td>
                <td class="small">{{ $comment->created_at->diffForHumans() }}</td>
                <td>
                    <form action="{{ route('admin.comments.delete', $comment->id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini karena melanggar?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-3">{{ $comments->links() }}</div>
</div>
@endsection