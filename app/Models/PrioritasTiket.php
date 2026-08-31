<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrioritasTiket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prioritas_tiket';

    protected $fillable = [
        'nama_prioritas',
        'urutan',
        'keterangan',
        'status',
    ];

    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }
}
