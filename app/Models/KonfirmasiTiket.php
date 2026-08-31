<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KonfirmasiTiket extends Model
{
    use HasFactory;

    protected $table = 'konfirmasi_tiket';

    protected $fillable = [
        'tiket_id',
        'pegawai_id',
        'status_konfirmasi',
        'alasan',
        'waktu_konfirmasi',
    ];

    protected function casts(): array
    {
        return [
            'waktu_konfirmasi' => 'datetime',
        ];
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
