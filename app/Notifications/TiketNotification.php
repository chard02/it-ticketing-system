<?php

namespace App\Notifications;

use App\Models\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TiketNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Tiket $tiket,
        public string $judul,
        public string $pesan,
        public string $url
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'tiket_id' => $this->tiket->id,

            'nomor_tiket' => $this->tiket->nomor_tiket,

            'judul' => $this->judul,

            'pesan' => $this->pesan,

            'url' => $this->url,
        ];
    }
}
