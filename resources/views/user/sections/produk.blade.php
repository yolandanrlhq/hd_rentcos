<!-- Hanya bagian konten (letakkan setelah header-mu, sebelum footer-mu) -->
<main class="products-section">
  <div class="container">
    <h2 class="section-title">Produk Kami</h2>

    <div class="products-grid">
      @foreach ($produks as $produk)
        <a href="{{ route('user.produk.show', $produk->id_produk) }}">
        <article class="product-card">
          <div class="img-wrap">
            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}">
            </div>

          <div class="card-body">
            <h3 class="product-title">{{ $produk->nama_produk }}</h3>

            <div class="rating">
              @php
                // misalnya rating disimpan di kolom 'rating' (0–5)
                $filledStars = floor($produk->rating);
                $halfStar = ($produk->rating - $filledStars) >= 0.5;
                $emptyStars = 5 - $filledStars - ($halfStar ? 1 : 0);
              @endphp

              <div class="stars" aria-hidden="true">
                {!! str_repeat('★', $filledStars) !!}
                {!! $halfStar ? '☆' : '' !!}
                {!! str_repeat('☆', $emptyStars) !!}
              </div>
              <span class="rating-score">{{ number_format($produk->rating, 1) }}/5</span>
            </div>

            <div class="price-row">
              <div class="price">IDR {{ number_format($produk->harga_produk, 0, ',', '.') }}</div>
              <div class="duration">/ 3 day</div>
            </div>
          </div>
        </article>
        </a>
      @endforeach
    </div>
  </div>
</main>
