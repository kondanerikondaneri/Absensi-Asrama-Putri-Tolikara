<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'kamar_id',
        'nama_lengkap',
        'nomor_identitas',
        'username',
        'password',
        'role',
        'status',
        'no_telepon',
        'foto',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function absensiHarian()
    {
        return $this->hasMany(AbsensiHarian::class);
    }

    public function absenKeluar()
    {
        return $this->hasMany(AbsenKeluar::class);
    }

    public function curfewChecksTarget()
    {
        return $this->hasMany(CurfewCheck::class, 'user_id');
    }

    public function curfewChecksAdmin()
    {
        return $this->hasMany(CurfewCheck::class, 'checked_by');
    }
}
