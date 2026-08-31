<?php

namespace App\Notifications;

use App\Models\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TiketStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Tiket $tiket,
        public string $pesan,
        public string $keterangan
    ) {}


    public function via(object $notifiable): array
    {
        return [
            'database',
        ];
    }


    public function toDatabase(object $notifiable): array
    {
        return [

            'judul' => 'Update Tiket',

            'pesan' => $this->pesan,

            'keterangan' => $this->keterangan,

            'tiket_id' => $this->tiket->id,

            'nomor_tiket' => $this->tiket->nomor_tiket,

            'url' => $this->getUrl($notifiable),

        ];
    }


    private function getUrl(object $notifiable): string
    {
        $level = $notifiable->level?->nama_level;

        if (in_array($level, [
            'Super Admin',
            'Admin IT',
            'Manager IT',
        ])) {

            return route(
                'admin.tiket.show',
                $this->tiket->id
            );
        }


        if ($level === 'Teknisi') {

            return route(
                'teknisi.tiket.show',
                $this->tiket->id
            );
        }


        if ($level === 'Pegawai') {

            return route(
                'pegawai.tiket.show',
                $this->tiket->id
            );
        }


        return route('dashboard');
    }
}
