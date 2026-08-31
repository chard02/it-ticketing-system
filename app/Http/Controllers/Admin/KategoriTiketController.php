<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriTiketController extends Controller
{
    public function index()
    {
        $kategoriTikets = KategoriTiket::latest()
            ->paginate(10);

        return view(
            'admin.kategori-tiket.index',
            compact('kategoriTikets')
        );
    }


    public function create()
    {
        return view(
            'admin.kategori-tiket.create'
        );
    }


    public function store(Request $request)
    {
        $validated = $request->validate([

            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'unique:kategori_tiket,nama_kategori',
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


        KategoriTiket::create($validated);


        return redirect()
            ->route('admin.kategori-tiket.index')
            ->with(
                'success',
                'Kategori tiket berhasil ditambahkan.'
            );
    }


    public function edit(KategoriTiket $kategoriTiket)
    {
        return view(
            'admin.kategori-tiket.edit',
            compact('kategoriTiket')
        );
    }


    public function update(
        Request $request,
        KategoriTiket $kategoriTiket
    ) {
        $validated = $request->validate([

            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'unique:kategori_tiket,nama_kategori,' .
                    $kategoriTiket->id,
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


        $kategoriTiket->update($validated);


        return redirect()
            ->route('admin.kategori-tiket.index')
            ->with(
                'success',
                'Kategori tiket berhasil diperbarui.'
            );
    }


    public function destroy(KategoriTiket $kategoriTiket)
    {
        DB::transaction(function () use ($kategoriTiket) {

            $kategoriTiket->update([

                'status' => 'TIDAK_AKTIF',

            ]);


            $kategoriTiket->delete();
        });


        return redirect()
            ->route('admin.kategori-tiket.index')
            ->with(
                'success',
                'Kategori tiket berhasil dinonaktifkan.'
            );
    }
}
