<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubUnitController extends Controller
{
    public function index()
    {
        $subUnit = SubUnit::with('unit')
            ->latest()
            ->paginate(10);

        return view('admin.sub-unit.index', compact('subUnit'));
    }

    public function create()
    {
        $unit = Unit::where('status', 'AKTIF')
            ->orderBy('nama_unit')
            ->get();

        return view('admin.sub-unit.create', compact('unit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => [
                'required',
                'exists:unit,id',
            ],

            'kode_sub_unit' => [
                'required',
                'string',
                'max:50',
                'unique:sub_unit,kode_sub_unit',
            ],

            'nama_sub_unit' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],
        ]);

        SubUnit::create($validated);

        return redirect()
            ->route('sub-unit.index')
            ->with('success', 'Data sub unit berhasil ditambahkan.');
    }

    public function edit(SubUnit $subUnit)
    {
        $unit = Unit::where('status', 'AKTIF')
            ->orderBy('nama_unit')
            ->get();

        return view('admin.sub-unit.edit', compact(
            'subUnit',
            'unit'
        ));
    }

    public function update(Request $request, SubUnit $subUnit)
    {
        $validated = $request->validate([
            'unit_id' => [
                'required',
                'exists:unit,id',
            ],

            'kode_sub_unit' => [
                'required',
                'string',
                'max:50',
                'unique:sub_unit,kode_sub_unit,' . $subUnit->id,
            ],

            'nama_sub_unit' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK_AKTIF',
            ],
        ]);

        $subUnit->update($validated);

        return redirect()
            ->route('sub-unit.index')
            ->with('success', 'Data sub unit berhasil diperbarui.');
    }

    public function destroy(SubUnit $subUnit)
    {
        DB::transaction(function () use ($subUnit) {

            $subUnit->update([
                'status' => 'TIDAK_AKTIF',
            ]);

            $subUnit->delete();
        });

        return redirect()
            ->route('sub-unit.index')
            ->with('success', 'Sub unit berhasil dinonaktifkan.');
    }
}
