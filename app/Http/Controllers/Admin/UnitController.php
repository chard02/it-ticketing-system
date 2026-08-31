<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Menampilkan daftar Unit.
     */
    public function index()
    {
        $unit = Unit::latest()
            ->paginate(10);

        return view('admin.unit.index', compact('unit'));
    }


    /**
     * Menampilkan form tambah Unit.
     */
    public function create()
    {
        return view('admin.unit.create');
    }


    /**
     * Menyimpan Unit baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_unit' => [
                'required',
                'string',
                'max:50',
                'unique:unit,kode_unit',
            ],

            'nama_unit' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],
        ]);


        Unit::create($validated);


        return redirect()
            ->route('unit.index')
            ->with('success', 'Data unit berhasil ditambahkan.');
    }


    /**
     * Menampilkan form edit Unit.
     */
    public function edit(Unit $unit)
    {
        return view('admin.unit.edit', compact('unit'));
    }


    /**
     * Memperbarui data Unit.
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'kode_unit' => [
                'required',
                'string',
                'max:50',
                'unique:unit,kode_unit,' . $unit->id,
            ],

            'nama_unit' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],
        ]);


        $unit->update($validated);


        return redirect()
            ->route('unit.index')
            ->with('success', 'Data unit berhasil diperbarui.');
    }


    /**
     * Menonaktifkan dan soft delete Unit.
     */
    public function destroy(Unit $unit)
    {
        $unit->update([
            'status' => 'TIDAK_AKTIF',
        ]);


        $unit->delete();


        return redirect()
            ->route('unit.index')
            ->with('success', 'Data unit berhasil dinonaktifkan.');
    }
}
