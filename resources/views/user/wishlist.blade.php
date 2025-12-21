@extends('layouts.user')

@section('title', 'Wishlist - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<section class="hero-collection">
    <h2>Wishlist Anda</h2>

    @if($wishlists->isEmpty())
        <p class="empty-wishlist">Wishlist kamu masih kosong ❤️</p>
    @else
        <div class="cards">
            @foreach($wishlists as $item)
                <div class="card">
                    <a href="{{ route('user.produk.show', $item->produk->id_produk) }}" class="card-link">
                        <img
                            src="{{ asset('storage/' . $item->produk->foto) }}"
                            alt="{{ $item->produk->nama_produk }}"
                        >
                        <h3>{{ $item->produk->nama_produk }}</h3>
                        <p>
                            Rp{{ number_format($item->produk->harga_produk, 0, ',', '.') }}
                        </p>
                    </a>

                    <!-- toggle wishlist (hapus) -->
                    <form
                        action="{{ route('wishlist.toggle') }}"
                        method="POST"
                        class="wishlist-remove-form"
                    >
                        @csrf
                        <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                        <button type="submit" class="remove-btn" title="Hapus dari wishlist">
                            💔
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</section>

@include('user.sections.footer')
@endsection
