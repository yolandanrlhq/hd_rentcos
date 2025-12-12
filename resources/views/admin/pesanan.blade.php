@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/pesanan.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
        <main class="main-content">
                <section class="stat-cards-container">
                    <div class="stat-card total">
                        <div class="card-icon"><i class="fas fa-receipt"></i></div>
                        <div class="card-info">
                            <span class="card-title">Total Pesanan</span>
                            <span class="card-value">250</span>
                        </div>
                        <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                    </div>

                    <div class="stat-card success">
                        <div class="card-icon"><i class="fas fa-user-check"></i></div>
                        <div class="card-info">
                            <span class="card-title">Berhasil</span>
                            <span class="card-value">15</span>
                        </div>
                        <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                    </div>

                    <div class="stat-card failed">
                        <div class="card-icon"><i class="fas fa-heart-broken"></i></div>
                        <div class="card-info">
                            <span class="card-title">Gagal</span>
                            <span class="card-value">200</span>
                        </div>
                        <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                    </div>

                    <div class="stat-card pending">
                        <div class="card-icon"><i class="fas fa-clipboard-list"></i></div>
                        <div class="card-info">
                            <span class="card-title">Dalam Proses</span>
                            <span class="card-value">35</span>
                        </div>
                        <button class="card-options"><i class="fas fa-ellipsis-v"></i></button>
                    </div>
                </section>

                <section class="data-table-section">
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>id_sewa</th>
                                    <th>nama</th>
                                    <th>kostum</th>
                                    <th>harga</th>
                                    <th>tgl_sewa</th>
                                    <th>tgl_kembali</th>
                                    <th>status</th>
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
                                        <select class="status-select" data-id="{{ $p->id }}">
                                            <option value="pending" {{ $p->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                            <option value="diproses" {{ $p->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="dibatalkan" {{ $p->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="pagination-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <!-- Info -->
                    <span class="table-count">
                        {{ $pesanan->firstItem() ?? 0 }}-{{ $pesanan->lastItem() ?? 0 }} of {{ $pesanan->total() }}
                    </span>

                    <!-- Controls -->
                    <div class="pagination-controls" style="display: flex; align-items: center; gap: 8px;">
                        <span>Rows per page:</span>
                        <span class="row-count">10</span>

                        <!-- Previous -->
                        @if($pesanan->onFirstPage())
                            <button class="nav-button disabled"><i class="fas fa-angle-left"></i></button>
                        @else
                            <a href="{{ $pesanan->previousPageUrl() }}" class="nav-button"><i class="fas fa-angle-left"></i></a>
                        @endif

                        <!-- Next -->
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

<script>
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const sewaId = this.dataset.id;
        const newStatus = this.value;

        fetch(`/admin/pesanan/${sewaId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                alert('Status berhasil diperbarui!');
            } else {
                alert('Gagal memperbarui status.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan.');
        });
    });
});
</script>

