@extends('layouts.user')

@section('title', 'Keranjang - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/') }}">
@endsection

@section('content')
    @include('user.sections.header')
    <main class="sewa-container">
        <h2>Checkout Berhasil</h2>
        <p>Terima kasih telah melakukan checkout. Berikut adalah rincian barang yang Anda sewa:</p>

        @if(isset($items) && $items->count())
        <table class="sewa-items">
            <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->produk->nama_produk ?? 'Produk' }}</td>
                <td>{{ $item->ukuran ?? '-' }}</td>
                <td>{{ $item->jumlah }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @else
        <p>Tidak ada barang yang disewa.</p>
        @endif

        @php
            // WhatsApp API link builder with a sample message (phone number should be replaced with seller's)
            $phoneNumber = '628123456789'; // Replace with seller's phone number with country code, no '+' or leading zeros
            $message = urlencode("Halo, saya telah melakukan checkout barang sewa dan ingin melanjutkan transaksi pembayaran. Mohon informasinya.");
            $whatsappUrl = "https://wa.me/{$phoneNumber}?text={$message}";
        @endphp

        <div class="whatsapp-contact">
            <a href="{{ $whatsappUrl }}" target="_blank" class="whatsapp-button">Lanjutkan Transaksi via WhatsApp</a>
        </div>
    </main>

        <style>
        .sewa-container {
            max-width: 800px;
            margin: auto;
            padding: 1rem;
            font-family: Arial, sans-serif;
        }
        .sewa-items {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        .sewa-items th, .sewa-items td {
            border: 1px solid #ddd;
            padding: 0.5rem;
            text-align: left;
        }
        .whatsapp-contact {
            margin-top: 2rem;
            text-align: center;
        }
        .whatsapp-button {
            display: inline-block;
            background-color: #25D366;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.1rem;
        }
        .whatsapp-button:hover {
            background-color: #1ebe57;
        }
        </style>
    @include('user.sections.footer')
@endsection
