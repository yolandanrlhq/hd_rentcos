<main class="status-container">
    <h2>Status Kostum Yang Disewa</h2>
    @if($carts->isEmpty())
        <p>Anda tidak memiliki kostum yang sedang disewa.</p>
    @else
        @foreach($carts as $cart)
            <section class="cart-status">
                <h3>Pesanan ID: {{ $cart->id }}</h3>
                <p>Status: {{ ucfirst($cart->status) }}</p>
                <p>Metode Pengiriman: {{ ucfirst(str_replace('_', ' ', $cart->delivery_method)) ?? 'Belum dipilih' }}</p>
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Ukuran</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                            <tr>
                                <td>{{ $item->produk->nama_produk ?? 'Produk Tidak Diketahui' }}</td>
                                <td>{{ $item->ukuran ?? '-' }}</td>
                                <td>{{ $item->jumlah ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endforeach
    @endif
    <a href="{{ route('cart.index') }}" class="btn btn-primary">Kembali ke Keranjang</a>
</main>
