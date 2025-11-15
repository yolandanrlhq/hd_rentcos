<main class="product-detail-section">
  <div class="container">

    <!-- Gambar & Informasi Produk -->
    <div class="grid-container">
      <!-- Gambar Produk -->
      <div class="product-image">
        <img src="{{ asset('storage/' . $produk->foto) }}"
             alt="{{ $produk->nama_produk }}">
      </div>

      <!-- Informasi Produk -->
      <div class="product-info">
        <h1>{{ $produk->nama_produk }}</h1>

        <!-- Rating Dinamis -->
        <div class="rating">
          @php
            $average = round($produk->rating ?? 0, 1);
            $filledStars = floor($average);
            $halfStar = ($average - $filledStars) >= 0.5;
            $totalReviews = $produk->jumlah_ulasan ?? 0;
          @endphp

          {{-- Bintang penuh --}}
          @for ($i = 0; $i < $filledStars; $i++)
            <i class="fas fa-star"></i>
          @endfor

          {{-- Setengah bintang --}}
          @if ($halfStar)
            <i class="fas fa-star-half-alt"></i>
          @endif

          {{-- Bintang kosong --}}
          @for ($i = $filledStars + ($halfStar ? 1 : 0); $i < 5; $i++)
            <i class="far fa-star"></i>
          @endfor

          <span>({{ $average }}/{{ $totalReviews }} Reviews)</span>
        </div>

        <div class="price-row">
          <span class="price">Rp{{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
          <span class="duration">/ 3 hari</span>
        </div>

        <p>{{ $produk->deskripsi ?? 'Deskripsi produk belum tersedia.' }}</p>

        <!-- Pilih Ukuran -->
        <div class="ukuran-buttons">
            @foreach($stok as $ukuran => $jumlah)
                <button
                type="button"
                class="ukuran-btn {{ $jumlah == 0 ? 'disabled' : '' }}"
                data-ukuran="{{ $ukuran }}"
                data-stok="{{ $jumlah }}"
                {{ $jumlah == 0 ? 'disabled' : '' }}
                >
                {{ $ukuran }}
                </button>
            @endforeach
        </div>

        <!-- Tambah ke Keranjang -->
        <form id="cartForm" action="{{ route('cart.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
            <input type="hidden" name="ukuran" id="selectedSize">
            <input type="hidden" name="jumlah" id="selectedQty" value="1">

            <div class="cart-actions">
                <div class="quantity-box">
                <button type="button" id="minusBtn">−</button>
                <span id="qtyDisplay">1</span>
                <button type="button" id="plusBtn">+</button>
                </div>

                <button type="submit" id="addCartBtn" class="add-cart-btn disabled" disabled>+ Tambah ke Keranjang</button>
            </div>
        </form>
      </div>
    </div>

    <!-- TAB SECTION -->
    <section class="tab-section">
      <div class="tab-buttons">
        <button class="active">Detail Produk</button>
        <button>Ulasan</button>
        <button>FAQ</button>
      </div>

      <!-- Detail Produk -->
      <div class="tab-content active" id="tab-detail">
        <p>{{ $produk->deskripsi ?? 'Belum ada detail tambahan untuk produk ini.' }}</p>
      </div>

      <!-- Ulasan -->
      <div class="tab-content" id="tab-ulasan">
        <h3>Belum ada ulasan.</h3>
      </div>

      <!-- FAQ -->
      <div class="tab-content" id="tab-faq">
        <p>Tidak ada pertanyaan untuk produk ini.</p>
      </div>
    </section>

    <!-- PRODUK REKOMENDASI -->
    <div class="rekomendasi">
      <h2>Produk Serupa</h2>
      <div class="rekomendasi-grid">
        @foreach($rekomendasi as $item)
          <a href="{{ route('user.produk.show', $item->id_produk) }}" class="rekomendasi-item">
            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}">
            <h3>{{ $item->nama_produk }}</h3>
            <p>Rp{{ number_format($item->harga_produk, 0, ',', '.') }}</p>
          </a>
        @endforeach
      </div>
    </div>

  </div>
</main>

<!-- Script untuk Tab -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('.tab-buttons button');
  const tabs = document.querySelectorAll('.tab-content');

  buttons.forEach((btn, index) => {
    btn.addEventListener('click', () => {
      buttons.forEach(b => b.classList.remove('active'));
      tabs.forEach(t => t.classList.remove('active'));

      btn.classList.add('active');
      tabs[index].classList.add('active');
    });
  });
});
document.addEventListener('DOMContentLoaded', () => {
  const sizeButtons = document.querySelectorAll('.ukuran-btn');
  const addBtn = document.getElementById('addCartBtn');
  const selectedSizeInput = document.getElementById('selectedSize');
  const qtyDisplay = document.getElementById('qtyDisplay');
  const plusBtn = document.getElementById('plusBtn');
  const minusBtn = document.getElementById('minusBtn');
  const qtyInput = document.getElementById('selectedQty');

  let selectedSize = null;
  let maxStok = 0;
  let qty = 1;

  // Klik ukuran
  sizeButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      if (btn.classList.contains('disabled')) return;

      sizeButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      selectedSize = btn.dataset.ukuran;
      maxStok = parseInt(btn.dataset.stok);

      selectedSizeInput.value = selectedSize;
      qty = 1;
      qtyDisplay.textContent = qty;
      qtyInput.value = qty;

      addBtn.classList.remove('disabled');
      addBtn.disabled = false;
    });
  });

  // Tombol plus
  plusBtn.addEventListener('click', () => {
    if (!selectedSize) return alert('Pilih ukuran terlebih dahulu!');
    if (qty < maxStok) {
      qty++;
      qtyDisplay.textContent = qty;
      qtyInput.value = qty;
    } else {
      alert('Jumlah melebihi stok tersedia!');
    }
  });

  // Tombol minus
  minusBtn.addEventListener('click', () => {
    if (qty > 1) {
      qty--;
      qtyDisplay.textContent = qty;
      qtyInput.value = qty;
    }
  });
});
</script>
