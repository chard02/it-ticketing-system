<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Divisi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'divisi';

    protected $fillable = [
        'unit_id',
        'kode_divisi',
        'nama_divisi',
        'status',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
