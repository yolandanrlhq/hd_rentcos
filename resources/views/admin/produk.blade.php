@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/produkAdmin.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
            <header class="main-header">
                <h2>Daftar Produk</h2>
                <div class="search-bar">
                    <form id="searchForm" action="{{ route('admin.produk') }}" method="GET">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Produk...">
                    </form>
                </div>
                <a href="{{ route('admin.create') }}" class="add-button">
                    Tambah Kostum
                    <i class="fas fa-plus-circle"></i>
                </a>

            </header>

            @php
                $currentSort = request('sort');
                $currentDir  = request('direction', 'asc');

                function sortLink($column) {
                    $dir = request('sort') === $column && request('direction') === 'asc'
                        ? 'desc'
                        : 'asc';

                    return request()->fullUrlWithQuery([
                        'sort' => $column,
                        'direction' => $dir
                    ]);
                }
            @endphp
            <section class="data-table-section">
                <div class="table-info">
                    <span class="status">semua produk</span>
                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="sortable {{ $currentSort=='id_produk' ? $currentDir : '' }}">
                                    <a href="{{ sortLink('id_produk') }}">
                                        ID
                                        <i class="sort-icon"></i>
                                    </a>
                                </th>

                                <th class="sortable {{ $currentSort=='nama_produk' ? $currentDir : '' }}">
                                    <a href="{{ sortLink('nama_produk') }}">
                                        Nama
                                        <i class="sort-icon"></i>
                                    </a>
                                </th>

                                <th>Kategori</th>

                                <th class="sortable {{ $currentSort=='harga_produk' ? $currentDir : '' }}">
                                    <a href="{{ sortLink('harga_produk') }}">
                                        Harga
                                        <i class="sort-icon"></i>
                                    </a>
                                </th>

                                <th class="sortable {{ $currentSort=='stok_produk' ? $currentDir : '' }}">
                                    <a href="{{ sortLink('stok_produk') }}">
                                        Stok
                                        <i class="sort-icon"></i>
                                    </a>
                                </th>

                                <th>Ukuran</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $item)
                            <tr>
                                <td>{{ $item->id_produk }}</td>
                                <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->nama_produk }}</td>
                                <td>{{ $item->kategori->nama_kategori }}</td>
                                <td>Rp{{ number_format($item->harga_produk, 0, ',', '.') }}</td>
                                <td>{{ $item->stok_produk }}</td>

                                <!-- ====== TAMPILKAN SEMUA UKURAN PRODUK ====== -->
                                <td>
                                    @if($item->ukuran->isNotEmpty())
                                    @foreach($item->ukuran as $u)
                                        <span class="badge-ukuran">{{ $u->nama_ukuran }}</span>
                                    @endforeach
                                    @else
                                    <span>-</span>
                                    @endif
                                </td>

                                <!-- ====== DESKRIPSI PRODUK (PENDEK) ====== -->
                                <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $item->deskripsi ?? '-' }}
                                </td>

                                <!-- ====== FOTO PRODUK ====== -->
                                <td>
                                    @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}" width="50" alt="{{ $item->nama_produk }}">
                                    @else
                                    Tidak ada
                                    @endif
                                </td>

                                <!-- ====== AKSI ====== -->
                                <td>
                                    <a href="{{ route('admin.editProduk', $item->id_produk) }}"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('admin.produk.destroy', $item->id_produk) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus produk ini?')"><i class="fa-solid fa-trash"></i></button  >
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                        <!-- Info -->
                        <span class="table-count">
                            {{ $produk->firstItem() ?? 0 }}-{{ $produk->lastItem() ?? 0 }} of {{ $produk->total() }}
                        </span>

                        <!-- Controls -->
                        <div class="pagination-controls" style="display: flex; align-items: center; gap: 8px;">
                            <span>Rows per page:</span>
                            <span class="row-count">10</span>

                            <!-- Previous -->
                            @if($produk->onFirstPage())
                                <button class="nav-button disabled"><i class="fas fa-angle-left"></i></button>
                            @else
                                <a href="{{ $produk->previousPageUrl() }}" class="nav-button"><i class="fas fa-angle-left"></i></a>
                            @endif

                            <!-- Next -->
                            @if($produk->hasMorePages())
                                <a href="{{ $produk->nextPageUrl() }}" class="nav-button"><i class="fas fa-angle-right"></i></a>
                            @else
                                <button class="nav-button disabled"><i class="fas fa-angle-right"></i></button>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
     </main>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-bar input');
    const tableRows = document.querySelectorAll('.data-table tbody tr');

    searchInput.addEventListener('keyup', function() {
        const query = this.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(query) ? '' : 'none';
        });
    });
});
</script>
@endsection
