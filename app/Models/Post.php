<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Schema\ArticleSchema;
use RalphJSmit\Laravel\SEO\Schema\BreadcrumbListSchema;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Post extends Model
{
    use HasSEO;

    /**
     * Nonaktifkan pembuatan otomatis baris `seo` dari trait HasSEO.
     * Baris override dikelola oleh Filament (relationship 'seo') saat editor mengisinya;
     * jika kosong, relasi seo()->withDefault() memastikan frontend tetap aman.
     */
    protected static function bootHasSEO(): void
    {
        //
    }

    protected $fillable = [
        'judul', 'slug', 'short_code', 'ringkasan', 'konten',
        'thumbnail', 'kategori', 'focus_keyword', 'penulis', 'published', 'published_at',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (! $this->thumbnail) {
            return '';
        }
        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        return asset('storage/'.$this->thumbnail);
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
        return url('/b/'.($this->short_code ?: $this->id));
    }

    /**
     * Data SEO dinamis untuk paket ralphjsmit/laravel-seo.
     * Nilai dari tabel `seo` (override editor di Filament) diutamakan,
     * lalu fallback ke field artikel. Menghasilkan meta + schema BlogPosting + Breadcrumb.
     */
    public function getDynamicSEOData(): SEOData
    {
        $seo = $this->seo; // relasi morphOne dengan withDefault() — aman walau kosong

        $description = $seo->getAttribute('description')
            ?: Str::limit(strip_tags($this->ringkasan ?: $this->konten), 155);

        $seoImage = $seo->getAttribute('image');
        $image = $seoImage
            ? Storage::disk('public')->url($seoImage)
            : ($this->thumbnail ? $this->thumbnail_url : config('seo.image.fallback'));

        return new SEOData(
            title: $seo->getAttribute('title') ?: $this->judul,
            description: $description,
            author: $this->penulis,
            image: $image,
            url: route('blog.show', $this->slug),
            published_time: $this->published_at,
            modified_time: $this->updated_at,
            section: $this->kategori,
            type: 'article',
            robots: $seo->getAttribute('robots') ?: null,
            canonical_url: $seo->getAttribute('canonical_url') ?: null,
            schema: SchemaCollection::initialize()
                ->addArticle(function (ArticleSchema $schema): ArticleSchema {
                    $schema->type = 'BlogPosting';

                    return $schema;
                })
                ->addBreadcrumbs(fn (BreadcrumbListSchema $schema): BreadcrumbListSchema => $schema->prependBreadcrumbs([
                    'Beranda' => url('/'),
                    'Blog' => route('blog.index'),
                ])),
        );
    }

    /** Buat short_code unik dari teks bebas (atau judul jika kosong) */
    public static function generateShortCode(string $source): string
    {
        $base = Str::slug(Str::limit($source, 40, ''));
        if ($base === '') {
            $base = Str::lower(Str::random(6));
        }

        $code = $base;
        $i = 1;
        while (static::where('short_code', $code)->exists()) {
            $code = $base.'-'.$i++;
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

        // Segarkan cache sitemap saat artikel berubah agar URL baru langsung terindeks.
        static::saved(fn () => Cache::forget('sitemap.xml'));
        static::deleted(fn () => Cache::forget('sitemap.xml'));
    }
}
