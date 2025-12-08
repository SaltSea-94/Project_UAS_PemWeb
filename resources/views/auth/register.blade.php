@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-lg border-0" style="max-width: 400px; width: 100%; background-color: #212529;">
        <div class="card-body">
            <h3 class="text-center mb-4 text-white fw-bold">Daftar Akun</h3>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control bg-dark text-white border-secondary" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Alamat Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-secondary">Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-bold">DAFTAR</button>
                </div>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Masuk</a></small>
            </div>
        </div>
    </div>
</div>
@endsection