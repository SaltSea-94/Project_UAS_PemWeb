@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<style>
    .profile-banner {
        height: 250px;
        background-image: url('https://media.tenor.com/sfHhORuORUAAAAAe/fin.png');
        background-size: cover;
        background-position: center;
    }
    .profile-picture {
        width: 128px;
        height: 128px;
        border-radius: 50%;
        border: 4px solid white;
        margin-top: -64px;
        background-color: #333;
    }
</style>

<div class="container">
    <div class="profile-banner rounded"></div>
    <div class="d-flex align-items-end px-4">
        <img src="https://pbs.twimg.com/media/FdChU06XwAQrVCJ.jpg" class="profile-picture" alt="Profile Picture">
        <div class="ms-3 mb-2">
            <h3 class="fw-bold mb-0">SaltSea</h3>
            <p class="text-muted">@SaltSea94</p>
        </div>
    </div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="perihal" role="tabpanel">
            <div class="row mt-4">
                <div class="col-md-4">
                    <p class="fw-bold">A man who enjoying his tragedy life</p>
                    <p class="text-muted small">Bergabung: Maret 21, 2020</p>
                </div>
                <div class="col-md-8">
                    <h5>Cerita disimpan oleh SaltSea</h5>
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <a href="/story/the-unkindled">
                                    <img src="https://img.wattpad.com/cover/400713440-256-k379853.jpg" class="img-fluid rounded-start" alt="Story Cover">
                                </a>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/story/the-unkindled" class="text-decoration-none">
                                            The Unkindled of The Broken Soil
                                        </a>
                                    </h5>
                                    <p class="card-text">Tak semua yang berjalan memiliki tujuan. Tak semua yang diam itu hampa. Dan tak semua kisah tentang dunia... harus berakhir dengan penyelamatan atau kehancuran.</p>
                                    <p class="card-text"><small class="text-muted">1 Cerita Tersimpan</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="percakapan" role="tabpanel">
            </div>
    </div>
</div>
@endsection