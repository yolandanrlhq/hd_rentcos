@if(session('error'))
<script>
    alert("{{ session('error') }}");
</script>
@endif

@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif


<main class="product-detail-section">
  <div class="container">

    <!-- Gambar & Informasi Produk -->
    <div class="grid-container">
      <!-- Gambar Produk -->
      <div class="product-image">
        @if($produk->fotos->count() > 0)
          <div class="slider-container">
            <img id="mainPhoto" src="{{ asset('storage/' . $produk->fotos->first()->foto_path) }}" alt="{{ $produk->nama_produk }}">
            <div class="slider-controls">
              <button id="prevBtn">&#10094;</button>
              <button id="nextBtn">&#10095;</button>
            </div>
            <div class="thumbnail-container">
              @foreach($produk->fotos as $foto)
                <img class="thumbnail" src="{{ asset('storage/' . $foto->foto_path) }}" alt="{{ $produk->nama_produk }}">
              @endforeach
            </div>
          </div>
        @else
          <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}">
        @endif
      </div>

      <style>
        .slider-container {
          position: relative;
          max-width: 400px;
        }
        #mainPhoto {
          width: 100%;
          height: auto;
        }
        .slider-controls {
          position: absolute;
          top: 50%;
          width: 100%;
          display: flex;
          justify-content: space-between;
          transform: translateY(-50%);
          pointer-events: none;
        }
        .slider-controls button {
          background-color: rgba(0,0,0,0.3);
          border: none;
          color: white;
          font-size: 24px;
          cursor: pointer;
          pointer-events: all;
          padding: 5px 10px;
        }
        .thumbnail-container {
          display: flex;
          justify-content: center;
          gap: 5px;
          margin-top: 8px;
        }
        .thumbnail {
          width: 50px;
          height: 50px;
          object-fit: cover;
          cursor: pointer;
          opacity: 0.7;
          border: 2px solid transparent;
          border-radius: 4px;
        }
        .thumbnail.active {
          opacity: 1;
          border-color: #007bff;
        }
      </style>

      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const mainPhoto = document.getElementById('mainPhoto');
          const thumbnails = document.querySelectorAll('.thumbnail');
          const prevBtn = document.getElementById('prevBtn');
          const nextBtn = document.getElementById('nextBtn');
          let currentIndex = 0;

          function setActiveThumbnail(index) {
            thumbnails.forEach((thumb, i) => {
              if (i === index) {
                thumb.classList.add('active');
              } else {
                thumb.classList.remove('active');
              }
            });
          }

          function updateMainPhoto(index) {
            mainPhoto.src = thumbnails[index].src;
            setActiveThumbnail(index);
            currentIndex = index;
          }

          thumbnails.forEach((thumb, index) => {
            thumb.addEventListener('click', () => {
              updateMainPhoto(index);
            });
          });

          prevBtn.addEventListener('click', () => {
            let newIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
            updateMainPhoto(newIndex);
          });

          nextBtn.addEventListener('click', () => {
            let newIndex = (currentIndex + 1) % thumbnails.length;
            updateMainPhoto(newIndex);
          });

          setActiveThumbnail(0);
        });
      </script>

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

        <!-- Pilih Ukuran -->
        <div class="ukuran-buttons">
            @foreach($stok as $ukuran => $detail)
                <button
                type="button"
                class="ukuran-btn {{ ($detail['stok'] == 0 || $detail['is_rented']) ? 'disabled' : '' }}"
                data-ukuran="{{ $ukuran }}"
                data-stok="{{ $detail['stok'] }}"
                {{ ($detail['stok'] == 0 || $detail['is_rented']) ? 'disabled' : '' }}
                title="{{ $detail['is_rented'] ? 'Ukuran ini sedang disewa' : '' }}"
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
                <button type="button" id="plusBtn" class="disabled">+</button>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
  /* -------- TAB -------- */
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


  /* -------- UKURAN & CART -------- */
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

  /* ------ FUNGSI TAMBAHAN ------ */

  // Update kondisi tombol +
  function updatePlusButton() {
    if (qty >= maxStok) {
      plusBtn.classList.add('disabled');
      plusBtn.disabled = true;
    } else {
      plusBtn.classList.remove('disabled');
      plusBtn.disabled = false;
    }
  }

  // Update tombol tambah keranjang
  function updateAddButton() {
    if (maxStok === 0) {
      addBtn.classList.add('disabled');
      addBtn.disabled = true;
    } else {
      addBtn.classList.remove('disabled');
      addBtn.disabled = false;
    }
  }

  /* ------ KLIK UKURAN ------ */
  sizeButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      if (btn.classList.contains('disabled')) return;

      sizeButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      selectedSize = btn.dataset.ukuran;
      maxStok = parseInt(btn.dataset.stok);

      selectedSizeInput.value = selectedSize;

      // Reset qty
      qty = 1;
      qtyDisplay.textContent = qty;
      qtyInput.value = qty;

      // Update tombol
      updatePlusButton();
      updateAddButton();
    });
  });

  /* ------ TOMBOL PLUS ------ */
  plusBtn.addEventListener('click', () => {
    if (!selectedSize) return alert('Pilih ukuran terlebih dahulu!');

    if (qty < maxStok) {
      qty++;
      qtyDisplay.textContent = qty;
      qtyInput.value = qty;
      updatePlusButton();
    } else {
      alert('Jumlah melebihi stok tersedia!');
    }
  });

  /* ------ TOMBOL MINUS ------ */
  minusBtn.addEventListener('click', () => {
    if (qty > 1) {
      qty--;
      qtyDisplay.textContent = qty;
      qtyInput.value = qty;
      updatePlusButton();
    }
  });
});

/* ------ CEK FORM SUBMIT ------ */
document.getElementById('cartForm').addEventListener('submit', function(e) {
  let ukuran = document.getElementById('selectedSize').value;
  if (!ukuran) {
      e.preventDefault();
      alert("Pilih ukuran terlebih dahulu!");
      return false;
  }
});
</script>
