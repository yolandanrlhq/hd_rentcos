@extends('layouts.user')

@section('title', 'Beranda - HD RENTCOS')

@section('content')
@include('user.sections.header')

<!-- ================= HERO ================= -->
<section class="hero">
    <div class="hero-text">
        <h4>Cosplay untuk Kamu yang Berani Tampil Beda</h4>
        <h1>Tampil Total <br> Jadi Karakter Favoritmu</h1>
        <p>Sewa kostum cosplay keren, siap bikin kamu jadi pusat perhatian.</p>
        <a href="{{ route('user.produk') }}">
            <button>Lihat Koleksi</button>
        </a>
    </div>
    <div class="hero-img slider">
        <div class="slider-track">
            <img src="{{ asset('assets/anime11.png') }}" class="slide active">
            <img src="{{ asset('assets/anime22.png') }}" class="slide">
            <img src="{{ asset('assets/anime33.png') }}" class="slide">
        </div>
    </div>
</section>

<!-- ================= REKOMENDASI ================= -->
<section class="hero-collection">
    <h2>Rekomendasi Kostum</h2>
    <p>Kostum favorit yang paling sering disewa</p>

    <div class="cards">
        @foreach($rekomendasi as $item)
            <div class="card">
                <a href="{{ route('user.produk.show', $item->id_produk) }}">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}">
                    <h3>{{ $item->nama_produk }}</h3>
                    <p>Rp{{ number_format($item->harga_produk,0,',','.') }}</p>
                </a>
            </div>
        @endforeach
    </div>

    <div class="lihat-semua-container">
        <a href="{{ route('user.produk') }}">
            <button class="lihat-semua-btn">Lihat Semua</button>
        </a>
    </div>
</section>

<!-- ================= TERBARU ================= -->
<section class="latest">
    <h2>Koleksi Terbaru</h2>
    <p>Kostum terbaru kami</p>

    <div class="cards">
        @foreach($latest as $item)
            <div class="card">
                <a href="{{ route('user.produk.show', $item->id_produk) }}">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}">
                    <h3>{{ $item->nama_produk }}</h3>
                    <p>Rp{{ number_format($item->harga_produk,0,',','.') }}</p>
                </a>
            </div>
        @endforeach
    </div>
</section>

<!-- ================= TESTIMONI ================= -->
<section class="testimonials">
    <h2>Pelanggan Puas Kami</h2>
    <div class="reviews">
        @foreach($testimoni as $review)
            <div class="review">
                @if($review->foto)
                    <div class="review-img">
                        <img src="{{ asset('storage/' . $review->foto) }}" alt="Foto Testimoni">
                    </div>
                @endif
                <div class="review-content">
                    <p class="review-text">"{{ $review->isi }}"</p>
                    <div class="review-rating">
                        @for($i=1; $i<=5; $i++)
                            <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@include('user.sections.footer')

<script>
document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.slide');
    let current = 0;

    slides.forEach(slide => {
        slide.classList.remove('active', 'exit');
    });

    slides[0].classList.add('active');

    setInterval(() => {
        const prev = current;
        current = (current + 1) % slides.length;

        slides.forEach(slide => {
            slide.classList.remove('active', 'exit');
        });

        slides[prev].classList.add('exit');
        slides[current].classList.add('active');

    }, 3500);
});
</script>
@endsection
