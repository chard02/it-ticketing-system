<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TiketUpdatedNotification extends Notification
{
    use Queueable;

    protected $tiket;

    protected $pesan;


    public function __construct($tiket, $pesan)
    {
        $this->tiket = $tiket;

        $this->pesan = $pesan;
    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }


    public function toArray(object $notifiable): array
    {
        return [

            'judul' => 'Update Tiket',

            'pesan' => $this->pesan,

            'nomor_tiket' => $this->tiket->nomor_tiket,

            'tiket_id' => $this->tiket->id,

            'url' => $this->getUrl($notifiable),

        ];
    }


    private function getUrl($notifiable)
    {
        $namaLevel = $notifiable->level?->nama_level;

        if (in_array($namaLevel, [
            'Super Admin',
            'Admin IT',
            'Manager IT',
        ])) {

            return route(
                'admin.tiket.show',
                $this->tiket->id
            );
        }


        if ($namaLevel === 'Teknisi') {

            return route(
                'teknisi.tiket.show',
                $this->tiket->id
            );
        }


        if ($namaLevel === 'Pegawai') {

            return route(
                'pegawai.tiket.show',
                $this->tiket->id
            );
        }


        return route('dashboard');
    }
}
