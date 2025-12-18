@extends('layouts.user')

@section('title', 'FAQ - HD RENTCOS')

@section('content')
@include('user.sections.header')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/pengembalian1.css') }}">
@endsection

 <main class="container">
        <h1 class="main-title">Apa Itu Uang Deposit Dan Apa Saja Ketentuan Pengembaliannya ?</h1>

        <div class="refund-box">
            <div class="refund-content">
                <div class="refund-title-container">
                    <span class="title-line"></span>
                    <h2 class="section-title">UANG DEPOSIT & DEPOSITO</h2>
                </div>
                
                <div class="content-section">
                    <p><strong>Uang Deposit (Uang Jaminan)</strong></p>
                    <p>Uang deposit adalah uang jaminan yang wajib dibayarkan oleh penyewa, khususnya bagi penyewa yang belum pernah merental karakter tertentu.</p>
                    <p>Uang deposit akan ditahan hingga masa sewa berakhir.</p>
                    <p>Apabila saat pengembalian kostum terdapat kerusakan, maka biaya denda akan dipotong dari uang deposit.</p>
                    <p>Namun, apabila kostum dikembalikan dalam kondisi aman, bersih, dan tanpa kerusakan, maka uang deposit akan dikembalikan secara penuh.</p>
                    <p>Pengembalian uang deposit dilakukan maksimal H+3 setelah kostum diterima kembali.</p>
                </div>

                <div class="content-section">
                    <p><strong>Deposito</strong></p>
                    <p>Deposito adalah uang muka (early payment) yang dibayarkan untuk melakukan booking kostum yang belum ready.</p>
                    <p>Besaran deposito umumnya beberapa persen lebih murah dibandingkan harga sewa kostum yang sudah ready.</p>
                </div>
            </div>
        </div>
    </main>

@include('user.sections.footer')
@endsection
