<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()->paginate(9);
        return view('blog.index', compact('posts'))->with('activeNav', 'blog');
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->where('published', true)->firstOrFail();
        return view('blog.show', compact('post'))->with('activeNav', 'blog');
    }
}
