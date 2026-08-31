```blade
@extends('layouts.admin.app')

@section('title', 'Tambah Jabatan')

@section('content')

    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Tambah Jabatan
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
                <a href="{{ route('jabatan.index') }}">
                    Jabatan
                </a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>

            <li class="nav-item">
                Tambah
            </li>

        </ul>

    </div>


    <form action="{{ route('jabatan.store') }}" method="POST">

        @csrf

        <div class="card">

            <div class="card-header">

                <h4 class="card-title">
                    Data Jabatan
                </h4>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- UNIT --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Unit
                            </label>

                            <select name="unit_id" class="form-select @error('unit_id') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Unit --
                                </option>

                                @foreach ($unit as $item)
                                    <option value="{{ $item->id }}" @selected(old('unit_id') == $item->id)>

                                        {{ $item->nama_unit }}

                                    </option>
                                @endforeach

                            </select>

                            @error('unit_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- KODE --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Kode Jabatan
                            </label>

                            <input type="text" name="kode_jabatan"
                                class="form-control @error('kode_jabatan') is-invalid @enderror"
                                value="{{ old('kode_jabatan') }}">

                            @error('kode_jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- NAMA --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Nama Jabatan
                            </label>

                            <input type="text" name="nama_jabatan"
                                class="form-control @error('nama_jabatan') is-invalid @enderror"
                                value="{{ old('nama_jabatan') }}">

                            @error('nama_jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- STATUS --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Status
                            </label>

                            <select name="status" class="form-select">

                                <option value="AKTIF" @selected(old('status', 'AKTIF') === 'AKTIF')>

                                    AKTIF

                                </option>

                                <option value="TIDAK_AKTIF" @selected(old('status') === 'TIDAK_AKTIF')>

                                    TIDAK AKTIF

                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="card">

            <div class="card-body text-end">

                <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">

                    Batal

                </a>

                <button type="submit" class="btn btn-primary">

                    <i class="fa fa-save"></i>

                    Simpan Jabatan

                </button>

            </div>

        </div>

    </form>

@endsection
```
