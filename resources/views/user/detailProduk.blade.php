@extends('layouts.user')

@section('title', 'Detail Produk - HD RENTCOS')
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/detailProduk.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="product-detail-section">
<div class="container">

    <!-- ================= PRODUK ================= -->
    <div class="grid-container">

        <!-- ===== GAMBAR ===== -->
        <div class="product-image">
            @if($produk->fotos->count() > 0)
            <div class="slider-container">
                <div class="slider-track" id="sliderTrack">
                    @foreach($produk->fotos as $foto)
                        <img src="{{ asset('storage/' . $foto->foto_path) }}" />
                    @endforeach
                </div>

                <div class="slider-controls">
                    <button type="button" id="prevBtn">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" id="nextBtn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="thumbnail-container">
                    @foreach($produk->fotos as $index => $foto)
                        <img class="thumbnail {{ $index==0?'active':'' }}"
                            data-index="{{ $index }}"
                            src="{{ asset('storage/' . $foto->foto_path) }}">
                    @endforeach
                </div>
            </div>
            @else
            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}">
            @endif
        </div>

        <!-- ===== INFO PRODUK ===== -->
        <div class="product-info">
            <h1>{{ $produk->nama_produk }}</h1>

            <!-- WISHLIST -->
            <div class="wishlist-btn-wrapper">
                <button type="button" class="wishlist-btn" id="wishlistBtn" data-produk="{{ $produk->id_produk }}">
                    <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart"></i>
                </button>
            </div>

            <!-- RATING -->
            <div class="rating">
                @php
                    $avg = round($produk->testimonis?->avg('rating') ?? 0,1);
                    $total = $produk->testimonis?->count() ?? 0;
                    $full = floor($avg);
                    $half = ($avg - $full) >= 0.5;
                @endphp

                @for($i=0;$i<$full;$i++) <i class="fas fa-star"></i> @endfor
                @if($half) <i class="fas fa-star-half-alt"></i> @endif
                @for($i=$full+($half?1:0);$i<5;$i++) <i class="far fa-star"></i> @endfor

                <span>({{ $avg }}/5 dari {{ $total }} ulasan)</span>
            </div>

            <div class="price-row">
                <span class="price">Rp{{ number_format($produk->harga_produk,0,',','.') }}</span>
                <span class="duration">/ 3 hari</span>
            </div>

            <!-- UKURAN -->
            <div class="ukuran-buttons">
                @foreach($stok as $ukuran => $detail)
                <button type="button"
                    class="ukuran-btn {{ ($detail['stok']==0 || $detail['is_rented']) ? 'disabled':'' }}"
                    data-ukuran="{{ $ukuran }}"
                    data-stok="{{ $detail['stok'] }}"
                    {{ ($detail['stok']==0 || $detail['is_rented']) ? 'disabled':'' }}>
                    {{ $ukuran }}
                </button>
                @endforeach
            </div>

            <div id="infoStok" class="info-stok"></div>

            <!-- CART -->
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

                    <div class="action-buttons">
                        <!-- TAMBAH KERANJANG -->
                        <button type="submit"
                                id="addCartBtn"
                                name="action"
                                value="add"
                                class="add-cart-btn disabled"
                                disabled>
                            + Tambah ke Keranjang
                        </button>

                        <!-- CHECKOUT SEKARANG -->
                        <button type="submit"
                                id="checkoutNowBtn"
                                name="action"
                                value="checkout"
                                class="checkout-now-btn disabled"
                                disabled>
                            Checkout Sekarang
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <section class="tab-section">
        <div class="tab-buttons">
            <button class="active">Detail Produk</button>
            <button>Ulasan</button>
        </div>

        <div class="tab-content active">
            <div class="produk-deskripsi">
                {!! nl2br(e($produk->deskripsi)) !!}
            </div>
        </div>

        <div class="tab-content">
            @if($produk->testimonis && $produk->testimonis->count() > 0)
                @foreach($produk->testimonis as $testi)
                    <div class="testimoni-card">
                        <div class="testimoni-header">
                            <strong>{{ $testi->sewa->user->name ?? 'User' }}</strong>
                            <span class="rating">⭐ {{ $testi->rating }}</span>
                        </div>

                        <p class="testimoni-text">{{ $testi->isi }}</p>

                        @if($testi->foto)
                            <img src="{{ asset('storage/' . $testi->foto) }}"
                                alt="Foto testimoni"
                                class="testimoni-foto">
                        @endif
                    </div>
                @endforeach
            @else
                <p class="empty-text">Belum ada ulasan.</p>
            @endif
        </div>
    </section>

    <!-- ================= REKOMENDASI ================= -->
    <div class="rekomendasi">
        <h2>Produk Serupa</h2>
        <div class="rekomendasi-grid">
            @foreach($rekomendasi as $item)
            <a href="{{ route('user.produk.show',$item->id_produk) }}" class="rekomendasi-item">
                <img src="{{ asset('storage/' . $item->foto) }}">
                <h3>{{ $item->nama_produk }}</h3>
                <p>Rp{{ number_format($item->harga_produk,0,',','.') }}</p>
            </a>
            @endforeach
        </div>
    </div>
