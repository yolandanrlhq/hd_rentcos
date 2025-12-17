<header class="navbar">
    <a href="{{ route('user.dashboard') }}" class="logo">HD <span>RENTCOS</span></a>

    <nav class="nav-links">
      <a href="{{ route('user.produk') }}" class="{{ request()->routeIs('user.sections.produk') ? 'active' : '' }}">Produk</a>
      <a href="{{ route('user.jadwalEvent') }}" class="{{ request()->routeIs('user.jadwalEvent') ? 'active' : '' }}">Jadwal Event</a>
      <a href="{{ route('wishlist.index') }}" class="{{ request()->routeIs('user.wishlist') ? 'active' : '' }}">Wishlist</a>
    </nav>

    <div class="search-box">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Search">
    </div>

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

        <a href="{{ route('user.chat') }}">
            <i class="ri-message-3-fill"></i>
        </a>
    </div>


    <div class="profil dropdown">
        <button class="profile-btn" id="profileToggle">
            <i class="ri-user-3-fill"></i>
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
    </div>
  </header>
