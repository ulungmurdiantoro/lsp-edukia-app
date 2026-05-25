<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $staticPages = [
            ['url' => route('home'),        'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => route('skema'),        'priority' => '0.9', 'changefreq' => 'monthly'],
            ['url' => route('tentang'),      'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('blog.index'),   'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('sertifikat'),   'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => route('informasi'),    'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('kegiatan.index'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ];

        $posts = Post::published()
            ->select('slug', 'updated_at', 'thumbnail')
            ->orderByDesc('published_at')
            ->get();

        $xml = view('sitemap', compact('staticPages', 'posts'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
