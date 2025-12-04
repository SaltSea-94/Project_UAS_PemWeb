@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container">
    <section class="mb-5">
        <h2 class="fw-bold border-bottom pb-2 mb-4">Cerita yang Baru Saja Update</h2>
        <div class="row">

            @php
                $books = [
                    [
                        'title' => 'The Unkindled Of The Broken Soil', 
                        'slug' => 'the-unkindled', 
                        'image' => 'https://img.wattpad.com/cover/400713440-256-k379853.jpg',
                        'synopsis' => 'Seorang pemuda bisu tanpa nama berjalan di dunia yang hancur dengan membawa beban masa lalu yang tak pernah diceritakannya.'
                    ],
                    [
                        'title' => 'Broken World', 
                        'slug' => '#', 
                        'image' => 'https://img.wattpad.com/cover/216359821-256-k550028.jpg',
                        'synopsis' => 'Di dunia yang terpecah belah, sebuah jam tua memegang kunci untuk memperbaiki atau menghancurkan waktu itu sendiri.'
                    ],
                    [
                        'title' => 'Asteria', 
                        'slug' => '#', 
                        'image' => 'https://img.wattpad.com/cover/395823563-256-k257621.jpg',
                        'synopsis' => 'Tiga individu dengan kekuatan takdir harus bersatu untuk menghadapi kegelapan yang mengancam galaksi.'
                    ],
                ];
            @endphp

            @foreach ($books as $book)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <a href="/story/{{ $book['slug'] }}">
                        <img src="{{ $book['image'] }}" class="card-img-top" alt="{{ $book['title'] }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/story/{{ $book['slug'] }}" class="text-decoration-none">{{ $book['title'] }}</a>
                        </h5>

                        <p class="card-text text-muted">{{ $book['synopsis'] }}</p>

                        <a href="/story/{{ $book['slug'] }}" class="btn btn-dark mt-auto">Mulai Baca</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection