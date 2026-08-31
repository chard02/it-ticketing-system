<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
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
                {{-- Dashboard --}}
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">
                        MENU UTAMA
                    </h4>
                </li>

                {{-- Manajemen Tiket --}}
                <li class="nav-item {{ request()->routeIs('admin.tiket.*') ? 'active' : '' }}">

                    <a href="{{ route('admin.tiket.index') }}">

                        <i class="fas fa-ticket-alt"></i>

                        <p>Manajemen Tiket</p>

                    </a>

                </li>


                {{-- Pegawai --}}
                <li class="nav-item">

                    <a href="{{ route('pegawai.index') }}">

                        <i class="fas fa-users"></i>

                        <p>Data Pegawai</p>

                    </a>

                </li>


                {{-- Master Data --}}
                <li class="nav-item">

                    <a data-bs-toggle="collapse" href="#masterData">

                        <i class="fas fa-database"></i>

                        <p>Master Data</p>

                        <span class="caret"></span>

                    </a>


                    <div class="collapse" id="masterData">

                        <ul class="nav nav-collapse">

                            <li>
                                <a href="{{ route('unit.index') }}">
                                    <span class="sub-item">
                                        Unit
                                    </span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('sub-unit.index') }}">
                                    <span class="sub-item">
                                        Sub Unit
                                    </span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('divisi.index') }}">
                                    <span class="sub-item">
                                        Divisi
                                    </span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('jabatan.index') }}">
                                    <span class="sub-item">
                                        Jabatan
                                    </span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('level.index') }}">
                                    <span class="sub-item">
                                        Level
                                    </span>
                                </a>
                            </li>

                        </ul>

                    </div>

                </li>

                {{-- Master Data --}}
                <li class="nav-item">

                    <a data-bs-toggle="collapse" href="#pengaturan">

                        <i class="fas fa-cog"></i>

                        <p>Setting</p>

                        <span class="caret"></span>

                    </a>


                    <div class="collapse" id="pengaturan">

                        <ul class="nav nav-collapse">

                            <li>
                                <a href="{{ route('admin.jenis-tiket.index') }}">
                                    <span class="sub-item">
                                        Jenis Tiket
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.kategori-tiket.index') }}">

                                    <span class="sub-item">
                                        Kategori Tiket
                                    </span>

                                </a>
                            </li>

                            <li>
                            <li>
                                <a href="{{ route('admin.sub-kategori-tiket.index') }}">

                                    <span class="sub-item">
                                        Sub Kategori Tiket
                                    </span>

                                </a>
                            </li>
                </li>

            </ul>

        </div>

        </li>

        </ul>

    </div>

</div>

</div>
