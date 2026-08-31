@extends('layouts.pegawai.app')

@section('title', 'Buat Tiket')

@section('content')

    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Buat Tiket
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

                <a href="{{ route('pegawai.tiket.index') }}">
                    Tiket Saya
                </a>

            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>

            <li class="nav-item">
                Buat Tiket
            </li>

        </ul>

    </div>


    <form action="{{ route('pegawai.tiket.store') }}" method="POST" enctype="multipart/form-data">

        @csrf


        <div class="row">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title">
                            Form Permintaan Bantuan IT
                        </h4>

                    </div>


                    <div class="card-body">

                        {{-- KATEGORI --}}

                        <div class="form-group">

                            <label>
                                Kategori
                            </label>

                            <select name="kategori_tiket_id" id="kategori_tiket_id"
                                class="form-select @error('kategori_tiket_id') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" @selected(old('kategori_tiket_id') == $item->id)>

                                        {{ $item->nama_kategori }}

                                    </option>
                                @endforeach

                            </select>

                            @error('kategori_tiket_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- SUB KATEGORI --}}

                        <div class="form-group">

                            <label>
                                Sub Kategori
                            </label>

                            <select name="sub_kategori_tiket_id" id="sub_kategori_tiket_id"
                                class="form-select @error('sub_kategori_tiket_id') is-invalid @enderror">

                                <option value="{{ $item->id }}" @selected(old('sub_kategori_tiket_id') == $item->id)>
                                    -- Pilih Sub Kategori --
                                </option>

                                @foreach ($subKategoriTiket as $item)
                                    <option value="{{ $item->id }}" @selected(old('sub_kategori_tiket_id') == $item->id)>{{ $item->nama_sub_kategori }}
                                    </option>
                                @endforeach

                            </select>

                            @error('sub_kategori_tiket_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- JENIS TIKET --}}

                        <div class="form-group">

                            <label>
                                Jenis Tiket
                            </label>

                            <select name="jenis_tiket_id" class="form-select @error('jenis_tiket_id') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Jenis Tiket --
                                </option>

                                @foreach ($jenisTiket as $item)
                                    <option value="{{ $item->id }}" @selected(old('jenis_tiket_id') == $item->id)>

                                        {{ $item->nama_jenis }}

                                    </option>
                                @endforeach

                            </select>

                            @error('jenis_tiket_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- JUDUL --}}

                        <div class="form-group">

                            <label>
                                Judul
                            </label>

                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul') }}" placeholder="Contoh: Komputer tidak bisa menyala">

                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="form-group">

                            <label>
                                Deskripsi
                            </label>

                            <textarea name="deskripsi" rows="6" class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Jelaskan masalah yang kamu alami secara detail...">{{ old('deskripsi') }}</textarea>

                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- LAMPIRAN --}}

                        <div class="form-group">

                            <label>
                                Lampiran
                            </label>

                            <input type="file" name="lampiran[]"
                                class="form-control @error('lampiran.*') is-invalid @enderror" multiple>

                            <small class="form-text text-muted">

                                Maksimal 5 MB per file.

                            </small>

                            @error('lampiran.*')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- INFORMASI --}}

            <div class="col-md-4">

                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title">
                            Informasi Tiket
                        </h4>

                    </div>

                    <div class="card-body">

                        <div class="alert alert-info">

                            <i class="fas fa-info-circle me-2"></i>

                            Setelah tiket dibuat, admin akan melakukan pemeriksaan dan menentukan prioritas serta teknisi
                            yang menangani tiket.

                        </div>


                        <div class="mb-3">

                            <small class="text-muted">
                                Prioritas
                            </small>

                            <div class="fw-bold">
                                Ditentukan Admin
                            </div>

                        </div>


                        <div class="mb-3">

                            <small class="text-muted">
                                Teknisi
                            </small>

                            <div class="fw-bold">
                                Ditentukan Admin
                            </div>

                        </div>


                        <div>

                            <small class="text-muted">
                                Status Awal
                            </small>

                            <div>

                                <span class="badge bg-primary">
                                    BARU
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="card">

                    <div class="card-body">

                        <a href="{{ route('pegawai.tiket.index') }}" class="btn btn-secondary">

                            Batal

                        </a>

                        <button type="submit" class="btn btn-primary float-end">

                            <i class="fas fa-paper-plane me-1"></i>

                            Kirim Tiket

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection
