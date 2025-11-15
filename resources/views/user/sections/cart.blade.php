<main class="cart-page">
  <div class="cart-container">
    <h2><i class="fas fa-shopping-cart"></i> Keranjang Saya</h2>

    <div class="cart-header">
      <span>Produk</span>
      <span>Harga Satuan</span>
      <span>Kuantitas</span>
      <span>Total Harga</span>
      <span>Aksi</span>
    </div>

    @foreach($cartItems as $item)
      <div class="cart-item">
        <div class="cart-product">
          <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="{{ $item->produk->nama_produk }}">
          <div>
            <strong>{{ $item->produk->nama_produk }}</strong>
            <p>{{ $item->produk->deskripsi }}</p>
          </div>
        </div>

        <div class="cart-price">Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</div>

        <div class="cart-qty">
          <button class="qty-btn" onclick="updateQty({{ $item->id }}, -1)">−</button>
          <span id="qty-{{ $item->id }}">{{ $item->jumlah }}</span>
          <button class="qty-btn" onclick="updateQty({{ $item->id }}, 1)">+</button>
        </div>

        <div class="cart-total">Rp{{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</div>

        <div class="cart-action">
          <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="hapus-btn">Hapus</button>
          </form>
        </div>
      </div>
    @endforeach

    <div class="cart-summary">
      <p>Total ({{ $cartItems->count() }} kostum): <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></p>
      <a href="{{ route('cart.checkout') }}" class="checkout-btn">Checkout</a>
    </div>
  </div>
</main>

<script>
function updateQty(id, change) {
  let qtySpan = document.getElementById(`qty-${id}`);
  let qty = parseInt(qtySpan.textContent) + change;
  if (qty < 1) return;

  fetch(`/keranjang/update/${id}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ jumlah: qty })
  })
  .then(() => location.reload());
}
</script>
