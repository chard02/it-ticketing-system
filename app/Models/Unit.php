<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'unit';

    protected $fillable = [
        'kode_unit',
        'nama_unit',
        'status',
    ];

    public function subUnit()
    {
        return $this->hasMany(SubUnit::class, 'unit_id');
    }

    public function divisi()
    {
        return $this->hasMany(Divisi::class, 'unit_id');
    }

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class, 'unit_id');
    }

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'unit_id');
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'unit_id');
    }
}
