<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Booklet extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'cover',
        'file',
        'link',
        'tampil',
        'urutan',
    ];

    protected $casts = [
        'tampil' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Filament tidak menghapus file lama saat diganti/dihapus — PDF booklet bisa belasan MB,
        // jadi file yatim dibersihkan di sini.
        static::updated(function (Booklet $booklet): void {
            foreach (['cover', 'file'] as $kolom) {
                $lama = $booklet->getOriginal($kolom);
                if ($booklet->wasChanged($kolom) && $lama) {
                    Storage::disk('public')->delete($lama);
                }
            }
        });

        static::deleted(function (Booklet $booklet): void {
            Storage::disk('public')->delete(array_filter([$booklet->cover, $booklet->file]));
        });

        // Halaman /booklet masuk sitemap & llms.txt hanya bila ada booklet tampil.
        static::saved(fn () => static::forgetIndexCache());
        static::deleted(fn () => static::forgetIndexCache());
    }

    private static function forgetIndexCache(): void
    {
        Cache::forget('sitemap.xml');
        Cache::forget('llms.txt');
    }

    public function scopeTampil(Builder $query): Builder
    {
        return $query->where('tampil', true);
    }

    /** Alamat untuk membaca booklet: PDF unggahan bila ada, selain itu tautan eksternal. */
    public function url(): ?string
    {
        if ($this->file) {
            return Storage::disk('public')->url($this->file);
        }

        return $this->link ?: null;
    }

    /** Hanya PDF unggahan yang bisa diunduh langsung; tautan eksternal dibuka di tab baru. */
    public function bisaDiunduh(): bool
    {
        return (bool) $this->file;
    }

    public function namaUnduhan(): string
    {
        return Str::slug($this->judul).'.pdf';
    }

    public function coverUrl(): ?string
    {
        return $this->cover ? Storage::disk('public')->url($this->cover) : null;
    }
}
