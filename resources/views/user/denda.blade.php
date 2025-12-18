@extends('layouts.user')

@section('title', 'FAQ - HD RENTCOS')

@section('content')
@include('user.sections.header')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/denda.css') }}">
@endsection

<main class="faq-main-content">
        <div class="container">
            <h1 class="faq-title">Apa Saja Ketentuan Denda Jika Terjadi Keterlambatan Atau Kerusakan?</h1>

            <section class="penalty-section">
                <div class="penalty-header">
                    <div class="line"></div>
                    <h2>KETENTUAN DENDA</h2>
                </div>
                
                <ol class="penalty-list">
                    <li>Wig kusut dikenakan denda sebesar **Rp10.000 – Rp35.000**.</li>
                    <li>Apabila wig rusak akibat hard styling, wajib diganti dengan yang baru.</li>
                    <li>Aksesoris rusak dikenakan denda **Rp30.000** atau wajib ganti baru.</li>
                    <li>Penggunaan kostum baru yang tidak sesuai toleransi dikenakan denda **Rp20.000**.</li>
                    <li>Keterlambatan pengembalian kostum dikenakan denda **Rp25.000** per hari.</li>
                    <li>Noda membandel pada kostum atau wig dikenakan denda **Rp20.000** atau wajib ganti baru.</li>
                    <li>Kerusakan kostum seperti robek (tertarik, jahitan brudul) atau bolong (terkena rokok, tusukan, dan sejenisnya) dikenakan denda **Rp30.000** atau wajib ganti baru.</li>
                    <li>Kehilangan plastik kostum dikenakan denda **Rp10.000**.</li>
                    <li>Kehilangan plastik wig dikenakan denda **Rp5.000**.</li>
                    <li>Ketahuan digunakan oleh pihak selain pemilik data penyewa dikenakan denda sebesar **1x harga sewa**.</li>
                </ol>
            </section>
        </div>
    </main>

@include('user.sections.footer')
@endsection
