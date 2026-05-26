<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FixPostRingkasan extends Command
{
    protected $signature   = 'blog:fix-ringkasan';
    protected $description = 'Perbaiki ringkasan artikel yang kosong atau berisi placeholder';

    public function handle(): void
    {
        // Fix ringkasan kosong / placeholder
        $posts = Post::whereNull('ringkasan')
            ->orWhere('ringkasan', '')
            ->orWhere('ringkasan', 'like', '%memuat%')
            ->orWhere('ringkasan', 'like', '%loading%')
            ->get();

        $this->info("Memperbaiki ringkasan: {$posts->count()} artikel.");
        foreach ($posts as $post) {
            $ringkasan = Str::limit(strip_tags($post->konten ?? ''), 280);
            $post->update(['ringkasan' => $ringkasan]);
            $this->line("  ✓ ringkasan: {$post->judul}");
        }

        // Wrap iframe yang belum dibungkus
        $allPosts = Post::where('konten', 'like', '%<iframe%')
            ->where('konten', 'not like', '%iframe-wrap%')
            ->get();

        $this->info("Memperbaiki iframe: {$allPosts->count()} artikel.");
        foreach ($allPosts as $post) {
            $konten = preg_replace('/<iframe([^>]*)><\/iframe>/i', '<div class="iframe-wrap"><iframe$1></iframe></div>', $post->konten);
            $post->update(['konten' => $konten]);
            $this->line("  ✓ iframe: {$post->judul}");
        }

        $this->info('Selesai.');
    }
}
