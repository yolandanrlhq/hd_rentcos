@extends('layouts.user')

@section('title', 'Status Penyewaan - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/status.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="status-page">
    <div class="status-container">
        <h2><i class="fas fa-truck"></i> Status Penyewaan</h2>

        <div class="status-tabs">
            <a href="{{ route('cart.status', ['status' => 'semua']) }}" class="{{ ($filter == 'semua' || !$filter) ? 'active' : '' }}">Semua</a>
            <a href="{{ route('cart.status', ['status' => 'menunggu_konfirmasi']) }}" class="{{ $filter == 'menunggu_konfirmasi' ? 'active' : '' }}">Diproses</a>
            <a href="{{ route('cart.status', ['status' => 'dikirim']) }}" class="{{ $filter == 'dikirim' ? 'active' : '' }}">Dikirim</a>
            <a href="{{ route('cart.status', ['status' => 'selesai']) }}" class="{{ $filter == 'selesai' ? 'active' : '' }}">Selesai</a>
            <a href="{{ route('cart.status', ['status' => 'dibatalkan']) }}" class="{{ $filter == 'dibatalkan' ? 'active' : '' }}">Dibatalkan</a>
        </div>

        {{-- Filter: tampilkan hanya yang masih memiliki produk --}}
        @php
            $validCarts = $carts->filter(fn($c) => $c->produk != null);
        @endphp

        @forelse ($validCarts as $item)
        <div class="status-card">
            <div class="status-left">
                <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="">

                <div>
                    <h3>{{ $item->produk->nama_produk }}</h3>
                    <p>Ukuran: <strong>{{ $item->ukuran }}</strong></p>
                    <p>Tanggal Sewa: <strong>{{ $item->tanggal_sewa }}</strong></p>
                    <p>Total: <strong>Rp{{ number_format($item->total,0,',','.') }}</strong></p>
                </div>
            </div>

            <div class="status-right">
                <span class="badge badge-{{ strtolower($item->status) }}">
                    {{ $item->status }}
                </span>

                <div class="btn-wrapper">
                    <a href="{{ route('cart.detail', $item->id) }}" class="btn-detail">Detail</a>

                    @if(strtolower($item->status) === 'dikirim')
                        <form action="{{ route('cart.complete', $item->id) }}" method="POST">
                            @csrf
                            <button class="btn-complete">
                                Barang Diterima
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
            <p class="no-data">Belum ada riwayat penyewaan.</p>
        @endforelse

    </div>
</main>

@include('user.sections.footer')
@endsection
