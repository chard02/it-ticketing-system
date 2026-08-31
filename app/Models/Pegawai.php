<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'nomor_telepon',
        'foto',
        'jenis_kelamin',
        'unit_id',
        'sub_unit_id',
        'divisi_id',
        'jabatan_id',
        'lokasi_id',
        'status',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function subUnit()
    {
        return $this->belongsTo(SubUnit::class, 'sub_unit_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function akun()
    {
        return $this->hasOne(
            Akun::class,
            'pegawai_id'
        );
    }

    public function tiketDilaporkan()
    {
        return $this->hasMany(Tiket::class, 'pelapor_id');
    }

    public function tiketDitangani()
    {
        return $this->hasMany(Tiket::class, 'teknisi_id');
    }

    public function progresTiket()
    {
        return $this->hasMany(ProgresTiket::class);
    }
}
