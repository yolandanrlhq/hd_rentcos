<div class="dashboard-container">
    <aside class="sidebar">
        <h1 class="logo">HDRENTCOS</h1>
            <nav class="nav-menu">
                <ul>
                    <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dasbor</a></li>
                    <li class="{{ request()->routeIs('admin.produk') ? 'active' : '' }}"><a href="{{ route('admin.produk') }}"><i class="fas fa-box"></i> Produk</a></li>
                    <li class="{{ request()->routeIs('admin.jadwalEvent') ? 'active' : '' }}"><a href="{{ route('admin.jadwalEvent') }}"><i class="fas fa-calendar-alt"></i> Event</a></li>
                    <li class="{{ request()->routeIs('admin.pesanan') ? 'active' : '' }}"><a href="{{ route('admin.pesanan') }}"><i class="fas fa-file-alt"></i> Pesanan</a></li>
                    <li class="{{ request()->routeIs('admin.user') ? 'active' : '' }}"><a href="{{ route('admin.user') }}"><i class="fas fa-user-friends"></i> User</a></li>
                    <li class="{{ request()->routeIs('admin.pesan') ? 'active' : '' }}"><a href="{{ route('admin.pesan') }}"><i class="fas fa-envelope"></i> Pesan</a></li>
                    <li class="{{ request()->routeIs('admin.produk') ? 'active' : '' }}"><a href="{{ route('admin.produk') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
    </aside>
</div>
