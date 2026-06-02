<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'judul', 'slug', 'short_code', 'ringkasan', 'konten',
        'thumbnail', 'kategori', 'penulis', 'published', 'published_at',
    ];

    protected $casts = [
        'published'    => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (! $this->thumbnail) return '';
        if (str_starts_with($this->thumbnail, 'http')) return $this->thumbnail;
        return asset('storage/' . $this->thumbnail);
    }

    // ~200 words per minute reading speed
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->konten ?? ''));
        return max(1, (int) ceil($words / 200));
    }

    /** URL pendek lengkap, mis. https://lspedukia.id/b/auditor-2026 */
    public function getShortUrlAttribute(): string
    {
        return url('/b/' . ($this->short_code ?: $this->id));
    }

    /** Buat short_code unik dari teks bebas (atau judul jika kosong) */
    public static function generateShortCode(string $source): string
    {
        $base = Str::slug(Str::limit($source, 40, ''));
        if ($base === '') {
            $base = Str::lower(Str::random(6));
        }

        $code = $base;
        $i    = 1;
        while (static::where('short_code', $code)->exists()) {
            $code = $base . '-' . $i++;
        }

        return $code;
    }

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->judul);
            }
        });

        static::saving(function (Post $post) {
            // Normalisasi short_code; jika kosong dibuat otomatis dari judul
            if (empty($post->short_code)) {
                $post->short_code = static::generateShortCode($post->judul ?? '');
            } else {
                $post->short_code = Str::slug($post->short_code);
            }
        });
    }
}
