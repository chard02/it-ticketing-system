@extends('layouts.admin.app')

@section('content')
    <div class="page-inner">

        <div class="page-header">

            <h3 class="fw-bold mb-3">
                Tambah Sub Kategori Tiket
            </h3>

        </div>


        <div class="card">

            <div class="card-header">

                <div class="card-title">

                    Form Tambah Sub Kategori Tiket

                </div>

            </div>


            <form action="{{ route('admin.sub-kategori-tiket.store') }}" method="POST">

                @csrf


                <div class="card-body">

                    {{-- KATEGORI --}}
                    <div class="form-group">

                        <label for="kategori_tiket_id">

                            Kategori Tiket
                            <span class="text-danger">*</span>

                        </label>


                        <select name="kategori_tiket_id" id="kategori_tiket_id"
                            class="form-select @error('kategori_tiket_id') is-invalid @enderror" required>

                            <option value="">

                                -- Pilih Kategori --

                            </option>


                            @foreach ($kategoriTikets as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori_tiket_id') == $kategori->id ? 'selected' : '' }}>

                                    {{ $kategori->nama_kategori }}

                                </option>
                            @endforeach

                        </select>


                        @error('kategori_tiket_id')
                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>
                        @enderror

                    </div>


                    {{-- NAMA SUB KATEGORI --}}
                    <div class="form-group">

                        <label for="nama_sub_kategori">

                            Nama Sub Kategori
                            <span class="text-danger">*</span>

                        </label>


                        <input type="text" name="nama_sub_kategori" id="nama_sub_kategori"
                            class="form-control @error('nama_sub_kategori') is-invalid @enderror"
                            value="{{ old('nama_sub_kategori') }}" placeholder="Masukkan nama sub kategori" required>


                        @error('nama_sub_kategori')
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
                            class="form-control @error('keterangan') is-invalid @enderror" placeholder="Masukkan keterangan (opsional)">{{ old('keterangan') }}</textarea>


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

                            <option value="AKTIF" {{ old('status', 'AKTIF') === 'AKTIF' ? 'selected' : '' }}>

                                AKTIF

                            </option>


                            <option value="TIDAK_AKTIF" {{ old('status') === 'TIDAK_AKTIF' ? 'selected' : '' }}>

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

                        Simpan

                    </button>


                    <a href="{{ route('admin.sub-kategori-tiket.index') }}" class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>
@endsection
