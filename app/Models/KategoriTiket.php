<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriTiket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_tiket';

    protected $fillable = [
        'nama_kategori',
        'keterangan',
        'status',
    ];

    public function subKategori()
    {
        return $this->hasMany(SubKategoriTiket::class);
    }

    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }
}
