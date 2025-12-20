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

        {{-- TAB FILTER --}}
        <div class="status-tabs">
            @php
                $tabs = ['semua','menunggu_konfirmasi','diproses','dikirim','selesai','dibatalkan'];
            @endphp
            @foreach($tabs as $tab)
                <a href="{{ route('cart.status', ['status' => $tab]) }}" class="{{ ($filter == $tab || (!$filter && $tab=='semua')) ? 'active' : '' }}">
                    {{ ucfirst(str_replace('_',' ',$tab)) }}
                </a>
            @endforeach
        </div>

        {{-- DATA SEWA --}}
        @forelse ($sewas as $sewa)
        <div class="status-card">

            {{-- KIRI --}}
            <div class="status-left">
                <h3>Pesanan #{{ $sewa->id }}</h3>
                <p>Nama: <strong>{{ $sewa->user->name ?? '-' }}</strong></p>
                <p>Tanggal Sewa: <strong>{{ $sewa->tanggal_sewa }}</strong></p>
                <p>Status: <strong class="{{ $sewa->status }}">{{ ucfirst(str_replace('_',' ',$sewa->status)) }}</strong></p>
                <p>Total: <strong>Rp{{ number_format($sewa->total_harga,0,',','.') }}</strong></p>
            </div>

            {{-- KANAN --}}
            <div class="status-right">
                <a href="{{ route('cart.detail', $sewa->id) }}" class="btn-detail">Detail</a>

                {{-- PENGEMBALIAN --}}
                @if($sewa->pengembalian)
                    <div class="return-status">
                        <p>Pengembalian:
                            <strong class="return {{ $sewa->pengembalian->status }}">
                                {{ ucfirst(str_replace('_',' ', $sewa->pengembalian->status)) }}
                            </strong>
                        </p>
                    </div>
                @endif

                {{-- BUTTON TESTIMONI --}}
                @if($sewa->status === 'selesai')
                    {{-- BELUM ADA TESTIMONI --}}
                    @if(!$sewa->testimoni)
                        <a href="{{ route('user.testimoni.create', $sewa->id) }}" class="btn-testimoni">
                            <i class="fas fa-star"></i>
                            Berikan Penilaian
                        </a>

                    {{-- SUDAH ADA TESTIMONI --}}
                    @else
                        <div class="testimoni-done">

                            {{-- RATING --}}
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $sewa->testimoni->rating ? 'active' : '' }}"></i>
                                @endfor
                            </div>

                            <a href="{{ route('user.testimoni.show', $sewa->id) }}"
                            class="btn-lihat-testimoni">
                                Lihat Testimoni
                            </a>
                        </div>
                    @endif
                @endif

            </div>
        </div>
        @empty
        <p class="no-data">Belum ada riwayat penyewaan.</p>
        @endforelse

        @if ($sewas->hasPages())
        <div class="simple-pagination">

            {{-- INFO --}}
            <div class="page-info">
                {{ $sewas->firstItem() }}–{{ $sewas->lastItem() }} of {{ $sewas->total() }}
            </div>

            {{-- RIGHT SIDE --}}
            <div class="page-controls">

                {{-- ROWS PER PAGE --}}
                <div class="rows-per-page">
                    Rows per page:
                    <span>{{ $sewas->perPage() }}</span>
                </div>

                {{-- PREV --}}
                @if ($sewas->onFirstPage())
                    <span class="nav disabled">‹</span>
                @else
                    <a href="{{ $sewas->previousPageUrl() }}" class="nav">‹</a>
                @endif

                {{-- NEXT --}}
                @if ($sewas->hasMorePages())
                    <a href="{{ $sewas->nextPageUrl() }}" class="nav">›</a>
                @else
                    <span class="nav disabled">›</span>
                @endif

            </div>
        </div>
        @endif
    </div>
</main>

@include('user.sections.footer')
@endsection
