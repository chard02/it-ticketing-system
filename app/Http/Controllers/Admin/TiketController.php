<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PrioritasTiket;
use App\Models\StatusTiket;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RiwayatTiket;
use App\Notifications\TiketNotification;
use App\Models\Akun;
use App\Models\KonfirmasiTiket;

class TiketController extends Controller
{
    /**
     * Daftar semua tiket.
     */
    public function index(Request $request)
    {
        $query = Tiket::with([
            'pelapor',
            'teknisi',
            'kategoriTiket',
            'subKategoriTiket',
            'jenisTiket',
            'prioritasTiket',
            'statusTiket',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status_tiket_id', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Prioritas
        |--------------------------------------------------------------------------
        */

        if ($request->filled('prioritas')) {
            $query->where(
                'prioritas_tiket_id',
                $request->prioritas
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pencarian
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nomor_tiket',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'judul',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas('pelapor', function ($q) use ($search) {
                        $q->where(
                            'nama',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        $tiket = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Data Filter
        |--------------------------------------------------------------------------
        */

        $statusTiket = StatusTiket::where(
            'status',
            'AKTIF'
        )
            ->orderBy('urutan')
            ->get();

        $prioritasTiket = PrioritasTiket::where(
            'status',
            'AKTIF'
        )
            ->orderBy('urutan')
            ->get();


        return view(
            'admin.tiket.index',
            compact(
                'tiket',
                'statusTiket',
                'prioritasTiket'
            )
        );
    }


    /**
     * Detail tiket.
     */
    public function show(Tiket $tiket)
    {
        $tiket->load([
            'jenisTiket',
            'kategoriTiket',
            'subKategoriTiket',
            'prioritasTiket',
            'statusTiket',

            'pelapor.jabatan',
            'pelapor.lokasi',
            'pelapor.unit',
            'pelapor.subUnit',
            'pelapor.divisi',

            'teknisi',
            'unit',
            'lokasi',

            'lampiran.pegawai',

            'progres' => function ($query) {
                $query->latest();
            },

            'progres.pegawai',
            'progres.statusTiket',

            'riwayat' => function ($query) {
                $query->latest();
            },

            'riwayat.pegawai',

            'konfirmasi.pegawai',

            'konfirmasiTerbaru.pegawai',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Ambil hanya pegawai dengan role TEKNISI
    |--------------------------------------------------------------------------
    */

        $teknisi = Pegawai::with([
            'akun.level',
        ])
            ->whereHas('akun.level', function ($query) {
                $query->where('nama_level', 'Teknisi')
                    ->where('status', 'AKTIF');
            })
            ->whereHas('akun', function ($query) {
                $query->where('status', 'AKTIF');
            })
            ->get();


        $prioritas = PrioritasTiket::where(
            'status',
            'AKTIF'
        )
            ->orderBy('urutan')
            ->get();


        return view(
            'admin.tiket.show',
            compact(
                'tiket',
                'teknisi',
                'prioritas'
            )
        );
    }
    /**
     * Assign teknisi dan prioritas tiket.
     */
    public function assign(Request $request, Tiket $tiket)
    {
        $validated = $request->validate([
            'teknisi_id' => [
                'required',
                'exists:pegawai,id',
            ],

            'prioritas_tiket_id' => [
                'required',
                'exists:prioritas_tiket,id',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $tiket
        ) {

            $statusDitugaskan = StatusTiket::where(
                'nama_status',
                'DITUGASKAN'
            )->firstOrFail();


            $tiket->update([

                'teknisi_id' =>
                $validated['teknisi_id'],

                'prioritas_tiket_id' =>
                $validated['prioritas_tiket_id'],

                'status_tiket_id' =>
                $statusDitugaskan->id,

                'waktu_ditugaskan' =>
                now(),
            ]);


            RiwayatTiket::create([

                'tiket_id' =>
                $tiket->id,

                'pegawai_id' =>
                Auth::user()->pegawai_id,

                'aktivitas' =>
                'Tiket ditugaskan',

                'keterangan' =>
                'Tiket ditugaskan kepada teknisi.',
            ]);


            /*
        |--------------------------------------------------------------------------
        | Cari akun teknisi
        |--------------------------------------------------------------------------
        */

            $akunTeknisi = Akun::where(
                'pegawai_id',
                $validated['teknisi_id']
            )->first();


            if ($akunTeknisi) {

                $akunTeknisi->notify(
                    new TiketNotification(

                        $tiket,

                        'Tiket Baru Ditugaskan',

                        'Anda mendapatkan tugas tiket ' .
                            $tiket->nomor_tiket .
                            ': ' .
                            $tiket->judul,

                        route(
                            'teknisi.tiket.show',
                            $tiket->id
                        )
                    )
                );
            }
        });

        return redirect()
            ->route(
                'admin.tiket.show',
                $tiket->id
            )
            ->with(
                'success',
                'Teknisi dan prioritas berhasil ditugaskan.'
            );
    }

    public function approveKonfirmasi(Tiket $tiket)
    {

        $konfirmasi = KonfirmasiTiket::where(
            'tiket_id',
            $tiket->id
        )
            ->latest()
            ->first();


        if (!$konfirmasi) {

            return back()->with(
                'error',
                'Konfirmasi pegawai tidak ditemukan.'
            );
        }

        $statusSekarang = strtoupper(
            $tiket->statusTiket?->nama_status
        );


        if ($statusSekarang !== 'MENUNGGU APPROVAL') {

            return back()->with(
                'error',
                'Tiket ini tidak sedang menunggu approval.'
            );
        }


        DB::transaction(function () use (
            $tiket,
            $konfirmasi
        ) {

            if (
                strtoupper($konfirmasi->status_konfirmasi)
                === 'SELESAI'
            ) {

                $statusDitutup = StatusTiket::where(
                    'nama_status',
                    'DITUTUP'
                )->firstOrFail();


                $tiket->update([

                    'status_tiket_id' => $statusDitutup->id,

                    'waktu_ditutup' => now(),

                ]);


                RiwayatTiket::create([

                    'tiket_id' => $tiket->id,

                    'pegawai_id' => null,

                    'aktivitas' =>
                    'Konfirmasi penyelesaian disetujui Admin',

                    'keterangan' =>
                    'Admin menyetujui konfirmasi pegawai. Tiket ditutup.',

                ]);
            }

            if (
                strtoupper($konfirmasi->status_konfirmasi)
                === 'BELUM_SELESAI'
            ) {

                $statusDiproses = StatusTiket::where(
                    'nama_status',
                    'DIPROSES'
                )->firstOrFail();


                $tiket->update([

                    'status_tiket_id' => $statusDiproses->id,

                    'waktu_selesai' => null,

                ]);


                RiwayatTiket::create([

                    'tiket_id' => $tiket->id,

                    'pegawai_id' => null,

                    'aktivitas' =>
                    'Tiket dibuka kembali oleh Admin',

                    'keterangan' =>
                    'Admin menyetujui permintaan buka kembali dari pegawai. ' .
                        'Tiket dikembalikan kepada teknisi yang sama. ' .
                        'Alasan: ' .
                        ($konfirmasi->alasan ?? '-'),

                ]);
            }
        });

        $tiket->refresh();

        $tiket->load([
            'pelapor.akun',
            'teknisi.akun',
        ]);


        if ($tiket->teknisi?->akun) {

            if (
                strtoupper($konfirmasi->status_konfirmasi)
                === 'BELUM_SELESAI'
            ) {

                $tiket->teknisi->akun->notify(

                    new \App\Notifications\TiketStatusNotification(

                        $tiket,

                        'Tiket dibuka kembali oleh Admin.',

                        'Alasan dari pelapor: ' .
                            ($konfirmasi->alasan ?? '-')

                    )

                );
            }
        }

        if ($tiket->pelapor?->akun) {

            $pesan =
                strtoupper($konfirmasi->status_konfirmasi)
                === 'SELESAI'

                ? 'Admin telah menyetujui penyelesaian tiket. Tiket telah ditutup.'

                : 'Admin telah menyetujui permintaan buka kembali. Tiket akan dikerjakan kembali oleh teknisi.';


            $keterangan =
                strtoupper($konfirmasi->status_konfirmasi) === 'SELESAI'

                ? 'Konfirmasi penyelesaian tiket telah disetujui oleh Admin.'

                : 'Alasan: ' . ($konfirmasi->alasan ?? '-');


            $tiket->pelapor->akun->notify(

                new \App\Notifications\TiketStatusNotification(

                    $tiket,

                    $pesan,

                    $keterangan

                )

            );
        }


        return back()->with(
            'success',

            strtoupper($konfirmasi->status_konfirmasi)
                === 'SELESAI'

                ? 'Konfirmasi selesai telah disetujui. Tiket berhasil ditutup.'

                : 'Permintaan buka kembali telah disetujui. Tiket dikembalikan ke teknisi.'
        );
    }

    public function bukaKembali(Tiket $tiket)
    {
        $tiket->load('statusTiket');


        $statusSekarang = strtoupper(
            $tiket->statusTiket?->nama_status ?? ''
        );


        if ($statusSekarang !== 'DITUTUP') {

            return back()->with(
                'error',
                'Tiket hanya dapat dibuka kembali jika sudah ditutup.'
            );
        }


        $statusDiproses = StatusTiket::where(
            'nama_status',
            'DIPROSES'
        )->firstOrFail();


        DB::transaction(function () use (
            $tiket,
            $statusDiproses
        ) {

            $tiket->update([

                'status_tiket_id' => $statusDiproses->id,

                'waktu_ditutup' => null,

                'waktu_selesai' => null,

            ]);


            RiwayatTiket::create([

                'tiket_id' => $tiket->id,

                'pegawai_id' => null,

                'aktivitas' =>
                'Tiket dibuka kembali oleh Admin',

                'keterangan' =>
                'Admin membuka kembali tiket untuk diproses ulang.',

            ]);
        });


        return back()->with(
            'success',
            'Tiket berhasil dibuka kembali.'
        );
    }
}
