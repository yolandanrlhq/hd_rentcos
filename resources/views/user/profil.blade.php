@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.user')

@section('title', 'Detail Produk - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/profilUser.css') }}">
@endsection

@section('content')
    @include('user.sections.header')
    <main class="profile-section">
        <div class="profile-card">
            <!-- Kiri: Foto Profil -->
            <div class="profile-left">
            <div class="profile-img-wrapper">
    @if ($user->foto)
        <img
            src="{{ asset('storage/' . $user->foto) }}"
            alt="Foto Profil"
            class="profile-img"
        >
    @else
        <div class="profile-avatar">
            {{ Str::upper(Str::substr($user->name, 0, 1)) }}
        </div>
    @endif
</div>

            <h2 class="profile-name">{{ $user->name }}</h2>
            <p class="profile-location">{{ $user->address ?? 'Belum ada alamat' }}</p>
            </div>

            <!-- Kanan: Detail Profil -->
            <div class="profile-right">
            <div class="profile-header">
                <h3>Informasi Akun</h3>
                <a href="{{ route('user.editProfile') }}" class="edit-btn">
                <i class="ri-edit-line"></i> Edit
                </a>
            </div>

            <div class="profile-details">
                <p><span>Email :</span> {{ $user->email }}</p>
                <p><span>No. Telepon :</span> {{ $user->phone ?? '-' }}</p>
                <p><span>Alamat :</span> {{ $user->address ?? '-' }}</p>
                <p><span>Bergabung Sejak :</span> {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('F Y') }}</p>
            </div>
            </div>
        </div>
    </main>
    @include('user.sections.footer')
@endsection

