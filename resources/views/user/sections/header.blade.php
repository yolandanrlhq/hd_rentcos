<header class="navbar">
    <a href="{{ route('user.dashboard') }}" class="logo">
    <img src="{{ asset('images/logo.jpg') }}" alt="HD RENTCOS Logo" class="logo-img">
    <span class="logo-text">HD <span>RENTCOS</span></span>
</a>



    <nav class="nav-links">
      <a href="{{ route('user.produk') }}" class="{{ request()->routeIs('user.sections.produk') ? 'active' : '' }}">Produk</a>
      <a href="{{ route('user.jadwalEvent') }}" class="{{ request()->routeIs('user.jadwalEvent') ? 'active' : '' }}">Jadwal Event</a>
      <a href="{{ route('wishlist.index') }}" class="{{ request()->routeIs('user.wishlist') ? 'active' : '' }}">Wishlist</a>
      <a href="{{ route('faq') }}" class="{{ request()->routeIs('user.faq') ? 'active' : '' }}">FAQ</a>
    </nav>

    <form action="{{ route('user.produk') }}" method="GET" class="search-box">
    <i class="fas fa-search"></i>
    <input
        type="text"
        name="q"
        placeholder="Cari produk..."
        value="{{ request('q') }}"
    >
</form>


    <div class="icons">
        <a href="{{ route('user.notifikasi') }}" class="notif-icon">
            <i class="ri-notification-3-fill"></i>

            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="notif-badge">{{ $unreadCount }}</span>
            @endif
        </a>

        <a href="{{ route('cart.index') }}">
            <i class="ri-shopping-cart-fill"></i>
        </a>

        <a href="{{ route('user.chat') }}" class="chat-icon" style="position:relative;">
    <i class="ri-message-3-fill"></i>

    @if(isset($unreadChatCount) && $unreadChatCount > 0)
        <span class="notif-badge">
            {{ $unreadChatCount }}
        </span>
    @endif
</a>
    </div>


    @if(Auth::check())
    <button type="button" class="profile-btn avatar-btn" id="profileToggle">
        @if(Auth::user()->foto)
            <img
                src="{{ asset('storage/' . Auth::user()->foto) }}"
                alt="Avatar"
                class="avatar-img"
            >
        @else
            <div class="avatar-letter">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
    </button>

    <div class="dropdown-menu" id="profileMenu">
        <a href="{{ route('user.profile') }}">
            <i class="ri-user-line"></i> Lihat Profil
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="ri-logout-box-r-line"></i> Logout
            </button>
        </form>
    </div>
@else
    {{-- JIKA BELUM LOGIN --}}
    <a href="{{ route('login') }}" class="login-btn">
        Login
    </a>
@endif
</header>
