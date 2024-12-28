<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('logout') }}" class="d-block">{{ auth()->user()->name  }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">

            <li class="nav-item">
                <a href="{{ route('dashboardadmin') }}" class="nav-link {{ request()->routeIs('dashboardadmin') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>{{ __('Users') }}</p>
                </a>
            </li>

            <li class="nav-item has-submenu">
                <a href="javascript:void(0)" class="nav-link {{ request()->routeIs('purchase_orders.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-circle nav-icon"></i>
                    <p>
                        Pembelian (FBF)
                        <i class="fas fa-angle-down right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview submenu" style="display: {{ request()->routeIs('purchase_orders.*') ? 'block' : 'none' }};">
                    <li class="nav-item">
                        <a href="{{ route('purchase_orders.create') }}" class="nav-link {{ request()->routeIs('purchase_orders.create') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Pembelian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('purchase_orders.index') }}" class="nav-link {{ request()->routeIs('purchase_orders.index') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Produk</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="javascript:void(0)" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-circle nav-icon"></i>
                    <p>
                       Penjualan Produk
                       <i class="fas fa-angle-down right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview submenu" style="display: {{ request()->routeIs('transactions.*') ? 'block' : 'none' }};">
                    <li class="nav-item">
                        <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Order</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transactions.status') }}" class="nav-link {{ request()->routeIs('transactions.status') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Pengiriman</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="javascript:void(0)" class="nav-link {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-circle nav-icon"></i>
                    <p>
                        Managemen Produk
                        <i class="fas fa-angle-down right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview submenu" style="display: {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'block' : 'none' }};">
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Produk</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="javascript:void(0)" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-circle nav-icon"></i>
                    <p>
                        Managemen Laporan
                        <i class="fas fa-angle-down right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview submenu" style="display: {{ request()->routeIs('reports.*') ? 'block' : 'none' }};">
                    <li class="nav-item">
                        <a href="{{ route('reports.monthlySales') }}" class="nav-link {{ request()->routeIs('reports.monthlySales') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Keuntungan Penjualan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.monthlyProduct') }}" class="nav-link {{ request()->routeIs('reports.monthlyProduct') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Total Penjualan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.monthly_stock') }}" class="nav-link {{ request()->routeIs('reports.monthly_stock') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Stok Produk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.monthly-transactions') }}" class="nav-link {{ request()->routeIs('reports.monthly-transactions') ? 'active' : '' }}">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Transaksi Penjualan</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="javascript:void(0)" class="nav-link {{ request()->routeIs('logout') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        Pengaturan
                        <i class="fas fa-angle-down right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview submenu" style="display: {{ request()->routeIs('logout') ? 'block' : 'none' }};">
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Log out</p>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<!-- JavaScript untuk Dropdown -->
<script>
    document.querySelectorAll('.has-submenu > a').forEach(function(element) {
        element.addEventListener('click', function() {
            var submenu = this.nextElementSibling;
            submenu.style.display = submenu.style.display === 'none' || submenu.style.display === '' ? 'block' : 'none';
        });
    });
</script>
