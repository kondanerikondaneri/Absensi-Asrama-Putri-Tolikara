<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlokAsrama extends Model
{
    use HasFactory;

    protected $table = 'blok_asrama';

    protected $fillable = [
        'nama_blok',
        'deskripsi',
    ];

    public function kamar()
    {
        return $this->hasMany(Kamar::class);
    }
}
