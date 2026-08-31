@extends('layouts.admin.app')

@section('title', 'Edit Unit')

@section('content')

```
<div class="page-header">

    <h3 class="fw-bold mb-3">
        Edit Unit
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
            <a href="{{ route('unit.index') }}">
                Unit
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


<form action="{{ route('unit.update', $unit->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">
                        Data Unit
                    </h4>
                </div>

                <div class="card-body">

                    {{-- KODE UNIT --}}
                    <div class="form-group">

                        <label for="kode_unit">
                            Kode Unit
                        </label>

                        <input
                            type="text"
                            id="kode_unit"
                            name="kode_unit"
                            class="form-control @error('kode_unit') is-invalid @enderror"
                            value="{{ old('kode_unit', $unit->kode_unit) }}"
                        >

                        @error('kode_unit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- NAMA UNIT --}}
                    <div class="form-group">

                        <label for="nama_unit">
                            Nama Unit
                        </label>

                        <input
                            type="text"
                            id="nama_unit"
                            name="nama_unit"
                            class="form-control @error('nama_unit') is-invalid @enderror"
                            value="{{ old('nama_unit', $unit->nama_unit) }}"
                        >

                        @error('nama_unit')
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

                        <select
                            name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                        >

                            <option value="AKTIF"
                                @selected(old('status', $unit->status) === 'AKTIF')>
                                AKTIF
                            </option>

                            <option value="TIDAK_AKTIF"
                                @selected(old('status', $unit->status) === 'TIDAK_AKTIF')>
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

                    <a
                        href="{{ route('unit.index') }}"
                        class="btn btn-secondary"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
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
