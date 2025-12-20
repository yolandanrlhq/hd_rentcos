@extends('layouts.user')

@section('title', 'Checkout - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/checkoutSuccess.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="success-container">
    <div class="success-box">
        <h2>🎉 Terima Kasih!</h2>
        <p>
            Form pesanan kamu berhasil terkirim.<br>
            Untuk melanjutkan pembayaran, silakan hubungi admin melalui chat.
        </p>

                @if(!empty($sewa))
        <a href="{{ route('user.chat') }}" class="btn-chat">
            💬 Lanjut ke Chat Admin
        </a>
        @else
        <span class="btn-chat-disabled">
            💬 Chat tersedia setelah pesanan dibuat
        </span>
        @endif

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.success-container');

    // Tambahkan confetti
    for(let i = 0; i < 50; i++){
        const confetti = document.createElement('div');
        confetti.classList.add('confetti');
        confetti.style.left = Math.random()*100 + 'vw';
        confetti.style.background = `hsl(${Math.random()*360}, 70%, 60%)`;
        confetti.style.animationDuration = 2 + Math.random()*3 + 's';
        confetti.style.width = 5 + Math.random()*10 + 'px';
        confetti.style.height = confetti.style.width;
        container.appendChild(confetti);
    }
});
</script>

@endsection
