@extends('layouts.admin.app')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- HEADER --}}
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">

        <div>

            <h3 class="fw-bold mb-3">
                Dashboard
            </h3>

            <h6 class="op-7 mb-2">
                Sistem Ticketing
            </h6>

        </div>


        <div class="ms-md-auto py-2 py-md-0">

            <span class="text-muted">

                Selamat datang,
                {{ $akun->pegawai?->nama_pegawai ?? $akun->username }}

            </span>

        </div>

    </div>



    {{-- STATISTIK TIKET --}}
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

        {{-- TIKET BARU --}}
        <div class="col-sm-6 col-md-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div class="icon-big text-center icon-info bubble-shadow-small">

                                <i class="fas fa-plus-circle"></i>

                            </div>

                        </div>


                        <div class="col col-stats ms-3 ms-sm-0">

                            <div class="numbers">

                                <p class="card-category">
                                    Tiket Baru
                                </p>

                                <h4 class="card-title">

                                    {{ $tiketBaru }}

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

                                <i class="fas fa-user-cog"></i>

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

                                <i class="fas fa-clock"></i>

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

        {{-- PENDING --}}
        <div class="col-sm-6 col-md-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div class="icon-big text-center icon-secondary bubble-shadow-small">

                                <i class="fas fa-pause-circle"></i>

                            </div>

                        </div>


                        <div class="col col-stats ms-3 ms-sm-0">

                            <div class="numbers">

                                <p class="card-category">
                                    Pending
                                </p>

                                <h4 class="card-title">

                                    {{ $tiketPending }}

                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- MENUNGGU APPROVAL --}}
        <div class="col-sm-6 col-md-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div class="icon-big text-center icon-danger bubble-shadow-small">

                                <i class="fas fa-exclamation-circle"></i>

                            </div>

                        </div>


                        <div class="col col-stats ms-3 ms-sm-0">

                            <div class="numbers">

                                <p class="card-category">
                                    Menunggu Approval
                                </p>

                                <h4 class="card-title">

                                    {{ $tiketMenungguApproval }}

                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- TIKET SELESAI --}}
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
                                    Selesai / Ditutup
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

            <div class="card card-round">


                <div class="card-header">

                    <div class="card-head-row">

                        <div class="card-title">

                            Tiket Terbaru

                        </div>


                        <div class="card-tools">

                            <a href="{{ route('admin.tiket.index') }}" class="btn btn-primary btn-sm">

                                <i class="fas fa-list"></i>

                                Lihat Semua

                            </a>

                        </div>

                    </div>

                </div>



                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>

                                <tr>

                                    <th>No. Tiket</th>

                                    <th>Judul</th>

                                    <th>Pelapor</th>

                                    <th>Teknisi</th>

                                    <th>Status</th>

                                    <th>Tanggal</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($tiketTerbaru as $tiket)
                                    <tr>


                                        {{-- NOMOR TIKET --}}
                                        <td>

                                            <strong>

                                                {{ $tiket->nomor_tiket }}

                                            </strong>

                                        </td>



                                        {{-- JUDUL --}}
                                        <td>

                                            {{ $tiket->judul }}

                                        </td>



                                        {{-- PELAPOR --}}
                                        <td>

                                            {{ $tiket->pelapor?->nama_pegawai ?? '-' }}

                                        </td>



                                        {{-- TEKNISI --}}
                                        <td>

                                            {{ $tiket->teknisi?->nama_pegawai ?? '-' }}

                                        </td>



                                        {{-- STATUS --}}
                                        <td>

                                            @php

                                                $status = strtoupper($tiket->statusTiket?->nama_status ?? '');

                                            @endphp


                                            @if ($status === 'DITUTUP')
                                                <span class="badge bg-dark">

                                                    DITUTUP

                                                </span>
                                            @elseif ($status === 'SELESAI')
                                                <span class="badge bg-success">

                                                    SELESAI

                                                </span>
                                            @elseif ($status === 'MENUNGGU APPROVAL')
                                                <span class="badge bg-danger">

                                                    MENUNGGU APPROVAL

                                                </span>
                                            @elseif ($status === 'DIPROSES')
                                                <span class="badge bg-warning text-dark">

                                                    DIPROSES

                                                </span>
                                            @elseif ($status === 'DITUGASKAN')
                                                <span class="badge bg-info">

                                                    DITUGASKAN

                                                </span>
                                            @elseif ($status === 'PENDING')
                                                <span class="badge bg-secondary">

                                                    PENDING

                                                </span>
                                            @elseif ($status === 'MENUNGGU')
                                                <span class="badge bg-primary">

                                                    MENUNGGU

                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark">

                                                    {{ $tiket->statusTiket?->nama_status ?? '-' }}

                                                </span>
                                            @endif

                                        </td>



                                        {{-- TANGGAL --}}
                                        <td>

                                            {{ $tiket->created_at?->format('d M Y H:i') ?? '-' }}

                                        </td>


                                    </tr>


                                @empty


                                    <tr>

                                        <td colspan="6" class="text-center text-muted py-4">

                                            <i class="fas fa-ticket-alt me-2"></i>

                                            Belum ada data tiket.

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- GRAFIK DASHBOARD --}}
    <div class="row mt-4">

        {{-- BAR CHART --}}
        <div class="col-md-6">

            <div class="card card-round">

                <div class="card-header">

                    <div class="card-title">

                        Status Tiket

                    </div>

                </div>


                <div style="height: 350px;">
                    <canvas id="statusChart"></canvas>
                </div>

            </div>

        </div>


        {{-- DOUGHNUT CHART --}}
        <div class="col-md-6">

            <div class="card card-round">

                <div class="card-header">

                    <div class="card-title">

                        Distribusi Tiket

                    </div>

                </div>


                <div style="height: 350px;">
                    <canvas id="doughnutChart"></canvas>
                </div>

            </div>

        </div>

    </div>


    {{-- GRAFIK PER BULAN --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">
                        Tiket per Bulan Tahun {{ now()->year }}
                    </div>
                </div>
                <div style="height: 400px;">
                    <canvas id="bulanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const statusLabels = @json($statusTiketChart->pluck('nama_status')->values());
            const statusData = @json($statusTiketChart->pluck('total')->values());
            const statusChartElement =
                document.getElementById('statusChart');
            if (statusChartElement) {
                new Chart(
                    statusChartElement,
                    {
                        type: 'bar',
                        data: {
                            labels: statusLabels,
                            datasets: [
                                {
                                    label: 'Jumlah Tiket',
                                    data: statusData,
                                    borderWidth: 1,
                                }
                            ]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    }
                );
            }

            const doughnutChartElement =
                document.getElementById('doughnutChart');
            if (doughnutChartElement) {
                new Chart(
                    doughnutChartElement,
                    {
                        type: 'doughnut',
                        data: {
                            labels: statusLabels,
                            datasets: [
                                {
                                    data: statusData,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                }

                            }

                        }

                    }

                );

            }

            const bulanChartElement =
                document.getElementById('bulanChart');


            if (bulanChartElement) {

                new Chart(

                    bulanChartElement,

                    {

                        type: 'line',

                        data: {

                            labels: @json($namaBulan),

                            datasets: [

                                {

                                    label: 'Jumlah Tiket',

                                    data: @json($dataPerBulan),

                                    tension: 0.4,

                                    fill: false,

                                }

                            ]

                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0,
                                    }
                                }
                            }
                        }
                    }
                );
            }
        </script>
    @endpush
@endsection
