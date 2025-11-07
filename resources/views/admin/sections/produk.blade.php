<div class="header-bar">
  <h2>Daftar Produk</h2>
  <a href="{{ route('admin.create') }}" class="btn-tambah">+ Tambah Produk</a>
</div>

<table class="table-produk">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Kategori</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Ukuran</th>
      <th>Foto</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($produk as $item)
    <tr>
      <td>{{ $item->id_produk }}</td>
      <td>{{ $item->nama_produk }}</td>
      <td>{{ $item->kategori->nama_kategori }}</td>
      <td>Rp{{ number_format($item->harga_produk, 0, ',', '.') }}</td>
      <td>{{ $item->stok_produk }}</td>
      <td>{{ $item->ukuran_produk ?? '-' }}</td>
      <td>
        @if($item->foto)
          <img src="{{ asset('storage/'.$item->foto) }}" width="50" />
        @else
          Tidak ada
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
