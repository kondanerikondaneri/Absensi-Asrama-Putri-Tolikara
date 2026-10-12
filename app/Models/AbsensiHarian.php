<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiHarian extends Model
{
    use HasFactory;

    protected $table = 'absensi_harian';

    protected $fillable = [
        'user_id',
        'metode',
        'latitude',
        'longitude',
        'jarak_meter',
        'qr_code_value',
        'status',
        'ip_address',
        'user_agent',
        'waktu_absensi',
    ];

    protected $casts = [
        'waktu_absensi' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
