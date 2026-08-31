<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\KonfirmasiTiket;

class Tiket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tiket';

    protected $fillable = [
        'nomor_tiket',
        'judul',
        'deskripsi',

        'jenis_tiket_id',
        'kategori_tiket_id',
        'sub_kategori_tiket_id',
        'prioritas_tiket_id',
        'status_tiket_id',

        'pelapor_id',
        'teknisi_id',

        'unit_id',
        'lokasi_id',

        'waktu_ditugaskan',
        'waktu_diproses',
        'waktu_selesai',
        'waktu_ditutup',
    ];

    protected function casts(): array
    {
        return [
            'waktu_ditugaskan' => 'datetime',
            'waktu_diproses' => 'datetime',
            'waktu_selesai' => 'datetime',
            'waktu_ditutup' => 'datetime',
        ];
    }

    public function jenisTiket()
    {
        return $this->belongsTo(JenisTiket::class);
    }

    public function kategoriTiket()
    {
        return $this->belongsTo(KategoriTiket::class);
    }

    public function subKategoriTiket()
    {
        return $this->belongsTo(
            SubKategoriTiket::class,
            'sub_kategori_tiket_id'
        );
    }

    public function prioritasTiket()
    {
        return $this->belongsTo(
            PrioritasTiket::class,
            'prioritas_tiket_id'
        );
    }

    public function statusTiket()
    {
        return $this->belongsTo(
            StatusTiket::class,
            'status_tiket_id'
        );
    }

    public function pelapor()
    {
        return $this->belongsTo(
            Pegawai::class,
            'pelapor_id'
        );
    }

    public function teknisi()
    {
        return $this->belongsTo(
            Pegawai::class,
            'teknisi_id'
        );
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function progres()
    {
        return $this->hasMany(ProgresTiket::class);
    }

    public function konfirmasi()
    {
        return $this->hasMany(KonfirmasiTiket::class);
    }

    public function konfirmasiTerbaru()
    {
        return $this->hasOne(KonfirmasiTiket::class)
            ->latestOfMany();
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatTiket::class);
    }

    public function lampiran()
    {
        return $this->hasMany(LampiranTiket::class);
    }
}
