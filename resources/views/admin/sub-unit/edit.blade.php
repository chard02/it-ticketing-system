@extends('layouts.admin.app')

@section('title', 'Edit Sub Unit')

@section('content')

    ```
    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Edit Sub Unit
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
                <a href="{{ route('sub-unit.index') }}">
                    Sub Unit
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


    <form action="{{ route('sub-unit.update', $subUnit->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">
                            Data Sub Unit
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
                                    <option value="{{ $item->id }}" @selected(old('unit_id', $subUnit->unit_id) == $item->id)>
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


                        {{-- KODE SUB UNIT --}}
                        <div class="form-group">

                            <label for="kode_sub_unit">
                                Kode Sub Unit
                            </label>

                            <input type="text" id="kode_sub_unit" name="kode_sub_unit"
                                class="form-control @error('kode_sub_unit') is-invalid @enderror"
                                value="{{ old('kode_sub_unit', $subUnit->kode_sub_unit) }}">

                            @error('kode_sub_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- NAMA SUB UNIT --}}
                        <div class="form-group">

                            <label for="nama_sub_unit">
                                Nama Sub Unit
                            </label>

                            <input type="text" id="nama_sub_unit" name="nama_sub_unit"
                                class="form-control @error('nama_sub_unit') is-invalid @enderror"
                                value="{{ old('nama_sub_unit', $subUnit->nama_sub_unit) }}">

                            @error('nama_sub_unit')
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

                                <option value="AKTIF" @selected(old('status', $subUnit->status) === 'AKTIF')>
                                    AKTIF
                                </option>

                                <option value="TIDAK_AKTIF" @selected(old('status', $subUnit->status) === 'TIDAK_AKTIF')>
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

                        <a href="{{ route('sub-unit.index') }}" class="btn btn-secondary">
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
    ```

@endsection
