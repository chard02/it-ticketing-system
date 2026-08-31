<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\JenisTiket;
use App\Models\KategoriTiket;
use App\Models\SubKategoriTiket;
use App\Models\StatusTiket;
use App\Models\Tiket;
use App\Models\RiwayatTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Akun;
use App\Notifications\TiketNotification;
use App\Models\KonfirmasiTiket;


class TiketController extends Controller
{
    /**
     * Daftar tiket milik pegawai.
     */
    public function index()
    {
        $pegawai = Auth::user()->pegawai;

        $tiket = Tiket::with([
            'jenisTiket',
            'kategoriTiket',
            'subKategoriTiket',
            'prioritasTiket',
            'statusTiket',
            'teknisi',
        ])
            ->where('pelapor_id', $pegawai->id)
            ->latest()
            ->paginate(10);

        return view('pegawai.tiket.index', compact(
            'tiket'
        ));
    }


    /**
     * Form buat tiket.
     */
    public function create()
    {
        $kategori = KategoriTiket::where('status', 'AKTIF')
            ->orderBy('nama_kategori')
            ->get();

        $jenisTiket = JenisTiket::where('status', 'AKTIF')
            ->orderBy('nama_jenis')
            ->get();

        $subKategoriTiket = SubKategoriTiket::where('status', 'AKTIF')
            ->orderBy('nama_sub_kategori')
            ->get();

        return view('pegawai.tiket.create', compact(
            'kategori',
            'jenisTiket',
            'subKategoriTiket',
        ));
    }


    /**
     * Simpan tiket baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_tiket_id' => [
                'required',
                'exists:kategori_tiket,id',
            ],

            'sub_kategori_tiket_id' => [
                'required',
                'exists:sub_kategori_tiket,id',
            ],

            'jenis_tiket_id' => [
                'required',
                'exists:jenis_tiket,id',
            ],

            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'required',
                'string',
            ],

            'lampiran.*' => [
                'nullable',
                'file',
                'max:5120',
            ],
        ]);


        $akun = Auth::user();
        $pegawai = $akun->pegawai;


        if (!$pegawai) {
            abort(403, 'Akun belum terhubung dengan pegawai.');
        }


        DB::transaction(function () use (
            $validated,
            $pegawai,
            $request
        ) {

            /*
            |--------------------------------------------------------------------------
            | Ambil status awal tiket
            |--------------------------------------------------------------------------
            */

            $statusMenunggu = StatusTiket::where(
                'nama_status',
                'Baru'
            )->first();


