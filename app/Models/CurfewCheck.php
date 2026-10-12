<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurfewCheck extends Model
{
    use HasFactory;

    protected $table = 'curfew_checks';

    protected $fillable = [
        'user_id',
        'checked_by',
        'metode',
        'is_hadir',
        'catatan',
        'tanggal_cek',
        'waktu_cek',
    ];

    protected $casts = [
        'is_hadir' => 'boolean',
        'tanggal_cek' => 'date',
        'waktu_cek' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
