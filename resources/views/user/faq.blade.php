@extends('layouts.user')

@section('title', 'FAQ - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/faq.css') }}">
@endsection
@section('content')
@include('user.sections.header')

<main class="faq-section">
    <div class="container">

        <!-- LEFT CONTENT -->
        <div class="left-content">
            <h1 class="main-title">Frequently Asked Questions</h1>

            <div class="cta-box">
                <p class="cta-title">Masih memiliki pertanyaan?</p>
                <p class="cta-text">
                    Tidak menemukan jawaban yang kamu cari? Tim dukungan pelanggan kami siap membantu menjawab pertanyaanmu.
                </p>
                <button class="email-btn" onclick="window.location='{{ route('user.chat') }}'">
                    Kirim Pesan
                </button>
            </div>
        </div>

        <!-- RIGHT CONTENT / FAQ ITEMS -->
        <div class="right-content">

            <!-- PERTANYAAN 1 -->
            <div class="faq-item">
                <div class="faq-item-header">
                    <i class="fas fa-plus"></i>
                    <p>Apa saja syarat dan ketentuan pengiriman di HD RENTCOS?</p>
                </div>
                <div class="faq-item-content">
                    <ul>
                        <li>COD hanya jika admin dan perental berada di event yang sama.</li>
                        <li>Kostum bisa diambil di rumah admin atau diantar maksimal 5 km.</li>
                        <li>Pengiriman lebih dari 5 km harus minimal 3 perental daerah.</li><br>
                        <li><strong>Ekspedisi:</strong>
                            <ul>
                                <li>Pengiriman H-3 sebelum pemakaian.</li>
                                <li>Pengembalian H+1 setelah pemakaian.</li>
                            </ul>
                        </li><br>
                        <li>Jika kostum diantar ke rumah, pengembalian harus ke admin atau via ekspedisi.</li>
                        <li>Customer luar Jawa wajib deposit + syarat tambahan (detail via DM).</li>
                        <li>Booking maksimal H-7 untuk menghindari keterlambatan pengiriman.</li><br>
                        <li><strong>Shopee:</strong>
                            <ul>
                                <li>Full Shopee dikenakan 15%.</li>
                                <li>Payment bisa direct, Shopee hanya untuk pengiriman.</li>
                                <li>Wajib video unboxing.</li>
                                <li>Kesalahan ekspedisi ditanggung customer sepenuhnya.</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- PERTANYAAN 2 -->
            <div class="faq-item">
                <div class="faq-item-header">
                    <i class="fas fa-plus"></i>
                    <p>Apa saja ketentuan denda jika terjadi keterlambatan atau kerusakan?</p>
                </div>
                <div class="faq-item-content">
                    <ol>
                        <li>Wig kusut dikenakan denda sebesar Rp10.000 – Rp35.000.</li>
                        <li>Apabila wig rusak akibat hard styling, wajib diganti baru.</li>
                        <li>Aksesoris rusak dikenakan denda Rp30.000 atau wajib ganti baru.</li>
                        <li>Penggunaan kostum baru yang tidak sesuai toleransi dikenakan denda Rp20.000.</li>
                        <li>Keterlambatan pengembalian kostum dikenakan denda Rp25.000 per hari.</li>
                        <li>Noda membandel pada kostum atau wig dikenakan denda Rp20.000 atau wajib ganti baru.</li>
                        <li>Kerusakan kostum seperti robek/bolong dikenakan denda Rp30.000 atau wajib ganti baru.</li>
                        <li>Kehilangan plastik kostum dikenakan denda Rp10.000.</li>
                        <li>Kehilangan plastik wig dikenakan denda Rp5.000.</li>
                        <li>Ketahuan digunakan oleh pihak selain pemilik data penyewa dikenakan denda sebesar 1x harga sewa.</li>
                    </ol>
                </div>
            </div>

            <!-- PERTANYAAN 3 -->
            <div class="faq-item">
                <div class="faq-item-header">
                    <i class="fas fa-plus"></i>
                    <p>Bagaimana kebijakan refund jika terjadi pembatalan atau ketidaksesuaian layanan?</p>
                </div>
                <div class="faq-item-content">
                    <p>Refund diberikan apabila:</p>
                    <ul>
                        <li>Kesalahan pendataan admin yang menyebabkan bentrok jadwal sewa.</li>
                        <li>Keterlambatan pengiriman oleh admin ke pihak ekspedisi.</li>
                    </ul><br>
                    <p>Refund tidak diberikan apabila:</p>
                    <ul>
                        <li>Ukuran kostum tidak sesuai.</li>
                        <li>Terjadi keterlambatan pengiriman oleh pihak ekspedisi.</li>
                        <li>Pastikan bertanya terlebih dahulu sebelum mengisi form pemesanan.</li>
                    </ul>
                </div>
            </div>

            <!-- PERTANYAAN 4 -->
            <div class="faq-item">
                <div class="faq-item-header">
                    <i class="fas fa-plus"></i>
                    <p>Apa itu uang deposit dan apa saja ketentuan pengembaliannya?</p>
                </div>
                <div class="faq-item-content">
                    <p><strong>Uang Deposit (Uang Jaminan)</strong></p>
                    <p>Deposit wajib dibayarkan oleh penyewa, ditahan hingga masa sewa berakhir. Jika kostum dikembalikan aman, bersih, dan tanpa kerusakan, deposit dikembalikan penuh. Maksimal H+3 setelah pengembalian.</p>
                    <br>
                    <p><strong>Deposito</strong></p>
                    <p>Deposito adalah uang muka (early payment) untuk booking kostum yang belum ready. Besaran deposito umumnya lebih murah beberapa persen dibanding harga sewa kostum ready.</p>
                </div>
            </div>

            <!-- PERTANYAAN 5 -->
            <div class="faq-item">
                <div class="faq-item-header">
                    <i class="fas fa-plus"></i>
                    <p>Apa saja aturan dan bagaimana cara melakukan proses rental?</p>
                </div>
                <div class="faq-item-content">
                    <ol>
                        <li>Penyewa wajib memiliki foto wajah jelas.</li>
                        <li>Kostum disewa untuk pemakaian pribadi.</li>
                        <li>Siapkan DP 50% ongkir.</li>
                        <li>Pastikan tidak mengganti username akun selama masa sewa.</li>
                        <li>Siapkan dokumen identitas (KTP/Kartu Pelajar/KIA/KK).</li>
                        <li>Proses rental: chat admin, cek ketersediaan, isi formulir, bayar DP, booking sah.</li>
                        <li>Syarat & peraturan rental: usia minimal 14, masa sewa 3 hari, rental bareng teman wajib isi formulir masing-masing, dan lain-lain.</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
</main>

@include('user.sections.footer')

<script>
document.addEventListener('DOMContentLoaded', () => {
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
});
</script>
@endsection
