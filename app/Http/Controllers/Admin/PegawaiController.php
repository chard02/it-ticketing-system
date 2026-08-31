<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Level;
use App\Models\Lokasi;
use App\Models\Pegawai;
use App\Models\SubUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with([
            'unit',
            'subUnit',
            'divisi',
            'jabatan',
            'lokasi',
            'akun.level',
        ])
            ->latest()
            ->paginate(10);

        return view('admin.pegawai.index', compact('pegawai'));
    }


    public function create()
    {
        $unit = Unit::where('status', 'AKTIF')
            ->orderBy('nama_unit')
            ->get();

        $subUnit = SubUnit::where('status', 'AKTIF')
            ->orderBy('nama_sub_unit')
            ->get();

        $divisi = Divisi::where('status', 'AKTIF')
            ->orderBy('nama_divisi')
            ->get();

        $jabatan = Jabatan::where('status', 'AKTIF')
            ->orderBy('nama_jabatan')
            ->get();

        $lokasi = Lokasi::where('status', 'AKTIF')
            ->orderBy('nama_lokasi')
            ->get();

        $level = Level::where('status', 'AKTIF')
            ->orderBy('nama_level')
            ->get();

        return view('admin.pegawai.create', compact(
            'unit',
            'subUnit',
            'divisi',
            'jabatan',
            'lokasi',
            'level'
        ));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'max:50',
                'unique:pegawai,nip',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:pegawai,email',
            ],

            'nomor_telepon' => [
                'nullable',
                'string',
                'max:30',
            ],

            'jenis_kelamin' => [
                'required',
                'in:LAKI_LAKI,PEREMPUAN',
            ],

            'unit_id' => [
                'required',
                'exists:unit,id',
            ],

            'sub_unit_id' => [
                'nullable',
                'exists:sub_unit,id',
            ],

            'divisi_id' => [
                'nullable',
                'exists:divisi,id',
            ],

            'jabatan_id' => [
                'nullable',
                'exists:jabatan,id',
            ],

            'lokasi_id' => [
                'nullable',
                'exists:lokasi,id',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK AKTIF',
            ],

            /*
            |--------------------------------------------------------------------------
            | Akun
            |--------------------------------------------------------------------------
            */

            'level_id' => [
                'required',
                'exists:level,id',
            ],

            'username' => [
                'required',
                'string',
                'max:100',
                'unique:akun,username',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);


        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | Simpan Pegawai
            |--------------------------------------------------------------------------
            */

            $pegawai = Pegawai::create([
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'email' => $validated['email'] ?? null,
                'nomor_telepon' => $validated['nomor_telepon'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'unit_id' => $validated['unit_id'],
                'sub_unit_id' => $validated['sub_unit_id'] ?? null,
                'divisi_id' => $validated['divisi_id'] ?? null,
                'jabatan_id' => $validated['jabatan_id'] ?? null,
                'lokasi_id' => $validated['lokasi_id'] ?? null,
                'status' => $validated['status'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Otomatis Buat Akun
            |--------------------------------------------------------------------------
            */

            Akun::create([
                'pegawai_id' => $pegawai->id,
                'level_id' => $validated['level_id'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'status' => $validated['status'],
            ]);
        });


        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai dan akun berhasil ditambahkan.');
    }


    public function edit(Pegawai $pegawai)
    {
        $pegawai->load('akun');

        $unit = Unit::where('status', 'AKTIF')
            ->orderBy('nama_unit')
            ->get();

        $subUnit = SubUnit::where('status', 'AKTIF')
            ->orderBy('nama_sub_unit')
            ->get();

        $divisi = Divisi::where('status', 'AKTIF')
            ->orderBy('nama_divisi')
            ->get();

        $jabatan = Jabatan::where('status', 'AKTIF')
            ->orderBy('nama_jabatan')
            ->get();

        $lokasi = Lokasi::where('status', 'AKTIF')
            ->orderBy('nama_lokasi')
            ->get();

        $level = Level::where('status', 'AKTIF')
            ->orderBy('nama_level')
            ->get();

        return view('admin.pegawai.edit', compact(
            'pegawai',
            'unit',
            'subUnit',
            'divisi',
            'jabatan',
            'lokasi',
            'level'
        ));
    }


    public function update(Request $request, Pegawai $pegawai)
    {
        $akun = $pegawai->akun;

        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'max:50',
                'unique:pegawai,nip,' . $pegawai->id,
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:pegawai,email,' . $pegawai->id,
            ],

            'nomor_telepon' => [
                'nullable',
                'string',
                'max:30',
            ],

            'jenis_kelamin' => [
                'required',
                'in:LAKI_LAKI,PEREMPUAN',
            ],

            'unit_id' => [
                'required',
                'exists:unit,id',
            ],

            'sub_unit_id' => [
                'nullable',
                'exists:sub_unit,id',
            ],

            'divisi_id' => [
                'nullable',
                'exists:divisi,id',
            ],

            'jabatan_id' => [
                'nullable',
                'exists:jabatan,id',
            ],

            'lokasi_id' => [
                'nullable',
                'exists:lokasi,id',
            ],

            'status' => [
                'required',
                'in:AKTIF,TIDAK AKTIF',
            ],

            'level_id' => [
                'required',
                'exists:level,id',
            ],

            'username' => [
                'required',
                'string',
                'max:100',
                'unique:akun,username,' . ($akun?->id ?? 0),
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);


        DB::transaction(function () use (
            $validated,
            $pegawai,
            $akun
        ) {

            $pegawai->update([
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'email' => $validated['email'] ?? null,
                'nomor_telepon' => $validated['nomor_telepon'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'unit_id' => $validated['unit_id'],
                'sub_unit_id' => $validated['sub_unit_id'] ?? null,
                'divisi_id' => $validated['divisi_id'] ?? null,
                'jabatan_id' => $validated['jabatan_id'] ?? null,
                'lokasi_id' => $validated['lokasi_id'] ?? null,
                'status' => $validated['status'],
            ]);


            $dataAkun = [
                'level_id' => $validated['level_id'],
                'username' => $validated['username'],
                'status' => $validated['status'],
            ];


            if (!empty($validated['password'])) {
                $dataAkun['password'] = Hash::make(
                    $validated['password']
                );
            }


            if ($akun) {

                $akun->update($dataAkun);
            } else {

                $dataAkun['pegawai_id'] = $pegawai->id;

                $dataAkun['password'] = Hash::make(
                    $validated['password']
                );

                Akun::create($dataAkun);
            }
        });


        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }


    public function destroy(Pegawai $pegawai)
    {
        DB::transaction(function () use ($pegawai) {

            if ($pegawai->akun) {

                $pegawai->akun->update([
                    'status' => 'TIDAK_AKTIF',
                ]);

                $pegawai->akun->delete();
            }

            $pegawai->update([
                'status' => 'TIDAK_AKTIF',
            ]);


            $pegawai->delete();
        });


        return redirect()
            ->route('pegawai.index')
            ->with(
                'success',
                'Data pegawai berhasil dinonaktifkan.'
            );
    }
}
