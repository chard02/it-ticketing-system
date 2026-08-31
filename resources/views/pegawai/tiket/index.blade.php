@extends('layouts.pegawai.app')

@section('title', 'Tiket Saya')

@section('content')

    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Tiket Saya
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
                Tiket Saya
            </li>

        </ul>

    </div>


    {{-- HEADER --}}
    <div class="card">

        <div class="card-header">

            <div class="card-head-row">

                <div class="card-title">
                    Daftar Tiket Saya
                </div>

                <div class="card-tools">

                    <a href="{{ route('pegawai.tiket.create') }}" class="btn btn-primary btn-round btn-sm">

                        <i class="fas fa-plus me-1"></i>

                        Buat Tiket

                    </a>

                </div>

            </div>

        </div>


        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">

                    <i class="fas fa-check-circle me-2"></i>

                    {{ session('success') }}

                </div>
            @endif


            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th width="50">
                                #
                            </th>

                            <th>
                                Nomor Tiket
                            </th>

                            <th>
                                Judul
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th>
                                Prioritas
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Teknisi
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th width="80">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($tiket as $item)
                            <tr>

                                <td>
                                    {{ $tiket->firstItem() + $loop->index }}
                                </td>

                                <td>

                                    <span class="fw-bold">
                                        {{ $item->nomor_tiket }}
                                    </span>

                                </td>

                                <td>

                                    {{ $item->judul }}

                                </td>

                                <td>

                                    {{ $item->kategoriTiket->nama_kategori ?? '-' }}

                                </td>

                                <td>

                                    @if ($item->prioritasTiket)
                                        <span class="badge bg-warning">

                                            {{ $item->prioritasTiket->nama_prioritas }}

                                        </span>
                                    @else
                                        <span class="text-muted">
                                            Belum ditentukan
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    @php
                                        $status = $item->statusTiket->nama_status ?? '-';

                                        $badge = match ($status) {
                                            'BARU' => 'bg-primary',
                                            'DITUGASKAN' => 'bg-info',
                                            'DIPROSES' => 'bg-info',
                                            'PENDING' => 'bg-warning',
                                            'MENUNGGU KONFIRMASI' => 'bg-warning',
                                            'SELESAI' => 'bg-success',
                                            'DIBUKA KEMBALI' => 'bg-danger',
                                            'DITUTUP' => 'bg-secondary',
                                            'DIBATALKAN' => 'bg-dark',
                                            default => 'bg-secondary',
                                        };
                                    @endphp

                                    <span class="badge {{ $badge }}">

                                        {{ $status }}

                                    </span>

                                </td>

                                <td>

                                    @if ($item->teknisi)
                                        {{ $item->teknisi->nama }}
                                    @else
                                        <span class="text-muted">
                                            Belum ditugaskan
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    {{ $item->created_at->format('d/m/Y H:i') }}

                                </td>

                                <td>

                                    <a href="{{ route('pegawai.tiket.show', $item) }}" class="btn btn-sm btn-primary">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9">

                                    <div class="text-center py-5">

                                        <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>

                                        <h5>
                                            Belum ada tiket
                                        </h5>

                                        <p class="text-muted">
                                            Kamu belum membuat tiket.
                                        </p>

                                        <a href="{{ route('pegawai.tiket.create') }}" class="btn btn-primary">

                                            <i class="fas fa-plus me-1"></i>

                                            Buat Tiket

                                        </a>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($tiket->hasPages())
                <div class="mt-3">

                    {{ $tiket->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
