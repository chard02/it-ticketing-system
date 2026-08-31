<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LampiranTiket extends Model
{
    use HasFactory;

    protected $table = 'lampiran_tiket';

    protected $fillable = [
        'tiket_id',
        'progres_tiket_id',
        'pegawai_id',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function progresTiket()
    {
        return $this->belongsTo(
            ProgresTiket::class,
            'progres_tiket_id'
        );
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
