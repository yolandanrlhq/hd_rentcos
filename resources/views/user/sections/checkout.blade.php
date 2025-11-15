<main class="checkout-container">
    <h2>Checkout</h2>

    <!-- Alamat Pengiriman -->
    <section class="alamat-box">
      <div class="alamat-header">
        <i class="ri-map-pin-user-fill"></i>
        <span>Alamat Pengiriman</span>
      </div>
      <div class="alamat-info">
        <div class="nama">
          <strong>Adnan</strong> <span>(+62) 838 9620 6981</span>
        </div>
        <div class="alamat">
          Jalan Cemara Blok Jongor, RT.12/RW.4, Cemara, Cantigi <br>
          (Anaknya ali sodiqin), KAB. INDRAMAYU - CANTIGI, JAWA BARAT, ID 45251
        </div>
        <a href="#" class="ubah">Ubah</a>
      </div>
    </section>

    <!-- Produk -->
    <section class="produk-box">
      <table>
        <thead>
          <tr>
            <th>Kostum disewa</th>
            <th>Harga</th>
            <th>Satuan</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="produk-info">
              <img src="assets/naruto.webp" alt="Naruto">
              <span>Naruto</span>
            </td>
            <td>Rp109.000</td>
            <td class="qty-cell">
              <button class="qty-btn minus">−</button>
              <input type="number" value="1" min="1" id="qty">
              <button class="qty-btn plus">+</button>
            </td>
            <td id="total-harga">Rp109.000</td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- Metode Pembayaran -->
    <section class="pembayaran-box">
      <h3>Metode Pembayaran</h3>
      <div class="payment-methods">
        <button class="active">COD</button>
        <button>Ambil ditempat</button>
        <button>Qris</button>
      </div>

      <div class="payment-summary">
        <div><span>Subtotal Pesanan</span><span id="subtotal">Rp109.000</span></div>
        <div><span>Subtotal Pengiriman</span><span>Rp6.500</span></div>
        <div><span>Voucher Diskon</span><span>-Rp3.000</span></div>
        <hr>
        <div class="total"><span>Total Pembayaran</span><span class="red" id="total-bayar">Rp113.500</span></div>
      </div>

      <div class="checkout-btn-container">
        <a href="struk.html"><button class="checkout-btn">Sewa Sekarang</button></a>
      </div>
    </section>
  </main>

  <script>
    // === Interaktif Tambah/Kurang Jumlah ===
    const qtyInput = document.getElementById("qty");
    const minusBtn = document.querySelector(".minus");
    const plusBtn = document.querySelector(".plus");
    const totalHarga = document.getElementById("total-harga");
    const subtotal = document.getElementById("subtotal");
    const totalBayar = document.getElementById("total-bayar");

    const hargaPerItem = 109000;
    const ongkir = 6500;
    const diskon = 3000;

    function updateTotal() {
      const qty = parseInt(qtyInput.value);
      const subtotalVal = hargaPerItem * qty;
      const totalVal = subtotalVal + ongkir - diskon;
      subtotal.textContent = "Rp" + subtotalVal.toLocaleString("id-ID");
      totalHarga.textContent = "Rp" + subtotalVal.toLocaleString("id-ID");
      totalBayar.textContent = "Rp" + totalVal.toLocaleString("id-ID");
    }

    minusBtn.addEventListener("click", () => {
      if (qtyInput.value > 1) {
        qtyInput.value--;
        updateTotal();
      }
    });

    plusBtn.addEventListener("click", () => {
      qtyInput.value++;
      updateTotal();
    });

    qtyInput.addEventListener("input", updateTotal);

    // === Highlight metode pembayaran aktif ===
    document.querySelectorAll(".payment-methods button").forEach(btn => {
      btn.addEventListener("click", () => {
        document.querySelectorAll(".payment-methods button").forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
      });
    });
  </script>
