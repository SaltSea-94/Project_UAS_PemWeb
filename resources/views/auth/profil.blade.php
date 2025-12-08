@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-5">
                    
                    <div class="mb-4 position-relative d-inline-block">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle" width="150" height="150" style="object-fit: cover; border: 5px solid var(--bg-color);">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=150" class="rounded-circle">
                        @endif
                    </div>

                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-4">{{ $user->email }}</p>

                    <hr>

                    <h5 class="text-start mb-3">Edit Data Diri</h5>
                    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="text-start">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Ganti Foto Profil</label>
                            <input type="file" name="photo" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="if(confirm('Yakin ingin menghapus akun?')){ document.getElementById('delete-account-form').submit(); }">
                                Hapus Akun
                            </button>

                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>

                    <form id="delete-account-form" action="{{ route('profil.destroy') }}" method="POST" class="d-none">
                        @csrf @method('DELETE')
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection