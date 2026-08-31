@extends('layouts.pegawai.app')

@section('content')
    <div class="container">

        ```
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="mb-1">Detail Tiket</h3>
                <small class="text-muted">
                    {{ $tiket->nomor_tiket }}
                </small>
            </div>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary">

                <i class="fa fa-arrow-left"></i>
                Kembali

            </a>

        </div>


        {{-- DETAIL TIKET --}}
        <div class="card">

            <div class="card-header">
                <strong>Informasi Tiket</strong>
            </div>


            <div class="card-body">

                <h4>
                    {{ $tiket->judul }}
                </h4>

                <hr>


                <div class="mb-4">

                    <strong>Deskripsi</strong>

                    <p class="mt-2">
                        {{ $tiket->deskripsi }}
                    </p>

                </div>


                <div class="row">

                    <div class="col-md-6 mb-3">

                        <strong>Status</strong>

                        <br>

                        <span class="badge bg-primary">
                            {{ $tiket->statusTiket?->nama_status ?? '-' }}
                        </span>

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Teknisi</strong>

                        <br>

                        {{ $tiket->teknisi?->nama ?? 'Belum ditugaskan' }}

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Jenis Tiket</strong>

                        <br>

                        {{ $tiket->jenisTiket?->nama_jenis ?? '-' }}

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Kategori</strong>

                        <br>

                        {{ $tiket->kategoriTiket?->nama_kategori ?? '-' }}

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Sub Kategori</strong>

                        <br>

                        {{ $tiket->subKategoriTiket?->nama_sub_kategori ?? '-' }}

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Prioritas</strong>

                        <br>

                        {{ $tiket->prioritasTiket?->nama_prioritas ?? '-' }}

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Unit</strong>

                        <br>

                        {{ $tiket->unit?->nama_unit ?? '-' }}

                    </div>


                    <div class="col-md-6 mb-3">

                        <strong>Lokasi</strong>

                        <br>

                        {{ $tiket->lokasi?->nama_lokasi ?? '-' }}

                    </div>

                </div>

            </div>

        </div>


        {{-- PROGRES TIKET --}}
        <div class="card mt-4">

            <div class="card-header">
                <strong>Progres Tiket</strong>
            </div>


            <div class="card-body">

                @forelse ($tiket->progres as $progres)
                    <div class="border-bottom pb-3 mb-3">

                        <div class="d-flex justify-content-between">

                            <strong>
                                {{ $progres->statusTiket?->nama_status ?? 'Update Progres' }}
                            </strong>

                            <small class="text-muted">

                                {{ $progres->created_at?->format('d M Y H:i') }}

                            </small>

                        </div>


                        <div class="mt-2">

                            {{ $progres->keterangan ?? '-' }}

                        </div>


                        @if ($progres->pegawai)
                            <small class="text-muted">

                                Oleh:
                                {{ $progres->pegawai->nama }}

                            </small>
                        @endif

                    </div>

                @empty

                    <div class="text-muted">

                        Belum ada progres dari teknisi.

                    </div>
                @endforelse

            </div>

        </div>


        {{-- RIWAYAT TIKET --}}
        <div class="card mt-4 mb-4">

            <div class="card-header">
                <strong>Riwayat Tiket</strong>
            </div>


            <div class="card-body">

                @forelse ($tiket->riwayat as $riwayat)
                    <div class="border-bottom pb-3 mb-3">

                        <strong>
                            {{ $riwayat->aktivitas }}
                        </strong>

                        <br>


                        <span>
                            {{ $riwayat->keterangan }}
                        </span>

                        <br>


                        <small class="text-muted">

                            {{ $riwayat->created_at?->format('d M Y H:i') }}

                        </small>

                    </div>

                @empty

                    <div class="text-muted">

                        Belum ada riwayat tiket.

                    </div>
                @endforelse

            </div>

        </div>

        {{-- KONFIRMASI PEGAWAI --}}
        @if (strtoupper($tiket->statusTiket?->nama_status) === 'SELESAI')
            <div class="card mt-4">

                <div class="card-header">
                    <strong>Konfirmasi Penyelesaian Tiket</strong>
                </div>

                <div class="card-body">

                    <p>
                        Teknisi telah menyelesaikan tiket ini.
                        Silakan konfirmasi apakah permasalahan sudah selesai.
                    </p>


                    <div class="d-flex gap-2">

                        {{-- SUDAH SELESAI --}}
                        <form action="{{ route('pegawai.tiket.konfirmasi', $tiket->id) }}" method="POST">

                            @csrf
                            @method('PUT')


                            <input type="hidden" name="aksi" value="SELESAI">


                            <input type="hidden" name="alasan"
                                value="Pegawai mengkonfirmasi bahwa permasalahan telah selesai.">


                            <button type="submit" class="btn btn-success">

                                <i class="fa fa-check"></i>
                                Sudah Selesai

                            </button>

                        </form>


                        {{-- BELUM SELESAI --}}
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#belumSelesaiModal">

                            <i class="fa fa-rotate-left"></i>
                            Belum Selesai

                        </button>

                    </div>

                </div>

            </div>


            {{-- MODAL BELUM SELESAI --}}
            <div class="modal fade" id="belumSelesaiModal" tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">


                        <form action="{{ route('pegawai.tiket.konfirmasi', $tiket->id) }}" method="POST">

                            @csrf
                            @method('PUT')


                            <div class="modal-header">

                                <h5 class="modal-title">

                                    Permasalahan Belum Selesai

                                </h5>


                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                            </div>


                            <div class="modal-body">


                                <input type="hidden" name="aksi" value="BELUM_SELESAI">


                                <div class="mb-3">

                                    <label class="form-label">

                                        Jelaskan masalah yang masih belum selesai

                                    </label>


                                    <textarea name="alasan" class="form-control" rows="4" required
                                        placeholder="Contoh: Printer masih belum bisa digunakan..."></textarea>

                                </div>


                            </div>


                            <div class="modal-footer">


                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                    Batal

                                </button>


                                <button type="submit" class="btn btn-danger">

                                    Kirim ke Admin

                                </button>


                            </div>

                        </form>

                    </div>

                </div>

            </div>
        @endif

    </div>
    ```
@endsection
