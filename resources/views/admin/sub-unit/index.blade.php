@extends('layouts.admin.app')

@section('title', 'Sub Unit')

@section('content')

    ```
    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Sub Unit
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
                Sub Unit
            </li>

        </ul>

    </div>


    <div class="card">

        <div class="card-header">

            <div class="d-flex align-items-center">

                <h4 class="card-title">
                    Data Sub Unit
                </h4>

                <a href="{{ route('sub-unit.create') }}" class="btn btn-primary btn-round ms-auto">
                    <i class="fa fa-plus"></i>
                    Tambah Sub Unit
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
                                Kode Sub Unit
                            </th>

                            <th>
                                Nama Sub Unit
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

                        @forelse ($subUnit as $item)
                            <tr>

                                <td>
                                    {{ $subUnit->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $item->kode_sub_unit }}
                                </td>

                                <td>
                                    {{ $item->nama_sub_unit }}
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

                                    <a href="{{ route('sub-unit.edit', $item->id) }}" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="{{ route('sub-unit.destroy', $item->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus sub unit ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-4">
                                    Belum ada data sub unit.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if ($subUnit->hasPages())
            <div class="card-footer">

                {{ $subUnit->links() }}

            </div>
        @endif

    </div>
    ```

@endsection
