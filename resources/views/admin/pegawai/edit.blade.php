@extends('layouts.admin.app')

@section('title', 'Edit Pegawai')

@section('content')

    ```
    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Edit Pegawai
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
                <a href="{{ route('pegawai.index') }}">
                    Pegawai
                </a>
            </li>

            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>

            <li class="nav-item">
                Edit
            </li>

        </ul>

    </div>


    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">

        @csrf

        @method('PUT')


        <div class="row">

            {{-- ============================================================
            DATA PEGAWAI
        ============================================================ --}}

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">
                            Data Pegawai
                        </h4>
                    </div>


                    <div class="card-body">

                        <div class="row">


                            {{-- NIP --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>NIP</label>

                                    <input type="text" name="nip"
                                        class="form-control @error('nip') is-invalid @enderror"
                                        value="{{ old('nip', $pegawai->nip) }}">

                                    @error('nip')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>


                            {{-- NAMA --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Nama Pegawai</label>

                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $pegawai->nama) }}">

                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>


                            {{-- EMAIL --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Email</label>

                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $pegawai->email) }}">

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>


                            {{-- NOMOR TELEPON --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Nomor Telepon</label>

                                    <input type="text" name="nomor_telepon"
                                        class="form-control @error('nomor_telepon') is-invalid @enderror"
                                        value="{{ old('nomor_telepon', $pegawai->nomor_telepon) }}">

                                    @error('nomor_telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>


                            {{-- JENIS KELAMIN --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Jenis Kelamin</label>

                                    <select name="jenis_kelamin"
                                        class="form-select @error('jenis_kelamin') is-invalid @enderror">

                                        <option value="">
                                            -- Pilih --
                                        </option>

                                        <option value="LAKI_LAKI" @selected(old('jenis_kelamin', $pegawai->jenis_kelamin) === 'LAKI_LAKI')>
                                            Laki-laki
                                        </option>

                                        <option value="PEREMPUAN" @selected(old('jenis_kelamin', $pegawai->jenis_kelamin) === 'PEREMPUAN')>
                                            Perempuan
                                        </option>

                                    </select>

                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>


                            {{-- STATUS --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Status</label>

                                    <select name="status" class="form-select @error('status') is-invalid @enderror">

                                        <option value="AKTIF" @selected(old('status', $pegawai->status) === 'AKTIF')>
                                            AKTIF
                                        </option>

                                        <option value="TIDAK_AKTIF" @selected(old('status', $pegawai->status) === 'TIDAK_AKTIF')>
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


                            {{-- UNIT --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Unit</label>

                                    <select name="unit_id" class="form-select @error('unit_id') is-invalid @enderror">

                                        <option value="">
                                            -- Pilih Unit --
                                        </option>

                                        @foreach ($unit as $item)
                                            <option value="{{ $item->id }}" @selected(old('unit_id', $pegawai->unit_id) == $item->id)>
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


                            {{-- SUB UNIT --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Sub Unit</label>

                                    <select name="sub_unit_id"
                                        class="form-select @error('sub_unit_id') is-invalid @enderror">

                                        <option value="">
                                            -- Pilih Sub Unit --
                                        </option>

                                        @foreach ($subUnit as $item)
                                            <option value="{{ $item->id }}" @selected(old('sub_unit_id', $pegawai->sub_unit_id) == $item->id)>
                                                {{ $item->nama_sub_unit }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('sub_unit_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>


                            {{-- DIVISI --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Divisi</label>

                                    <select name="divisi_id" class="form-select @error('divisi_id') is-invalid @enderror">

                                        <option value="">
                                            -- Pilih Divisi --
                                        </option>

                                        @foreach ($divisi as $item)
                                            <option value="{{ $item->id }}" @selected(old('divisi_id', $pegawai->divisi_id) == $item->id)>
                                                {{ $item->nama_divisi }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('divisi_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>


                            {{-- JABATAN --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Jabatan</label>

                                    <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror">

                                        <option value="">
                                            -- Pilih Jabatan --
                                        </option>

                                        @foreach ($jabatan as $item)
                                            <option value="{{ $item->id }}" @selected(old('jabatan_id', $pegawai->jabatan_id) == $item->id)>
                                                {{ $item->nama_jabatan }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('jabatan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>


                            {{-- LOKASI --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Lokasi</label>

                                    <select name="lokasi_id" class="form-select @error('lokasi_id') is-invalid @enderror">

                                        <option value="">
                                            -- Pilih Lokasi --
                                        </option>

                                        @foreach ($lokasi as $item)
                                            <option value="{{ $item->id }}" @selected(old('lokasi_id', $pegawai->lokasi_id) == $item->id)>
                                                {{ $item->nama_lokasi }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('lokasi_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ============================================================
            DATA AKUN
        ============================================================ --}}

            <div class="col-md-4">

                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title">
                            Akun Login
                        </h4>

                    </div>


                    <div class="card-body">


                        {{-- LEVEL --}}

                        <div class="form-group">

                            <label>Level</label>

                            <select name="level_id" class="form-select @error('level_id') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Level --
                                </option>

                                @foreach ($level as $item)
                                    <option value="{{ $item->id }}" @selected(old('level_id', $pegawai->akun?->level_id) == $item->id)>
                                        {{ $item->nama_level }}
                                    </option>
                                @endforeach

                            </select>

                            @error('level_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- USERNAME --}}

                        <div class="form-group">

                            <label>Username</label>

                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username', $pegawai->akun?->username) }}">

                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <hr>


                        <div class="alert alert-info">

                            <small>
                                Kosongkan password jika tidak ingin mengubah password.
                            </small>

                        </div>


                        {{-- PASSWORD BARU --}}

                        <div class="form-group">

                            <label>Password Baru</label>

                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- KONFIRMASI PASSWORD --}}

                        <div class="form-group">

                            <label>Konfirmasi Password Baru</label>

                            <input type="password" name="password_confirmation" class="form-control">

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- BUTTON --}}

        <div class="card">

            <div class="card-body text-end">

                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
                    Batal
                </a>


                <button type="submit" class="btn btn-primary">

                    <i class="fa fa-save"></i>

                    Update Pegawai

                </button>

            </div>

        </div>

    </form>
    ```

@endsection
