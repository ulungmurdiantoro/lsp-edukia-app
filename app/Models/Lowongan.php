<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $fillable = [
        'slug',
        'judul',
        'deskripsi',
        'kategori',
        'lokasi',
        'tipe',
        'requirements',
        'responsibilities',
        'tampil',
        'urutan',
    ];

    protected $casts = [
        'requirements' => 'array',
        'responsibilities' => 'array',
        'tampil' => 'boolean',
    ];

    public function scopeTampil(Builder $query): Builder
    {
        return $query->where('tampil', true);
    }
}
