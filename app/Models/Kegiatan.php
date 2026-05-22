<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'judul', 'foto', 'deskripsi', 'tanggal', 'tampilkan', 'urutan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tampilkan' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('tampilkan', true)->orderBy('urutan')->orderByDesc('tanggal');
    }

    public function getFotoUrlAttribute(): string
    {
        return asset('storage/' . $this->foto);
    }
}
