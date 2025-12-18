@extends('layouts.user')

@section('title', 'FAQ - HD RENTCOS')

@section('content')
@include('user.sections.header')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/refund.css') }}">
@endsection

 <main class="container">
        <h1 class="main-title">Bagaimana Kebijakan Refund Jika Terjadi Pembatalan Ketidaksesuaian Layanan ?</h1>

        <div class="refund-box">
            <div class="refund-content">
                <div class="refund-title-container">
                    <span class="title-line"></span>
                    <h2 class="section-title">KETENTUAN REFUND</h2>
                </div>
                
                <p>Refund diberikan apabila:</p>
                <ul>
                    <li>Terjadi kesalahan pendataan oleh admin yang menyebabkan bentrok jadwal sewa.</li>
                    <li>Terjadi keterlambatan pengiriman oleh admin ke pihak ekspedisi.</li>
                </ul>

                <p>Refund tidak diberikan apabila:</p>
                <ul>
                    <li>Ukuran kostum tidak sesuai (terlalu besar atau terlalu kecil).</li>
                    <li>Mohon pastikan ukuran dengan bertanya terlebih dahulu sebelum mengisi form pemesanan.</li>
                    <li>Terjadi keterlambatan pengiriman yang disebabkan oleh pihak ekspedisi.</li>
                </ul>
            </div>
        </div>
    </main>

@include('user.sections.footer')
@endsection
