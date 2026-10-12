<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $fillable = [
        'blok_asrama_id',
        'nomor_kamar',
        'kapasitas',
    ];

    public function blokAsrama()
    {
        return $this->belongsTo(BlokAsrama::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
