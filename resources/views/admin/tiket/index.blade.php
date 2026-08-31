@extends('layouts.admin.app')

@section('title', 'Manajemen Tiket')

@section('content')

    {{-- HEADER --}}
    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Manajemen Tiket
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
                Manajemen Tiket
            </li>

        </ul>

    </div>


    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif


    <div class="card">

        {{-- HEADER CARD --}}
        <div class="card-header">

            <div class="card-head-row">

                <div class="card-title">

                    Daftar Tiket

                </div>

            </div>

        </div>


        <div class="card-body">

            {{-- FILTER --}}
            <form method="GET" action="{{ route('admin.tiket.index') }}">

                <div class="row mb-4">

                    {{-- SEARCH --}}
                    <div class="col-md-4 mb-2">

                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nomor, judul, atau pelapor..." value="{{ request('search') }}">

                    </div>


                    {{-- STATUS --}}
                    <div class="col-md-3 mb-2">

                        <select name="status" class="form-select">

                            <option value="">
                                Semua Status
                            </option>

                            @foreach ($statusTiket as $status)
                                <option value="{{ $status->id }}" @selected(request('status') == $status->id)>

                                    {{ $status->nama_status }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- PRIORITAS --}}
                    <div class="col-md-3 mb-2">

                        <select name="prioritas" class="form-select">

                            <option value="">
                                Semua Prioritas
                            </option>

                            @foreach ($prioritasTiket as $prioritas)
                                <option value="{{ $prioritas->id }}" @selected(request('prioritas') == $prioritas->id)>

                                    {{ $prioritas->nama_prioritas }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- BUTTON --}}
                    <div class="col-md-2 mb-2">

                        <button type="submit" class="btn btn-primary w-100">

                            <i class="fas fa-search me-1"></i>

                            Cari

                        </button>

                    </div>

                </div>

            </form>


            {{-- TABLE --}}
            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th width="5%">
                                No
                            </th>

                            <th>
                                Nomor Tiket
                            </th>

                            <th>
                                Judul
                            </th>

                            <th>
                                Pelapor
                            </th>

                            <th>
                                Prioritas
                            </th>

                            <th>
                                Teknisi
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Dibuat
                            </th>

                            <th class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($tiket as $item)
                            <tr>

                                {{-- NOMOR --}}
                                <td>

                                    {{ $tiket->firstItem() + $loop->index }}

                                </td>


                                {{-- NOMOR TIKET --}}
                                <td>

                                    <span class="fw-bold">

                                        {{ $item->nomor_tiket }}

                                    </span>

                                </td>


                                {{-- JUDUL --}}
                                <td>

                                    {{ $item->judul }}

                                </td>


                                {{-- PELAPOR --}}
                                <td>

                                    {{ $item->pelapor->nama ?? '-' }}

                                </td>


                                {{-- PRIORITAS --}}
                                <td>

                                    @if ($item->prioritasTiket)
                                        <span class="badge bg-info">

                                            {{ $item->prioritasTiket->nama_prioritas }}

                                        </span>
                                    @else
                                        <span class="text-muted">

                                            Belum ditentukan

                                        </span>
                                    @endif

                                </td>


                                {{-- TEKNISI --}}
                                <td>

                                    @if ($item->teknisi)
                                        {{ $item->teknisi->nama }}
                                    @else
                                        <span class="text-muted">

                                            Belum ditugaskan

                                        </span>
                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @php

                                        $status = $item->statusTiket->nama_status ?? '-';

                                    @endphp


                                    @if ($status === 'BARU')
                                        <span class="badge bg-primary">

                                            BARU

                                        </span>
                                    @elseif ($status === 'DITUGASKAN')
                                        <span class="badge bg-info">

                                            DITUGASKAN

                                        </span>
                                    @elseif ($status === 'DIPROSES')
                                        <span class="badge bg-warning">

                                            DIPROSES

                                        </span>
                                    @elseif ($status === 'PENDING')
                                        <span class="badge bg-secondary">

                                            PENDING

                                        </span>
                                    @elseif ($status === 'MENUNGGU KONFIRMASI')
                                        <span class="badge bg-warning">

                                            MENUNGGU KONFIRMASI

                                        </span>
                                    @elseif ($status === 'SELESAI')
                                        <span class="badge bg-success">

                                            SELESAI

                                        </span>
                                    @elseif ($status === 'DIBUKA KEMBALI')
                                        <span class="badge bg-danger">

                                            DIBUKA KEMBALI

                                        </span>
                                    @elseif ($status === 'DITUTUP')
                                        <span class="badge bg-dark">

                                            DITUTUP

                                        </span>
                                    @elseif ($status === 'DIBATALKAN')
                                        <span class="badge bg-danger">

                                            DIBATALKAN

                                        </span>
                                    @else
                                        <span class="badge bg-secondary">

                                            {{ $status }}

                                        </span>
                                    @endif

                                </td>


                                {{-- TANGGAL --}}
                                <td>

                                    {{ $item->created_at?->format('d M Y H:i') }}

                                </td>


                                {{-- AKSI --}}
                                <td class="text-center">

                                    <a href="{{ route('admin.tiket.show', $item->id) }}"
                                        class="btn btn-sm btn-primary">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9" class="text-center py-4">

                                    <i
                                        class="fas fa-ticket-alt
                                        fa-2x
                                        text-muted
                                        mb-3">
                                    </i>

                                    <p class="text-muted
                                        mb-0">

                                        Belum ada tiket.

                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            <div class="mt-3">

                {{ $tiket->links() }}

            </div>

        </div>

    </div>

@endsection
