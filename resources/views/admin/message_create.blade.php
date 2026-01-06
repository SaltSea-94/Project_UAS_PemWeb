@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="admin-card p-4 shadow-lg border border-secondary">
                
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
                    <h4 class="fw-bold text-white">
                        <i class="bi bi-envelope-plus-fill text-warning me-2"></i> Kirim Pesan Admin
                    </h4>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </div>

                <div class="alert alert-dark d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div class="text-white-50 small">Penerima:</div>
                        <strong class="text-white fs-5">{{ $user->name }}</strong> 
                        <span class="text-muted small">({{ $user->email }})</span>
                    </div>
                </div>

                <form action="{{ route('admin.message.send', $user->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label text-light fw-bold">Judul Pesan / Notifikasi</label>
                        <input type="text" name="subject" class="form-control bg-dark text-white border-secondary p-3" placeholder="Contoh: Peringatan Pelanggaran / Info Penting" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-light fw-bold">Isi Pesan</label>
                        <textarea name="message" class="form-control bg-dark text-white border-secondary p-3" rows="6" placeholder="Tulis pesan lengkap di sini..." required></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning fw-bold py-2 fs-5">
                            <i class="bi bi-send-fill me-2"></i> Kirim Pesan Sekarang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection