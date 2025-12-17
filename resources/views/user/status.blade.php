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
                @if($sewa->pengembalian && $sewa->pengembalian->status == 'selesai')
                    @if(!$sewa->testimoni)
                        <a href="{{ route('user.testimoni.create', $sewa->id) }}" class="btn-testimoni">
                            Berikan Penilaian
                        </a>
                    @else
                        <div class="user-testimoni">
                            <strong>Testimoni Anda:</strong>
                            <p>{{ $sewa->testimoni->isi }}</p>
                            <p>Rating: {{ $sewa->testimoni->rating }} ⭐</p>
                        </div>
                    @endif
                @endif

            </div>
        </div>
        @empty
        <p class="no-data">Belum ada riwayat penyewaan.</p>
        @endforelse

        {{-- PAGINASI --}}
        <div class="pagination-wrapper">
            {{ $sewas->links() }}
        </div>
    </div>
</main>

@include('user.sections.footer')
@endsection
