<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->when(request('kategori'), fn ($q, $cat) => $q->where('kategori', $cat))
            ->latest('published_at')
            ->paginate(9);

        $kategori = request('kategori');

        return view('blog.index', compact('posts'))
            ->with('activeNav', 'blog')
            ->with('SEOData', new SEOData(
                title: $kategori ? "Blog — {$kategori}" : 'Blog & Artikel Sertifikasi',
                description: $kategori
                    ? "Kumpulan artikel kategori {$kategori} dari LSP Edukia seputar sertifikasi kompetensi dan pengembangan profesi."
                    : 'Artikel, tips, dan informasi terbaru seputar sertifikasi kompetensi person terakreditasi KAN, skema kompetensi, dan pengembangan karier dari LSP Edukia.',
            ));
    }

    /** Halaman kategori ber-path & terindeks: /blog/kategori/{slug} */
    public function kategori(string $slug)
    {
        // Cari kategori yang slug-nya cocok (mis. "tips-sertifikasi" -> "Tips Sertifikasi").
        $kategori = Post::published()
            ->get('kategori')
            ->pluck('kategori')
            ->unique()
            ->first(fn ($k) => Str::slug($k) === $slug);

        abort_if(! $kategori, 404);

        $posts = Post::published()
            ->where('kategori', $kategori)
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', compact('posts'))
            ->with('activeNav', 'blog')
            ->with('kategoriAktif', $kategori)
            ->with('SEOData', new SEOData(
                title: "Artikel {$kategori}",
                description: "Kumpulan artikel kategori {$kategori} dari LSP Edukia seputar sertifikasi kompetensi person terakreditasi KAN dan pengembangan kompetensi.",
                url: route('blog.kategori', $slug),
            ));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->where('published', true)->firstOrFail();

        // Same category first, then fill with latest
        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->where('kategori', $post->kategori)
            ->latest('published_at')
            ->limit(3)
            ->get();

        if ($related->count() < 3) {
            $more = Post::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->latest('published_at')
                ->limit(3 - $related->count())
                ->get();
            $related = $related->merge($more);
        }

        return view('blog.show', compact('post', 'related'))
            ->with('activeNav', 'blog')
            // Pakai SEOData hasil getDynamicSEOData() (bukan model) agar aman walau
            // artikel belum punya baris override `seo`, dan tetap menghormati override editor.
            ->with('SEOData', $post->getDynamicSEOData());
    }

    public function redirectLegacy(string $slug): RedirectResponse
    {
        return redirect('/'.ltrim($slug, '/'), 301);
    }

    /** Short link: /b/{code} → redirect ke artikel lengkap */
    public function short(string $code): RedirectResponse
    {
        $post = Post::where('published', true)
            ->where(fn ($q) => $q
                ->where('short_code', $code)
                ->when(is_numeric($code), fn ($sq) => $sq->orWhere('id', (int) $code)))
            ->firstOrFail();

        return redirect()->route('blog.show', $post->slug, 301);
    }
}
