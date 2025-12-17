@extends('layouts.user')

@section('title', 'Beranda - HD RENTCOS')

@section('content')
@include('user.sections.header')

<!-- ================= HERO ================= -->
<section class="hero">
    <div class="hero-text">
        <h4>Cosplay for the Modern Hero</h4>
        <h1>Level Up Your Style <br> Like Your Favorite Hero</h1>
        <p>Sewa kostum cosplay berkualitas, tampil maksimal di setiap event.</p>
        <a href="{{ route('user.produk') }}">
            <button>Explore Kostum</button>
        </a>
    </div>
    <div class="hero-img">
        <img src="{{ asset('assets/heroImage.png') }}" alt="Hero Image">
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
    <h2>Latest Arrivals</h2>
    <p>Koleksi terbaru kami</p>

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
    <h2>Our Happy Customers</h2>
    <div class="reviews">
        <div class="review">
            <p>"Kostumnya bersih dan detail banget!"</p>
            <span>★★★★★</span>
        </div>
        <div class="review">
            <p>"Pelayanan cepat, recommended buat event."</p>
            <span>★★★★★</span>
        </div>
        <div class="review">
            <p>"Harga masuk akal, kualitas premium."</p>
            <span>★★★★☆</span>
        </div>
    </div>
</section>

@include('user.sections.footer')
@endsection
