<div class="form-container">
    <h2>Tambah Produk Baru</h2>

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" required>
        </div>

        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" id="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $item)
                    <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="harga_produk">Harga</label>
            <input type="number" name="harga_produk" id="harga_produk" required>
        </div>

        <div class="form-group">
            <label for="stok_produk">Stok</label>
            <input type="number" name="stok_produk" id="stok_produk" required>
        </div>

        <div class="form-group">
            <label for="ukuran_produk">Ukuran (Opsional)</label>
            <input type="text" name="ukuran_produk" id="ukuran_produk" placeholder="Contoh: S, M, L, XL">
        </div>

        <div class="form-group">
            <label for="foto">Foto Produk</label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Simpan</button>
            <a href="{{ route('admin.produk') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>
