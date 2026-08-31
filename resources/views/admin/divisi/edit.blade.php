@extends('layouts.admin.app')

@section('title', 'Edit Divisi')

@section('content')
    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Edit Divisi
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
                <a href="{{ route('divisi.index') }}">
                    Divisi
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


    <form action="{{ route('divisi.update', $divisi->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title">
                            Data Divisi
                        </h4>

                    </div>


                    <div class="card-body">

                        {{-- UNIT --}}
                        <div class="form-group">

                            <label for="unit_id">
                                Unit
                            </label>

                            <select name="unit_id" id="unit_id"
                                class="form-select @error('unit_id') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Unit --
                                </option>

                                @foreach ($unit as $item)
                                    <option value="{{ $item->id }}" @selected(old('unit_id', $divisi->unit_id) == $item->id)>
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


                        {{-- KODE DIVISI --}}
                        <div class="form-group">

                            <label for="kode_divisi">
                                Kode Divisi
                            </label>

                            <input type="text" name="kode_divisi" id="kode_divisi"
                                class="form-control @error('kode_divisi') is-invalid @enderror"
                                value="{{ old('kode_divisi', $divisi->kode_divisi) }}" placeholder="Masukkan kode divisi">

                            @error('kode_divisi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- NAMA DIVISI --}}
                        <div class="form-group">

                            <label for="nama_divisi">
                                Nama Divisi
                            </label>

                            <input type="text" name="nama_divisi" id="nama_divisi"
                                class="form-control @error('nama_divisi') is-invalid @enderror"
                                value="{{ old('nama_divisi', $divisi->nama_divisi) }}" placeholder="Masukkan nama divisi">

                            @error('nama_divisi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- STATUS --}}
                        <div class="form-group">

                            <label for="status">
                                Status
                            </label>

                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">

                                <option value="AKTIF" @selected(old('status', $divisi->status) === 'AKTIF')>
                                    AKTIF
                                </option>

                                <option value="TIDAK_AKTIF" @selected(old('status', $divisi->status) === 'TIDAK_AKTIF')>
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


                    <div class="card-footer text-end">

                        <a href="{{ route('divisi.index') }}" class="btn btn-secondary">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan Perubahan
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>
@endsection
