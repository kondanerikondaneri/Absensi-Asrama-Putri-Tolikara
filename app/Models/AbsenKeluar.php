<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenKeluar extends Model
{
    use HasFactory;

    protected $table = 'absen_keluar';

    protected $fillable = [
        'user_id',
        'keterangan',
        'waktu_keluar',
        'waktu_kembali',
    ];

    protected $casts = [
        'waktu_keluar' => 'datetime',
        'waktu_kembali' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
