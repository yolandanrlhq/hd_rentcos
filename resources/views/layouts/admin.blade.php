<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'HDRENTCOS Dashboard')</title>
  <link rel="stylesheet" href="{{ asset('css/berandaAdmin.css') }}">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo">HDRENTCOS</h2>
      <nav>
        <ul>
          <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <span>🏠</span> <a href="{{ route('admin.dashboard') }}">Dasbor</a>
          </li>
          <li><span>📦</span> <a href="#">Produk</a></li>
          <li><span>🎉</span> <a href="#">Event</a></li>
          <li><span>🧾</span> <a href="#">Pesanan</a></li>
          <li><span>👤</span> <a href="#">User</a></li>
          <li><span>🔒</span>
            <form method="POST" action="{{ route('admin.logout') }}">
              @csrf
              <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">Logout</button>
            </form>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main">
      @yield('content')
    </main>
  </div>
</body>
</html>
