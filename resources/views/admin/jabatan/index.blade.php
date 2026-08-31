```blade
@extends('layouts.admin.app')

@section('title', 'Jabatan')

@section('content')

    <div class="page-header">

        <h3 class="fw-bold mb-3">
            Jabatan
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
                Jabatan
            </li>

        </ul>

    </div>


    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <h4 class="card-title">
                    Data Jabatan
                </h4>

                <div class="card-tools">

                    <a href="{{ route('jabatan.create') }}" class="btn btn-primary btn-round">

                        <i class="fa fa-plus"></i>

                        Tambah Jabatan

                    </a>

                </div>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                Unit
                            </th>

                            <th>
                                Kode Jabatan
                            </th>

                            <th>
                                Nama Jabatan
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="180" class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($jabatan as $item)
                            <tr>

                                <td>
                                    {{ $jabatan->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $item->unit->nama_unit ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->kode_jabatan }}
                                </td>

                                <td>
                                    {{ $item->nama_jabatan }}
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

                                    <a href="{{ route('jabatan.edit', $item) }}" class="btn btn-sm btn-warning">

                                        <i class="fa fa-edit"></i>

                                    </a>


                                    <form action="{{ route('jabatan.destroy', $item) }}" method="POST" class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Nonaktifkan jabatan ini?')">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center">

                                    Belum ada data jabatan.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-3">

                {{ $jabatan->links() }}

            </div>

        </div>

    </div>

@endsection
```
