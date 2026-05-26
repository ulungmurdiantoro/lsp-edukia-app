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
        $posts = Post::whereNull('ringkasan')
            ->orWhere('ringkasan', '')
            ->orWhere('ringkasan', 'like', '%memuat%')
            ->orWhere('ringkasan', 'like', '%loading%')
            ->get();

        $this->info("Ditemukan {$posts->count()} artikel yang perlu diperbaiki.");

        foreach ($posts as $post) {
            $ringkasan = Str::limit(strip_tags($post->konten ?? ''), 280);
            $post->update(['ringkasan' => $ringkasan]);
            $this->line("  ✓ {$post->judul}");
        }

        $this->info('Selesai.');
    }
}
