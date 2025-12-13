@extends('layouts.user')

@section('title', 'Detail Produk - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/pesanUser.css') }}">
@endsection

@section('content')
@include('user.sections.header')

<main class="profile-section">
    <div class="chat-wrapper">

        <!-- Header -->
        <div class="chat-header-user">
            <i class="fas fa-user-circle chat-avatar-user"></i>
            <div class="chat-user-info">
                <span class="chat-title">Chat Admin</span>
                <small class="chat-subtitle">Online • Balasan cepat</small>
            </div>
        </div>

        <!-- Chat Body -->
        <div id="chat-body" class="chat-body-user"></div>

        <!-- Input -->
        <div class="chat-input-user">
            <input
                id="message-input"
                type="text"
                placeholder="Ketik pesan..."
                autocomplete="off"
            >
            <button id="send-btn" class="send-btn">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

    </div>
</main>

@include('user.sections.footer')

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const CHAT_SEND_URL = "{{ route('user.chat.send') }}";
    const CHAT_MESSAGES_URL = "{{ route('user.chat.messages', ['adminId' => 1]) }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
    const ADMIN_ID = 1;
</script>
<script>
    const CURRENT_USER_ID = {{ auth()->id() }};
    const PUSHER_KEY = "{{ env('PUSHER_APP_KEY') }}";
    const PUSHER_CLUSTER = "{{ env('PUSHER_APP_CLUSTER') }}";
</script>
<script src="{{ asset('js/pesanUser.js') }}"></script>
@endsection
