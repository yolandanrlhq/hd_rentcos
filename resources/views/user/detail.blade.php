@extends('layouts.user')

@section('title', 'Detail Pesanan - HD RENTCOS')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/status.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="status-page">
    <div class="status-container">
        <h2>Detail Pesanan #{{ $sewa->id }}</h2>

        @foreach($sewa->items as $item)
        <div class="status-card">
            <div class="status-left">
                <img src="{{ $item->produk ? asset('storage/' . $item->produk->foto) : asset('storage/default.jpg') }}" alt="">
                <div>
                    <h3>{{ optional($item->produk)->nama_produk ?? 'Produk tidak tersedia' }}</h3>
                    <p>Ukuran: <strong>{{ $item->ukuran }}</strong></p>
                    <p>Jumlah: <strong>{{ $item->jumlah }}</strong></p>
                    <p>Total: <strong>Rp{{ number_format($item->subtotal,0,',','.') }}</strong></p>
                </div>
            </div>
        </div>
        @endforeach

        <div class="btn-wrapper" style="margin-top: 15px;">
            @if(in_array($sewa->status, ['dikirim', 'diproses']))
            <form action="{{ route('cart.complete', $sewa->id) }}" method="POST">
                @csrf
                <button class="btn-complete">Pesanan Selesai</button>
            </form>
            @endif

            @if(in_array($sewa->status, ['pending','menunggu_konfirmasi','diproses']))
            <form action="{{ route('cart.cancel', $sewa->id) }}" method="POST" style="margin-top: 5px;">
                @csrf
                <button class="btn-cancel">Batalkan Pesanan</button>
            </form>
            @endif
        </div>
    </div>
</main>

@include('user.sections.footer')
@endsection
