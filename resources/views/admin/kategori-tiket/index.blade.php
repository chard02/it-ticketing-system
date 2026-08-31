@extends('layouts.admin.app')

@section('content')

<div class="page-inner">

    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Kategori Tiket
        </h3>

    </div>


    @if (session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    <div class="card">

        <div class="card-header">

            <div class="d-flex align-items-center">

                <h4 class="card-title">
                    Data Kategori Tiket
                </h4>


                <a
                    href="{{ route('admin.kategori-tiket.create') }}"
                    class="btn btn-primary btn-round ms-auto"
                >

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

                            <th>Nama Kategori</th>

                            <th>Keterangan</th>

                            <th>Status</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($kategoriTikets as $kategori)

                            <tr>

                                <td>

                                    {{ $kategoriTikets->firstItem() + $loop->index }}

                                </td>


                                <td>

                                    <strong>

                                        {{ $kategori->nama_kategori }}

                                    </strong>

                                </td>


                                <td>

                                    {{ $kategori->keterangan ?? '-' }}

                                </td>


                                <td>

                                    @if ($kategori->status === 'AKTIF')

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

                                    <a
                                        href="{{ route(
                                            'admin.kategori-tiket.edit',
                                            $kategori->id
                                        ) }}"
                                        class="btn btn-warning btn-sm"
                                    >

                                        <i class="fa fa-edit"></i>

                                    </a>


                                    <form
                                        action="{{ route(
                                            'admin.kategori-tiket.destroy',
                                            $kategori->id
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menonaktifkan kategori ini?')"
                                        >

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center"
                                >

                                    Belum ada data kategori tiket.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>


                {{ $kategoriTikets->links() }}

            </div>

        </div>

    </div>

</div>

@endsection