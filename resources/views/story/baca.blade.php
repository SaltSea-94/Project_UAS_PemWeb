@extends('layouts.app')

@section('title', 'Prolog - The Unkindled')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <h2 class="text-center mb-4">Prolog: Di Masa Sebelum Keheningan</h2>
            <hr class="my-4">

            @php
                $naskahLengkap = "Di zaman dahulu, zaman sebelum sungai berubah menjadi debu dan kehidupan setiap makhluk terjaga.

                Di zaman sebelum bintang-bintang di langit jatuh untuk terakhir kalinya dan menara-menara tua yang agung menjadi reruntuhan hingga hancur.

                Terdapat harapan yang terjalin dalam nafas dunia.

                Bukan sebuah harapan yang keras.
                Bukan sebuah harapan yang dinyanyikan oleh penyanyi keliling atau terukir di sebuah Prasasti.

                Tetapi hanya harapan yang tenang.
                Harapan yang bertahan karena tak terlihat.

                Dan di antara keheningan itu, berjalanlah seseorang yang tidak lahir dari ramalan atau diciptakan dengan kekuatan khusus dari para dewa.

                Dia tidak membawa sebuah legenda yang tidak memiliki darah dewa di nadinya.

                Namun, ketika tabir antara apa yang ada dan apa yang seharusnya tidak pernah ada telah terbelah.

                Dia berdiri di tempat para orang-orang yang sedang berlutut pasrah tunduk kepada kekuatan absolut.

                Bukan sebagai pejuang.
                Bukan sebagai orang yang suci.
                Tetapi sebagai seorang saksi.

                Untuk sebuah rasa sakit.
                Untuk sebuah perubahan.
                Dan untuk sebuah kebenaran.

                Dia berjalan bukan untuk memimpin pasukan atau mengklaim mahkota, tetapi untuk mengingat apa yang dilupakan dunia bahwa menjadi manusia bukanlah takdir yang ditulis oleh takdir itu sendiri, tetapi pilihan yang dibuat dalam bayangan yang paling tergelap dari diri mereka sendiri.

                Awalnya, Dia tidak disebut apa-apa dan hanya jiwa lain yang terbebani oleh waktu.

                Namun, saat kerajaan-kerajaan mulai hancur, saat binatang-binatang bergerak di bumi yang terdalam, dan saat kebohongan dimahkotai dan kebenaran dibuang ke pengasingan.

                Namanya kembali muncul.

                Berbisik dalam hembusan angin.
                Diucapkan oleh pohon-pohon yang hampir mati.
                Dan, terukir dalam cahaya api unggun yang menyinari dalam dinding-dinding gua sebagai mural.

                Hanya menjadi seorang Saksi.

                Bukan sebagai penyelamat.
                Bukan pula sebagai hakim.

                Tetapi orang yang melihat bentuk dari apa yang mungkin akan datang nantinya dan memilih untuk tetap melangkah maju tanpa melihat ke arah belakangnya.

                Dan dengan demikianlah cerita tentang seseorang yang berjalan di dunia yang sudah hancur itu, telah dimulai.

                Dia berjalan tidak dengan sebuah misi penaklukan.
                Dia berjalan tidak dengan sebuah misi kemuliaan.
                Namun dengan kenangan dan jiwa yang cukup kuat untuk menanggung perjalanannya di dunia yang sudah rusak itu.";

                $paragraf = preg_split('/(\r\n|\n|\r){2,}/', $naskahLengkap);
                $naskahTerformat = '';
                foreach ($paragraf as $p) {
                    if (!empty(trim($p))) {
                        $naskahTerformat .= "<p>" . trim(nl2br($p)) . "</p>";
                    }
                }
            @endphp
            <div style="font-size: 1.1rem; line-height: 1.8;">
                {!! $naskahTerformat !!}
            </div>

            <hr class="my-5">

            <div class="d-flex justify-content-center gap-3">
                <a href="/story/the-unkindled" class="btn btn-lg btn-contrast">Kembali ke Halaman Novel</a>
                <a href="/story/the-unkindled/bab-satu" class="btn btn-lg btn-contrast">Lanjut ke bab berikutnya</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.cookie = "lastRead_the-unkindled=bab-prolog; path=/; max-age=31536000; SameSite=Lax";
</script>
@endpush