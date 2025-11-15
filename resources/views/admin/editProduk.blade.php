@extends('layouts.admin')

@section('content')
<div class="form-container">
    <h2>Edit Produk</h2>

    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nama Produk -->
        <div class="form-group">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
        </div>

        <!-- Kategori -->
        <div class="form-group">
            <label for="id_kategori">Kategori</label>
            <select name="id_kategori" id="id_kategori" required>
                @foreach($kategori as $item)
                    <option value="{{ $item->id_kategori }}" {{ $produk->id_kategori == $item->id_kategori ? 'selected' : '' }}>
                        {{ $item->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Harga -->
        <div class="form-group">
            <label for="harga_produk">Harga</label>
            <input type="number" name="harga_produk" id="harga_produk" value="{{ old('harga_produk', $produk->harga_produk) }}" required>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
            <label for="deskripsi">Deskripsi Produk</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

        <!-- Foto -->
        <div class="form-group">
            <label for="foto">Foto Produk</label><br>
            @if($produk->foto)
                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" width="120" class="mb-2">
            @endif
            <input type="file" name="foto" id="foto" accept="image/*">
        </div>

        <!-- ====== BAGIAN UKURAN PRODUK (DINAMIS) ====== -->
        <div class="form-group">
            <label>Ukuran & Stok Produk</label>
            <div id="ukuran-wrapper">
                @foreach($produk->ukuranProduk as $ukuran)
                <div class="ukuran-item">
                    <input type="hidden" name="id_ukuran[]" value="{{ $ukuran->id }}">
                    <input type="text" name="ukuran_produk[]" value="{{ $ukuran->nama_ukuran }}" placeholder="Ukuran" required>
                    <input type="number" name="stok_ukuran[]" value="{{ $ukuran->stok }}" placeholder="Stok" min="0" required>
                    <button type="button" class="btn-remove" onclick="hapusUkuran(this)">❌</button>
                </div>
                @endforeach
            </div>
            <button type="button" id="btn-tambah-ukuran" class="btn-add">+ Tambah Ukuran</button>
        </div>

        <!-- Tombol Aksi -->
        <div class="form-actions">
            <button type="submit" class="btn-submit">Simpan Perubahan</button>
            <a href="{{ route('admin.produk') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>

<!-- ====== SCRIPT TAMBAH/HAPUS UKURAN ====== -->
<script>
document.getElementById('btn-tambah-ukuran').addEventListener('click', function() {
    const wrapper = document.getElementById('ukuran-wrapper');
    const div = document.createElement('div');
    div.classList.add('ukuran-item');
    div.innerHTML = `
        <input type="text" name="ukuran_produk[]" placeholder="Ukuran" required>
        <input type="number" name="stok_ukuran[]" placeholder="Stok" min="0" required>
        <button type="button" class="btn-remove" onclick="hapusUkuran(this)">❌</button>
    `;
    wrapper.appendChild(div);
});

function hapusUkuran(button) {
    button.parentElement.remove();
}
</script>
@endsection
