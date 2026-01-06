@extends('layouts.app')
@section('title', 'Kotak Masuk')
@section('content')
<div class="container mt-5">
    <h3 class="fw-bold mb-4 adaptive-text"><i class="bi bi-inbox-fill me-2"></i> Pesan dari Admin</h3>

    <div class="list-group shadow-sm">
        @forelse($messages as $msg)
            <div class="list-group-item adaptive-card p-4 mb-3 border rounded {{ $msg->is_read ? 'opacity-75' : 'border-primary border-2' }}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold mb-0 text-danger">
                        @if(!$msg->is_read) <span class="badge bg-danger me-2">BARU</span> @endif
                        {{ $msg->subject }}
                    </h5>
                    <small class="text-muted">{{ $msg->created_at->format('d M Y, H:i') }}</small>
                </div>
                <p class="mb-0 adaptive-text">{{ $msg->message }}</p>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-envelope-open display-1"></i>
                <p class="mt-3">Tidak ada pesan baru.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection