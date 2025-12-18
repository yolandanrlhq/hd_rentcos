@extends('layouts.user')

@section('title', 'FAQ - HD RENTCOS')

@section('content')
@include('user.sections.header')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/persyaratan.css') }}">
@endsection

  <main class="content-section">
        <div class="container">
            <h1 class="main-title">Apa Saja Syarat Dan Ketentuan Pengiriman Di HD RENTCOS??</h1>

            <div class="card-container">
                
                <div class="card card-indramayu">
                    <div class="card-header">
                        <span class="dot dot-green"></span>
                        <h2 class="card-title">Ketentuan Khusus Area Indramayu</h2>
                    </div>
                    <ul class="list">
                        <li>
                            <p>COD hanya jika admin dan perental berada di event yang sama.</p>
                        </li>
                        <li>
                            <p>Kostum bisa diambil di rumah admin atau diantar maksimal $5$ km.</p>
                        </li>
                        <li>
                            <p>Pengiriman lebih dari $5$ km harus minimal $3$ perental daerah.</p>
                        </li>
                        <li>
                            <p>**Ekspedisi:**</p>
                            <ul>
                                <li>Pengiriman H-3 sebelum pemakaian.</li>
                                <li>Pengembalian H+1 setelah pemakaian (hari ketiga & sewa).</li>
                            </ul>
                        </li>
                        <li>
                            <p>Jika kostum diantar ke rumah, pengembalian harus ke admin atau via ekspedisi (tidak bisa dijemput, kecuali kondisi tertentu).</p>
                        </li>
                    </ul>
                </div>

                <div class="card card-luar-indramayu">
                    <div class="card-header">
                        <span class="dot dot-green"></span>
                        <h2 class="card-title">Ketentuan Luar Indramayu</h2>
                    </div>
                    <ul class="list">
                        <li>
                            <p>Melayani customer Pulau Jawa.</p>
                        </li>
                        <li>
                            <p>Customer luar Jawa wajib deposit + syarat tambahan (detail via DM).</p>
                        </li>
                        <li>
                            <p>Booking maksimal H-7 untuk menghindari keterlambatan pengiriman.</p>
                        </li>
                        <li>
                            <p>**Shopee:**</p>
                            <ul>
                                <li>Full Shopee dikenakan $15\%$.</li>
                                <li>Payment bisa direct, Shopee hanya untuk pengiriman.</li>
                                <li>Wajib video unboxing.</li>
                                <li>Kesalahan ekspedisi ditanggung customer sepenuhnya (tanpa asuransi Shopee).</li>
                            </ul>
                        </li>
                        <li>
                            <p>Pengembalian via direct wajib menggunakan asuransi.</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card card-ekspedisi-list">
                <div class="card-header">
                    <span class="dot dot-green"></span>
                    <h2 class="card-title">Ekspedisi yang Digunakan</h2>
                </div>
                <ul class="list list-column">
                    <li><p>1. J&T Express</p></li>
                    <li><p>2. JNE Express</p></li>
                    <li><p>3. SiCepat Ekspres</p></li>
                    <li><p>4. J&T Cargo</p></li>
                    <li><p>5. SPX Express</p></li>
                </ul>
            </div>
        </div>
    </main>
    
    

@include('user.sections.footer')
@endsection
