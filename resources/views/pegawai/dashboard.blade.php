@extends('layouts.pegawai.app')

@section('title', 'Dashboard')

@section('content')

    {{-- HEADER --}}
    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Dashboard
        </h3>

        <ul class="breadcrumbs mb-3">

            <li class="nav-home">
                <a href="{{ route('dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>

            <li class="nav-item">
                Dashboard
            </li>

        </ul>

    </div>


    {{-- SAPAAN --}}
    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="fw-bold">
                        Halo, {{ $pegawai->nama }} 👋
                    </h4>

                    <p class="text-muted mb-0">
                        Selamat datang di sistem IT Ticketing.
                        Silakan buat tiket jika membutuhkan bantuan IT.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- STATISTIK --}}
    <div class="row">

        {{-- TOTAL --}}
        <div class="col-sm-6 col-md-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div class="icon-big text-center icon-primary bubble-shadow-small">

                                <i class="fas fa-ticket-alt"></i>

                            </div>

                        </div>

                        <div class="col col-stats ms-3">

                            <div class="numbers">

                                <p class="card-category">
                                    Total Tiket
                                </p>

                                <h4 class="card-title">
                                    {{ $totalTiket }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- MENUNGGU --}}
        <div class="col-sm-6 col-md-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div class="icon-big text-center icon-warning bubble-shadow-small">

                                <i class="fas fa-clock"></i>

                            </div>

                        </div>

                        <div class="col col-stats ms-3">

                            <div class="numbers">

                                <p class="card-category">
                                    Menunggu
                                </p>

                                <h4 class="card-title">
                                    {{ $menunggu }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- DIPROSES --}}
        <div class="col-sm-6 col-md-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div class="icon-big text-center icon-info bubble-shadow-small">

                                <i class="fas fa-spinner"></i>

                            </div>

                        </div>

                        <div class="col col-stats ms-3">

                            <div class="numbers">

                                <p class="card-category">
                                    Diproses
                                </p>

                                <h4 class="card-title">
                                    {{ $diproses }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- SELESAI --}}
        <div class="col-sm-6 col-md-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div class="icon-big text-center icon-success bubble-shadow-small">

                                <i class="fas fa-check-circle"></i>

                            </div>

                        </div>

                        <div class="col col-stats ms-3">

                            <div class="numbers">

                                <p class="card-category">
                                    Selesai
                                </p>

                                <h4 class="card-title">
                                    {{ $selesai }}
                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TIKET TERBARU + AKSI --}}
    <div class="row">

        {{-- TIKET TERBARU --}}
        <div class="col-md-8">

            <div class="card card-round">

                <div class="card-header">

                    <div class="card-head-row">

                        <div class="card-title">
                            Tiket Terbaru
                        </div>

                    </div>

                </div>


                <div class="card-body">

                    @forelse ($tiketTerbaru as $tiket)
                        <div class="d-flex align-items-center mb-3">

                            <div class="avatar avatar-sm">

                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="fas fa-ticket-alt"></i>
                                </span>

                            </div>


                            <div class="flex-1 ms-3">

                                <h6 class="fw-bold mb-1">

                                    {{ $tiket->nomor_tiket }}

                                </h6>

                                <p class="text-muted mb-0">

                                    {{ $tiket->judul }}

                                </p>

                            </div>


                            <div>

                                <span class="badge bg-secondary">

                                    {{ $tiket->statusTiket->nama_status ?? '-' }}

                                </span>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-4">

                            <i class="fas fa-ticket-alt fa-2x text-muted mb-3"></i>

                            <p class="text-muted mb-0">

                                Belum ada tiket.

                            </p>

                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    </div>

@endsection
```
