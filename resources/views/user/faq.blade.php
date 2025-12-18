@extends('layouts.user')

@section('title', 'FAQ - HD RENTCOS')

@section('content')
@include('user.sections.header')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/faq.css') }}">
@endsection

<main class="faq-section">
        <div class="container">
            <div class="left-content">
                <h1 class="main-title">Frequenty Asked Questions</h1>

                <div class="cta-box">
                    <p class="cta-title">Still have a questions?</p>
                    <p class="cta-text">
                        Tidak menemukan jawaban yang kamu cari? Tim
                        dukungan pelanggan kami siap membantu menjawab
                        pertanyaanmu.
                    </p>
                    <button class="email-btn">Send Email</button>
                </div>
            </div>

            <div class="right-content">
                <a href="{{ route('persyaratan') }}"><div class="faq-item">
                    <i class="fas fa-plus"></i>
                    <p>Apa saja syarat dan ketentuan pengiriman di HD RENTCOS??</p>
                </div></a>
               <a href="{{ route('denda') }}"> <div class="faq-item">
                    <i class="fas fa-plus"></i>
                    <p>Apa saja ketentuan denda jika terjadi keterlambatan atau kerusakan?</p>
                </div></a>
                <a href="{{ route('refund') }}"><div class="faq-item">
                    <i class="fas fa-plus"></i>
                    <p>Bagaimana kebijakan refund jika terjadi pembatalan atau ketidaksesuaian layanan?</p>
                </div>
                <a href="{{ route('pengembalian') }}"><div class="faq-item">
                    <i class="fas fa-plus"></i>
                    <p>Apa itu uang deposit dan apa saja ketentuan pengembaliannya?</p>
                </div>
                <a href="{{ route('rental') }}"><div class="faq-item">
                    <i class="fas fa-plus"></i>
                    <p>Apa saja aturan dan bagaimana cara melakukan proses rental?</p>
                </div></a>
            </div>
        </div>
    </main>

@include('user.sections.footer')
@endsection
