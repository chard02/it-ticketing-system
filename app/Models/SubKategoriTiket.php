<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubKategoriTiket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sub_kategori_tiket';

    protected $fillable = [
        'kategori_tiket_id',
        'nama_sub_kategori',
        'keterangan',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriTiket::class, 'kategori_tiket_id');
    }

    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }
}
