<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $level = Level::latest()->paginate(10);

        return view('admin.level.index', compact('level'));
    }

    public function create()
    {
        return view('admin.level.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_level' => [
                'required',
                'string',
                'max:100',
                'unique:level,nama_level',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK AKTIF',
            ],
        ]);

        Level::create($validated);

        return redirect()
            ->route('level.index')
            ->with('success', 'Level berhasil ditambahkan.');
    }

    public function edit(Level $level)
    {
        return view('admin.level.edit', compact('level'));
    }

    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'nama_level' => [
                'required',
                'string',
                'max:100',
                'unique:level,nama_level,' . $level->id,
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK AKTIF',
            ],
        ]);

        $level->update($validated);

        return redirect()
            ->route('level.index')
            ->with('success', 'Level berhasil diperbarui.');
    }

    public function destroy(Level $level)
    {
        $level->update([
            'status' => 'TIDAK_AKTIF',
        ]);

        $level->delete();

        return redirect()
            ->route('level.index')
            ->with('success', 'Level berhasil dinonaktifkan.');
    }
}
