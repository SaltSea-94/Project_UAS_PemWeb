@extends('layouts.app')

@section('title', 'The Unkindled Of The Broken Soil')

@section('content')
<style>
    .story-cover-main {
        width: 250px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .author-profile-pic {
        width: 80px;
        height: 80px;
    }
    .chapter-list .list-group-item {
        border-left: none;
        border-right: none;
    }
    .chapter-list .dot {
        height: 10px;
        width: 10px;
        background-color: #198754;
        border-radius: 50%;
        display: inline-block;
        margin-right: 10px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="text-center">
                <img src="https://img.wattpad.com/cover/400713440-256-k379853.jpg" class="story-cover-main mb-4" alt="Story Cover">
                <h1 class="fw-bold">The Unkindled Of The Broken Soil</h1>
                <div class="d-flex justify-content-center my-3 text-muted">
                    <span><i class="bi bi-eye-fill"></i> 1,3K Pembaca</span>
                    <span class="mx-3">|</span>
                    <span><i class="bi bi-star-fill"></i> 876 Suara</span>
                    <span class="mx-3">|</span>
                    <span><i class="bi bi-list-ul"></i> 6 Bagian</span>
                </div>
            </div>
            <div class="mt-4">
                <p>Tak semua yang berjalan memiliki tujuan.</p>
                <p>Tak semua yang diam itu hampa.</p>
                <p>Dan tak semua kisah tentang dunia... harus berakhir dengan penyelamatan atau kehancuran.</p>
                <p>Kehancuran itu bukanlah akibat perang terakhir, melainkan pengkhianatan yang tak pernah diratapi.</p>
                <p>Langit telah lama berhenti berbicara. Dan dunia mulai membusuk dari dalam.</p>
                <p>Di antara reruntuhan, berjalanlah seorang pria yang tak pernah bersuara, yaitu Sora, Sang Tak Bernyawa. Ia tak membawa takdir, juga tak membawa janji. Ia hanya berjalan. Bisu sejak lahir, namun dalam kebisuannya tersimpan luka sejarah yang tak seorang pun dapat ungkapkan. Sora tak pernah berniat menyelamatkan dunia, juga tak ingin menghancurkannya. Ia hanya ingin tahu... apakah dunia yang telah membuangnya, masih layak untuk dipahami?</p>
                <p>Dalam perjalanannya, Sora bertemu tiga jiwa lain yang sama rapuhnya, seperti;</p>
                <p>Kaelith, seorang pemanah pemberani yang menyembunyikan cinta dalam kesunyian yang sunyi.</p>
                <p>Vael, seorang ksatria sisa dari kerajaan yang runtuh, masih terikat oleh sumpah yang tak tertebus.</p>
                <p>Namien, seorang penyihir flamboyan yang menyembunyikan kejenuhannya akan dunia dalam ejekan dan lelucon tajamnya, telah memilih untuk menjadi pedagang pengembara.</p>
                <p>Bersama-sama, mereka menapaki tanah yang retak, menghadapi kutukan kuno, pasukan tak bernyawa, dan pertanyaan-pertanyaan yang tak akan pernah mereka temukan jawabannya. Mereka tak tahu apakah mereka sedang bergerak menuju keselamatan... atau hanya memperpanjang kejatuhan mereka.</p>
                <p>Namun seiring berjalannya waktu, mereka belajar bahwa yang menghubungkan mereka bukanlah harapan, melainkan keberanian untuk berjalan dalam keheningan. Bahwa mungkin dunia tidak membutuhkan seorang penyelamat, melainkan seseorang yang cukup hancur untuk mendengarkan... dan cukup jujur untuk tidak menjanjikan apa pun.</p>
                <p class="text-muted small mt-3">&copy; Seluruh Hak Cipta Dilindungi Undang-Undang</p>

                <div class="mt-4 genre-tags">
                    @php
                        $tags = ['Action', 'Adventure', 'Anti-Hero', 'Post-Apocalyptic', 'Grimdark', 'Fantasy', 'Mystery', 'Psychological', 'Romance', 'Supranatural', 'Survival', 'Tragedy', 'Thriller'];
                    @endphp
        
                    @foreach ($tags as $tag)
                        <a class="text-decoration-none me-3">{{ $tag }}</a>
                    @endforeach
                </div>
            </div>

            <hr class="my-5">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Daftar Isi</h4>
                </div>
                @php
                    $chapters = [
                        ['title' => 'Prolog: Di Masa Sebelum Keheningan', 'date' => 'Kamis, Agt 28, 2020', 'completed' => true, 'slug' => 'prolog'],
                        ['title' => 'Bab Satu: Bara Api di Bawah Langit yang Terlupakan', 'date' => 'Kamis, Agt 28, 2020', 'completed' => true, 'slug' => 'bab-satu'],
                        ['title' => 'Bab Dua: Pedang Tanpa Nama', 'date' => 'Kamis, Agt 28, 2020', 'completed' => true, 'slug' => 'bab-dua'],
                        ['title' => 'Bab Tiga: Abu di Bawah Tulang-Tulang Boreal', 'date' => 'Kamis, Okt 2, 2020', 'completed' => true, 'slug' => 'bab-tiga'],
                        ['title' => 'Bab Empat: Mahkota Mayat Hidup', 'date' => 'Kamis, Okt 2, 2020', 'completed' => true, 'slug' => 'bab-empat'],
                        ['title' => 'Bab Lima: Di Balik Selubung Api', 'date' => 'Kamis, Okt 2, 2020', 'completed' => true, 'slug' => 'bab-lima'],
                    ];
                    $lastReadSlug = request()->cookie('lastRead_the-unkindled');
                @endphp
                <ul class="list-group list-group-flush chapter-list">
                    @foreach ($chapters as $chapter)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a href="/story/the-unkindled/{{ $chapter['slug'] }}" class="text-decoration-none text-dark">{{ $chapter['title'] }}</a>
                            
                            @if ($chapter['slug'] === $lastReadSlug)
                                <span class="text-success small ms-2">(100%)</span>
                            @endif
                        </div>
                        <span class="text-muted small">{{ $chapter['date'] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-lg-4 mt-5 mt-lg-0">
            <div class="card">
                <div class="card-body d-flex flex-column align-items-center text-center">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRELQj5hriIcoFRsLNxwe4n18NzeYwaDCLrRA&s" class="rounded-circle author-profile-pic" alt="Author">
                    <a href="#" class="text-decoration-none fw-bold mt-2">MauMandi</a>
                    <small class="text-muted">Penulis</small>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookId = 'the-unkindled';
        const lastReadSlug = localStorage.getItem('lastRead_' + bookId);

        if (lastReadSlug) {
            const lastReadLink = document.querySelector(`.chapter-list a[data-slug='${lastReadSlug}']`);

            if (lastReadLink) {
                const greenDot = document.createElement('span');
                greenDot.className = 'dot';
                lastReadLink.parentNode.insertBefore(greenDot, lastReadLink);
            }
        }
    });
</script>
@endpush