            if (!$statusMenunggu) {
                abort(
                    500,
                    'Status tiket "Menunggu" belum tersedia.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Generate nomor tiket
            |--------------------------------------------------------------------------
            */

            $nomorTiket = $this->generateNomorTiket();


            /*
            |--------------------------------------------------------------------------
            | Simpan tiket
            |--------------------------------------------------------------------------
            */

            $tiket = Tiket::create([
                'nomor_tiket' => $nomorTiket,

                'judul' => $validated['judul'],

                'deskripsi' => $validated['deskripsi'],

                'jenis_tiket_id' => $validated['jenis_tiket_id'],

                'kategori_tiket_id' =>
                $validated['kategori_tiket_id'],

                'sub_kategori_tiket_id' =>
                $validated['sub_kategori_tiket_id'] ?? null,

                /*
                |--------------------------------------------------------------------------
                | Prioritas ditentukan admin
                |--------------------------------------------------------------------------
                */

                'prioritas_tiket_id' => null,

                /*
                |--------------------------------------------------------------------------
                | Status awal
                |--------------------------------------------------------------------------
                */

                'status_tiket_id' => $statusMenunggu->id,

                /*
                |--------------------------------------------------------------------------
                | Pelapor otomatis dari akun login
                |--------------------------------------------------------------------------
                */

                'pelapor_id' => $pegawai->id,

                /*
                |--------------------------------------------------------------------------
                | Teknisi ditentukan admin
                |--------------------------------------------------------------------------
                */

                'teknisi_id' => null,

                /*
                |--------------------------------------------------------------------------
                | Unit & lokasi otomatis dari pegawai
                |--------------------------------------------------------------------------
                */

                'unit_id' => $pegawai->unit_id,

                'lokasi_id' => $pegawai->lokasi_id,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Riwayat
            |--------------------------------------------------------------------------
            */

            RiwayatTiket::create([
                'tiket_id' => $tiket->id,
                'pegawai_id' => $pegawai->id,
                'aktivitas' => 'Tiket dibuat',
                'keterangan' =>
                'Pegawai membuat tiket baru.',
            ]);

            $admin = Akun::whereHas(
                'level',
                function ($query) {

                    $query->whereIn(
                        'nama_level',
                        [
                            'Super Admin',
                            'Admin IT',
                        ]
                    );
                }
            )->get();


            foreach ($admin as $akunAdmin) {

                $akunAdmin->notify(
                    new TiketNotification(

                        $tiket,

                        'Tiket Baru',

                        'Tiket baru telah dibuat: ' .
                            $tiket->nomor_tiket .
                            ' - ' .
                            $tiket->judul,

                        route(
                            'admin.tiket.show',
                            $tiket->id
                        )
                    )
                );
            }
            /*
            |--------------------------------------------------------------------------
            | Lampiran
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('lampiran')) {

                foreach ($request->file('lampiran') as $file) {

                    $path = $file->store(
                        'lampiran-tiket',
                        'public'
                    );


                    $tiket->lampiran()->create([
                        'pegawai_id' => $pegawai->id,
                        'nama_file' => $file->getClientOriginalName(),
                        'path_file' => $path,
                        'tipe_file' => $file->getClientMimeType(),
                        'ukuran_file' => $file->getSize(),
                    ]);
                }
            }
        });


        return redirect()
            ->route('pegawai.tiket.index')
            ->with(
                'success',
                'Tiket berhasil dibuat.'
            );
    }


    /**
     * Detail tiket.
     */
    public function show(Tiket $tiket)
    {
        $pegawai = Auth::user()->pegawai;

        if ($tiket->pelapor_id !== $pegawai->id) {
            abort(403);
        }

        $tiket->load([
            'jenisTiket',
            'kategoriTiket',
            'subKategoriTiket',
            'prioritasTiket',
            'statusTiket',
            'teknisi',
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

            'konfirmasi' => function ($query) {
                $query->latest();
            },
        ]);


        return view(
            'pegawai.tiket.show',
            compact('tiket')
        );
    }


    /**
     * Generate nomor tiket.
     */
    private function generateNomorTiket(): string
    {
        $prefix = 'TKT-' . now()->format('Ymd') . '-';


        $lastTiket = Tiket::withTrashed()
            ->where(
                'nomor_tiket',
                'like',
                $prefix . '%'
            )
            ->orderByDesc('id')
            ->first();


        if (!$lastTiket) {
            $urutan = 1;
        } else {

            $lastNumber = (int) substr(
                $lastTiket->nomor_tiket,
                -4
            );

            $urutan = $lastNumber + 1;
        }


        return $prefix . str_pad(
            $urutan,
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    public function konfirmasi(
        Request $request,
        Tiket $tiket
    ) {

        $request->validate([
            'aksi' => [
                'required',
                'in:SELESAI,BELUM_SELESAI',
            ],

            'alasan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        $akun = Auth::user();


        /*
|--------------------------------------------------------------------------
| PASTIKAN TIKET MILIK PEGAWAI YANG LOGIN
|--------------------------------------------------------------------------
*/

        if (
            !$akun->pegawai ||
            $tiket->pelapor_id !== $akun->pegawai->id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke tiket ini.'
            );
        }


        /*
|--------------------------------------------------------------------------
| HANYA TIKET SELESAI YANG BISA DIKONFIRMASI
|--------------------------------------------------------------------------
*/

        $tiket->load('statusTiket');


        if (
            strtoupper(
                $tiket->statusTiket?->nama_status
            ) !== 'SELESAI'
        ) {
            return back()->with(
                'error',
                'Tiket ini belum dapat dikonfirmasi.'
            );
        }


        /*
|--------------------------------------------------------------------------
| JIKA BELUM SELESAI, ALASAN WAJIB DIISI
|--------------------------------------------------------------------------
*/

        if (
            $request->aksi === 'BELUM_SELESAI' &&
            empty($request->alasan)
        ) {
            return back()
                ->withErrors([
                    'alasan' => 'Alasan wajib diisi.',
                ])
                ->withInput();
        }


        /*
|--------------------------------------------------------------------------
| CARI STATUS MENUNGGU APPROVAL
|--------------------------------------------------------------------------
*/

        $statusMenungguApproval = StatusTiket::where(
            'nama_status',
            'MENUNGGU APPROVAL'
        )->first();


        if (!$statusMenungguApproval) {
            return back()->with(
                'error',
                'Status MENUNGGU APPROVAL belum tersedia.'
            );
        }


        /*
|--------------------------------------------------------------------------
| SIMPAN DATA
|--------------------------------------------------------------------------
*/

        DB::transaction(function () use (
            $request,
            $tiket,
            $akun,
            $statusMenungguApproval
        ) {

            /*
    |--------------------------------------------------------------------------
    | SIMPAN KONFIRMASI PEGAWAI
    |--------------------------------------------------------------------------
    */

            KonfirmasiTiket::create([

                'tiket_id' => $tiket->id,

                'pegawai_id' => $akun->pegawai->id,

                'status_konfirmasi' => $request->aksi,

                'alasan' => $request->aksi === 'BELUM_SELESAI'
                    ? $request->alasan
                    : 'Pegawai mengkonfirmasi bahwa permasalahan telah selesai.',

                'waktu_konfirmasi' => now(),

            ]);


            /*
    |--------------------------------------------------------------------------
    | UBAH STATUS TIKET
    |--------------------------------------------------------------------------
    */

            $tiket->update([

                'status_tiket_id' => $statusMenungguApproval->id,

            ]);


            /*
    |--------------------------------------------------------------------------
    | TENTUKAN RIWAYAT
    |--------------------------------------------------------------------------
    */

            $aktivitas = $request->aksi === 'SELESAI'
                ? 'Pegawai mengkonfirmasi tiket telah selesai'
                : 'Pegawai menyatakan permasalahan belum selesai';


            $keterangan = $request->aksi === 'SELESAI'
                ? 'Menunggu persetujuan Admin.'
                : $request->alasan;


            /*
    |--------------------------------------------------------------------------
    | SIMPAN RIWAYAT
    |--------------------------------------------------------------------------
    */

            RiwayatTiket::create([

                'tiket_id' => $tiket->id,

                'pegawai_id' => $akun->pegawai->id,

                'aktivitas' => $aktivitas,

                'keterangan' => $keterangan,

            ]);
        });


        /*
|--------------------------------------------------------------------------
| RELOAD RELASI
|--------------------------------------------------------------------------
*/

        $tiket->refresh();

        $tiket->load([
            'pelapor.akun',
            'teknisi.akun',
        ]);


        /*
|--------------------------------------------------------------------------
| NOTIFIKASI ADMIN
|--------------------------------------------------------------------------
*/

        $admins = Akun::whereHas(
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
                new \App\Notifications\KonfirmasiTiketNotification(
                    $tiket,
                    $request->aksi,
                    $akun->pegawai->nama
                )
            );
        }


        return back()->with(
            'success',
            'Konfirmasi berhasil dikirim dan sedang menunggu keputusan Admin.'
        );
    }
}
