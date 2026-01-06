@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-white">Kelola User</h2>
        <form action="{{ route('admin.users') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm bg-dark text-white border-secondary me-2" placeholder="Cari Email / Nama..." value="{{ request('search') }}">
            <button class="btn btn-warning btn-sm fw-bold">Cari</button>
        </form>
    </div>

    <div class="admin-card shadow-sm">
        <div class="table-responsive">
            <table class="table table-dark table-hover admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 40%">User (Foto & Nama)</th>
                        <th style="width: 30%">Email</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        {{-- KOLOM 1: FOTO & NAMA --}}
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" 
                                         class="rounded-circle me-3 border border-secondary" 
                                         style="width: 45px; height: 45px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3 text-white border border-secondary" 
                                         style="width: 45px; height: 45px; font-weight: bold; font-size: 18px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div>
                                    <span class="fw-bold text-white d-block" style="font-size: 1.1rem;">{{ $user->name }}</span>
                                    <small class="text-muted"><i class="bi bi-book me-1"></i> {{ $user->stories_count }} Cerita</small>
                                </div>
                            </div>
                        </td>

                        {{-- KOLOM 2: EMAIL --}}
                        <td class="text-white-50">{{ $user->email }}</td>

                        {{-- KOLOM 3: STATUS --}}
                        <td>
                            @if($user->is_admin)
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Admin</span>
                            @elseif($user->is_banned)
                                <span class="badge bg-danger px-3 py-2 rounded-pill">Banned</span>
                            @else
                                <span class="badge bg-success px-3 py-2 rounded-pill">Aktif</span>
                            @endif
                        </td>

                        {{-- KOLOM 4: TOMBOL AKSI --}}
                        <td>
                            <div class="d-flex gap-2">
                                @if(!$user->is_admin)
                                    {{-- Tombol Ban --}}
                                    <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm {{ $user->is_banned ? 'btn-success' : 'btn-warning' }}" 
                                                title="{{ $user->is_banned ? 'Buka Blokir (Unban)' : 'Blokir User' }}">
                                            
                                            <i class="bi {{ $user->is_banned ? 'bi-check-lg' : 'bi-slash-circle' }}"></i>
                                            
                                            <span class="d-none d-md-inline ms-1">
                                                {{ $user->is_banned ? 'Buka Akses' : 'Ban' }}
                                            </span>
                                        </button>
                                    </form>

                                    {{-- Tombol Pesan --}}
                                    <a href="{{ route('admin.message.create', $user->id) }}" class="btn btn-sm btn-outline-info" title="Kirim Pesan">
                                        <i class="bi bi-envelope"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini permanen?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled><i class="bi bi-shield-lock"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-search display-6 d-block mb-3"></i>
                            Tidak ada user yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-3 border-top border-secondary">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection