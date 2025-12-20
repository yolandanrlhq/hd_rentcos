@extends('layouts.user')

@section('title', 'Produk - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/produkUser.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="products-section">
    <div class="container">
        <h2 class="section-title">Produk Kami</h2>
        {{-- FILTER KATEGORI --}}
        <div class="filter-buttons">
            <a href="{{ route('user.produk') }}"
            class="filter-btn {{ request('kategori') == null ? 'active' : '' }}">
                Semua
            </a>

            <a href="{{ route('user.produk', ['kategori' => 1]) }}"
            class="filter-btn {{ request('kategori') == 1 ? 'active' : '' }}">
                Kostum Anime
            </a>

            <a href="{{ route('user.produk', ['kategori' => 2]) }}"
            class="filter-btn {{ request('kategori') == 2 ? 'active' : '' }}">
                Kostum Game
            </a>
        </div>

        {{-- FORM SEARCH (TIDAK MERUBAH TAMPILAN) --}}
        <form method="GET" action="{{ route('user.produk') }}">
            {{-- input search ada di header, ini hanya penampung GET --}}
        </form>

        <div class="products-grid">
            @forelse ($produks as $produk)
                @php
                    $avg   = round($produk->testimonis_avg_rating ?? 0, 1);
                    $total = $produk->testimonis_count ?? 0;

                    $full = floor($avg);
                    $half = ($avg - $full) >= 0.5;
                @endphp

                <a href="{{ route('user.produk.show', $produk->id_produk) }}">
                    <article class="product-card">
                        <div class="img-wrap">
                            <img
                                src="{{ asset('storage/' . $produk->foto) }}"
                                alt="{{ $produk->nama_produk }}"
                            >
                        </div>

                        <div class="card-body">
                            <h3 class="product-title">{{ $produk->nama_produk }}</h3>

                            <!-- ===== RATING ===== -->
                            <div class="rating">
                                <div class="stars" aria-hidden="true">
                                    @for($i = 0; $i < $full; $i++)
                                        ★
                                    @endfor

                                    @if($half)
                                        ☆
                                    @endif

                                    @for($i = $full + ($half ? 1 : 0); $i < 5; $i++)
                                        ☆
                                    @endfor
                                </div>

                                <span class="rating-score">
                                    {{ $avg }}/5
                                    <small>({{ $total }})</small>
                                </span>
                            </div>

                            <!-- ===== HARGA ===== -->
                            <div class="price-row">
                                <div class="price">
                                    Rp{{ number_format($produk->harga_produk, 0, ',', '.') }}
                                </div>
                                <div class="duration">/ 3 hari</div>
                            </div>
                        </div>
                    </article>
                </a>
            @empty
                <p>Tidak ada produk ditemukan.</p>
            @endforelse
        </div>
    </div>
</main>

@include('user.sections.footer')
@endsection
