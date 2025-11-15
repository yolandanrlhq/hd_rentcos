<header class="navbar">
    <a href="{{ route('user.dashboard') }}" class="logo">HD <span>RENTCOS</span></a>

    <nav class="nav-links">
      <a href="{{ route('user.produk') }}" class="{{ request()->routeIs('user.sections.produk') ? 'active' : '' }}">Produk</a>
      <a href="{{ route('user.jadwalEvent') }}" class="{{ request()->routeIs('user.jadwalEvent') ? 'active' : '' }}">Jadwal Event</a>
      <a href="{{ route('user.wishlist') }}" class="{{ request()->routeIs('user.wishlist') ? 'active' : '' }}">Wishlist</a>
    </nav>

    <div class="search-box">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Search">
    </div>

    <div class="icons">
      <a href="Notifikasi.html"><i class="ri-notification-3-fill"></i></a>
      <a href="{{ route('cart.store') }}" class="{{ request()->routeIs('cart.store') ? 'active' : '' }}">
        <i class="ri-shopping-cart-fill"></i></a>
      <a href="pesan.html"><i class="ri-message-3-fill"></i></a>
    </div>

    <div class="profil">
      <!-- <a href="#" class="login">Login</a>
      <span>|</span>
      <a href="#" class="register">Register</a> -->
      <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
        <i class="ri-user-3-fill"></i></a>
    </div>
  </header>
