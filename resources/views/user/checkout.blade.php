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
        <form id="checkout-form" method="POST" action="{{ route('cart.sewa') }}">
            @csrf

            <!-- Tanggal Sewa -->
            <section class="tanggal-sewa-box">
                <div class="tanggal-input">
                    <h3>📅 Jadwal Sewa</h3>
                    <small class="hint">
                    Pilih tanggal mulai penyewaan kostum
                    </small>

                    <label for="tanggal_sewa">Mulai Sewa</label>
                    <input
                        type="date"
                        name="tanggal_sewa"
                        id="tanggal_sewa"
                        required
                        min="{{ now()->toDateString() }}"
                    >

                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input
                        type="date"
                        name="tanggal_kembali"
                        id="tanggal_kembali"
                        required
                        readonly
                    >
                </div>
            </section>

            <!-- Metode Pengiriman -->
            <h3>Metode Pengiriman</h3>

            <div class="payment-methods">
            <button type="button" data-method="cod" class="active">COD</button>
            <button type="button" data-method="ambil_ditempat">Ambil ditempat</button>
            <button type="button" data-method="antar_ke_rumah">Antar ke rumah</button>
            <button type="button" data-method="via_ekspedisi">Via ekspedisi</button>
            </div>

            <input type="hidden" name="delivery_method" id="delivery_method" value="cod">

            <!-- Ringkasan -->
            <div class="payment-summary">
            <div>
                <span>Subtotal</span>
                <span id="subtotal">Rp{{ number_format($subtotal) }}</span>
            </div>
            <hr>
            <div class="total">
                <span>Total Pembayaran</span>
                <span class="red" id="total-bayar">Rp{{ number_format($subtotal) }}</span>
            </div>
            </div>

            <!-- Hidden Selected -->
            @foreach(request()->query('selected', []) as $id)
            <input type="hidden" name="selected[]" value="{{ $id }}">
            @endforeach

            <button type="submit" class="checkout-btn">Sewa Sekarang</button>
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

document.addEventListener('DOMContentLoaded', () => {
    const tanggalSewa = document.getElementById('tanggal_sewa');
    const tanggalKembali = document.getElementById('tanggal_kembali');

    tanggalSewa.addEventListener('change', () => {
        if(tanggalSewa.value){
            const sewaDate = new Date(tanggalSewa.value);
            const kembaliDate = new Date(sewaDate);
            kembaliDate.setDate(sewaDate.getDate() + 1); // +1 hari
            const yyyy = kembaliDate.getFullYear();
            const mm = String(kembaliDate.getMonth() + 1).padStart(2, '0');
            const dd = String(kembaliDate.getDate()).padStart(2, '0');
            tanggalKembali.value = `${yyyy}-${mm}-${dd}`;
        } else {
            tanggalKembali.value = '';
        }
    });
});
</script>
@endsection
