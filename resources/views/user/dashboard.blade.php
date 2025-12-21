@extends('layouts.user')

@section('title', 'Beranda - HD RENTCOS')

@section('content')
@include('user.sections.header')

<!-- ================= HERO ================= -->
<section class="hero">
    <div class="hero-text">
        <h4>Cosplay untuk Kamu yang Berani Tampil Beda</h4>
        <h1>Tampil Total <br> Jadi Karakter Favoritmu</h1>
        <p>Sewa kostum cosplay keren, siap bikin kamu jadi pusat perhatian.</p>
        <a href="{{ route('user.produk') }}">
            <button>Lihat Koleksi</button>
        </a>
    </div>
    <div class="hero-img slider">
        <div class="slider-track">
            <img src="{{ asset('assets/anime11.png') }}" class="slide active">
            <img src="{{ asset('assets/anime22.png') }}" class="slide">
            <img src="{{ asset('assets/anime33.png') }}" class="slide">
            <img src="{{ asset('assets/anime44.png') }}" class="slide">
        </div>
    </div>
</section>

<!-- ================= REKOMENDASI ================= -->
<section class="hero-collection">
    <h2>Rekomendasi Kostum</h2>
    <p>Kostum favorit yang paling sering disewa</p>

    <div class="cards">
        @foreach($rekomendasi as $item)
            <div class="card">
                <a href="{{ route('user.produk.show', $item->id_produk) }}">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}">
                    <h3>{{ $item->nama_produk }}</h3>
                    <p>Rp{{ number_format($item->harga_produk,0,',','.') }}</p>
                </a>
            </div>
        @endforeach
    </div>

    <div class="lihat-semua-container">
        <a href="{{ route('user.produk') }}">
            <button class="lihat-semua-btn">Lihat Semua</button>
        </a>
    </div>
</section>

<!-- ================= TERBARU ================= -->
<section class="latest">
    <h2>Koleksi Terbaru</h2>
    <p>Kostum terbaru kami</p>

    <div class="cards">
        @foreach($latest as $item)
            <div class="card">
                <a href="{{ route('user.produk.show', $item->id_produk) }}">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}">
                    <h3>{{ $item->nama_produk }}</h3>
                    <p>Rp{{ number_format($item->harga_produk,0,',','.') }}</p>
                </a>
            </div>
        @endforeach
    </div>
</section>

<!-- ================= TESTIMONI ================= -->
<section class="testimonials">
    <h2>Pelanggan Puas Kami</h2>
    <div class="reviews">
        @foreach($testimoni as $review)
            <div class="review">
                @if($review->foto)
                    <div class="review-img">
                        <img src="{{ asset('storage/' . $review->foto) }}" alt="Foto Testimoni">
                    </div>
                @endif
                <div class="review-content">
                    <p class="review-text">"{{ $review->isi }}"</p>
                    <div class="review-rating">
                        @for($i=1; $i<=5; $i++)
                            <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">&#9733;</span>
                        @endfor
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- ================= EVENT HIGHLIGHT ================= -->
<section class="event-highlight">
    <div class="event-box">

        <!-- IMAGE -->
        <div class="event-image">
            <img src="{{ asset('storage/'.$eventHighlight->gambar) }}" alt="Event">
        </div>

        <!-- CONTENT -->
        <div class="event-content">
            <h2>{{ $eventHighlight->nama_event }}</h2>
            <p>
                Join the fest and transform into your beloved anime character!
            </p>

            <!-- COUNTDOWN -->
            <div class="countdown"
                 data-date="{{ $eventHighlight->tgl_event }}">
                <div class="time-box">
                    <span class="days">00</span>
                    <small>Days</small>
                </div>
                <div class="time-box">
                    <span class="hours">00</span>
                    <small>Hours</small>
                </div>
                <div class="time-box">
                    <span class="minutes">00</span>
                    <small>Min</small>
                </div>
            </div>

            <a href="{{ route('user.jadwalEvent') }}">
                <button class="event-btn">Lihat Detail</button>
            </a>
        </div>

    </div>
</section>

<!-- ================= FAQ PREVIEW ================= -->
<section class="faq-section">

    <section class="faq-preview">
        <h2>Pertanyaan Umum</h2>
        <p>Yang sering ditanyakan pelanggan</p>

        <div class="faq-preview-list">
            <div class="faq-preview-item">
                <h4>Bagaimana sistem pengiriman kostum?</h4>
                <p>Pengiriman bisa COD saat event atau via ekspedisi H-3 sebelum pemakaian.</p>
            </div>

            <div class="faq-preview-item">
                <h4>Apakah ada denda keterlambatan?</h4>
                <p>Ya, denda Rp25.000 per hari jika terlambat pengembalian.</p>
            </div>

            <div class="faq-preview-item">
                <h4>Apa itu uang deposit?</h4>
                <p>Deposit adalah uang jaminan yang dikembalikan jika kostum aman.</p>
            </div>
        </div>

        <div class="lihat-semua-container">
            <a href="{{ route('user.faq') }}">
                <button class="lihat-semua-btn">Buka FAQ Lengkap</button>
            </a>
        </div>
    </section>

</section>


@include('user.sections.footer')

<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ================= SLIDER ================= */
    const slides = document.querySelectorAll('.slide');
    let current = 0;

    slides.forEach(slide => slide.classList.remove('active', 'exit'));
    if (slides.length > 0) slides[0].classList.add('active');

    setInterval(() => {
        const prev = current;
        current = (current + 1) % slides.length;

        slides.forEach(slide => slide.classList.remove('active', 'exit'));

        slides[prev].classList.add('exit');
        slides[current].classList.add('active');
    }, 3500);


    /* ================= CARD ANIMATION ================= */
    const cards = document.querySelectorAll('.card');

    const cardObserver = new IntersectionObserver(entries => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('show');
                }, index * 120);
            }
        });
    }, { threshold: 0.2 });

    cards.forEach(card => cardObserver.observe(card));


    /* ================= REVIEW ANIMATION ================= */
    const reviews = document.querySelectorAll('.review');

    const reviewObserver = new IntersectionObserver(entries => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('show');
                }, index * 150);
            }
        });
    }, { threshold: 0.3 });

    reviews.forEach(review => reviewObserver.observe(review));

});

document.querySelectorAll('.countdown').forEach(countdown => {
    const targetDate = new Date(countdown.dataset.date).getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const diff = targetDate - now;

        if (diff <= 0) return;

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);

        countdown.querySelector('.days').textContent = days;
        countdown.querySelector('.hours').textContent = hours;
        countdown.querySelector('.minutes').textContent = minutes;
    }

    updateCountdown();
    setInterval(updateCountdown, 60000);
});

document.querySelectorAll('.faq-card').forEach(card => {
    card.addEventListener('click', () => {
        card.classList.toggle('active');
    });
});

document.querySelectorAll('.faq-preview-item').forEach(card => {

    card.addEventListener('mouseenter', () => {
        card.classList.add('floating');
    });

    card.addEventListener('mouseleave', () => {
        card.classList.remove('floating');
    });
});
</script>

@endsection
