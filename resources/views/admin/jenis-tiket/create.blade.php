@extends('layouts.admin.app')

@section('content')
    <div class="page-inner">

        <div class="page-header">

            <h3 class="fw-bold mb-3">

                Tambah Jenis Tiket

            </h3>

        </div>


        <div class="card">

            <div class="card-body">


                <form action="{{ route('admin.jenis-tiket.store') }}" method="POST">

                    @csrf


                    <div class="mb-3">

                        <label class="form-label">
                            Nama Jenis Tiket
                        </label>

                        <input type="text" name="nama_jenis"
                            class="form-control @error('nama_jenis') is-invalid @enderror" value="{{ old('nama_jenis') }}"
                            required>

                        @error('nama_jenis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Keterangan
                        </label>

                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="4"
                            placeholder="Masukkan keterangan jenis tiket...">{{ old('keterangan') }}</textarea>

                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-control" required>

                            <option value="AKTIF">
                                AKTIF
                            </option>

                            <option value="TIDAK AKTIF">
                                TIDAK AKTIF
                            </option>

                        </select>

                    </div>

                    <a href="{{ route('admin.jenis-tiket.index') }}" class="btn btn-secondary">

                        Kembali

                    </a>


                    <button type="submit" class="btn btn-primary">

                        Simpan

                    </button>

                </form>

            </div>

        </div>

    </div>
@endsection
