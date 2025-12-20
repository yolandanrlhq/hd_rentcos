<footer class="footer">
    <div class="footer-container">

        {{-- BRAND --}}
        <div class="footer-brand">
            <h2>HD RENTCOS</h2>
            <p>
                Kami menyediakan berbagai kostum cosplay berkualitas untuk disewa,
                mulai dari karakter anime, game, hingga tokoh film favorit.
                Setiap kostum dirawat dengan baik agar kamu bisa tampil maksimal
                dan percaya diri di setiap event.
            </p>

            <div class="social-icons">
                <a href="https://www.instagram.com/hd.rentcos" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://wa.me/6283121638156" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>

        {{-- MENU --}}
        <div class="footer-section">
            <h3>Menu</h3>
            <ul>
                <li><a href="{{ route('user.dashboard') }}">Beranda</a></li>
                <li><a href="{{ route('user.produk') }}">Produk</a></li>
                <li><a href="{{ route('user.jadwalEvent') }}">Event</a></li>
            </ul>
        </div>

        {{-- BANTUAN --}}
        <div class="footer-section">
            <h3>Bantuan</h3>
            <ul>
                <li><a href="{{ route('faq') }}">FAQ</a></li>
                <li><a href="{{ route('rental') }}">Cara Rental</a></li>
                <li><a href="{{ route('pengembalian') }}">Pengembalian</a></li>
                <li><a href="{{ route('denda') }}">Ketentuan Denda</a></li>
            </ul>
        </div>

        {{-- KONTAK --}}
        <div class="footer-section">
            <h3>Kontak</h3>
            <ul>
                <li>
                    <i class="fas fa-map-marker-alt"></i>
                    <span>
                        Perumahan Prawira Kepolo, Jl. Anggrek 7 Blok D1-9,
                        Desa Singaraja, Kec. Indramayu, Kab. Indramayu
                    </span>
                </li>
                <li>
                    <i class="fas fa-phone"></i>
                    <span>083121638156</span>
                </li>
                <li>
                    <i class="fas fa-envelope"></i>
                    <span>info@hdrentcos.com</span>
                </li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© {{ date('Y') }} HD RENTCOS. All rights reserved.</p>
    </div>
</footer>
