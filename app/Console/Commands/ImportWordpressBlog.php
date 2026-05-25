<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportWordpressBlog extends Command
{
    protected $signature   = 'blog:import-wordpress {--url=https://yellowgreen-dunlin-984191.hostingersite.com}';
    protected $description = 'Import semua artikel dari WordPress lama via REST API';

    private array $catMap = [
        25 => 'Kegiatan',
        29 => 'Umum',
        8  => 'Pelatihan',
        24 => 'Kegiatan',
        30 => 'Tips Sertifikasi',
        7  => 'Tips Sertifikasi',
        26 => 'Info Skema',
        28 => 'Info Skema',
        27 => 'Info Skema',
        1  => 'Umum',
    ];

    public function handle(): void
    {
        $base = rtrim($this->option('url'), '/');
        $this->info("Mengambil artikel dari: {$base}");

        $page   = 1;
        $total  = 0;
        $imported = 0;

        do {
            $response = Http::timeout(30)->get("{$base}/wp-json/wp/v2/posts", [
                'per_page' => 100,
                'page'     => $page,
                '_fields'  => 'id,title,slug,content,excerpt,date,status,categories,featured_media,author',
            ]);

            if ($response->failed()) {
                $this->error("Gagal mengambil halaman {$page}: " . $response->status());
                break;
            }

            $posts = $response->json();
            if (empty($posts)) break;

            if ($page === 1) {
                $total = (int) $response->header('X-WP-Total');
                $this->info("Ditemukan {$total} artikel. Memulai import…");
            }

            foreach ($posts as $wp) {
                $this->importPost($wp, $base);
                $imported++;
                $this->line("  ✓ [{$imported}/{$total}] " . html_entity_decode(strip_tags($wp['title']['rendered'])));
            }

            $page++;
        } while (count($posts) === 100);

        $this->newLine();
        $this->info("Selesai! {$imported} artikel berhasil diimport.");
    }

    private function importPost(array $wp, string $base): void
    {
        $judul    = html_entity_decode(strip_tags($wp['title']['rendered']));
        $slug     = Str::slug($judul);
        $konten   = $this->cleanContent($wp['content']['rendered']);
        $ringkasan = trim(html_entity_decode(strip_tags($wp['excerpt']['rendered'])));
        $kategori = $this->resolveKategori($wp['categories']);
        $thumbnail = $this->fetchThumbnail($wp['featured_media'], $base);
        $publishedAt = $wp['status'] === 'publish' ? $wp['date'] : null;

        // Pastikan slug unik
        $baseSlug = $slug;
        $i = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }

        Post::updateOrCreate(
            ['slug' => Str::slug($judul)],
            [
                'judul'        => $judul,
                'slug'         => $slug,
                'konten'       => $konten,
                'ringkasan'    => Str::limit($ringkasan, 300),
                'kategori'     => $kategori,
                'thumbnail'    => $thumbnail,
                'penulis'      => 'Admin LSP Edukia',
                'published'    => $wp['status'] === 'publish',
                'published_at' => $publishedAt,
            ]
        );
    }

    private function resolveKategori(array $catIds): string
    {
        foreach ($catIds as $id) {
            if (isset($this->catMap[$id])) {
                return $this->catMap[$id];
            }
        }
        return 'Umum';
    }

    private function fetchThumbnail(int $mediaId, string $base): ?string
    {
        if ($mediaId === 0) return null;

        $response = Http::timeout(10)->get("{$base}/wp-json/wp/v2/media/{$mediaId}", [
            '_fields' => 'source_url',
        ]);

        return $response->ok() ? ($response->json('source_url') ?? null) : null;
    }

    private function cleanContent(string $html): string
    {
        // Hapus shortcodes WordPress [...]
        $html = preg_replace('/\[[^\]]+\]/', '', $html);

        // Hapus style inline berlebihan
        $html = preg_replace('/\s*style="[^"]*"/i', '', $html);

        // Bersihkan class WordPress
        $html = preg_replace('/\s*class="[^"]*"/i', '', $html);

        return trim($html);
    }
}
