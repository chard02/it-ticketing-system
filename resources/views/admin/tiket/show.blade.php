@extends('layouts.admin.app')

@section('title', 'Detail Tiket')

@section('content')

    {{-- HEADER --}}
    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Detail Tiket
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
                <a href="{{ route('admin.tiket.index') }}">
                    Manajemen Tiket
                </a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>

            <li class="nav-item">
                Detail Tiket
            </li>

        </ul>

    </div>


    {{-- HEADER TIKET --}}
    <div class="card card-round">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <div class="d-flex align-items-center">

                        <div class="avatar avatar-lg">

                            <span class="avatar-title rounded-circle bg-primary">

                                <i class="fas fa-ticket-alt"></i>

                            </span>

                        </div>


                        <div class="ms-3">

                            <small class="text-muted">
                                Nomor Tiket
                            </small>

                            <h4 class="fw-bold mb-1">

                                {{ $tiket->nomor_tiket }}

                            </h4>

                            <p class="mb-0">

                                {{ $tiket->judul }}

                            </p>

                        </div>

                    </div>

                </div>


                <div class="col-md-4 text-md-end mt-3 mt-md-0">

                    <span class="badge bg-primary fs-6">

                        {{ $tiket->statusTiket->nama_status ?? '-' }}

                    </span>

                </div>

            </div>

        </div>

    </div>


    <div class="row">

        {{-- INFORMASI TIKET --}}
        <div class="col-md-8">

            <div class="card card-round">

                <div class="card-header">

                    <div class="card-title">

                        Informasi Tiket

                    </div>

                </div>


                <div class="card-body">

                    <div class="row">

                        {{-- KATEGORI --}}
                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Kategori

                            </small>

                            <div class="fw-bold">

                                {{ $tiket->kategoriTiket->nama_kategori ?? '-' }}

                            </div>

                        </div>


                        {{-- SUB KATEGORI --}}
                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Sub Kategori

                            </small>

                            <div class="fw-bold">

                                {{ $tiket->subKategoriTiket->nama_sub_kategori ?? '-' }}

                            </div>

                        </div>


                        {{-- JENIS --}}
                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Jenis Tiket

                            </small>

                            <div class="fw-bold">

                                {{ $tiket->jenisTiket->nama_jenis ?? '-' }}

                            </div>

                        </div>


                        {{-- PRIORITAS --}}
                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Prioritas

                            </small>

                            <div>

                                @if ($tiket->prioritasTiket)
                                    <span class="badge bg-warning text-dark">

                                        {{ $tiket->prioritasTiket->nama_prioritas }}

                                    </span>
                                @else
                                    <span class="badge bg-secondary">

                                        Belum Ditentukan

                                    </span>
                                @endif

                            </div>

                        </div>


                        {{-- TANGGAL --}}
                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Dibuat

                            </small>

                            <div class="fw-bold">

                                {{ $tiket->created_at?->format('d M Y H:i') ?? '-' }}

                            </div>

                        </div>


                        {{-- TEKNISI --}}
                        <div class="col-md-6 mb-4">

                            <small class="text-muted">

                                Teknisi

                            </small>

                            <div class="fw-bold">

                                {{ $tiket->teknisi->nama ?? 'Belum Ditugaskan' }}

                            </div>

                        </div>

                    </div>


                    {{-- DESKRIPSI --}}
                    <div class="mt-2">

                        <small class="text-muted">

                            Deskripsi Permasalahan

                        </small>


                        <div class="border rounded p-3 mt-2">

                            {!! nl2br(e($tiket->deskripsi)) !!}

                        </div>

                    </div>

                </div>

            </div>


            {{-- LAMPIRAN --}}
            <div class="card card-round">

                <div class="card-header">

                    <div class="card-title">

                        Lampiran

                    </div>

                </div>


                <div class="card-body">

                    @forelse ($tiket->lampiran as $lampiran)
                        <div class="d-flex align-items-center border-bottom py-3">

                            <div class="avatar avatar-sm">

                                <span class="avatar-title rounded-circle bg-secondary">

                                    <i class="fas fa-paperclip"></i>

                                </span>

                            </div>


                            <div class="flex-1 ms-3">

                                <div class="fw-bold">

                                    {{ $lampiran->nama_file }}

                                </div>

                                <small class="text-muted">

                                    {{ $lampiran->pegawai->nama ?? '-' }}

                                    •

                                    {{ number_format($lampiran->ukuran_file / 1024, 2) }} KB

                                </small>

                            </div>


                            <a href="{{ asset('storage/' . $lampiran->path_file) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">

                                <i class="fas fa-download"></i>

                            </a>

                        </div>

                    @empty

                        <div class="text-center py-4 text-muted">

                            <i class="fas fa-paperclip fa-2x mb-2"></i>

                            <p class="mb-0">

                                Tidak ada lampiran.

                            </p>

                        </div>
                    @endforelse

                </div>

            </div>


            {{-- RIWAYAT --}}
            <div class="card card-round">

                <div class="card-header">

                    <div class="card-title">

                        Riwayat Tiket

                    </div>

                </div>


                <div class="card-body">

                    @forelse ($tiket->riwayat as $riwayat)
                        <div class="d-flex mb-4">

                            <div class="avatar avatar-sm">

                                <span class="avatar-title rounded-circle bg-primary">

                                    <i class="fas fa-history"></i>

                                </span>

                            </div>


                            <div class="ms-3 flex-1">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <div class="fw-bold">

                                            {{ $riwayat->aktivitas }}

                                        </div>

                                        <small class="text-muted">

                                            {{ $riwayat->pegawai->nama ?? 'Sistem' }}

                                        </small>

                                    </div>


                                    <small class="text-muted">

                                        {{ $riwayat->created_at?->format('d M Y H:i') }}

                                    </small>

                                </div>


                                @if ($riwayat->keterangan)
                                    <p class="mb-0 mt-1">

                                        {{ $riwayat->keterangan }}

                                    </p>
                                @endif

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-4 text-muted">

                            Belum ada riwayat.

                        </div>
                    @endforelse

                </div>

            </div>

        </div>


        {{-- SIDEBAR --}}
        <div class="col-md-4">

            {{-- INFORMASI PELAPOR --}}
            <div class="card card-round">

                <div class="card-header">

                    <div class="card-title">

                        Informasi Pelapor

                    </div>

                </div>


                <div class="card-body">

                    {{-- NAMA --}}
                    <div class="mb-3">

                        <small class="text-muted">

                            Nama

                        </small>

                        <div class="fw-bold">

                            {{ $tiket->pelapor->nama ?? '-' }}

                        </div>

                    </div>


                    {{-- NIP --}}
                    <div class="mb-3">

                        <small class="text-muted">

                            NIP

                        </small>

                        <div class="fw-bold">

                            {{ $tiket->pelapor->nip ?? '-' }}

                        </div>

                    </div>


                    {{-- JABATAN --}}
                    <div class="mb-3">

                        <small class="text-muted">

                            Jabatan

                        </small>

                        <div class="fw-bold">

                            {{ $tiket->pelapor->jabatan->nama_jabatan ?? '-' }}

                        </div>

                    </div>


                    {{-- DIVISI --}}
                    <div class="mb-3">

                        <small class="text-muted">

                            Divisi

                        </small>

                        <div class="fw-bold">

                            {{ $tiket->pelapor->divisi->nama_divisi ?? '-' }}

                        </div>

                    </div>


                    {{-- UNIT --}}
                    <div class="mb-3">

                        <small class="text-muted">

                            Unit

                        </small>

                        <div class="fw-bold">

                            {{ $tiket->pelapor->unit->nama_unit ?? '-' }}

                        </div>

                    </div>


                    {{-- SUB UNIT --}}
                    <div class="mb-3">

                        <small class="text-muted">

                            Sub Unit

                        </small>

                        <div class="fw-bold">

                            {{ $tiket->pelapor->subUnit->nama_sub_unit ?? '-' }}

                        </div>

                    </div>


                    {{-- LOKASI --}}
                    <div class="mb-0">

                        <small class="text-muted">

                            Lokasi

                        </small>

                        <div class="fw-bold">

                            {{ $tiket->pelapor->lokasi->nama_lokasi ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>

            {{-- APPROVAL KONFIRMASI PEGAWAI --}}
            @if (strtoupper($tiket->statusTiket?->nama_status) === 'MENUNGGU APPROVAL' && $tiket->konfirmasiTerbaru)

                <div class="card card-round">

                    <div class="card-header">
                        <div class="card-title">
                            Approval Konfirmasi Pegawai
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <small class="text-muted">
                                Pelapor
                            </small>

                            <div class="fw-bold">
                                {{ $tiket->konfirmasiTerbaru->pegawai?->nama ?? '-' }}
                            </div>
                        </div>


                        <div class="mb-3">

                            <small class="text-muted">
                                Konfirmasi
                            </small>

                            <div>

                                @if (strtoupper($tiket->konfirmasiTerbaru->status_konfirmasi) === 'SELESAI')
                                    <span class="badge bg-success">
                                        PEGAWAI MENYATAKAN SELESAI
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        PEGAWAI MEMINTA BUKA KEMBALI
                                    </span>
                                @endif

                            </div>

                        </div>


                        @if ($tiket->konfirmasiTerbaru->alasan)
                            <div class="mb-3">

                                <small class="text-muted">
                                    Keterangan Pegawai
                                </small>

                                <div class="border rounded p-3 mt-2">
                                    {{ $tiket->konfirmasiTerbaru->alasan }}
                                </div>

                            </div>
                        @endif


                        <hr>


                        {{-- SATU ROUTE UNTUK APPROVAL --}}
                        <form action="{{ route('admin.tiket.approve-konfirmasi', $tiket->id) }}" method="POST">

                            @csrf
                            @method('PUT')


                            @if (strtoupper($tiket->konfirmasiTerbaru->status_konfirmasi) === 'SELESAI')
                                <button type="submit" class="btn btn-success w-100">

                                    <i class="fas fa-check me-2"></i>

                                    Approve & Tutup Tiket

                                </button>
                            @else
                                <button type="submit" class="btn btn-warning w-100">

                                    <i class="fas fa-redo me-2"></i>

                                    Approve & Buka Kembali

                                </button>
                            @endif

                        </form>

                    </div>

                </div>

            @endif

            {{-- ASSIGN TIKET --}}
            @include('admin.tiket.partials.assign')

            {{-- STATUS PENANGANAN --}}
            <div class="card card-round">

                <div class="card-header">

                    <div class="card-title">

                        Status Penanganan

                    </div>

                </div>


                <div class="card-body">

                    <div class="mb-3">

                        <small class="text-muted">

                            Status

                        </small>

                        <div>

                            <span class="badge bg-primary">

                                {{ $tiket->statusTiket->nama_status ?? '-' }}

                            </span>

                        </div>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">

                            Teknisi

                        </small>

                        <div class="fw-bold">

                            {{ $tiket->teknisi->nama ?? 'Belum Ditugaskan' }}

                        </div>

                    </div>


                    <div>

                        <small class="text-muted">

                            Waktu Ditugaskan

                        </small>

                        <div class="fw-bold">

                            {{ $tiket->waktu_ditugaskan?->format('d M Y H:i') ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- AKSI --}}
            <div class="card card-round">

                <div class="card-body">

                    <a href="{{ route('admin.tiket.index') }}" class="btn btn-outline-secondary w-100">

                        <i class="fas fa-arrow-left me-2"></i>

                        Kembali

                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection
