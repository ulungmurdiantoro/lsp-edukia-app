<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $fillable = [
        'nama',
        'gelar',
        'skema',
        'kategori',
        'nomor_sertifikat',
        'no_sk',
        'no_skema',
        'tanggal_terbit',
        'tanggal_kadaluarsa',
        'tampil',
    ];

    protected $casts = [
        'tanggal_terbit'     => 'date',
        'tanggal_kadaluarsa' => 'date',
        'tampil'             => 'boolean',
    ];

    protected $appends = ['status'];

    // Computed: aktif | expiring (≤90 hari) | kadaluarsa (sudah lewat)
    public function getStatusAttribute(): string
    {
        if (! $this->tanggal_kadaluarsa) {
            return 'aktif';
        }
        $today = now()->startOfDay();
        if ($this->tanggal_kadaluarsa->lt($today)) {
            return 'kadaluarsa';
        }
        if ($this->tanggal_kadaluarsa->lte(now()->startOfDay()->addDays(90))) {
            return 'expiring';
        }
        return 'aktif';
    }

    public function scopeTampil(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('tampil', true);
    }
}
