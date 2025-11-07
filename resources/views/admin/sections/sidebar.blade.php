{{-- resources/views/admin/sections/header.blade.php --}}
<div class="container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2 class="logo">HDRENTCOS</h2>
    <nav>
      <ul>
        <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
          <span>🏠</span> <a href="{{ route('admin.dashboard') }}">Dasbor</a>
        </li>
        <li>
          <span>📦</span>
          <a href="{{ route('admin.produk') }}" class="{{ request()->routeIs('admin.produk') ? 'active' : '' }}">Produk</a>
        </li>
        <li><span>🎉</span> <a href="#">Event</a></li>
        <li><span>🧾</span> <a href="#">Pesanan</a></li>
        <li><span>👤</span> <a href="#">User</a></li>
        <li>
          <span>🔒</span>
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">Logout</button>
          </form>
        </li>
      </ul>
    </nav>
  </aside>
</div>
