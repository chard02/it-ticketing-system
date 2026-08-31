@extends('layouts.admin.app')
@section('title', 'Jenis-Tiket')
@section('content')
    <div class="page-inner">

        <div class="page-header">

            <h3 class="fw-bold mb-3">
                Jenis Tiket
            </h3>

        </div>


        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h4 class="card-title">

                    Data Jenis Tiket

                </h4>


                <a href="{{ route('admin.jenis-tiket.create') }}" class="btn btn-primary">

                    <i class="fa fa-plus"></i>

                    Tambah Jenis Tiket

                </a>

            </div>


            <div class="card-body">


                @if (session('success'))
                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>
                @endif


                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>
                            <tr>

                                <th>No</th>

                                <th>Nama Jenis</th>

                                <th>Keterangan</th>

                                <th>Status</th>

                                <th>Aksi</th>

                            </tr>
                        </thead>


                        <tbody>

                            @forelse ($jenisTikets as $jenis)
                                <tr>

                                    <td>
                                        {{ $jenisTikets->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $jenis->nama_jenis }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $jenis->keterangan ?? '-' }}
                                    </td>

                                    <td>

                                        @if ($jenis->status === 'AKTIF')
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

                                        <a href="{{ route('admin.jenis-tiket.edit', $jenis->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>


                                        <form action="{{ route('admin.jenis-tiket.destroy', $jenis->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus jenis tiket ini?')">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center">

                                        Belum ada data jenis tiket.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="mt-3">

                    {{ $jenisTikets->links() }}

                </div>


            </div>

        </div>

    </div>
@endsection
