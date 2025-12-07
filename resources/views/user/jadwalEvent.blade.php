@extends('layouts.user')

@section('title', 'Detail Produk - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/jadwalEventUser.css') }}">
@endsection

@section('content')
    @include('user.sections.header')
    <main class="event-container">
        <h2>Jadwal Event</h2>

        @foreach($events as $event)
        <div class="event-card">
            <div class="event-info">
                <h3>{{ $event->nama_event }}</h3>
                <div class="event-details">
                    <p><i class="fas fa-map-marker-alt"></i> {{ $event->tempat_event }}</p>
                    <p><i class="fas fa-calendar-alt"></i> {{ date('Y-m-d', strtotime($event->tgl_event)) }}</p>                    <p><i class="fas fa-ticket-alt"></i> {{ $event->htm }}</p>
                    <p><i class="fas fa-phone-alt"></i> {{ $event->kontak_panitia }}</p>
                </div>
            </div>
            <div class="event-image">
                @if($event->gambar)
                    <img src="{{ asset('storage/'.$event->gambar) }}" alt="{{ $event->nama_event }}">
                @else
                    <div class="img-placeholder">Gambar Event</div>
                @endif
            </div>
        </div>
        @endforeach
    </main>
    @include('user.sections.footer')
@endsection
