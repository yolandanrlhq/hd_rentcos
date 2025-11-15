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
            <select name="id_kategori" id="id_kategori" required>
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
            <label for="stok_produk">Stok Total</label>
            <input type="number" name="stok_produk" id="stok_produk" placeholder="Total stok (opsional, bisa dihitung dari ukuran)" required>
        </div>

        <!-- ====== BAGIAN UKURAN PRODUK (DINAMIS DENGAN STOK) ====== -->
        <div class="form-group">
            <label>Ukuran Produk & Stok</label>
            <div id="ukuran-wrapper">
                <div class="ukuran-item">
                    <input type="text" name="ukuran[0][nama_ukuran]" placeholder="Ukuran (misal: S)" required>
                    <input type="number" name="ukuran[0][stok]" placeholder="Stok ukuran ini" required>
                    <button type="button" class="btn-remove" onclick="hapusUkuran(this)">❌</button>
                </div>
            </div>
            <button type="button" id="btn-tambah-ukuran" class="btn-add">+ Tambah Ukuran</button>
        </div>
        <!-- ============================================ -->

        <div class="form-group">
            <label for="deskripsi">Deskripsi Produk</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Tulis deskripsi produk..." required></textarea>
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

<!-- ====== SCRIPT TAMBAH/HAPUS UKURAN ====== -->
<script>
document.getElementById('btn-tambah-ukuran').addEventListener('click', function() {
    const wrapper = document.getElementById('ukuran-wrapper');
    const index = wrapper.querySelectorAll('.ukuran-item').length;
    const div = document.createElement('div');
    div.classList.add('ukuran-item');
    div.innerHTML = `
        <input type="text" name="ukuran[${index}][nama_ukuran]" placeholder="Ukuran (misal: M)" required>
        <input type="number" name="ukuran[${index}][stok]" placeholder="Stok ukuran ini" required>
        <button type="button" class="btn-remove" onclick="hapusUkuran(this)">❌</button>
    `;
    wrapper.appendChild(div);
});

function hapusUkuran(button) {
    button.parentElement.remove();
}
</script>
