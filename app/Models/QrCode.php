<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $table = 'qr_codes';

    protected $fillable = [
        'kode',
        'tipe',
        'reference_id',
        'reference_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
