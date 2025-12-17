@extends('layouts.user')

@section('title', 'Berikan Testimoni')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/testimoni.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="testimoni-page">
    <div class="testimoni-wrapper">
        <div class="testimoni-header">
            Testimoni untuk Pesanan #{{ $sewa->id }}
        </div>

        <div class="testimoni-body">
            {{-- Testimoni yang sudah ada --}}
            @if($sewa->testimoni)
                <div class="testimoni-bubble testimoni-received">
                    <p>{{ $sewa->testimoni->isi }}</p>
                    <small>Rating: {{ $sewa->testimoni->rating }} ⭐</small>
                    @if($sewa->testimoni->foto)
                        <img src="{{ asset('storage/' . $sewa->testimoni->foto) }}" alt="Foto Testimoni" class="testimoni-img">
                    @endif
                </div>
            @endif

            {{-- Form untuk kirim testimoni --}}
            @if(!$sewa->testimoni)
            <form action="{{ route('user.testimoni.store', $sewa->id) }}" method="POST" class="testimoni-form" enctype="multipart/form-data">
                @csrf
                <textarea name="isi" rows="3" placeholder="Tuliskan pengalamanmu..."></textarea>
                <label for="foto">Upload Foto (opsional):</label>
                <input type="file" name="foto" accept="image/*">
                <select name="rating">
                    @for($i=5; $i>=1; $i--)
                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                    @endfor
                </select>
                <button type="submit">Kirim</button>
            </form>
            @endif
        </div>
    </div>
</main>

@include('user.sections.footer')
@endsection
