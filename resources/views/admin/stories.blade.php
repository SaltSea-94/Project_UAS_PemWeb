@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-white">Kelola Cerita User</h2>
        <form action="{{ route('admin.stories') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm bg-dark text-white border-secondary me-2" placeholder="Cari Judul..." value="{{ request('search') }}">
            <button class="btn btn-warning btn-sm fw-bold">Cari</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="admin-card shadow-sm">
        <div class="table-responsive">
            <table class="table table-dark table-hover admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 40%">Judul & Penulis</th>
                        <th style="width: 15%">Statistik</th>
                        <th style="width: 15%">Tanggal</th>
                        <th style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stories as $index => $story)
                    <tr>
                        <td>{{ $stories->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3" style="width: 40px; height: 60px; background-color: #333; overflow: hidden; border-radius: 4px;">
                                    @if($story->cover_image)
                                        <img src="{{ asset('storage/' . $story->cover_image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-muted small"><i class="bi bi-book"></i></div>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('story.show', $story->slug) }}" target="_blank" class="fw-bold text-warning text-decoration-none text-truncate d-block" style="max-width: 250px;">
                                        {{ $story->title }} <i class="bi bi-box-arrow-up-right small ms-1 text-muted"></i>
                                    </a>
                                    <small class="text-white-50">Penulis: {{ $story->author->name }}</small>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-25 p-2">
                                    <i class="bi bi-eye-fill me-1"></i> {{ number_format($story->views) }} Pembaca
                                </span>
                                <small class="text-muted ps-1">
                                    <i class="bi bi-layers me-1"></i> {{ $story->chapters_count ?? $story->chapters->count() }} Bab
                                </small>
                            </div>
                        </td>

                        <td class="text-white-50 small">
                            {{ $story->created_at->format('d M Y') }}
                        </td>
                        
                        <td>
                            <form action="{{ route('admin.stories.delete', $story->id) }}" method="POST" onsubmit="return confirm('Hapus cerita ini secara paksa? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus Paksa">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            Belum ada cerita yang diterbitkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top border-secondary">
            {{ $stories->links() }}
        </div>
    </div>
</div>
@endsection