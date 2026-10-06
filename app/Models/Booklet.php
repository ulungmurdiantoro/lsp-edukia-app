<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Booklet lembaga — hanya satu dokumen (satu baris), dikelola lewat halaman admin Booklet.
 */
class Booklet extends Model
{
    protected $fillable = [
        'judul',
        'file',
        'link',
        'tampil',
    ];

    protected $casts = [
        'tampil' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Filament tidak menghapus file lama saat diganti — PDF booklet bisa belasan MB,
        // jadi file yatim dibersihkan di sini.
        static::updated(function (Booklet $booklet): void {
            $lama = $booklet->getOriginal('file');
            if ($booklet->wasChanged('file') && $lama) {
                Storage::disk('public')->delete($lama);
            }
        });

        // Halaman /booklet masuk sitemap & llms.txt hanya bila booklet tampil.
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

    /** Booklet yang sedang ditampilkan di website, atau null (menu Booklet disembunyikan). */
    public static function aktif(): ?self
    {
        return static::tampil()
            ->where(fn (Builder $q) => $q->whereNotNull('file')->orWhereNotNull('link'))
            ->first();
    }

    /** Alamat dokumen: PDF unggahan bila ada, selain itu tautan eksternal. */
    public function url(): ?string
    {
        if ($this->file) {
            return Storage::disk('public')->url($this->file);
        }

        return $this->link ?: null;
    }

    public function namaUnduhan(): string
    {
        return Str::slug($this->judul).'.pdf';
    }
}
