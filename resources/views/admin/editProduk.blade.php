@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/editProduk.css') }}">
@endsection

@section('content')
<div class="container">
    @include('admin.sections.sidebar')
    <div class="main">
        <div class="form-container">
            <h2>Edit Produk</h2>

            @if ($errors->any())
                <div class="alert alert-danger" style="background-color:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" style="background-color:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                </div>

                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select name="id_kategori" id="id_kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->id_kategori }}" {{ old('id_kategori', $produk->id_kategori) == $item->id_kategori ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="harga_produk">Harga</label>
                    <input type="number" name="harga_produk" id="harga_produk" value="{{ old('harga_produk', $produk->harga_produk) }}" required>
                </div>

                <div class="form-group">
                    <label for="stok_produk">Stok Total</label>
                    <input type="number" name="stok_produk" id="stok_produk" value="{{ old('stok_produk', $produk->stok_produk) }}" placeholder="Total stok (opsional, bisa dihitung dari ukuran)" required>
                </div>

                <div class="form-group">
                    <label>Ukuran Produk & Stok</label>
                    <div id="ukuran-wrapper">
                        @if(old('ukuran'))
                            @foreach(old('ukuran') as $index => $ukuran)
                                <div class="ukuran-item">
                                    <input type="text" name="ukuran[{{ $index }}][nama_ukuran]" value="{{ $ukuran['nama_ukuran'] }}" placeholder="Ukuran (misal: S)" required>
                                    <input type="number" name="ukuran[{{ $index }}][stok]" value="{{ $ukuran['stok'] }}" placeholder="Stok ukuran ini" required>
                                    <button type="button" class="btn-remove" onclick="hapusUkuran(this)">❌</button>
                                </div>
                            @endforeach
                        @else
                            @foreach($produk->ukuran as $index => $ukuran)
                                <div class="ukuran-item">
                                    <input type="text" name="ukuran[{{ $index }}][nama_ukuran]" value="{{ $ukuran->nama_ukuran }}" placeholder="Ukuran (misal: S)" required>
                                    <input type="number" name="ukuran[{{ $index }}][stok]" value="{{ $ukuran->stok }}" placeholder="Stok ukuran ini" required>
                                    <button type="button" class="btn-remove" onclick="hapusUkuran(this)">❌</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" id="btn-tambah-ukuran" class="btn-add">+ Tambah Ukuran</button>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Produk</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Tulis deskripsi produk...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="fotos">Foto Produk Baru</label>
                    <input type="file" name="fotos[]" id="fotos" accept="image/*" multiple>
                </div>

                <div class="form-group">
                    <label>Foto Produk Lama</label>
                    <div class="existing-photos">
                        @foreach($produk->fotos as $foto)
                            <img src="{{ asset('storage/' . $foto->foto_path) }}" alt="Foto Produk" style="width: 80px; height: 80px; object-fit: cover; margin-right: 5px;">
                        @endforeach
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Perbarui</button>
                    <a href="{{ route('admin.produk') }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>

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
    </div>
</div>
@endsection
