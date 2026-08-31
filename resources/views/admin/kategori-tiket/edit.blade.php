@extends('layouts.admin.app')

@section('content')
    <div class="page-inner">

        <div class="page-header">

            <h3 class="fw-bold mb-3">
                Edit Kategori Tiket
            </h3>

        </div>


        <div class="card">

            <div class="card-header">

                <div class="card-title">
                    Form Edit Kategori Tiket
                </div>

            </div>


            <form
                action="{{ route('admin.kategori-tiket.update', $kategoriTiket->id) }}"
                method="POST">

                @csrf

                @method('PUT')


                <div class="card-body">

                    {{-- NAMA KATEGORI --}}
                    <div class="form-group">

                        <label for="nama_kategori">

                            Nama Kategori
                            <span class="text-danger">*</span>

                        </label>


                        <input type="text" name="nama_kategori" id="nama_kategori"
                            class="form-control @error('nama_kategori') is-invalid @enderror"
                            value="{{ old('nama_kategori', $kategoriTiket->nama_kategori) }}"
                            required>


                        @error('nama_kategori')
                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>
                        @enderror

                    </div>


                    {{-- KETERANGAN --}}
                    <div class="form-group">

                        <label for="keterangan">

                            Keterangan

                        </label>


                        <textarea name="keterangan" id="keterangan" rows="4"
                            class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $kategoriTiket->keterangan) }}</textarea>


                        @error('keterangan')
                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>
                        @enderror

                    </div>


                    {{-- STATUS --}}
                    <div class="form-group">

                        <label for="status">

                            Status
                            <span class="text-danger">*</span>

                        </label>


                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                            required>

                            <option value="AKTIF"
                                {{ old('status', $kategoriTiket->status) === 'AKTIF' ? 'selected' : '' }}>

                                AKTIF

                            </option>


                            <option value="TIDAK_AKTIF"
                                {{ old('status', $kategoriTiket->status) === 'TIDAK_AKTIF' ? 'selected' : '' }}>

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


                <div class="card-action">

                    <button type="submit" class="btn btn-primary">

                        <i class="fa fa-save"></i>

                        Update

                    </button>


                    <a href="{{ route('admin.kategori-tiket.index') }}" class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>
@endsection
