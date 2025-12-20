<div class="dashboard-container">
    <aside class="sidebar">
        <h1 class="logo">HDRENTCOS</h1>
            <nav class="nav-menu">
                <ul>
                    <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dasbor</a></li>
                    <li class="{{ request()->routeIs('admin.produk') ? 'active' : '' }}"><a href="{{ route('admin.produk') }}"><i class="fas fa-box"></i> Produk</a></li>
                    <li class="{{ request()->routeIs('admin.event.index') ? 'active' : '' }}"><a href="{{ route('admin.event.index') }}"><i class="fas fa-calendar-alt"></i> Event</a></li>
                    <li class="{{ request()->routeIs('admin.pesanan') ? 'active' : '' }}"><a href="{{ route('admin.pesanan') }}"><i class="fas fa-file-alt"></i> Pesanan</a></li>
                    <li class="{{ request()->routeIs('admin.pengembalian.index') ? 'active' : '' }}"><a href="{{ route('admin.pengembalian.index') }}"><i class="fas fa-undo-alt"></i> Pengembalian</a></li>
                    <li class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"><a href="{{ route('admin.users') }}"><i class="fas fa-user-friends"></i> User</a></li>
                    <li class="{{ request()->routeIs('admin.pesan') ? 'active' : '' }}"><a href="{{ route('admin.pesan') }}"><i class="fas fa-envelope"></i> Pesan</a></li>
                    <li class="{{ request()->routeIs('admin.iotControl') ? 'active' : '' }}"><a href="{{ route('admin.iotControl') }}"><i class="fa-solid fa-wrench"></i> IoT Control</a></li>
                    <li class="logout-item">
                        <form action="{{ route('admin.logout') }}" method="POST" class="logout-form"
                            onsubmit="return confirm('Apakah Anda yakin ingin logout?')">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
    </aside>
</div>
