<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriTiket;
use App\Models\SubKategoriTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubKategoriTiketController extends Controller
{
    public function index()
    {
        $subKategoriTikets = SubKategoriTiket::with('kategori')
            ->latest()
            ->paginate(10);

        return view(
            'admin.sub-kategori-tiket.index',
            compact('subKategoriTikets')
        );
    }


    public function create()
    {
        $kategoriTikets = KategoriTiket::where(
            'status',
            'AKTIF'
        )
            ->orderBy('nama_kategori')
            ->get();

        return view(
            'admin.sub-kategori-tiket.create',
            compact('kategoriTikets')
        );
    }


    public function store(Request $request)
    {
        $validated = $request->validate([

            'kategori_tiket_id' => [
                'required',
                'exists:kategori_tiket,id',
            ],

            'nama_sub_kategori' => [
                'required',
                'string',
                'max:100',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],

        ]);


        SubKategoriTiket::create($validated);


        return redirect()
            ->route('admin.sub-kategori-tiket.index')
            ->with(
                'success',
                'Sub kategori tiket berhasil ditambahkan.'
            );
    }


    public function edit(SubKategoriTiket $subKategoriTiket)
    {
        $kategoriTikets = KategoriTiket::where(
            'status',
            'AKTIF'
        )
            ->orderBy('nama_kategori')
            ->get();

        return view(
            'admin.sub-kategori-tiket.edit',
            compact(
                'subKategoriTiket',
                'kategoriTikets'
            )
        );
    }


    public function update(
        Request $request,
        SubKategoriTiket $subKategoriTiket
    ) {
        $validated = $request->validate([

            'kategori_tiket_id' => [
                'required',
                'exists:kategori_tiket,id',
            ],

            'nama_sub_kategori' => [
                'required',
                'string',
                'max:100',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],

        ]);


        $subKategoriTiket->update($validated);


        return redirect()
            ->route('admin.sub-kategori-tiket.index')
            ->with(
                'success',
                'Sub kategori tiket berhasil diperbarui.'
            );
    }


    public function destroy(
        SubKategoriTiket $subKategoriTiket
    ) {
        DB::transaction(function () use (
            $subKategoriTiket
        ) {

            $subKategoriTiket->update([

                'status' => 'TIDAK_AKTIF',

            ]);


            $subKategoriTiket->delete();
        });


        return redirect()
            ->route('admin.sub-kategori-tiket.index')
            ->with(
                'success',
                'Sub kategori tiket berhasil dinonaktifkan.'
            );
    }
}
