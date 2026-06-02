@extends('layouts.app')
@section('title', $post->judul . ' — LSP Edukia')
@section('description', Str::limit(strip_tags($post->ringkasan ?: $post->konten), 160))
@section('og-type', 'article')
@section('og-image', $post->thumbnail ? $post->thumbnail_url : asset('images/hero-index.jpg'))
@section('schema-json')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ addslashes($post->judul) }}",
  "description": "{{ addslashes(Str::limit(strip_tags($post->ringkasan ?: $post->konten), 160)) }}",
  @if($post->thumbnail)
  "image": "{{ $post->thumbnail_url }}",
  @endif
  "datePublished": "{{ $post->published_at?->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": { "@type": "Organization", "name": "LSP Edukia" },
  "publisher": {
    "@type": "Organization",
    "name": "LSP Edukia",
    "logo": { "@type": "ImageObject", "url": "{{ asset('images/logo-edukia.png') }}" }
  },
  "mainEntityOfPage": { "@type": "WebPage", "@id": "{{ url()->current() }}" }
}
</script>
@endsection

@section('extra-css')
<style>
/* ── Article header ─────────────────────────────────────── */
.art-header{background:#fff;border-bottom:1px solid var(--line);padding:24px 0 28px}
.art-breadcrumb{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--muted);margin-bottom:16px}
.art-breadcrumb a{color:var(--muted);text-decoration:none}
.art-breadcrumb a:hover{color:var(--navy-800)}
.art-cat-badge{display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:999px;font-size:11px;font-weight:700;background:var(--orange-50);color:var(--orange-deep);letter-spacing:.04em;text-transform:uppercase;margin-bottom:12px}
.art-h1{font-size:clamp(22px,3vw,40px);line-height:1.15;letter-spacing:-.02em;font-weight:800;color:var(--ink);margin:0 0 14px}
.art-lead{font-size:16px;color:var(--ink-2);line-height:1.65;margin:0}
.art-meta{display:flex;align-items:center;gap:14px;margin-top:18px;padding-top:16px;border-top:1px solid var(--line);font-size:13px;color:var(--muted);flex-wrap:wrap}
.art-author{display:flex;align-items:center;gap:10px}
.art-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--navy-800),var(--navy-600));color:#fff;display:grid;place-items:center;font-weight:800;font-size:13px;flex:0 0 auto}
.art-author-name{color:var(--ink);font-weight:700;font-size:14px}
.art-author-role{font-size:12.5px;color:var(--muted)}
.meta-sep{width:1px;height:24px;background:var(--line-2);flex:0 0 auto}
.art-share-btn{background:#fff;border:1px solid var(--line-2);height:38px;padding:0 16px;border-radius:999px;font-weight:600;font-size:13px;color:var(--ink-2);cursor:pointer;display:inline-flex;align-items:center;gap:6px;text-decoration:none}
.art-share-btn:hover{border-color:var(--navy-800);color:var(--navy-800)}
.art-share-primary{background:var(--navy-800);color:#fff;border-color:var(--navy-800)}
.art-share-primary:hover{background:var(--navy-700);color:#fff}

/* ── Article body ───────────────────────────────────────── */
.art-body-section{padding:32px 0 72px;background:var(--cream)}
.art-body-grid{display:grid;grid-template-columns:1fr 200px;gap:48px;align-items:flex-start}
.art-prose{max-width:720px;font-size:16px;line-height:1.8;color:var(--ink-2)}
.art-prose>p:first-child{font-size:17px;line-height:1.7;font-weight:500;color:var(--ink);margin:0 0 20px}
.art-prose p{margin:0 0 18px}
.art-prose h2{font-size:22px;font-weight:700;color:var(--ink);margin:36px 0 12px;letter-spacing:-.02em;line-height:1.25}
.art-prose h3{font-size:18px;font-weight:700;color:var(--ink);margin:28px 0 10px}
.art-prose h4{font-size:15px;font-weight:700;color:var(--ink);margin:20px 0 8px}
.art-prose ul,.art-prose ol{margin:0 0 18px;padding-left:22px}
.art-prose li{margin-bottom:6px;line-height:1.65}
.art-prose blockquote{margin:24px 0;padding:16px 20px;background:#fff;border-left:4px solid var(--orange);border-radius:0 10px 10px 0;font-size:16px;font-style:italic;color:var(--navy-800);font-family:"Fraunces",serif;font-weight:400;line-height:1.55}
.art-prose a{color:var(--blue);text-decoration:underline}
.art-prose strong{color:var(--ink);font-weight:700}
.art-prose em{font-style:italic}
.art-prose pre,.art-prose code{font-family:ui-monospace,monospace;font-size:13px;background:var(--navy-50);padding:2px 6px;border-radius:4px}
/* WordPress imported content */
.art-prose figure{margin:24px 0}
.art-prose figure img,.art-prose img{max-width:100%;height:auto;border-radius:10px;display:block}
.art-prose figcaption{font-size:13px;color:var(--muted);text-align:center;margin-top:8px;font-style:italic}
.art-prose table{width:100%;border-collapse:collapse;font-size:14.5px;margin:20px 0}
.art-prose table th{background:var(--navy-800);color:#fff;padding:10px 14px;text-align:left;font-weight:600}
.art-prose table td{padding:9px 14px;border-bottom:1px solid var(--line);vertical-align:top}
.art-prose table tr:nth-child(even) td{background:var(--navy-50)}
.art-prose .art-featured-img{width:100%;max-height:380px;object-fit:cover;border-radius:12px;border:1px solid var(--line);margin-bottom:28px;display:block}
/* Responsive iframe (YouTube embed dll) */
.art-prose .iframe-wrap{position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:10px;margin:20px 0}
.art-prose .iframe-wrap iframe{position:absolute;top:0;left:0;width:100%;height:100%;border:0}
.art-prose iframe{max-width:100%;width:100%;aspect-ratio:16/9;border-radius:10px;margin:20px 0;border:0;display:block}
.art-prose *{color:inherit}

/* Callout box (for custom CTA inside article) */
.art-callout{margin:32px 0;padding:28px;background:#fff;border:1px solid var(--line);border-radius:16px;display:flex;gap:18px;align-items:flex-start}
.art-callout-icon{width:48px;height:48px;border-radius:12px;background:var(--navy-50);color:var(--navy-700);display:grid;place-items:center;flex:0 0 auto}

/* Tags */
.art-tags{margin-top:40px;padding-top:28px;border-top:1px solid var(--line);display:flex;flex-wrap:wrap;gap:8px;align-items:center}
.tag-label{font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);margin-right:6px}
.tag-chip{background:#fff;border:1px solid var(--line-2);padding:6px 12px;border-radius:999px;font-size:12.5px;color:var(--ink-2);font-weight:500;text-decoration:none}
.tag-chip:hover{border-color:var(--navy-800);color:var(--navy-800)}

/* ── ToC sidebar ─────────────────────────────────────────── */
.toc-aside{position:sticky;top:100px}
.toc-eyebrow{font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);margin-bottom:14px}
.toc-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0;border-left:2px solid var(--line)}
.toc-item{padding-left:14px;margin-left:-2px;border-left:2px solid transparent;transition:border-color .15s}
.toc-item.active{border-left-color:var(--orange)}
.toc-item a{font-size:13px;color:var(--muted);font-weight:500;text-decoration:none;line-height:1.4;display:block;padding:5px 0;transition:color .12s}
.toc-item.active a,.toc-item a:hover{color:var(--navy-800);font-weight:700}

/* ── Related posts ──────────────────────────────────────── */
.related-section{padding:64px 0 96px;background:var(--cream,#fbf9f3);border-top:1px solid var(--line)}
.related-header{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:28px}
.related-header h3{font-size:28px;font-weight:700;color:var(--ink);margin:0;letter-spacing:-.02em}
.related-header a{font-size:13.5px;color:var(--navy-800);font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:4px}
.related-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.related-card{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;text-decoration:none;color:inherit;display:block;transition:box-shadow .18s,transform .18s}
.related-card:hover{box-shadow:0 8px 28px rgba(10,37,71,.09);transform:translateY(-2px)}
.related-card-img{aspect-ratio:16/9;overflow:hidden;background:var(--navy-50)}
.related-card-img img{width:100%;height:100%;object-fit:cover;display:block}
.related-card-body{padding:22px}
.related-cat{font-size:11px;font-weight:700;color:var(--blue-deep);letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px}
.related-card-body h4{font-size:16px;font-weight:700;color:var(--ink);margin:0;line-height:1.35}

@media(max-width:960px){
  .art-body-grid{grid-template-columns:1fr}
  .toc-aside{display:none}
  .related-grid{grid-template-columns:1fr 1fr}
  .art-hero-wrap{padding:0}
  .art-hero-img{border-radius:0;border-left:0;border-right:0;margin-top:0}
  .art-h1{font-size:clamp(20px,4vw,30px)}
}
@media(max-width:600px){
  .related-grid{grid-template-columns:1fr}
  .art-meta{gap:10px}
  .meta-sep{display:none}
  .art-h1{font-size:20px}
  .art-lead{font-size:15px}
  .art-header{padding:20px 0 28px}
  .art-body-section{padding:28px 0 56px}
  .art-prose{font-size:15px}
}
</style>
@endsection

@section('content')
<article>

  {{-- ─ Article header ──────────────────────────────────── --}}
  <header class="art-header">
    <div class="wrap">
      {{-- Breadcrumb --}}
      <div class="art-breadcrumb">
        <a href="{{ route('blog.index') }}">Blog</a>
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        <span>{{ $post->kategori }}</span>
      </div>

      <div>
        {{-- Category badge --}}
        <div class="art-cat-badge">
          <span style="width:6px;height:6px;border-radius:50%;background:var(--orange);flex:0 0 auto"></span>
          {{ $post->kategori }}
        </div>

        {{-- Title --}}
        <h1 class="art-h1">{{ $post->judul }}</h1>

        {{-- Lead / ringkasan --}}
        @php $lead = $post->ringkasan && !str_contains(strtolower($post->ringkasan), 'memuat') ? $post->ringkasan : null; @endphp
        @if($lead)
        <p class="art-lead">{{ $lead }}</p>
        @endif

        {{-- Meta row --}}
        <div class="art-meta">
          <div class="art-author">
            <div class="art-avatar">TL</div>
            <div>
              <div class="art-author-name">{{ $post->penulis }}</div>
              <div class="art-author-role">Editorial Team</div>
            </div>
          </div>
          <span class="meta-sep"></span>
          <span>{{ $post->published_at?->translatedFormat('d F Y') }}</span>
          <span class="meta-sep"></span>
          <span>{{ $post->reading_time }} menit baca</span>
        </div>
        <div style="display:flex;gap:10px;margin-top:14px;flex-wrap:wrap">
          <a href="https://wa.me/6285175479385?text={{ urlencode('Saya tertarik dengan artikel: ' . $post->judul) }}"
             class="art-share-btn" target="_blank" rel="noopener">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            Bagikan
          </a>
          <a href="{{ route('skema') }}" class="art-share-btn art-share-primary">
            Daftar Sertifikasi
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>
    </div>
  </header>

  {{-- ─ Article body + sidebar ───────────────────────────── --}}
  <div class="art-body-section">
    <div class="wrap">
      <div class="art-body-grid">

        {{-- Main prose --}}
        <div class="art-prose" id="art-body">
          @if($post->thumbnail)
          <img src="{{ $post->thumbnail_url }}" alt="{{ $post->judul }}" class="art-featured-img">
          @endif
          {!! $post->konten !!}

          {{-- Tags --}}
          <div class="art-tags">
            <span class="tag-label">Tags</span>
            <a href="{{ route('blog.index', ['kategori' => $post->kategori]) }}" class="tag-chip">{{ $post->kategori }}</a>
            <a href="{{ route('blog.index') }}" class="tag-chip">LSP Edukia</a>
            <a href="{{ route('blog.index') }}" class="tag-chip">Sertifikasi</a>
          </div>

          {{-- Back link --}}
          <div style="margin-top:36px;padding-top:28px;border-top:1px solid var(--line);display:flex;gap:12px;flex-wrap:wrap">
            <a href="{{ route('blog.index') }}" class="btn btn-outline">
              <svg class="icon"><use href="#i-arrow-l"></use></svg>
              Kembali ke Blog
            </a>
            <a href="{{ route('skema') }}" class="btn btn-primary">
              <svg class="icon"><use href="#i-doc"></use></svg>
              Lihat Skema Sertifikasi
            </a>
          </div>
        </div>

        {{-- ToC sidebar (built by JS) --}}
        <aside class="toc-aside" id="toc-aside">
          <div class="toc-eyebrow">Daftar Isi</div>
          <ol class="toc-list" id="toc-list"></ol>
        </aside>

      </div>
    </div>
  </div>

  {{-- ─ Related posts ─────────────────────────────────────── --}}
  @if($related->count() > 0)
  <section class="related-section">
    <div class="wrap">
      <div class="related-header">
        <h3>Artikel terkait</h3>
        <a href="{{ route('blog.index') }}">
          Semua artikel
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="related-grid">
        @foreach($related as $rel)
        <a href="{{ route('blog.show', $rel->slug) }}" class="related-card">
          <div class="related-card-img">
            @if($rel->thumbnail)
            <img src="{{ $rel->thumbnail_url }}" alt="{{ $rel->judul }}" loading="lazy">
            @else
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--navy-50)">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--navy-500)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 15l4-4 3 3 4-5 7 9"/></svg>
            </div>
            @endif
          </div>
          <div class="related-card-body">
            <div class="related-cat">{{ $rel->kategori }}</div>
            <h4>{{ $rel->judul }}</h4>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

</article>

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

@section('scripts')
<script>
(function () {
  const body    = document.getElementById('art-body');
  const tocList = document.getElementById('toc-list');
  const tocAside = document.getElementById('toc-aside');
  if (!body || !tocList) return;

  const headings = Array.from(body.querySelectorAll('h2'));
  if (headings.length === 0) { if (tocAside) tocAside.style.display = 'none'; return; }

  headings.forEach((h, i) => {
    const id = 'h2-' + i;
    h.id = id;
    const li = document.createElement('li');
    li.className = 'toc-item';
    li.innerHTML = '<a href="#' + id + '">' + h.textContent + '</a>';
    li.querySelector('a').addEventListener('click', function (e) {
      e.preventDefault();
      document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
    tocList.appendChild(li);
  });

  // Active heading on scroll
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      const li = tocList.querySelector('li:nth-child(' + (headings.indexOf(entry.target) + 1) + ')');
      if (li) li.classList.toggle('active', entry.isIntersecting);
    });
  }, { rootMargin: '0px 0px -55% 0px', threshold: 0 });

  headings.forEach(h => observer.observe(h));
})();
</script>
@endsection
