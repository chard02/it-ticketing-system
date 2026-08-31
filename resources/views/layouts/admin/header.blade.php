<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
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
        <!-- End Logo Header -->
    </div>


    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">

        <div class="container-fluid">

            <!-- Search Desktop -->
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">

                <div class="input-group">

                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-search pe-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>

                    <input type="text" placeholder="Cari..." class="form-control" />

                </div>

            </nav>


            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">


                <!-- Search Mobile -->
                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">

                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">
                        <i class="fa fa-search"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-search animated fadeIn">

                        <li>
                            <form class="navbar-left navbar-form nav-search">

                                <div class="input-group">

                                    <input type="text" placeholder="Cari..." class="form-control" />

                                </div>

                            </form>
                        </li>

                    </ul>

                </li>


                <!-- Pesan -->
                <li class="nav-item topbar-icon dropdown hidden-caret">

                    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-envelope"></i>
                    </a>

                    <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">

                        <li>

                            <div class="dropdown-title">
                                Pesan
                            </div>

                        </li>

                        <li>

                            <div class="message-notif-scroll scrollbar-outer">

                                <div class="notif-center">

                                    <div class="text-center p-3 text-muted">
                                        Belum ada pesan.
                                    </div>

                                </div>

                            </div>

                        </li>

                    </ul>

                </li>


                @php
                    $akunLogin = auth()->user();

                    $notifikasiBelumDibaca = $akunLogin
                        ? $akunLogin->unreadNotifications()->latest()->take(10)->get()
                        : collect();

                    $jumlahNotifikasi = $akunLogin ? $akunLogin->unreadNotifications()->count() : 0;
                @endphp


                <li class="nav-item topbar-icon dropdown hidden-caret">

                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <i class="fa fa-bell"></i>

                        @if ($jumlahNotifikasi > 0)
                            <span class="notification">
                                {{ $jumlahNotifikasi > 99 ? '99+' : $jumlahNotifikasi }}
                            </span>
                        @endif

                    </a>


                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">

                        <li>

                            <div class="dropdown-title">

                                @if ($jumlahNotifikasi > 0)
                                    Anda memiliki
                                    {{ $jumlahNotifikasi }}
                                    notifikasi baru
                                @else
                                    Tidak ada notifikasi baru
                                @endif

                            </div>

                        </li>


                        <li>

                            <div class="notif-scroll scrollbar-outer">

                                <div class="notif-center">


                                    @forelse($notifikasiBelumDibaca as $notification)
                                        <form action="{{ route('notifications.read', $notification->id) }}"
                                            method="POST" class="m-0">

                                            @csrf

                                            <button type="submit" class="w-100 text-start border-0 bg-transparent p-0">

                                                <div class="d-flex align-items-center px-3 py-2">

                                                    {{-- ICON --}}
                                                    <div class="notif-icon notif-primary">

                                                        <i class="fa fa-bell"></i>

                                                    </div>


                                                    {{-- CONTENT --}}
                                                    <div class="notif-content">

                                                        <span class="block">

                                                            {{ $notification->data['message'] ?? 'Anda memiliki notifikasi baru' }}

                                                        </span>


                                                        <span class="time">

                                                            {{ $notification->created_at->diffForHumans() }}

                                                        </span>

                                                    </div>

                                                </div>

                                            </button>

                                        </form>


                                    @empty


                                        <div class="text-center text-muted p-4">

                                            <i class="fa fa-bell-slash mb-2"></i>

                                            <br>

                                            Tidak ada notifikasi baru.

                                        </div>
                                    @endforelse


                                </div>

                            </div>

                        </li>


                        <li>

                            <a class="see-all" href="{{ url('/notifications') }}">

                                Lihat semua notifikasi

                                <i class="fa fa-angle-right"></i>

                            </a>

                        </li>

                    </ul>

                </li>


                <!-- Quick Actions -->
                <li class="nav-item topbar-icon dropdown hidden-caret">

                    <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                    </a>


                    <div class="dropdown-menu quick-actions animated fadeIn">

                        <div class="quick-actions-header">

                            <span class="title mb-1">
                                Menu Cepat
                            </span>

                            <span class="subtitle op-7">
                                Shortcut
                            </span>

                        </div>


                        <div class="quick-actions-scroll scrollbar-outer">

                            <div class="quick-actions-items">

                                <div class="row m-0">

                                    <a class="col-6 col-md-4 p-0" href="{{ route('dashboard') }}">

                                        <div class="quick-actions-item">

                                            <div class="avatar-item bg-primary rounded-circle">

                                                <i class="fas fa-home"></i>

                                            </div>

                                            <span class="text">
                                                Dashboard
                                            </span>

                                        </div>

                                    </a>


                                    <a class="col-6 col-md-4 p-0" href="#">

                                        <div class="quick-actions-item">

                                            <div class="avatar-item bg-success rounded-circle">

                                                <i class="fas fa-ticket-alt"></i>

                                            </div>

                                            <span class="text">
                                                Tiket
                                            </span>

                                        </div>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </li>


                <!-- User -->
                <li class="nav-item topbar-user dropdown hidden-caret">

                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">

                        <div class="avatar-sm">

                            <img src="{{ asset('img/profile.jpg') }}" alt="Profile"
                                class="avatar-img rounded-circle" />

                        </div>


                        <span class="profile-username">

                            <span class="op-7">
                                Hi,
                            </span>

                            <span class="fw-bold">

                                {{ auth()->user()->pegawai->nama_pegawai ?? auth()->user()->username }}

                            </span>

                        </span>

                    </a>


                    <ul class="dropdown-menu dropdown-user animated fadeIn">

                        <div class="dropdown-user-scroll scrollbar-outer">

                            <li>

                                <div class="user-box">

                                    <div class="avatar-lg">

                                        <img src="{{ asset('img/profile.jpg') }}" alt="Profile"
                                            class="avatar-img rounded" />

                                    </div>


                                    <div class="u-text">

                                        <h4>

                                            {{ auth()->user()->pegawai->nama_pegawai ?? auth()->user()->username }}

                                        </h4>


                                        <p class="text-muted">

                                            {{ auth()->user()->level->nama_level ?? 'User' }}

                                        </p>


                                        <a href="#" class="btn btn-xs btn-secondary btn-sm">
                                            Lihat Profil
                                        </a>

                                    </div>

                                </div>

                            </li>


                            <li>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="#">
                                    Profil Saya
                                </a>


                                <a class="dropdown-item" href="#">
                                    Pengaturan Akun
                                </a>


                                <div class="dropdown-divider"></div>


                                <!-- Logout -->
                                <form action="{{ route('logout') }}" method="POST">

                                    @csrf

                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>

                                        Logout
                                    </button>

                                </form>

                            </li>

                        </div>

                    </ul>

                </li>

            </ul>

        </div>
    </nav>
    <!-- End Navbar -->
</div>
