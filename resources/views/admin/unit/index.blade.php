@extends('layouts.admin.app')
@section('title', 'Data Unit')
@section('content')
    <div class="page-header">
        <h3 class="fw-bold mb-3">
            Data Unit
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
                Unit
            </li>
        </ul>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">
                    Daftar Unit
                </h4>
                <a href="{{ route('unit.create') }}" class="btn btn-primary btn-round ms-auto">
                    <i class="fa fa-plus"></i>
                    Tambah Unit
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">
                                No
                            </th>

                            <th>
                                Kode Unit
                            </th>

                            <th>
                                Nama Unit
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-center" width="15%">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($unit as $item)
                            <tr>

                                <td>

                                    {{ $unit->firstItem() + $loop->index }}

                                </td>


                                <td>

                                    {{ $item->kode_unit }}

                                </td>


                                <td>

                                    {{ $item->nama_unit }}

                                </td>


                                <td>

                                    @if ($item->status === 'AKTIF')
                                        <span class="badge badge-success">
                                            AKTIF
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            TIDAK AKTIF
                                        </span>
                                    @endif

                                </td>


                                <td class="text-center">

                                    {{-- EDIT --}}

                                    <a href="{{ route('unit.edit', $item->id) }}" class="btn btn-warning btn-sm">

                                        <i class="fa fa-edit"></i>

                                    </a>


                                    {{-- HAPUS --}}

                                    <form action="{{ route('unit.destroy', $item->id) }}" method="POST" class="d-inline">

                                        @csrf

                                        @method('DELETE')


                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menonaktifkan unit ini?')">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">

                                    Data unit belum tersedia.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}

            <div class="mt-3">

                {{ $unit->links() }}

            </div>

        </div>

    </div>
    ```

@endsection
