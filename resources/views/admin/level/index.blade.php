@extends('layouts.admin.app')

@section('title', 'Level')

@section('content')

    <div class="page-header">
        <h3 class="fw-bold mb-3">Level</h3>

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
                Level
            </li>
        </ul>
    </div>

    <div class="card card-round">

        <div class="card-header">
            <div class="card-head-row">

                <div class="card-title">
                    Data Level
                </div>

                <div class="card-tools">
                    <a href="{{ route('level.create') }}" class="btn btn-primary btn-round">
                        <i class="fa fa-plus"></i>
                        Tambah Level
                    </a>
                </div>

            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Level</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($level as $item)
                            <tr>

                                <td>
                                    {{ $level->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $item->nama_level }}
                                </td>

                                <td>
                                    {{ $item->keterangan ?? '-' }}
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

                                    <a href="{{ route('level.edit', $item) }}" class="btn btn-sm btn-primary">

                                        <i class="fa fa-edit"></i>

                                    </a>

                                    <form action="{{ route('level.destroy', $item) }}" method="POST" class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data level.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $level->links() }}
            </div>

        </div>

    </div>

@endsection
