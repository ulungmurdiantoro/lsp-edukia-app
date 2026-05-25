<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'judul', 'slug', 'ringkasan', 'konten',
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

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->judul);
            }
        });
    }
}
