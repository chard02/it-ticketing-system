@extends('layouts.admin.app')

@section('content')
    <div class="page-inner">

        <div class="page-header">

            <h3 class="fw-bold mb-3">
                Sub Kategori Tiket
            </h3>

        </div>


        @if (session('success'))
            <div class="alert alert-success">

                {{ session('success') }}

            </div>
        @endif


        @if (session('error'))
            <div class="alert alert-danger">

                {{ session('error') }}

            </div>
        @endif


        <div class="card">

            <div class="card-header">

                <div class="d-flex align-items-center">

                    <h4 class="card-title">
                        Data Sub Kategori Tiket
                    </h4>


                    <a href="{{ route('admin.sub-kategori-tiket.create') }}" class="btn btn-primary btn-round ms-auto">

                        <i class="fa fa-plus"></i>

                        Tambah

                    </a>

                </div>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Kategori</th>

                                <th>Nama Sub Kategori</th>

                                <th>Keterangan</th>

                                <th>Status</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($subKategoriTikets as $subKategori)
                                <tr>

                                    <td>

                                        {{ $subKategoriTikets->firstItem() + $loop->index }}

                                    </td>


                                    <td>

                                        {{ $subKategori->kategori?->nama_kategori ?? '-' }}

                                    </td>


                                    <td>

                                        <strong>

                                            {{ $subKategori->nama_sub_kategori }}

                                        </strong>

                                    </td>


                                    <td>

                                        {{ $subKategori->keterangan ?? '-' }}

                                    </td>


                                    <td>

                                        @if ($subKategori->status === 'AKTIF')
                                            <span class="badge bg-success">

                                                AKTIF

                                            </span>
                                        @else
                                            <span class="badge bg-danger">

                                                TIDAK AKTIF

                                            </span>
                                        @endif

                                    </td>


                                    <td>

                                        <a href="{{ route('admin.sub-kategori-tiket.edit', $subKategori->id) }}"
                                            class="btn btn-warning btn-sm">

                                            <i class="fa fa-edit"></i>

                                        </a>


                                        <form
                                            action="{{ route('admin.sub-kategori-tiket.destroy', $subKategori->id) }}"
                                            method="POST" class="d-inline">

                                            @csrf

                                            @method('DELETE')


                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menonaktifkan sub kategori ini?')">

                                                <i class="fa fa-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center">

                                        Belum ada data sub kategori tiket.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>


                    {{ $subKategoriTikets->links() }}

                </div>

            </div>

        </div>

    </div>
@endsection
