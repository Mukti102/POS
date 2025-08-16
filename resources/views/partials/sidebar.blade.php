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
                <li class="{{ request()->is('pos') ? 'active' : '' }}">
                    <a href="{{ route('pos') }}"><img src="{{ asset('assets/img/icons/quotation1.svg') }}"
                            alt="img" /><span>
                            POS</span>
                    </a>
                </li>

                @if (auth()->user()->role == 'superadmin')
                    <li class="{{ request()->is('cabang*') ? 'active' : '' }}">
                        <a href="{{ route('cabang.index') }}"><img src="{{ asset('assets/img/icons/places.svg') }}"
                                alt="img" /><span>
                                Cabang</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('user') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}"><img src="{{ asset('assets/img/icons/users1.svg') }}"
                                alt="img" /><span>
                                User</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('costumer*') ? 'active' : '' }}">
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
                            <li><a href="{{ route('category.index') }}" class="{{ request()->is('category*') ? 'active' : '' }}">Category</a></li>
                            <li><a href="{{ route('product.index') }}" class="{{ request()->is('product*') ? 'active' : '' }}">Product</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="javascript:void(0);"><img src="/assets/img/icons/purchase1.svg" alt="img" /><span>
                                Pengadaan Barang</span>
                            <span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('pengadaan.index') }}" class="{{ request()->is('pengadaan*') ? 'active' : '' }}">Pengadaan</a></li>
                        </ul>
                    </li>
                    <li class="{{ request()->is('mutasi-stock*') ? 'active' : '' }}">
                        <a href="{{ route('mutasi-stock.index') }}"><img src="{{ asset('assets/img/icons/transfer1.svg') }}"
                                alt="img" /><span>
                                Transfer</span>
                        </a>
                    </li>
                    <li class="submenu">
                        <a href="javascript:void(0);"><img src="/assets/img/icons/sales1.svg" alt="img" /><span>
                                Penjualan</span>
                            <span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('transaction.index') }}" class="{{ request()->is('transaction*') ? 'active' : '' }}">Transaksi</a></li>
                            <li><a href="{{ route('pos') }}">POS</a></li>
                        </ul>
                    </li>
                    <li class="{{ request()->is('debt') ? 'active' : '' }}">
                        <a href="{{ route('debt.index') }}"><img src="{{ asset('/assets/img/icons/purchase1.svg') }}"
                                alt="img" /><span>
                                Data Hutang</span>
                        </a>
                    </li>
                @endif

                <li class="{{ request()->is('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}"><img src="{{ asset('/assets/img/icons/users1.svg') }}"
                            alt="img" /><span>
                            Profil</span>
                    </a>
                </li>
                <li class="{{ request()->is('setting') ? 'active' : '' }}">
                    <a href="{{ route('setting.index') }}"><img src="{{ asset('/assets/img/icons/settings.svg') }}"
                            alt="img" /><span>
                            Setting</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
