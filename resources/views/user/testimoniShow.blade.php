@extends('layouts.user')

@section('title', 'Detail Testimoni')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/testimoniShow.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="testimoni-detail-page">
    <div class="testimoni-detail-card">

        <h2>Testimoni Pesanan #{{ $sewa->id }}</h2>

        {{-- RATING --}}
        <div class="rating-stars">
            @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star {{ $i <= $testimoni->rating ? 'active' : '' }}"></i>
            @endfor
        </div>

        {{-- ISI --}}
        <p class="testimoni-text">
            “{{ $testimoni->isi }}”
        </p>

        {{-- FOTO --}}
        @if($testimoni->foto)
            <img
                src="{{ asset('storage/' . $testimoni->foto) }}"
                alt="Foto Testimoni"
                class="testimoni-foto"
            >
        @endif

        <a href="{{ route('cart.status', ['status' => 'selesai']) }}" class="btn-back">
            ← Kembali
        </a>

    </div>
</main>

@include('user.sections.footer')
@endsection
