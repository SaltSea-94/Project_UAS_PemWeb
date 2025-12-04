@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<div class="col-md-5 col-lg-4 w-100" style="max-width: 400px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Sign In</h3>
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Ingat Saya</label>
            </div>
            <div class="d-grid mt-4">
                <a href="/" class="btn btn-dark">Login</a>
            </div>
        </div>
        <div class="card-footer text-center py-3">
            <small class="text-muted">Belum punya akun? <a href="/register">Sign Up</a></small>
        </div>
    </div>
</div>
@endsection