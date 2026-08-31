<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatTiket extends Model
{
    use HasFactory;

    protected $table = 'riwayat_tiket';

    protected $fillable = [
        'tiket_id',
        'pegawai_id',
        'aktivitas',
        'keterangan',
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
