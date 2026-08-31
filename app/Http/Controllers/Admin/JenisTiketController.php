<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisTiketController extends Controller
{
    public function index()
    {
        $jenisTikets = JenisTiket::latest()->paginate(10);

        return view(
            'admin.jenis-tiket.index',
            compact('jenisTikets')
        );
    }


    public function create()
    {
        return view(
            'admin.jenis-tiket.create'
        );
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis' => [
                'required',
                'string',
                'max:100',
                'unique:jenis_tiket,nama_jenis',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK AKTIF',
            ],
        ]);

        JenisTiket::create($validated);

        return redirect()
            ->route('admin.jenis-tiket.index')
            ->with(
                'success',
                'Jenis tiket berhasil ditambahkan.'
            );
    }


    public function edit(JenisTiket $jenisTiket)
    {
        return view(
            'admin.jenis-tiket.edit',
            compact('jenisTiket')
        );
    }


    public function update(
        Request $request,
        JenisTiket $jenisTiket
    ) {
        $validated = $request->validate([
            'nama_jenis' => [
                'required',
                'string',
                'max:100',
                'unique:jenis_tiket,nama_jenis,' . $jenisTiket->id,
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK AKTIF',
            ],
        ]);

        $jenisTiket->update($validated);

        return redirect()
            ->route('admin.jenis-tiket.index')
            ->with(
                'success',
                'Jenis tiket berhasil diperbarui.'
            );
    }


    public function destroy(JenisTiket $jenisTiket)
    {
        DB::transaction(function () use ($jenisTiket) {

            $jenisTiket->update([
                'status' => 'TIDAK_AKTIF',
            ]);

            $jenisTiket->delete();
        });


        return redirect()
            ->route('admin.jenis-tiket.index')
            ->with(
                'success',
                'Jenis tiket berhasil dinonaktifkan.'
            );
    }
}
