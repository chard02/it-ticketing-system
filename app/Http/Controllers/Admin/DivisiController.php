<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisiController extends Controller
{
    public function index()
    {
        $divisi = Divisi::with('unit')
            ->latest()
            ->paginate(10);

        return view('admin.divisi.index', compact('divisi'));
    }

    public function create()
    {
        $unit = Unit::where('status', 'AKTIF')
            ->orderBy('nama_unit')
            ->get();

        return view('admin.divisi.create', compact('unit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => [
                'required',
                'exists:unit,id',
            ],

            'kode_divisi' => [
                'required',
                'string',
                'max:50',
                'unique:divisi,kode_divisi',
            ],

            'nama_divisi' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],
        ]);

        Divisi::create($validated);

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Data divisi berhasil ditambahkan.');
    }

    public function edit(Divisi $divisi)
    {
        $unit = Unit::where('status', 'AKTIF')
            ->orderBy('nama_unit')
            ->get();

        return view('admin.divisi.edit', compact(
            'divisi',
            'unit'
        ));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $validated = $request->validate([
            'unit_id' => [
                'required',
                'exists:unit,id',
            ],
            'kode_divisi' => [
                'required',
                'string',
                'max:50',
                'unique:divisi,kode_divisi,' . $divisi->id,
            ],

            'nama_divisi' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],
        ]);

        $divisi->update($validated);

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Data divisi berhasil diperbarui.');
    }
    public function destroy(Divisi $divisi)
    {
        DB::transaction(function () use ($divisi) {

            // Ubah status menjadi tidak aktif
            $divisi->update([
                'status' => 'TIDAK_AKTIF',
            ]);

            // Soft delete
            $divisi->delete();
        });

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil dinonaktifkan.');
    }
}
