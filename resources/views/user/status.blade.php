@extends('layouts.user')

@section('title', 'Status Penyewaan - HD RENTCOS')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/status.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="status-page">
    <div class="status-container">
        <h2><i class="fas fa-truck"></i> Status Penyewaan</h2>

        <div class="status-tabs">
            <a href="{{ route('cart.status', ['status' => 'semua']) }}" class="{{ ($filter == 'semua' || !$filter) ? 'active' : '' }}">Semua</a>
            <a href="{{ route('cart.status', ['status' => 'menunggu_konfirmasi']) }}" class="{{ $filter == 'menunggu_konfirmasi' ? 'active' : '' }}">Menunggu Konfirmasi</a>
            <a href="{{ route('cart.status', ['status' => 'diproses']) }}" class="{{ $filter == 'diproses' ? 'active' : '' }}">Diproses</a>
            <a href="{{ route('cart.status', ['status' => 'dikirim']) }}" class="{{ $filter == 'dikirim' ? 'active' : '' }}">Dikirim</a>
            <a href="{{ route('cart.status', ['status' => 'selesai']) }}" class="{{ $filter == 'selesai' ? 'active' : '' }}">Selesai</a>
            <a href="{{ route('cart.status', ['status' => 'dibatalkan']) }}" class="{{ $filter == 'dibatalkan' ? 'active' : '' }}">Dibatalkan</a>
        </div>

        @forelse ($sewas as $sewa)
            <div class="status-card">
                <div class="status-left">
                    <div>
                        <h3>Pesanan #{{ $sewa->id }}</h3>
                        <p>Nama: <strong>{{ $sewa->user->name ?? '-' }}</strong></p>
                        <p>Tanggal Sewa: <strong>{{ $sewa->tanggal_sewa }}</strong></p>
                        <p>Status: <strong>{{ ucfirst($sewa->status) }}</strong></p>
                        <p>Total: <strong>Rp{{ number_format($sewa->total_harga,0,',','.') }}</strong></p>
                    </div>
                </div>
                <div class="status-right">
                    <a href="{{ route('cart.detail', $sewa->id) }}" class="btn-detail">Detail</a>
                </div>
            </div>
        @empty
            <p class="no-data">Belum ada riwayat penyewaan.</p>
        @endforelse

        <div class="pagination-wrapper">
            {{ $sewas->links() }}
        </div>
    </div>
</main>

@include('user.sections.footer')
@endsection
