@extends('layouts.user')

@section('title', 'Notifikasi - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/notifikasi.css') }}">
@endsection

@section('content')

@include('user.sections.header')

<main class="notifikasi-container">
    <h2>Notifikasi</h2>

    @php
        use Carbon\Carbon;

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $grouped = $notifications->groupBy(function ($notif) use ($today, $yesterday) {
            if ($notif->created_at->isToday()) {
                return 'Hari Ini';
            } elseif ($notif->created_at->isYesterday()) {
                return 'Kemarin';
            } elseif ($notif->created_at->greaterThan($today->copy()->subDays(7))) {
                return 'Minggu Ini';
            } else {
                return $notif->created_at->format('d F Y');
            }
        });
    @endphp

    @forelse ($grouped as $label => $items)
        <div class="notif-group">
            <h4 class="notif-group-title">{{ $label }}</h4>

            <div class="notifikasi-list">
                @foreach ($items as $notif)
                    <div class="notifikasi-item {{ $notif->is_read ? '' : 'new' }}">
                        <i class="ri-{{ $notif->ikon ?? 'notification-3-fill' }} icon"></i>

                        <div class="notifikasi-text">
                            <h5>{{ $notif->judul }}</h5>
                            <p>{{ $notif->pesan }}</p>
                            <span class="time">
                                {{ $notif->created_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p>Tidak ada notifikasi.</p>
    @endforelse
</main>

@include('user.sections.footer')

@endsection
