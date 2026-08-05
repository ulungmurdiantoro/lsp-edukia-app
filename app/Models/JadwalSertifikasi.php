<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class JadwalSertifikasi extends Model
{
    protected $fillable = [
        'skema',
        'bidang',
        'tanggal_sertifikasi',
        'tampil',
    ];

    protected $casts = [
        'tanggal_sertifikasi' => 'date',
        'tampil' => 'boolean',
    ];

    public function scopeTampil(Builder $query): Builder
    {
        return $query->where('tampil', true);
    }
}
