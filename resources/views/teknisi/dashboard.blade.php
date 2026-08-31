@extends('layouts.teknisi.app')

@section('title', 'Dashboard Teknisi')

@section('content')

    <div class="page-inner">

        <div class="page-header">
            <h3 class="fw-bold mb-3">Dashboard Teknisi</h3>

            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('teknisi.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>

                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>

                <li class="nav-item">
                    <a href="#">Dashboard</a>
                </li>
            </ul>
        </div>


        {{-- STATISTIK --}}
        <div class="row">

            {{-- TOTAL TIKET --}}
            <div class="col-sm-6 col-md-3">

                <div class="card card-stats card-round">

                    <div class="card-body">

                        <div class="row align-items-center">

                            <div class="col-icon">

                                <div class="icon-big text-center icon-primary bubble-shadow-small">

                                    <i class="fas fa-ticket-alt"></i>

                                </div>

                            </div>


                            <div class="col col-stats ms-3 ms-sm-0">

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


            {{-- DITUGASKAN --}}
            <div class="col-sm-6 col-md-3">

                <div class="card card-stats card-round">

                    <div class="card-body">

                        <div class="row align-items-center">

                            <div class="col-icon">

                                <div class="icon-big text-center icon-info bubble-shadow-small">

                                    <i class="fas fa-user-check"></i>

                                </div>

                            </div>


                            <div class="col col-stats ms-3 ms-sm-0">

                                <div class="numbers">

                                    <p class="card-category">
                                        Ditugaskan
                                    </p>

                                    <h4 class="card-title">
                                        {{ $tiketDitugaskan }}
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

                                <div class="icon-big text-center icon-warning bubble-shadow-small">

                                    <i class="fas fa-tools"></i>

                                </div>

                            </div>


                            <div class="col col-stats ms-3 ms-sm-0">

                                <div class="numbers">

                                    <p class="card-category">
                                        Diproses
                                    </p>

                                    <h4 class="card-title">
                                        {{ $tiketDiproses }}
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


                            <div class="col col-stats ms-3 ms-sm-0">

                                <div class="numbers">

                                    <p class="card-category">
                                        Selesai
                                    </p>

                                    <h4 class="card-title">
                                        {{ $tiketSelesai }}
                                    </h4>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TIKET TERBARU --}}
        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">

                        <div class="card-title">
                            Tiket Terbaru
                        </div>

                    </div>


                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>No.</th>

                                        <th>Nomor Tiket</th>

                                        <th>Judul</th>

                                        <th>Pelapor</th>

                                        <th>Prioritas</th>

                                        <th>Status</th>

                                        <th>Tanggal</th>

                                        <th>Aksi</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($tiketTerbaru as $index => $tiket)
                                        <tr>

                                            <td>
                                                {{ $index + 1 }}
                                            </td>


                                            <td>

                                                <strong>
                                                    {{ $tiket->nomor_tiket }}
                                                </strong>

                                            </td>


                                            <td>

                                                {{ $tiket->judul }}

                                            </td>


                                            <td>

                                                {{ $tiket->pelapor?->nama ?? '-' }}

                                            </td>


                                            <td>

                                                @if ($tiket->prioritasTiket)
                                                    <span class="badge bg-secondary">

                                                        {{ $tiket->prioritasTiket->nama_prioritas }}

                                                    </span>
                                                @else
                                                    <span class="text-muted">
                                                        -
                                                    </span>
                                                @endif

                                            </td>


                                            <td>

                                                @php

                                                    $status = $tiket->statusTiket?->nama_status ?? '-';

                                                @endphp


                                                @if ($status === 'DITUGASKAN')
                                                    <span class="badge bg-info">

                                                        {{ $status }}

                                                    </span>
                                                @elseif($status === 'DIPROSES')
                                                    <span class="badge bg-warning text-dark">

                                                        {{ $status }}

                                                    </span>
                                                @elseif($status === 'SELESAI')
                                                    <span class="badge bg-success">

                                                        {{ $status }}

                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">

                                                        {{ $status }}

                                                    </span>
                                                @endif

                                            </td>


                                            <td>

                                                {{ $tiket->created_at?->format('d M Y H:i') }}

                                            </td>


                                            <td>

                                                <a href="{{ route('teknisi.tiket.show', $tiket->id) }}"
                                                    class="btn btn-sm btn-primary">

                                                    <i class="fas fa-eye"></i>

                                                    Detail

                                                </a>

                                            </td>

                                        </tr>


                                    @empty

                                        <tr>

                                            <td colspan="8" class="text-center text-muted py-4">

                                                <i class="fas fa-inbox fa-2x mb-2"></i>

                                                <br>

                                                Belum ada tiket yang ditugaskan kepada Anda.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>


                    @if ($totalTiket > 5)
                        <div class="card-footer text-end">

                            <a href="{{ route('teknisi.tiket.index') }}" class="btn btn-primary btn-sm">

                                Lihat Semua Tiket

                                <i class="fas fa-arrow-right"></i>

                            </a>

                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection
