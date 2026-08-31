<?php

namespace App\Notifications;

use App\Models\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class KonfirmasiTiketNotification extends Notification
{
    use Queueable;

    protected $tiket;
    protected $aksi;
    protected $namaPegawai;


    public function __construct(
        Tiket $tiket,
        string $aksi,
        string $namaPegawai
    ) {
        $this->tiket = $tiket;
        $this->aksi = $aksi;
        $this->namaPegawai = $namaPegawai;
    }


    public function via(object $notifiable): array
    {
        return [
            'database',
        ];
    }


    public function toDatabase(object $notifiable): array
    {
        /*
        |--------------------------------------------------------------------------
        | Tentukan pesan berdasarkan konfirmasi pegawai
        |--------------------------------------------------------------------------
        */

        if ($this->aksi === 'SELESAI') {

            $judul = 'Konfirmasi Tiket Selesai';

            $pesan =
                $this->namaPegawai .
                ' mengkonfirmasi bahwa tiket ' .
                $this->tiket->nomor_tiket .
                ' telah selesai dan menunggu persetujuan Admin.';
        } else {

            $judul = 'Permintaan Buka Ulang Tiket';

            $pesan =
                $this->namaPegawai .
                ' menyatakan bahwa tiket ' .
                $this->tiket->nomor_tiket .
                ' belum selesai dan meminta tiket dibuka kembali.';
        }


        return [

            'judul' => $judul,

            'pesan' => $pesan,

            'aksi' => $this->aksi,

            'tiket_id' => $this->tiket->id,

            /*
            |--------------------------------------------------------------
            | URL menuju detail tiket Admin
            |--------------------------------------------------------------
            */

            'url' => route(
                'admin.tiket.show',
                $this->tiket->id
            ),

        ];
    }
}
