<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->when(request('kategori'), fn ($q, $cat) => $q->where('kategori', $cat))
            ->latest('published_at')
            ->paginate(9);
        return view('blog.index', compact('posts'))->with('activeNav', 'blog');
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

        return view('blog.show', compact('post', 'related'))->with('activeNav', 'blog');
    }

    public function redirectLegacy(string $slug): RedirectResponse
    {
        return redirect('/' . ltrim($slug, '/'), 301);
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
