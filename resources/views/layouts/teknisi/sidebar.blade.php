<div class="sidebar" data-background-color="dark">

    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">

            <a href="{{ route('teknisi.dashboard') }}" class="logo">
                <img src="{{ asset('img/kaiadmin/logo_light.svg') }}" alt="Ticketing System" class="navbar-brand"
                    height="20" />
            </a>

            <div class="nav-toggle">

                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>

                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>

            </div>

            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>

        </div>
    </div>


    <div class="sidebar-wrapper scrollbar scrollbar-inner">

        <div class="sidebar-content">

            <ul class="nav nav-secondary">


                {{-- ===================================================== --}}
                {{-- DASHBOARD --}}
                {{-- ===================================================== --}}

                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                    <a href="{{ route('dashboard') }}">

                        <i class="fas fa-home"></i>

                        <p>Dashboard</p>

                    </a>

                </li>


                {{-- ===================================================== --}}
                {{-- MENU UTAMA --}}
                {{-- ===================================================== --}}

                <li class="nav-section">

                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>

                    <h4 class="text-section">
                        MENU UTAMA
                    </h4>

                </li>


                {{-- ===================================================== --}}
                {{-- BUAT TIKET --}}
                {{-- ===================================================== --}}

                <li class="nav-item {{ request()->routeIs('pegawai.tiket.create') ? 'active' : '' }}">

                    <a href="{{ route('pegawai.tiket.index') }}">

                        <i class="fas fa-plus-circle"></i>

                        <p>Buat Tiket</p>

                    </a>

                </li>


                {{-- ===================================================== --}}
                {{-- TIKET SAYA --}}
                {{-- ===================================================== --}}

                <li class="nav-item {{ request()->routeIs('pegawai.tiket.index') ? 'active' : '' }}">

                    <a href="{{ route('pegawai.tiket.index') }}">

                        <i class="fas fa-ticket-alt"></i>

                        <p>Tiket Saya</p>

                    </a>

                </li>


                {{-- ===================================================== --}}
                {{-- RIWAYAT TIKET --}}
                {{-- ===================================================== --}}

                <li class="nav-item {{ request()->routeIs('pegawai.tiket.riwayat') ? 'active' : '' }}">

                    <a href="#">

                        <i class="fas fa-history"></i>

                        <p>Riwayat Tiket</p>

                    </a>

                </li>


                {{-- ===================================================== --}}
                {{-- AKUN --}}
                {{-- ===================================================== --}}

                <li class="nav-section">

                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>

                    <h4 class="text-section">
                        AKUN
                    </h4>

                </li>


                {{-- ===================================================== --}}
                {{-- PROFIL --}}
                {{-- ===================================================== --}}

                <li class="nav-item {{ request()->routeIs('pegawai.profil') ? 'active' : '' }}">

                    <a href="#">

                        <i class="fas fa-user"></i>

                        <p>Profil</p>

                    </a>

                </li>


            </ul>

        </div>

    </div>

</div>
