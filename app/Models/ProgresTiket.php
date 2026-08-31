<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgresTiket extends Model
{
    use HasFactory;

    protected $table = 'progres_tiket';

    protected $fillable = [
        'tiket_id',
        'pegawai_id',
        'persentase_progres',
        'keterangan',
        'status_tiket_id',
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function statusTiket()
    {
        return $this->belongsTo(StatusTiket::class);
    }

    public function lampiran()
    {
        return $this->hasMany(LampiranTiket::class);
    }
}
