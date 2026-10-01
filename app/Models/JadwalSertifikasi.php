<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class JadwalSertifikasi extends Model
{
    /** Metode pelaksanaan uji kompetensi: nilai kolom => label tampilan. */
    public const METODE = [
        'online' => 'Online',
        'offline' => 'Offline',
    ];

    protected $fillable = [
        'skema',
        'bidang',
        'tanggal_sertifikasi',
        'metode',
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
