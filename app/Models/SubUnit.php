<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sub_unit';

    protected $fillable = [
        'unit_id',
        'kode_sub_unit',
        'nama_sub_unit',
        'status',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class);
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
