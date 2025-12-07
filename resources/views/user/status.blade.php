@extends('layouts.user')

@section('title', 'Status Penyewaan - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/status.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="status-page">
    {{-- <pre>
        {{ dd($sewas->toArray()) }}
    </pre> --}}
    <div class="status-container">
        <h2><i class="fas fa-truck"></i> Status Penyewaan</h2>

        <div class="status-tabs">
            <a href="{{ route('cart.status', ['status' => 'semua']) }}" class="{{ ($filter == 'semua' || !$filter) ? 'active' : '' }}">Semua</a>
            <a href="{{ route('cart.status', ['status' => 'menunggu_konfirmasi']) }}" class="{{ $filter == 'menunggu_konfirmasi' ? 'active' : '' }}">Diproses</a>
            <a href="{{ route('cart.status', ['status' => 'dikirim']) }}" class="{{ $filter == 'dikirim' ? 'active' : '' }}">Dikirim</a>
            <a href="{{ route('cart.status', ['status' => 'selesai']) }}" class="{{ $filter == 'selesai' ? 'active' : '' }}">Selesai</a>
            <a href="{{ route('cart.status', ['status' => 'dibatalkan']) }}" class="{{ $filter == 'dibatalkan' ? 'active' : '' }}">Dibatalkan</a>
        </div>

        @forelse ($sewas as $sewa)
            @foreach($sewa->items as $item)
            <div class="status-card">
                <div class="status-left">
                    <img src="{{ $item->produk ? asset('storage/' . $item->produk->foto) : asset('storage/default.jpg') }}" alt="">
                    <div>
                        <h3>{{ optional($item->produk)->nama_produk ?? 'Produk tidak tersedia' }}</h3>
                        <p>Ukuran: <strong>{{ $item->ukuran }}</strong></p>
                        <p>Jumlah: <strong>{{ $item->jumlah }}</strong></p>
                        <p>Tanggal Sewa: <strong>{{ $sewa->tanggal_sewa }}</strong></p>
                        <p>Total: <strong>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</strong></p>
                    </div>
                </div>

                <div class="status-right">
                    <span class="badge badge-{{ strtolower($sewa->status) }}">
                        {{ ucfirst($sewa->status) }}
                    </span>

                    <div class="btn-wrapper">
                        <a href="{{ route('cart.detail', $sewa->id) }}" class="btn-detail">Detail</a>

                        @if(strtolower($sewa->status) === 'dikirim')
                            <form action="{{ route('cart.complete', $sewa->id) }}" method="POST">
                                @csrf
                                <button class="btn-complete">Barang Diterima</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @empty
            <p class="no-data">Belum ada riwayat penyewaan.</p>
        @endforelse

    </div>
</main>

@include('user.sections.footer')
@endsection
