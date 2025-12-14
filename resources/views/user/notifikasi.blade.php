@extends('layouts.user')

@section('title', 'Notifikasi - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/notifikasi.css') }}">
@endsection

@section('content')

@include('user.sections.header')

<main class="notifikasi-container">
    <h2>Notifikasi</h2>

    @if($notifications->isEmpty())
        <p>Tidak ada notifikasi.</p>
    @else
        <div class="notifikasi-list">
            @foreach($notifications as $notif)
                <div class="notifikasi-item {{ $notif->is_read ? '' : 'new' }}">
                    <i class="ri-{{ $notif->ikon ?? 'notification-3-fill' }} icon"></i>

                    <div class="notifikasi-text">
                        <h4>{{ $notif->judul }}</h4>
                        <p>{{ $notif->pesan }}</p>
                        <span class="time">
                            {{ $notif->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>

@include('user.sections.footer')

@endsection
