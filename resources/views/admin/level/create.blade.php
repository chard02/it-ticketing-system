@extends('layouts.admin.app')

@section('title', 'Tambah Level')

@section('content')

    ```
    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Tambah Level
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
                <a href="{{ route('level.index') }}">
                    Level
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


    <form action="{{ route('level.store') }}" method="POST">

        @csrf

        <div class="card">

            <div class="card-header">

                <h4 class="card-title">
                    Data Level
                </h4>

            </div>

            <div class="card-body">

                <div class="row">

                    {{-- NAMA LEVEL --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Nama Level
                            </label>

                            <input type="text" name="nama_level"
                                class="form-control @error('nama_level') is-invalid @enderror"
                                value="{{ old('nama_level') }}" placeholder="Contoh: Administrator">

                            @error('nama_level')
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

                            <select name="status" class="form-select @error('status') is-invalid @enderror">

                                <option value="AKTIF" @selected(old('status', 'AKTIF') === 'AKTIF')>
                                    AKTIF
                                </option>

                                <option value="TIDAK AKTIF" @selected(old('status') === 'TIDAK AKTIF')>
                                    TIDAK AKTIF
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- KETERANGAN --}}

                    <div class="col-md-12">

                        <div class="form-group">

                            <label>
                                Keterangan
                            </label>

                            <textarea name="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Keterangan level (opsional)">{{ old('keterangan') }}</textarea>

                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="card">

            <div class="card-body text-end">

                <a href="{{ route('level.index') }}" class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    Simpan Level
                </button>

            </div>

        </div>

    </form>
    ```

@endsection
