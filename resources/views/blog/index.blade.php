@extends('layouts.app')
@section('title', 'Blog — LSP Edukia')

@section('content')
<section class="hero" style="border-top:0;padding:0">
  <div class="wrap" style="padding:64px 32px">
    <div class="badge" style="margin-bottom:20px"><span class="dot"></span> Blog &amp; Artikel</div>
    <h1 style="color:#fff;max-width:16ch">Artikel &amp; informasi <em>sertifikasi</em></h1>
    <p class="lead" style="margin-top:16px">Tips sertifikasi, info skema terbaru, dan berita dari LSP Edukasi Global Cendekia.</p>
  </div>
</section>

<section>
  <div class="wrap">
    @if($posts->count() > 0)
    <div class="blog-grid">
      @foreach($posts as $post)
      <a class="post-card" href="{{ route('blog.show', $post->slug) }}">
        <div class="post-card-img">
          @if($post->thumbnail)
          <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->judul }}">
          @else
          <div style="background:var(--navy-50);height:100%;display:flex;align-items:center;justify-content:center;color:var(--muted)">
            <svg width="40" height="40"><use href="#i-image"></use></svg>
          </div>
          @endif
        </div>
        <div class="post-card-body">
          <div class="post-card-cat">{{ $post->kategori }}</div>
          <h3>{{ $post->judul }}</h3>
          @if($post->ringkasan)
          <p>{{ Str::limit($post->ringkasan, 120) }}</p>
          @endif
          <div class="post-card-meta">{{ $post->penulis }} · {{ $post->published_at?->translatedFormat('d M Y') }}</div>
        </div>
      </a>
      @endforeach
    </div>
    <div style="margin-top:40px">{{ $posts->links() }}</div>
    @else
    <p style="color:var(--muted);text-align:center;padding:64px 0;font-size:16px">Belum ada artikel. Tambahkan di <a href="/admin/posts" style="color:var(--blue)">panel admin</a>.</p>
    @endif
  </div>
</section>
@endsection
