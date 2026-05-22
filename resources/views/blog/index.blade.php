@extends('layouts.app')
@section('title', 'Blog & Artikel — LSP Edukia')

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-informasi.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.page-hero-badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}

/* Blog grid */
.blog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.blog-card{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;text-decoration:none;color:inherit;display:block;transition:box-shadow .18s,transform .18s}
.blog-card:hover{box-shadow:0 8px 32px rgba(10,37,71,.10);transform:translateY(-2px)}
.blog-card-img{aspect-ratio:16/9;overflow:hidden;background:var(--navy-50)}
.blog-card-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .3s}
.blog-card:hover .blog-card-img img{transform:scale(1.04)}
.blog-card-body{padding:22px}
.blog-cat{font-size:11px;font-weight:700;color:var(--blue-deep);letter-spacing:.1em;text-transform:uppercase;margin-bottom:10px}
.blog-card-body h3{font-size:17px;font-weight:700;color:var(--ink);margin:0 0 10px;line-height:1.35;text-wrap:balance}
.blog-card-body p{font-size:13.5px;color:var(--muted);line-height:1.6;margin:0;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.blog-meta{font-size:12px;color:var(--muted);margin-top:16px;padding-top:14px;border-top:1px solid var(--line)}

/* Placeholder image */
.blog-card-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--navy-50),var(--blue-50))}

/* Empty state */
.blog-empty{padding:80px 24px;text-align:center;color:var(--muted)}
.blog-empty h3{font-size:22px;color:var(--ink);margin-bottom:12px}

/* Category filter chips */
.cat-filter{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:36px}
.cat-chip{height:38px;padding:0 18px;border-radius:999px;border:1px solid var(--line-2);background:#fff;color:var(--ink-2);font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:8px;font-family:inherit;text-decoration:none;transition:background .12s,color .12s,border-color .12s}
.cat-chip:hover,.cat-chip.active{border-color:var(--navy-800);background:var(--navy-800);color:#fff}

@media(max-width:960px){.blog-grid{grid-template-columns:1fr 1fr}}
@media(max-width:600px){.blog-grid{grid-template-columns:1fr}}
</style>
@endsection

@section('content')
{{-- Page hero --}}
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="page-hero-badge">Blog &amp; Artikel</div>
    <h1>Artikel &amp; informasi <em>sertifikasi</em></h1>
    <p class="lead">Tips sertifikasi, info skema terbaru, dan berita dari LSP Edukasi Global Cendekia.</p>
  </div>
</div>

<section style="padding:60px 0 96px;background:var(--cream)">
  <div class="wrap">

    {{-- Category filter --}}
    @php
    $cats = ['Tips Sertifikasi','Info Skema','Industri','Pelatihan','Kegiatan'];
    $currentCat = request('kategori');
    @endphp
    <div class="cat-filter">
      <a href="{{ route('blog.index') }}" class="cat-chip {{ !$currentCat ? 'active' : '' }}">Semua</a>
      @foreach($cats as $cat)
      <a href="{{ route('blog.index', ['kategori' => $cat]) }}"
         class="cat-chip {{ $currentCat === $cat ? 'active' : '' }}">{{ $cat }}</a>
      @endforeach
    </div>

    @if($posts->count() > 0)
    <div class="blog-grid">
      @foreach($posts as $post)
      <a href="{{ route('blog.show', $post->slug) }}" class="blog-card">
        <div class="blog-card-img">
          @if($post->thumbnail)
          <img src="{{ $post->thumbnail_url }}" alt="{{ $post->judul }}" loading="lazy">
          @else
          <div class="blog-card-placeholder">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--navy-500)" stroke-width="1.5">
              <rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 15l4-4 3 3 4-5 7 9"/>
            </svg>
          </div>
          @endif
        </div>
        <div class="blog-card-body">
          <div class="blog-cat">{{ $post->kategori }}</div>
          <h3>{{ $post->judul }}</h3>
          <p>{{ $post->ringkasan }}</p>
          <div class="blog-meta">{{ $post->penulis }} &nbsp;·&nbsp; {{ $post->published_at?->translatedFormat('d M Y') }}</div>
        </div>
      </a>
      @endforeach
    </div>

    @if($posts->hasPages())
    <div style="margin-top:48px;display:flex;justify-content:center">
      {{ $posts->appends(request()->query())->links() }}
    </div>
    @endif

    @else
    <div class="blog-empty">
      <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--line-2)" stroke-width="1.5" style="margin-bottom:20px">
        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
      </svg>
      <h3>Belum ada artikel</h3>
      <p>Tambahkan artikel pertama melalui <a href="/admin/posts" style="color:var(--blue);font-weight:600">panel admin</a>.</p>
    </div>
    @endif

  </div>
</section>

<section style="padding:0 0 96px;border-top:0">
  <div class="wrap">
    <div class="cta">
      <div class="cta-body">
        <h3>Siap memulai sertifikasi Anda?</h3>
        <p>Konsultasi GRATIS dengan tim kami — hubungi via WhatsApp sekarang.</p>
      </div>
      <a class="btn btn-primary btn-lg" href="{{ route('skema') }}">
        <svg class="icon"><use href="#i-doc"></use></svg> Lihat 26 skema
      </a>
      <a class="wa" href="https://wa.me/6285175479385">
        <svg class="icon" style="color:#7ee0a3"><use href="#i-wa"></use></svg>
        +62 851-7547-9385
      </a>
    </div>
  </div>
</section>
@endsection
