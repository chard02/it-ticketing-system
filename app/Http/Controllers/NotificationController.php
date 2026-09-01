<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusTiket;
use App\Models\ProgresTiket;
use App\Models\RiwayatTiket;
use App\Models\Akun;
use App\Notifications\TiketUpdatedNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $akun = $request->user();

        $notifications = $akun->notifications()
            ->latest()
            ->paginate(15);

        $namaLevel = $akun->level?->nama_level;

        /*
        |--------------------------------------------------------------------------
        | Tentukan Layout Berdasarkan Role
        |--------------------------------------------------------------------------
        */

        if (in_array($namaLevel, [
            'Super Admin',
            'Admin IT',
            'Manager IT',
        ])) {

            $layout = 'layouts.admin.app';
        } elseif ($namaLevel === 'Teknisi') {

            $layout = 'layouts.teknisi.app';
        } elseif ($namaLevel === 'Pegawai') {

            $layout = 'layouts.pegawai.app';
        } else {

            abort(403, 'Level akun tidak dikenali.');
        }


        return view(
            'notifications.index',
            compact(
                'akun',
                'notifications',
                'layout'
            )
        );
    }


    public function read(Request $request, string $notification)
    {
        $akun = $request->user();

        $notificationData = $akun->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        if (is_null($notificationData->read_at)) {
            $notificationData->markAsRead();
        }

        if (!empty($notificationData->data['url'])) {

            return redirect(
                $notificationData->data['url']
            );
        }

        return redirect()
            ->route('notifications.index');
    }


    public function readAll(Request $request)
    {
        $akun = $request->user();

        $akun->unreadNotifications
            ->markAsRead();

        return redirect()
            ->route('notifications.index')
            ->with(
                'success',
                'Semua notifikasi telah ditandai sebagai dibaca.'
            );
    }

    public function updateStatus(Request $request, Tiket $tiket)
    {
        $request->validate([
            'status' => 'required|in:DIPROSES,PENDING,SELESAI',
            'keterangan' => 'nullable|string',
        ]);

        $akun = Auth::user();

        $akun->load('pegawai');

        /*
    |--------------------------------------------------------------------------
    | Pastikan tiket memang milik teknisi yang login
    |--------------------------------------------------------------------------
    */

        if ($tiket->teknisi_id !== $akun->pegawai_id) {
            abort(403, 'Tiket ini bukan tugas Anda.');
        }


        /*
    |--------------------------------------------------------------------------
    | Update Status
    |--------------------------------------------------------------------------
    */

        $status = $request->status;

        $statusTiket = \App\Models\StatusTiket::where(
            'nama_status',
            $status
        )->firstOrFail();

        $tiket->status_tiket_id = $statusTiket->id;


        /*
    |--------------------------------------------------------------------------
    | Update Waktu Berdasarkan Status
    |--------------------------------------------------------------------------
    */

        if ($status === 'DIPROSES') {

            $tiket->waktu_diproses = now();
        }

        if ($status === 'SELESAI') {

            $tiket->waktu_selesai = now();
        }

        $tiket->save();


        /*
    |--------------------------------------------------------------------------
    | Simpan Progres
    |--------------------------------------------------------------------------
    */

        ProgresTiket::create([
            'tiket_id' => $tiket->id,
            'pegawai_id' => $akun->pegawai_id,
            'keterangan' => $request->keterangan
                ?? 'Status tiket diubah menjadi ' . $status,
        ]);


        /*
    |--------------------------------------------------------------------------
    | Simpan Riwayat
    |--------------------------------------------------------------------------
    */

        RiwayatTiket::create([
            'tiket_id' => $tiket->id,
            'pegawai_id' => $akun->pegawai_id,
            'aktivitas' => 'Update Status Tiket',
            'keterangan' => 'Teknisi mengubah status tiket menjadi ' . $status,
        ]);


        /*
    |--------------------------------------------------------------------------
    | Kirim Notifikasi ke Pelapor
    |--------------------------------------------------------------------------
    */

        $tiket->load('pelapor.akun');

        if ($tiket->pelapor?->akun) {

            $tiket->pelapor->akun->notify(
                new TiketUpdatedNotification(
                    $tiket,
                    'Teknisi telah mengupdate tiket Anda menjadi ' . $status
                )
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Kirim Notifikasi ke Admin
    |--------------------------------------------------------------------------
    */

        $admins = Akun::whereHas('level', function ($query) {

            $query->whereIn(
                'nama_level',
                [
                    'Super Admin',
                    'Admin IT',
                    'Manager IT',
                ]
            );
        })->get();


        foreach ($admins as $admin) {

            $admin->notify(
                new TiketUpdatedNotification(
                    $tiket,
                    'Teknisi telah mengupdate tiket '
                        . $tiket->nomor_tiket
                        . ' menjadi '
                        . $status
                )
            );
        }


        return back()->with(
            'success',
            'Status tiket berhasil diperbarui perbaharui.'
        );
    }
}
