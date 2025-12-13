@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/pesanAdmin.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')

    <main class="main-content">
        <div class="message-container">

            <!-- LEFT SIDE – USER LIST -->
            <section class="contact-list-section">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search-user" placeholder="Cari pelanggan...">
                </div>
                <div id="user-list" class="contact-list"></div>
            </section>

            <!-- RIGHT SIDE – CHAT AREA -->
            <section class="chat-area">
                <header class="chat-header" id="chat-header" style="display:none;">
                    <div class="chat-user-info">
                        <div class="chat-avatar"></div>
                        <div>
                            <span id="chat-user-name" class="chat-user-name"></span>
                            <span id="chat-user-status" class="chat-user-status"></span>
                        </div>
                    </div>
                </header>

                <div id="chat-body" class="chat-body">
                    <div id="empty-chat-state" class="empty-chat-state">
                        <div class="empty-chat-box">
                            <div class="empty-chat-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h3>Belum ada percakapan</h3>
                            <p>Pilih pelanggan di sebelah kiri untuk mulai membalas pesan.</p>
                        </div>
                    </div>

                </div>

                <div id="chat-input-area" class="chat-input-placeholder" style="display:none;">
                    <input type="text" id="admin-chat-input" placeholder="Ketik pesan...">
                    <button id="admin-send-btn"><i class="fas fa-paper-plane"></i></button>
                </div>
            </section>
        </div>
    </main>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const ADMIN_CHAT_SEND_URL = "{{ route('admin.chat.send') }}";
        const CSRF_TOKEN_ADMIN = "{{ csrf_token() }}";
        const PUSHER_KEY = "{{ env('PUSHER_APP_KEY') }}";
        const PUSHER_CLUSTER = "{{ env('PUSHER_APP_CLUSTER') }}";
    </script>

    <script src="{{ asset('js/pesanAdmin.js') }}"></script>

</div>
@endsection
