<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'judul', 'slug', 'thumbnail', 'ringkasan',
        'konten', 'kategori', 'penulis', 'published', 'published_at',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->judul);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('published', true)->orderByDesc('published_at');
    }
}