</div>
</main>

@include('user.sections.footer')

<script>
document.addEventListener('DOMContentLoaded', () => {
    /* TAB */
    const tabBtns = document.querySelectorAll('.tab-buttons button');
    const tabs = document.querySelectorAll('.tab-content');
    tabBtns.forEach((btn,i)=>btn.onclick=()=>{
        tabBtns.forEach(b=>b.classList.remove('active'));
        tabs.forEach(t=>t.classList.remove('active'));
        btn.classList.add('active'); tabs[i].classList.add('active');
    });

    /* UKURAN & CART */
    let qty=1,max=0;
    const info=document.getElementById('infoStok');
    const qtyDisp=document.getElementById('qtyDisplay');
    const plus=document.getElementById('plusBtn');
    const minus=document.getElementById('minusBtn');
    const sizeInput=document.getElementById('selectedSize');
    const qtyInput=document.getElementById('selectedQty');
    const addBtn=document.getElementById('addCartBtn');
    const checkoutBtn = document.getElementById('checkoutNowBtn');


    document.querySelectorAll('.ukuran-btn').forEach(btn=>{
        btn.onclick=()=>{
            if(btn.classList.contains('disabled')) return;
            document.querySelectorAll('.ukuran-btn').forEach(b=>b.classList.remove('active'));
            btn.classList.add('active');
            max=parseInt(btn.dataset.stok);
            sizeInput.value=btn.dataset.ukuran;
            qty=1; qtyDisp.textContent=1; qtyInput.value=1;
            info.textContent=`Stok tersedia: ${max}`;
            addBtn.disabled = false;
            addBtn.classList.remove('disabled');

            checkoutBtn.disabled = false;
            checkoutBtn.classList.remove('disabled');

            plus.disabled=max<=1;
        }
    });

    plus.onclick=()=>{ if(qty<max){qty++;qtyDisp.textContent=qty;qtyInput.value=qty;} };
    minus.onclick=()=>{ if(qty>1){qty--;qtyDisp.textContent=qty;qtyInput.value=qty;} };

    /* WISHLIST */
    const wishBtn=document.getElementById('wishlistBtn');
    if(wishBtn){
        wishBtn.onclick=async()=>{
            const res=await fetch("{{ route('wishlist.toggle') }}",{
                method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},
                body:JSON.stringify({id_produk:wishBtn.dataset.produk})
            });
            if(res.status===401){location.href="{{ route('login') }}";return;}
            const data=await res.json();
            const icon=wishBtn.querySelector('i');
            icon.classList.toggle('fas',data.status==='added');
            icon.classList.toggle('far',data.status==='removed');
        }
    }
});

document.addEventListener('DOMContentLoaded', () => {

    const track = document.getElementById('sliderTrack');
    const slides = track.children;
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const thumbs = document.querySelectorAll('.thumbnail');

    let index = 0;
    let startX = 0;
    const threshold = 40;

    const updateSlide = () => {
        track.style.transform = `translateX(-${index * 100}%)`;

        thumbs.forEach(t => t.classList.remove('active'));
        thumbs[index]?.classList.add('active');

        // disable button di ujung
        prevBtn.classList.toggle('disabled', index === 0);
        nextBtn.classList.toggle('disabled', index === slides.length - 1);
    };

    nextBtn.onclick = () => {
        if (index < slides.length - 1) {
            index++;
            updateSlide();
        }
    };

    prevBtn.onclick = () => {
        if (index > 0) {
            index--;
            updateSlide();
        }
    };

    thumbs.forEach(t => {
        t.onclick = () => {
            index = parseInt(t.dataset.index);
            updateSlide();
        };
    });

    /* ===== SWIPE ===== */
    track.addEventListener('touchstart', e => {
        startX = e.touches[0].clientX;
    }, { passive: true });

    track.addEventListener('touchend', e => {
        const diff = startX - e.changedTouches[0].clientX;

        if (Math.abs(diff) > threshold) {
            if (diff > 0 && index < slides.length - 1) index++;     // swipe kiri
            if (diff < 0 && index > 0) index--;                     // swipe kanan
            updateSlide();
        }
    });

    updateSlide();
});
</script>
@endsection
