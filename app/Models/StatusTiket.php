<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusTiket extends Model
{
    use HasFactory;

    protected $table = 'status_tiket';

    protected $fillable = [
        'nama_status',
        'urutan',
        'keterangan',
        'status',
    ];

    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }

    public function progresTiket()
    {
        return $this->hasMany(ProgresTiket::class);
    }
}
