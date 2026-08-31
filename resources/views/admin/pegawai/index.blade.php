@extends('layouts.admin.app')

@section('title', 'Data Pegawai')

@section('content')

    <div class="page-header">
        <h3 class="fw-bold mb-3">
            Data Pegawai
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
                <a href="#">
                    Pegawai
                </a>
            </li>

        </ul>
    </div>


    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="card-title">
                    Daftar Pegawai
                </h4>

                <a href="{{ route('pegawai.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    Tambah Pegawai
                </a>

            </div>

        </div>


        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">

                    {{ session('success') }}

                </div>
            @endif


            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>NIP</th>

                            <th>Nama</th>

                            <th>Unit</th>

                            <th>Jabatan</th>

                            <th>Username</th>

                            <th>Level</th>

                            <th>Status</th>

                            <th class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($pegawai as $item)
                            <tr>

                                <td>

                                    {{ $pegawai->firstItem() + $loop->index }}

                                </td>


                                <td>

                                    {{ $item->nip }}

                                </td>


                                <td>

                                    <strong>

                                        {{ $item->nama }}

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ $item->email }}

                                    </small>

                                </td>


                                <td>

                                    {{ $item->unit->nama_unit ?? '-' }}

                                </td>


                                <td>

                                    {{ $item->jabatan->nama_jabatan ?? '-' }}

                                </td>


                                <td>

                                    {{ $item->akun->username ?? '-' }}

                                </td>


                                <td>

                                    {{ $item->akun->level->nama_level ?? '-' }}

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


                                <td>

                                    <div class="d-flex justify-content-center gap-1">

                                        <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-warning btn-sm">

                                            <i class="fa fa-edit"></i>

                                        </a>


                                        <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data pegawai ini?')">

                                            @csrf

                                            @method('DELETE')


                                            <button type="submit" class="btn btn-danger btn-sm">

                                                <i class="fa fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9" class="text-center">

                                    Belum ada data pegawai.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-3">

                {{ $pegawai->links() }}

            </div>

        </div>

    </div>

@endsection
