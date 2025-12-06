@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/pesan.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
            <div class="message-container">

                <section class="contact-list-section">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search for...">
                    </div>

                    <div class="active-users">
                        <span class="active-title">Active</span>
                        <div class="active-avatars">
                            <i class="fas fa-user-circle active-avatar"></i>
                            <i class="fas fa-user-circle active-avatar"></i>
                            <i class="fas fa-user-circle active-avatar"></i>
                            <i class="fas fa-user-circle active-avatar"></i>
                            <i class="fas fa-user-circle active-avatar"></i>
                            <i class="fas fa-user-circle active-avatar"></i>
                        </div>
                    </div>

                    <div class="message-counts">Messages 40</div>

                    <div class="contact-item">
                        <i class="fas fa-user-circle contact-avatar"></i>
                        <div class="contact-info">
                            <span class="contact-name">Patrick Meyer</span>
                            <span class="contact-preview">Lorem ipsum dolor sit amet consectetur non...</span>
                        </div>
                        <span class="time-stamp">5 min ago</span>
                    </div>

                    <div class="contact-item active-chat">
                        <i class="fas fa-user-circle contact-avatar"></i>
                        <div class="contact-info">
                            <span class="contact-name">Sophie Moore</span>
                            <span class="contact-preview">Lorem ipsum dolor sit amet consectetur non...</span>
                        </div>
                        <span class="time-stamp">10 min ago</span>
                    </div>

                    <div class="contact-item">
                        <i class="fas fa-user-circle contact-avatar"></i>
                        <div class="contact-info">
                            <span class="contact-name">Matt Cannon</span>
                            <span class="contact-preview">Lorem ipsum dolor sit amet consectetur non...</span>
                        </div>
                        <span class="time-stamp">15 min ago</span>
                    </div>

                    <div class="contact-item">
                        <i class="fas fa-user-circle contact-avatar"></i>
                        <div class="contact-info">
                            <span class="contact-name">Graham Hills</span>
                            <span class="contact-preview">Lorem ipsum dolor sit amet consectetur non...</span>
                        </div>
                        <span class="time-stamp">20 min ago</span>
                    </div>

                    <div class="contact-item">
                        <i class="fas fa-user-circle contact-avatar"></i>
                        <div class="contact-info">
                            <span class="contact-name">Sandy Houston</span>
                            <span class="contact-preview">Lorem ipsum dolor sit amet consectetur non...</span>
                        </div>
                        <span class="time-stamp">25 min ago</span>
                    </div>
                </section>

                <section class="chat-area">
                    <header class="chat-header">
                        <div class="chat-user-info">
                            <i class="fas fa-user-circle chat-avatar"></i>
                            <div>
                                <span class="chat-user-name">Sophie Moore</span>
                                <span class="chat-user-status">@sophiemoore</span>
                            </div>
                        </div>
                        <button class="call-button">
                            <i class="fas fa-phone-alt"></i> Call Sophie
                        </button>
                    </header>

                    <div class="chat-body">

                        <div class="message received">
                            <i class="fas fa-user-circle message-avatar"></i>
                            <div class="message-content">
                                <p>Hello John! Hope you're doing well. I need your help with some reports, are you available for a call later today?</p>
                                <div class="message-time">10:40 AM</div>
                            </div>
                        </div>

                        <div class="message received">
                            <i class="fas fa-user-circle message-avatar"></i>
                            <div class="message-content">
                                <p>Thank you</p>
                                <div class="message-time">10:40 AM</div>
                            </div>
                        </div>

                        <div class="message sent">
                            <div class="message-content">
                                <p>Hey Sophie! How are you?</p>
                                <div class="message-time">11:41 AM</div>
                            </div>
                        </div>

                        <div class="message sent">
                            <div class="message-content">
                                <p>For sure. I'll be free offer mid-day, let me know what time works for you</p>
                                <div class="message-time">11:41 AM</div>
                            </div>
                        </div>

                        <div class="message received">
                            <i class="fas fa-user-circle message-avatar"></i>
                            <div class="message-content">
                                <p>What about 2:00 PM? Works for you?</p>
                                <div class="message-time">11:45 AM</div>
                            </div>
                        </div>

                        <div class="message sent with-image">
                            <div class="message-content">
                                <div class="image-placeholder">
                                                                    </div>
                                <div class="message-time">11:45 AM</div>
                            </div>
                        </div>

                        <div class="chat-input-placeholder">
                             <input type="text" placeholder="Type a message...">
                             <button><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </section>
            </div>
    </main>
</div>
@endsection
