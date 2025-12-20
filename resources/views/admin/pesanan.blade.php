@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/pesanan.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
        <header class="main-header">
            <h2>PESANAN</h2>
            <div class="filters">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search-input" placeholder="Cari Pesanan...">
                </div>
                <div class="date-filters">
                    <label>Start Date:</label>
                    <input type="date" id="start-date">
                    <label>End Date:</label>
                    <input type="date" id="end-date">
                    <button id="filter-date-btn">Filter</button>
                </div>
            </div>
        </header>
        <section class="stat-cards-container">
            <div class="stat-card total">
                <div class="card-icon"><i class="fas fa-receipt"></i></div>
                <div class="card-info">
                    <span class="card-title">Total Pesanan</span>
                    <span class="card-value">{{ $total }}</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="card-icon"><i class="fas fa-user-check"></i></div>
                <div class="card-info">
                    <span class="card-title">Berhasil</span>
                    <span class="card-value">{{ $berhasil }}</span>
                </div>
            </div>

            <div class="stat-card failed">
                <div class="card-icon"><i class="fas fa-heart-broken"></i></div>
                <div class="card-info">
                    <span class="card-title">Gagal</span>
                    <span class="card-value">{{ $gagal }}</span>
                </div>
            </div>

            <div class="stat-card pending">
                <div class="card-icon"><i class="fas fa-clipboard-list"></i></div>
                <div class="card-info">
                    <span class="card-title">Dalam Proses</span>
                    <span class="card-value">{{ $diproses + $pending + $dikirim }}</span>
                </div>
            </div>
        </section>

        <section class="data-table-section">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="sortable" data-sort="id">ID SEWA</th>
                            <th class="sortable" data-sort="name">NAMA</th>
                            <th class="sortable" data-sort="kostum">KOSTUM</th>
                            <th class="sortable" data-sort="harga">HARGA</th>
                            <th class="sortable" data-sort="tgl_sewa">TGL SEWA</th>
                            <th class="sortable" data-sort="tgl_kembali">TGL KEMBALI</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan as $p)
                        @foreach($p->items as $item)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>{{ $item->produk->nama_produk ?? '-' }}</td>
                            <td>{{ number_format($item->sewa->total_harga,0,',','.') }}</td>
                            <td>{{ $p->tanggal_sewa }}</td>
                            <td>{{ $p->tanggal_kembali }}</td>
                            <td>
                                @if(in_array($p->status, ['selesai','dibatalkan']))
                                    <span>{{ ucfirst(str_replace('_',' ',$p->status)) }}</span>
                                @else
                                    <select class="status-select" data-id="{{ $p->id }}">
                                        <option value="menunggu_konfirmasi" {{ $p->status == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                        <option value="diproses" {{ $p->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="dikirim" {{ $p->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ $p->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <div class="pagination-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
            <span class="table-count">
                {{ $pesanan->firstItem() ?? 0 }}-{{ $pesanan->lastItem() ?? 0 }} of {{ $pesanan->total() }}
            </span>

            <div class="pagination-controls" style="display: flex; align-items: center; gap: 8px;">
                <span>Rows per page:</span>
                <span class="row-count">10</span>

                @if($pesanan->onFirstPage())
                    <button class="nav-button disabled"><i class="fas fa-angle-left"></i></button>
                @else
                    <a href="{{ $pesanan->previousPageUrl() }}" class="nav-button"><i class="fas fa-angle-left"></i></a>
                @endif

                @if($pesanan->hasMorePages())
                    <a href="{{ $pesanan->nextPageUrl() }}" class="nav-button"><i class="fas fa-angle-right"></i></a>
                @else
                    <button class="nav-button disabled"><i class="fas fa-angle-right"></i></button>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/pesananAdmin.js') }}"></script>
@endsection

