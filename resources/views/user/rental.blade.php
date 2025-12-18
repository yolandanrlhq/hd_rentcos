@extends('layouts.user')

@section('title', 'FAQ - HD RENTCOS')

@section('content')
@include('user.sections.header')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/caraRental.css') }}">
@endsection

<main class="container">
        <h1 class="main-title">Apa Saja Syarat Dan Ketentuan Pengiriman Di HD RENTCOS??</h1>

        <div class="grid-row">
            <div class="faq-card">
                <div class="card-header">
                    <span class="pill-accent"></span>
                    <h3>SEBELUM MELAKUKAN RENTAL, HARAP PASTIKAN:</h3>
                </div>
                <ol>
                    <li>Akun penyewa wajib memiliki foto wajah yang jelas (pada postingan atau highlight akun).</li>
                    <li>Kostum disewa untuk pemakaian pribadi, bukan untuk teman, pihak lain, atau disewakan kembali.</li>
                    <li>Siapkan saldo untuk DP sebesar 50% dari ongkos kirim.</li>
                    <li>Pastikan tidak ada rencana untuk mengganti username akun selama masa sewa berlangsung.</li>
                    <li>Siapkan dokumen identitas pribadi (KTP/Kartu Pelajar/KIA/KK).</li>
                </ol>
            </div>

            <div class="faq-card">
                <div class="card-header">
                    <span class="pill-accent"></span>
                    <h3>CARA MELAKUKAN RENTAL</h3>
                </div>
                <ol>
                    <li>Hubungi admin melalui chat dengan format: "Min, kostum (nama kostum) untuk tanggal (...) apakah masih tersedia?"</li>
                    <li>Jika tersedia, ajukan pertanyaan yang diperlukan (detail ukuran, lokasi, dll).</li>
                    <li>Isi formulir pemesanan secara lengkap dan lampirkan dokumen.</li>
                    <li>Lakukan pembayaran DP.</li>
                    <li>Pemesanan dianggap sah (booking) apabila formulir telah diisi dan DP dibayar.</li>
                </ol>
            </div>
        </div>

        <div class="faq-card wide-card">
            <div class="card-header">
                <span class="dot-accent"></span>
                <h3>SYARAT & PERATURAN RENTAL</h3>
            </div>
            <ol>
                <li>Penyewa berusia minimal 14 tahun (kelas 2 SMP ke atas).</li>
                <li>Masa sewa berlaku 3 hari.</li>
                <li>Rental bersama teman diwajibkan masing-masing mengisi formulir.</li>
                <li>Perubahan tanggal sewa maksimal H-7 sebelum event.</li>
                <li>Dilarang memotong atau mencatok wig tanpa izin.</li>
                <li>Wajib melakukan foto dan video unboxing saat kostum diterima.</li>
                <li>Kostum tidak perlu dicuci setelah dipakai.</li>
                <li>Pembatalan mendadak (cancel) akan mengakibatkan DP hangus.</li>
                <li>Dilarang menggunakan kostum untuk aktivitas ekstrem.</li>
                <li>Kostum game hanya dapat dirental oleh penyewa berpengalaman.</li>
                <li>Penyewa pemula (first timer) disarankan menyewa kostum sederhana.</li>
                <li>Rental pada hari kerja (weekdays) diperbolehkan.</li>
            </ol>
        </div>
    </main>

@include('user.sections.footer')
@endsection
