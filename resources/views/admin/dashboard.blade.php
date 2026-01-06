@extends('layouts.admin') {{-- Pastikan menggunakan layout admin --}}

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <h2 class="fw-bold mb-4 text-white">Pusat Kontrol Admin</h2>

    {{-- Alert Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 1. KARTU STATISTIK --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="admin-card p-3 border-start border-4 border-primary">
                <h6 class="text-muted text-uppercase small">Total User</h6>
                <h2 class="mb-0 fw-bold text-white">{{ $totalUsers ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-card p-3 border-start border-4 border-warning">
                <h6 class="text-muted text-uppercase small">Penulis Aktif</h6>
                <h2 class="mb-0 fw-bold text-white">{{ $stats['writers'] ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-card p-3 border-start border-4 border-info">
                <h6 class="text-muted text-uppercase small">Pembaca Murni</h6>
                <h2 class="mb-0 fw-bold text-white">{{ $stats['readers'] ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-card p-3 border-start border-4 border-success">
                <h6 class="text-muted text-uppercase small">Total Cerita</h6>
                <h2 class="mb-0 fw-bold text-white">{{ $totalStories ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- 2. TABEL USER TERBARU --}}
        <div class="col-md-6 mb-4">
            <div class="admin-card shadow-sm h-100">
                <div class="card-header fw-bold bg-danger text-white border-0 p-3">
                    <i class="bi bi-people-fill me-2 fs-5"></i> <span class="fs-5">User Terbaru</span>
                </div>
                
                <ul class="list-group list-group-flush bg-transparent">
                    @foreach($latestUsers as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-secondary p-3">
                            <div>
                                <strong class="text-warning">{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            
                            <div class="d-flex gap-2">
                                @if(!$user->is_admin)
                                    <a href="{{ route('admin.message.create', $user->id) }}" class="btn btn-sm btn-outline-info" title="Kirim Pesan">
                                        <i class="bi bi-envelope"></i>
                                    </a>
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Banned user ini selamanya?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus User"><i class="bi bi-trash"></i></button>
                                    </form>
                                @else
                                    <span class="badge bg-warning text-dark">Admin</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="card-footer bg-transparent border-0 text-end p-3">
                    <a href="{{ route('admin.users') }}" class="text-decoration-none text-info small">Lihat Semua User &rarr;</a>
                </div>
            </div>
        </div>

        {{-- 3. TABEL CERITA TERBARU --}}
        <div class="col-md-6 mb-4">
            <div class="admin-card shadow-sm h-100">
                <div class="card-header fw-bold bg-success text-white border-0 p-3">
                    <i class="bi bi-book-half me-2 fs-5"></i> <span class="fs-5">Cerita Terbaru</span>
                </div>
                
                <ul class="list-group list-group-flush bg-transparent">
                    @foreach($latestStories as $story)
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-secondary p-3">
                            <div>
                                <strong class="text-truncate d-block" style="max-width: 200px;">{{ $story->title }}</strong>
                                <small class="text-muted">Oleh: {{ $story->author->name }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('story.show', $story->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                                <form action="{{ route('admin.stories.delete', $story->id) }}" method="POST" onsubmit="return confirm('Hapus paksa cerita ini?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="card-footer bg-transparent border-0 text-end p-3">
                    <a href="{{ route('admin.stories') }}" class="text-decoration-none text-success small">Lihat Semua Cerita &rarr;</a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- 4. PENGUMUMAN GLOBAL (PANEL KANAN BAWAH ATAU FULL WIDTH) --}}
    <div class="row">
        <div class="col-12">
             <div class="admin-card p-3 mb-4 border-start border-4 border-info">
                <h6 class="fw-bold text-white border-bottom pb-2 mb-3">📢 Kelola Pengumuman Global</h6>
                
                {{-- Form Pengumuman Sederhana --}}
                <form action="{{ route('admin.announcement.store') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <textarea name="message" class="form-control bg-dark text-white border-secondary" rows="1" placeholder="Tulis pengumuman singkat..." required></textarea>
                        <select name="type" class="form-select bg-dark text-white border-secondary" style="max-width: 150px;">
                            <option value="info">Info (Biru)</option>
                            <option value="warning">Warning (Kuning)</option>
                            <option value="danger">Urgent (Merah)</option>
                        </select>
                        <button class="btn btn-info fw-bold">Pasang</button>
                    </div>
                </form>

                {{-- Tampilkan Pengumuman Aktif --}}
                @if(isset($activeAnnouncement) && $activeAnnouncement)
                    <div class="alert alert-{{ $activeAnnouncement->type }} d-flex justify-content-between align-items-center mt-3 mb-0 py-2">
                        <small class="text-truncate">{{ $activeAnnouncement->message }}</small>
                        <form action="{{ route('admin.announcement.delete', $activeAnnouncement->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-dark ms-2"><i class="bi bi-x-lg"></i></button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection