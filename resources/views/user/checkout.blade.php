@extends('layouts.user')

@section('title', 'Checkout - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="checkout-container">
  <h2>Checkout</h2>

  <!-- Alamat Pengiriman -->
  <section class="alamat-box">
    <div class="alamat-header">
      <i class="ri-map-pin-user-fill"></i>
      <span>Alamat Pengiriman</span>
    </div>
    <div class="alamat-info">
      <div class="nama">
        <strong>{{ auth()->user()->name }}</strong>
        <span>{{ auth()->user()->phone ?? '' }}</span>
      </div>
      <div class="alamat">
        {!! nl2br(e(auth()->user()->address ?? '')) !!}
      </div>
      <a href="{{ route('user.profile') }}" class="ubah">Ubah</a>
    </div>
  </section>

  <!-- Produk -->
  <section class="produk-box">
    <table>
      <thead>
        <tr>
          <th>Kostum disewa</th>
          <th>Harga</th>
          <th>Satuan</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach(($items ?? collect()) as $item)
        <tr data-item-id="{{ $item->id }}">
          <td class="produk-info">
            <img src="{{ asset('storage/' . ($item->produk->foto ?? '')) }}" alt="{{ $item->produk->nama_produk }}">
            <span>{{ $item->produk->nama_produk }} @if($item->ukuran) ({{ $item->ukuran }}) @endif</span>
          </td>
          <td>Rp{{ number_format($item->harga_satuan,0,',','.') }}</td>
          <td>{{ $item->jumlah }}</td>
          <td class="row-total" id="total-{{ $item->id }}">Rp{{ number_format($item->harga_satuan * $item->jumlah,0,',','.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </section>

  <!-- Metode Pengiriman -->
  <section class="pembayaran-box">
    <h3>Metode Pengiriman</h3>

    <form id="checkout-form" method="POST" action="{{ route('cart.sewa') }}">
      @csrf

      <div class="payment-methods">
        <button type="button" data-method="cod" class="active">COD</button>
        <button type="button" data-method="ambil_ditempat">Ambil ditempat</button>
        <button type="button" data-method="antar_ke_rumah">
          Antar ke rumah
          <a href="{{ url('/faq') }}" target="_blank" style="font-size: 0.8em;">(FAQ)</a>
        </button>
        <button type="button" data-method="via_ekspedisi">Via ekspedisi</button>
      </div>

      <input type="hidden" name="delivery_method" id="delivery_method" value="cod">

      @php
        $subtotal = ($items ?? collect())->sum(fn($i) => $i->harga_satuan * $i->jumlah);
      @endphp

      <div class="payment-summary">
        <div><span>Subtotal</span><span id="subtotal">Rp{{ number_format($subtotal) }}</span></div>
        <hr>
        <div class="total"><span>Total Pembayaran</span><span class="red" id="total-bayar">Rp{{ number_format($subtotal) }}</span></div>
      </div>

      <div class="checkout-btn-container">
          @foreach(request()->query('selected', []) as $id)
              <input type="hidden" name="selected[]" value="{{ $id }}">
          @endforeach
        <button type="submit" class="checkout-btn">Sewa Sekarang</button>
      </div>
    </form>
  </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('.payment-methods button');
  const hiddenInput = document.getElementById('delivery_method');

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      buttons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      hiddenInput.value = btn.dataset.method;
    });
  });
});
</script>
@endsection
