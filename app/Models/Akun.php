<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Akun extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'akun';

    protected $fillable = [
        'pegawai_id',
        'level_id',
        'username',
        'password',
        'terakhir_login',
        'ip_login',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'terakhir_login' => 'datetime',
        ];
    }

    public function pegawai()
    {
        return $this->belongsTo(
            Pegawai::class,
            'pegawai_id'
        );
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
