@extends('layouts.app')
@section('title', $post->judul . ' — LSP Edukia')

@section('content')
<section class="hero" style="border-top:0;padding:0">
  <div class="wrap" style="padding:56px 32px 48px">
    <div class="badge" style="margin-bottom:16px"><span class="dot"></span> {{ $post->kategori }}</div>
    <h1 style="color:#fff;max-width:22ch;font-size:clamp(28px,4vw,48px)">{{ $post->judul }}</h1>
    <p style="color:rgba(255,255,255,.6);margin-top:14px;font-size:14px">{{ $post->penulis }} &nbsp;·&nbsp; {{ $post->published_at?->translatedFormat('d F Y') }}</p>
  </div>
</section>

<section>
  <div class="wrap" style="max-width:800px">
    @if($post->thumbnail)
    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->judul }}"
      style="width:100%;border-radius:16px;margin-bottom:40px;object-fit:cover;max-height:420px">
    @endif
    <div class="post-content" style="font-size:16px;line-height:1.8;color:var(--ink-2)">
      {!! nl2br(e($post->konten)) !!}
    </div>
    <div style="margin-top:48px;padding-top:28px;border-top:1px solid var(--line);display:flex;gap:16px">
      <a href="{{ route('blog.index') }}" class="btn btn-outline">
        <svg class="icon"><use href="#i-arrow-l"></use></svg> Kembali ke Blog
      </a>
      <a href="https://wa.me/6285175479385" class="btn btn-primary" target="_blank" rel="noopener">
        Daftar Sekarang <svg class="icon"><use href="#i-arrow-r"></use></svg>
      </a>
    </div>
  </div>
</section>
@endsection
