@extends('layouts.admin.app')

@section('title', 'Divisi')

@section('content')

    ```
    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Divisi
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
                Divisi
            </li>

        </ul>

    </div>


    <div class="card">

        <div class="card-header">

            <div class="d-flex align-items-center">

                <h4 class="card-title">
                    Data Divisi
                </h4>

                <a href="{{ route('divisi.create') }}" class="btn btn-primary btn-round ms-auto">
                    <i class="fa fa-plus"></i>
                    Tambah Divisi
                </a>

            </div>

        </div>


        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">

                    <i class="fa fa-check-circle me-1"></i>

                    {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                </div>
            @endif


            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                Kode Divisi
                            </th>

                            <th>
                                Nama Divisi
                            </th>

                            <th>
                                Unit
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="150" class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($divisi as $item)
                            <tr>

                                <td>
                                    {{ $divisi->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $item->kode_divisi }}
                                </td>

                                <td>
                                    {{ $item->nama_divisi }}
                                </td>

                                <td>
                                    {{ $item->unit?->nama_unit ?? '-' }}
                                </td>

                                <td>

                                    @if ($item->status === 'AKTIF')
                                        <span class="badge badge-success">
                                            AKTIF
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            TIDAK AKTIF
                                        </span>
                                    @endif

                                </td>

                                <td class="text-center">

                                    <a href="{{ route('divisi.edit', $item->id) }}" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>


                                    <form action="{{ route('divisi.destroy', $item->id) }}" method="POST" class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus divisi ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-4">
                                    Belum ada data divisi.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if ($divisi->hasPages())
            <div class="card-footer">

                {{ $divisi->links() }}

            </div>
        @endif

    </div>
    ```

@endsection
