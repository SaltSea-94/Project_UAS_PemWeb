@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-lg border-0" style="max-width: 400px; width: 100%; background-color: #212529;">
        <div class="card-body">
            <h3 class="text-center mb-4 text-white fw-bold">Masuk</h3>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary">Alamat Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary" placeholder="name@example.com" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-secondary">Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="******" required>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-warning fw-bold">MASUK</button>
                </div>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-warning text-decoration-none">Daftar sekarang</a></small>
            </div>
        </div>
    </div>
</div>
@endsection