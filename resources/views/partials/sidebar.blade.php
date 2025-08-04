<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><img src="{{ asset('assets/img/icons/dashboard.svg') }}"
                            alt="img" /><span>
                            Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->is('costumer') ? 'active' : '' }}">
                    <a href="{{ route('costumer.index') }}"><img src="{{ asset('assets/img/icons/users1.svg') }}"
                            alt="img" /><span>
                            Costumer</span>
                    </a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img" /><span>
                            Product</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('category.index') }}">Category</a></li>
                        <li><a href="{{route('category.create')}}">Tambah Category</a></li>
                        <li><a href="{{ route('product.index') }}">Product</a></li>
                        <li><a href="{{route('product.create')}}">Tambah Product</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="/assets/img/icons/purchase1.svg" alt="img" /><span>
                            Pengadaan Barang</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('pengadaan.index') }}">Pengadaan</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="/assets/img/icons/sales1.svg" alt="img" /><span>
                            Penjualan</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('transaction.index') }}">Transaksi</a></li>
                        <li><a href="{{ route('pos') }}">POS</a></li>
                    </ul>
                </li>
                <li class="{{ request()->is('debt') ? 'active' : '' }}">
                    <a href="{{ route('debt.index') }}"><img src="{{ asset('/assets/img/icons/purchase1.svg') }}"
                            alt="img" /><span>
                            Data Hutang</span>
                    </a>
                </li>
                <li class="{{ request()->is('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}"><img src="{{ asset('/assets/img/icons/users1.svg') }}"
                            alt="img" /><span>
                            Profil</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
