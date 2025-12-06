@extends('layouts.user')

@section('title', 'Detail Produk - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/produk.css') }}">
@endsection

@section('content')
    @include('user.sections.header')
    <!-- ===== Be The Hero Section ===== -->
    <section class="hero-collection">
        <h2>WishList Anda!!</h2>
        <p>Kostum Yang Anda Sukai.</p>
        <div class="cards">
            <!-- Gambar produk hero -->
            <div class="card">
                <img src="image.png" alt="">
                <h3>Hero Costume 1</h3>
                <p>$59.99</p>
            </div>
            <div class="card">
                <img src="image.png" alt="">
                <h3>Hero Costume 1</h3>
                <p>$59.99</p>
            </div>
            <div class="card">
                <img src="image.png" alt="">
                <h3>Hero Costume 1</h3>
                <p>$59.99</p>
            </div>
            <div class="card">
                <img src="image.png" alt="">
                <h3>Hero Costume 1</h3>
                <p>$59.99</p>
            </div>
            <div class="card">
                <img src="image.png" alt="">
                <h3>Hero Costume 1</h3>
                <p>$59.99</p>
            </div>
            <div class="card">
                <img src="image.png" alt="">
                <h3>Hero Costume 1</h3>
                <p>$59.99</p>
            </div>

        </div>

    </section>
    @include('user.sections.footer')
@endsection
