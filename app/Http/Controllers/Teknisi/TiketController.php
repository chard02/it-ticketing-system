<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusTiket;
use App\Models\ProgresTiket;
use App\Models\RiwayatTiket;
use App\Models\Akun;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function index()
    {
        $pegawai = Auth::user()->pegawai;

        $tiket = Tiket::with([
            'pelapor',
            'statusTiket',
            'prioritasTiket',
        ])
            ->where('teknisi_id', $pegawai->id)
            ->latest()
            ->paginate(10);

        return view('teknisi.tiket.index', compact('tiket'));
    }


    public function show(Tiket $tiket)
    {
        $pegawai = Auth::user()->pegawai;

        // Pastikan teknisi hanya bisa melihat tiket miliknya
        if ($tiket->teknisi_id !== $pegawai->id) {
            abort(403);
        }

        $tiket->load([
            'jenisTiket',
            'kategoriTiket',
            'subKategoriTiket',
            'prioritasTiket',
            'statusTiket',
            'pelapor',
            'unit',
            'lokasi',
            'lampiran',

            'progres' => function ($query) {
                $query->latest();
            },

            'progres.pegawai',
            'progres.statusTiket',

            'riwayat' => function ($query) {
                $query->latest();
            },

            'riwayat.pegawai',
        ]);

        return view('teknisi.tiket.show', compact('tiket'));
    }

    public function updateStatus(Request $request, Tiket $tiket)
    {
        $request->validate([
            'aksi' => [
                'required',
                'in:DIPROSES,PENDING,SELESAI',
            ],

            'keterangan' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $akun = Auth::user();


        /*
    |--------------------------------------------------------------------------
    | Pastikan teknisi hanya mengupdate tiket miliknya sendiri
    |--------------------------------------------------------------------------
    */

        if (
            !$akun->pegawai ||
            $tiket->teknisi_id !== $akun->pegawai->id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses untuk mengupdate tiket ini.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Cari status berdasarkan aksi
    |--------------------------------------------------------------------------
    */

        $status = StatusTiket::where(
            'nama_status',
            $request->aksi
        )->first();


        if (!$status) {

            return back()->with(
                'error',
                'Status tiket "' . $request->aksi . '" tidak ditemukan.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Update Status Tiket
    |--------------------------------------------------------------------------
    */

        $tiket->status_tiket_id = $status->id;


        if ($request->aksi === 'DIPROSES') {

            $tiket->waktu_diproses = now();
        }


        if ($request->aksi === 'SELESAI') {

            $tiket->waktu_selesai = now();
        }


        $tiket->save();


        /*
    |--------------------------------------------------------------------------
    | Tentukan Persentase Progres
    |--------------------------------------------------------------------------
    */

        $persentaseProgres = match ($request->aksi) {
            'DIPROSES' => 50,
            'PENDING'  => 50,
            'SELESAI'  => 100,
        };


        /*
    |--------------------------------------------------------------------------
    | Simpan Progres Tiket
    |--------------------------------------------------------------------------
    */

        ProgresTiket::create([
            'tiket_id' => $tiket->id,

            'pegawai_id' => $akun->pegawai->id,

            // PERBAIKAN DI SINI
            'status_tiket_id' => $status->id,

            'persentase_progres' => $persentaseProgres,

            'keterangan' => $request->keterangan,
        ]);


        /*
    |--------------------------------------------------------------------------
    | Simpan Riwayat Tiket
    |--------------------------------------------------------------------------
    */

        RiwayatTiket::create([

            'tiket_id' => $tiket->id,

            'pegawai_id' => $akun->pegawai->id,

            'aktivitas' => $this->getAktivitas(
                $request->aksi
            ),

            'keterangan' => $request->keterangan,

        ]);


        /*
    |--------------------------------------------------------------------------
    | Reload Relasi
    |--------------------------------------------------------------------------
    */

        $tiket->load([
            'pelapor',
            'teknisi',
        ]);


        /*
    |--------------------------------------------------------------------------
    | Kirim Notifikasi
    |--------------------------------------------------------------------------
    */

        $this->kirimNotifikasi(
            $tiket,
            $request->aksi,
            $request->keterangan
        );


        return back()->with(
            'success',
            'Status tiket berhasil diperbarui.'
        );
    }

    private function getAktivitas(string $aksi): string
    {
        return match ($aksi) {
            'DIPROSES' => 'Tiket sedang diproses',
            'PENDING'  => 'Tiket ditunda',
            'SELESAI'  => 'Tiket telah diselesaikan',
            default    => 'Status tiket diperbarui',
        };
    }

    private function kirimNotifikasi(
        Tiket $tiket,
        string $aksi,
        string $keterangan
    ): void {

        $pesan = match ($aksi) {
            'DIPROSES' => 'Tiket sedang diproses oleh teknisi.',
            'PENDING'  => 'Tiket ditunda oleh teknisi.',
            'SELESAI'  => 'Tiket telah diselesaikan oleh teknisi.',
            default    => 'Status tiket telah diperbarui.',
        };


        /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI KE PELAPOR
    |--------------------------------------------------------------------------
    */

        if ($tiket->pelapor?->akun) {

            $tiket->pelapor->akun->notify(
                new \App\Notifications\TiketStatusNotification(
                    $tiket,
                    $pesan,
                    $keterangan
                )
            );
        }


        /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI KE ADMIN
    |--------------------------------------------------------------------------
    */

        $admins = \App\Models\Akun::whereHas(
            'level',
            function ($query) {
                $query->whereIn(
                    'nama_level',
                    [
                        'Super Admin',
                        'Admin IT',
                        'Manager IT',
                    ]
                );
            }
        )
            ->where('status', 'AKTIF')
            ->get();


        foreach ($admins as $admin) {

            $admin->notify(
                new \App\Notifications\TiketStatusNotification(
                    $tiket,
                    $pesan,
                    $keterangan
                )
            );
        }
    }
}
