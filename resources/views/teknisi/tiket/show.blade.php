@extends('layouts.teknisi.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Detail Tiket</h3>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>


        <div class="card">

            <div class="card-header">
                {{ $tiket->nomor_tiket }}
            </div>

            <div class="card-body">

                <h4>{{ $tiket->judul }}</h4>

                <hr>

                <p>
                    <strong>Deskripsi:</strong><br>
                    {{ $tiket->deskripsi }}
                </p>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Pelapor</strong><br>
                        {{ $tiket->pelapor?->nama ?? '-' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Status</strong><br>
                        {{ $tiket->statusTiket?->nama_status ?? '-' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Jenis Tiket</strong><br>
                        {{ $tiket->jenisTiket?->nama_jenis ?? '-' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Kategori</strong><br>
                        {{ $tiket->kategoriTiket?->nama_kategori ?? '-' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Sub Kategori</strong><br>
                        {{ $tiket->subKategoriTiket?->nama_sub_kategori ?? '-' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Prioritas</strong><br>
                        {{ $tiket->prioritasTiket?->nama_prioritas ?? '-' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Unit</strong><br>
                        {{ $tiket->unit?->nama_unit ?? '-' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Lokasi</strong><br>
                        {{ $tiket->lokasi?->nama_lokasi ?? '-' }}
                    </div>

                </div>

            </div>

        </div>


        {{-- AKSI TEKNISI --}}
        @php
            $statusTiket = strtoupper($tiket->statusTiket?->nama_status ?? '');
        @endphp


        @if (in_array($statusTiket, ['SELESAI', 'MENUNGGU APPROVAL', 'DITUTUP']))
            <div class="card mt-4">

                <div class="card-header">
                    <strong>Aksi Tiket</strong>
                </div>

                <div class="card-body">

                    @if ($statusTiket === 'SELESAI')
                        <div class="alert alert-success mb-0">

                            <i class="fa fa-check-circle me-2"></i>

                            Tiket sudah selesai. Menunggu konfirmasi dari pelapor.

                        </div>
                    @elseif ($statusTiket === 'MENUNGGU APPROVAL')
                        <div class="alert alert-info mb-0">

                            <i class="fa fa-clock me-2"></i>

                            Tiket sedang menunggu approval Admin.

                        </div>
                    @elseif ($statusTiket === 'DITUTUP')
                        <div class="alert alert-secondary mb-0">

                            <i class="fa fa-lock me-2"></i>

                            Tiket sudah ditutup dan tidak dapat diproses lagi.

                        </div>
                    @endif

                </div>

            </div>
        @else
            <div class="card mt-4">

                <div class="card-header">
                    <strong>Aksi Tiket</strong>
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif


                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif


                    <form action="{{ route('teknisi.tiket.update-status', $tiket->id) }}" method="POST">

                        @csrf
                        @method('PUT')


                        <div class="row">

                            {{-- PILIH AKSI --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Aksi
                                </label>


                                <select name="aksi" class="form-control" required>

                                    <option value="">
                                        -- Pilih Aksi --
                                    </option>


                                    {{-- STATUS DITUGASKAN --}}
                                    @if ($statusTiket === 'DITUGASKAN')
                                        <option value="DIPROSES">
                                            Proses Tiket
                                        </option>

                                        <option value="PENDING">
                                            Pending
                                        </option>
                                    @endif


                                    {{-- STATUS DIPROSES --}}
                                    @if ($statusTiket === 'DIPROSES')
                                        <option value="PENDING">
                                            Pending
                                        </option>

                                        <option value="SELESAI">
                                            Selesaikan Tiket
                                        </option>
                                    @endif


                                    {{-- STATUS PENDING --}}
                                    @if ($statusTiket === 'PENDING')
                                        <option value="DIPROSES">
                                            Lanjutkan Pekerjaan
                                        </option>

                                        <option value="SELESAI">
                                            Selesaikan Tiket
                                        </option>
                                    @endif

                                </select>

                            </div>


                            {{-- KETERANGAN --}}
                            <div class="col-md-8 mb-3">

                                <label class="form-label">
                                    Keterangan / Update Pekerjaan
                                </label>

                                <textarea name="keterangan" class="form-control" rows="3"
                                    placeholder="Contoh: Sedang melakukan pengecekan perangkat..." required></textarea>

                            </div>

                        </div>


                        <button type="submit" class="btn btn-primary">

                            <i class="fa fa-save"></i>

                            Simpan Update

                        </button>

                    </form>

                </div>

            </div>
        @endif


        {{-- RIWAYAT TIKET --}}
        <div class="card mt-4">

            <div class="card-header">
                Riwayat Tiket
            </div>

            <div class="card-body">

                @forelse($tiket->riwayat as $riwayat)
                    <div class="border-bottom pb-3 mb-3">

                        <strong>
                            {{ $riwayat->aktivitas }}
                        </strong>

                        <br>

                        <small>
                            {{ $riwayat->keterangan }}
                        </small>

                        <br>

                        <small class="text-muted">
                            {{ $riwayat->created_at?->format('d M Y H:i') }}
                        </small>

                    </div>

                @empty

                    <div class="text-muted">
                        Belum ada riwayat.
                    </div>
                @endforelse

            </div>

        </div>

    </div>
@endsection
