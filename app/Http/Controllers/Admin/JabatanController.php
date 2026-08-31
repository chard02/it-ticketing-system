<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Unit;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::with('unit')
            ->latest()
            ->paginate(10);

        return view('admin.jabatan.index', compact('jabatan'));
    }


    public function create()
    {
        $unit = Unit::where('status', 'AKTIF')
            ->orderBy('nama_unit')
            ->get();

        return view('admin.jabatan.create', compact('unit'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => [
                'required',
                'exists:unit,id',
            ],

            'kode_jabatan' => [
                'required',
                'string',
                'max:50',
                'unique:jabatan,kode_jabatan',
            ],

            'nama_jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],
        ]);

        Jabatan::create($validated);

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }


    public function edit(Jabatan $jabatan)
    {
        $unit = Unit::where('status', 'AKTIF')
            ->orderBy('nama_unit')
            ->get();

        return view('admin.jabatan.edit', compact(
            'jabatan',
            'unit'
        ));
    }


    public function update(Request $request, Jabatan $jabatan)
    {
        $validated = $request->validate([
            'unit_id' => [
                'required',
                'exists:unit,id',
            ],

            'kode_jabatan' => [
                'required',
                'string',
                'max:50',
                'unique:jabatan,kode_jabatan,' . $jabatan->id,
            ],

            'nama_jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],
        ]);

        $jabatan->update($validated);

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }


    public function destroy(Jabatan $jabatan)
    {
        $jabatan->update([
            'status' => 'TIDAK_AKTIF',
        ]);

        $jabatan->delete();

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Jabatan berhasil dinonaktifkan.');
    }
}
