<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Skemas;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap.xml', now()->addHours(6), function (): string {
            $staticPages = [
                ['url' => route('home'),           'priority' => '1.0', 'changefreq' => 'weekly'],
                ['url' => route('skema'),          'priority' => '0.9', 'changefreq' => 'monthly'],
                ['url' => route('tentang'),        'priority' => '0.8', 'changefreq' => 'monthly'],
                ['url' => route('blog.index'),     'priority' => '0.8', 'changefreq' => 'weekly'],
                ['url' => route('sertifikat'),     'priority' => '0.7', 'changefreq' => 'weekly'],
                ['url' => route('informasi'),      'priority' => '0.7', 'changefreq' => 'monthly'],
                ['url' => route('kegiatan.index'), 'priority' => '0.6', 'changefreq' => 'monthly'],
                ['url' => route('webinar.gerakan-nasional'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ];

            // Hub per bidang skema.
            foreach (array_keys(Skemas::bidangs()) as $bidang) {
                $staticPages[] = ['url' => route('skema.bidang', $bidang), 'priority' => '0.7', 'changefreq' => 'monthly'];
            }

            // Halaman detail tiap skema sertifikasi (aset keyword utama).
            foreach (Skemas::all() as $skema) {
                $staticPages[] = ['url' => route('skema.show', $skema['slug']), 'priority' => '0.8', 'changefreq' => 'monthly'];
            }

            // Halaman kategori blog.
            Post::published()->distinct()->pluck('kategori')->filter()->each(function (string $kategori) use (&$staticPages) {
                $staticPages[] = ['url' => route('blog.kategori', Str::slug($kategori)), 'priority' => '0.6', 'changefreq' => 'weekly'];
            });

            $posts = Post::published()
                ->select('slug', 'updated_at', 'thumbnail')
                ->orderByDesc('published_at')
                ->get();

            return view('sitemap', compact('staticPages', 'posts'))->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
