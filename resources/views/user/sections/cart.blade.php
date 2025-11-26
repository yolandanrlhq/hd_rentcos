<main class="cart-page">
  <div class="cart-container">
    <h2><i class="fas fa-shopping-cart"></i> Keranjang Saya</h2>

    <!-- HEADER -->
    <div class="cart-header">
      <span>Pilih</span>
      <span>Produk</span>
      <span>Harga</span>
      <span>Kuantitas</span>
      <span>Total</span>
      <span>Aksi</span>
    </div>

    <!-- ITEM -->
    @foreach($cartItems as $item)
      <div class="cart-item" id="cart-item-{{ $item->id }}">

        <div class="cart-col center">
          <input type="checkbox" class="select-item" value="{{ $item->id }}">
        </div>

        <div class="cart-col product">
          <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="">
          <div>
            <strong>{{ $item->produk->nama_produk }}</strong>
            <p>Ukuran : <strong>{{ $item->ukuran }}</strong></p>
          </div>
        </div>

        <div class="cart-col price" id="price-{{ $item->id }}">
          Rp{{ number_format($item->harga_satuan,0,',','.') }}
        </div>

        <div class="cart-col qty">
          <button onclick="updateQty({{ $item->id }}, -1, {{ $item->harga_satuan }})">-</button>
          <span id="qty-{{ $item->id }}">{{ $item->jumlah }}</span>
          <button onclick="updateQty({{ $item->id }}, 1, {{ $item->harga_satuan }})">+</button>
        </div>

        <div class="cart-col total" id="total-{{ $item->id }}">
          Rp{{ number_format($item->harga_satuan * $item->jumlah,0,',','.') }}
        </div>

        <div class="cart-col center">
          <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
            @csrf @method('DELETE')
            <button class="hapus-btn">Hapus</button>
          </form>
        </div>

      </div>
    @endforeach

    <!-- SUMMARY -->
    <div class="cart-summary">
      <label class="select-all-wrapper">
        <input type="checkbox" id="select-all">
        <span>Pilih Semua</span>
      </label>

      <p class="summary-total">
        Total (<span id="summary-count">{{ $cartItems->count() }}</span>):
        <strong>Rp{{ number_format($total,0,',','.') }}</strong>
      </p>

      <div style="display: flex; flex-direction: column; gap: 10px;">
        <button class="checkout-btn" onclick="proceedToCheckout()">Checkout</button>
        <a href="{{ route('cart.status') }}" class="checkout-btn">Lihat Status Penyewaan</a>
      </div>
    </div>
  </div>
</main>

<script>

// ================= UPDATE QTY =================
function updateQty(id, change, hargaSatuan) {
    let qtySpan = document.getElementById(`qty-${id}`);
    let qty = parseInt(qtySpan.textContent) + change;
    if (qty < 1) return;

    fetch(`/user/cart/update/${id}`, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": '{{ csrf_token() }}'
        },
        body: JSON.stringify({ jumlah: qty })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            alert(data.message || 'Gagal update qty');
            return;
        }

        // Update qty & total per item
        qtySpan.textContent = qty;
        document.getElementById(`total-${id}`).textContent =
            'Rp' + (hargaSatuan * qty).toLocaleString('id-ID');

        // Re-calculate summary berdasarkan item yang dicentang
        updateSummaryBySelection();
    });
}



// ================= CHECKOUT =================
function proceedToCheckout() {
    const checked = Array.from(document.querySelectorAll('.select-item:checked'))
                         .map(cb => cb.value);

    if (checked.length === 0) {
        alert('Pilih minimal satu produk untuk checkout');
        return;
    }

    const base = '{{ route('cart.checkout') }}';
    const params = checked.map(id => 'selected[]=' + encodeURIComponent(id)).join('&');
    window.location.href = base + (base.includes('?') ? '&' : '?') + params;
}



// ================= PILIH SEMUA =================
function toggleSelectAll(checked) {
    document.querySelectorAll('.select-item').forEach(cb => cb.checked = checked);
}



// ================= UPDATE RINGKASAN TOTAL =================
function updateSummaryBySelection() {
    const checkedItems = Array.from(document.querySelectorAll('.select-item:checked'));

    let totalHarga = 0;
    let jumlahItem = checkedItems.length;

    checkedItems.forEach(cb => {
        const id = cb.value;
        const qty = parseInt(document.getElementById(`qty-${id}`).textContent);
        const harga = parseInt(
            document.getElementById(`price-${id}`).textContent.replace(/[^\d]/g, '')
        );

        totalHarga += qty * harga;
    });

    document.querySelector('.summary-total strong').textContent =
        'Rp' + totalHarga.toLocaleString('id-ID');

    document.getElementById('summary-count').textContent = jumlahItem;
}



// ================= INISIALISASI =================
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('select-all');
    const items = document.querySelectorAll('.select-item');

    // Select All listener
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            toggleSelectAll(this.checked);
            updateSummaryBySelection();
        });
    }

    // Listener per item
    items.forEach(cb => cb.addEventListener('change', function () {
        const allChecked = Array.from(items).every(i => i.checked);
        if (selectAll) selectAll.checked = allChecked;
        updateSummaryBySelection();
    }));

    // Set total awal = 0 (tidak ada centang)
    updateSummaryBySelection();
});

</script>
