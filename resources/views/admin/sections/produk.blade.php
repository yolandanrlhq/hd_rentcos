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
      <th>Deskripsi</th>
      <th>Foto</th>
      <th>Aksi</th>
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
        <a href="{{ route('admin.editProduk', $item->id_produk) }}" class="btn-edit">Edit</a>
        <form action="{{ route('admin.produk.destroy', $item->id_produk) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
