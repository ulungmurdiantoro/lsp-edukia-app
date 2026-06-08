@extends('layouts.app')
{{-- Meta dikelola via $SEOData dari PageController@webinarGerakanNasional (ralphjsmit/laravel-seo). --}}

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-informasi.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:44px 0 48px;position:relative;max-width:60ch}
.page-hero-badge{display:inline-flex;align-items:center;gap:10px;height:32px;padding:0 14px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:16px}
.page-hero-badge .dot{width:7px;height:7px;border-radius:50%;background:#7ee0a3;box-shadow:0 0 0 4px rgba(126,224,163,.18)}
.page-hero h1{color:#fff;margin:0;font-size:clamp(24px,3.2vw,38px)}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue);letter-spacing:-0.02em}

/* Asset cards */
.asset-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.asset-card{background:#fff;border:1px solid var(--line);border-radius:18px;padding:26px;display:flex;flex-direction:column;gap:14px;text-decoration:none;color:inherit;transition:border-color .18s,transform .18s,box-shadow .18s}
.asset-card:hover{border-color:var(--blue);transform:translateY(-3px);box-shadow:0 14px 36px rgba(15,29,53,.08)}
.asset-ico{width:52px;height:52px;border-radius:14px;display:grid;place-items:center;background:var(--navy-50);color:var(--navy-700)}
.asset-ico.orange{background:var(--orange-50);color:var(--orange-deep)}
.asset-ico.blue{background:var(--blue-50);color:var(--blue-deep)}
.asset-ico svg{width:26px;height:26px}
.asset-card h3{font-size:17px;margin:0}
.asset-card p{font-size:13.5px;color:var(--muted);line-height:1.55;flex:1}
.asset-link{display:inline-flex;align-items:center;gap:8px;font-size:13.5px;font-weight:600;color:var(--blue-deep)}
.asset-link svg{width:16px;height:16px;transition:transform .18s}
.asset-card:hover .asset-link{color:var(--orange-deep)}
.asset-card:hover .asset-link svg{transform:translateX(3px)}

/* Related blog cards */
.post-card{display:block;text-decoration:none;color:inherit}
.post-card-body p{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}

@media(max-width:960px){.asset-grid{grid-template-columns:1fr 1fr}}
@media(max-width:600px){.asset-grid{grid-template-columns:1fr}}
</style>
@endsection

@section('content')
{{-- Hero --}}
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="page-hero-badge"><span class="dot"></span> Hasil Webinar Nasional</div>
    <h1>Gerakan Nasional Sertifikasi Kompetensi SDM Perguruan Tinggi &amp; <em>Laboratorium ISO/IEC 17025</em></h1>
  </div>
</div>

{{-- Asset / tautan webinar --}}
<section style="background:var(--cream)">
  <div class="wrap">
    <div class="sec-head" style="text-align:center;margin:0 auto 48px">
      <span class="eyebrow" style="justify-content:center">Unduhan &amp; Tautan</span>
      <h2 style="margin-top:10px">Akses hasil webinar</h2>
      <p class="sub" style="margin:14px auto 0">Klik salah satu kartu untuk membuka folder Google Drive terkait. Pastikan Anda login dengan akun Google untuk mengakses berkas.</p>
    </div>

    <div class="asset-grid">
      @foreach($assets as $asset)
      <a class="asset-card" href="{{ $asset['url'] }}" target="_blank" rel="noopener noreferrer">
        <div class="asset-ico {{ $asset['tone'] }}"><svg><use href="#{{ $asset['icon'] }}"></use></svg></div>
        <h3>{{ $asset['label'] }}</h3>
        <p>{{ $asset['desc'] }}</p>
        <span class="asset-link">Buka di Google Drive <svg><use href="#i-arrow-r"></use></svg></span>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- Kumpulan blog --}}
<section>
  <div class="wrap">
    <div class="sec-head" style="display:flex;justify-content:space-between;align-items:flex-end;gap:20px;flex-wrap:wrap;max-width:none">
      <div>
        <span class="eyebrow">Dari Blog Kami</span>
        <h2 style="margin-top:10px">Artikel &amp; informasi sertifikasi</h2>
        <p class="sub" style="margin-top:12px">Bacaan lanjutan seputar sertifikasi kompetensi, skema, dan pengembangan profesi.</p>
      </div>
      <a class="btn btn-outline" href="{{ route('blog.index') }}">Lihat semua artikel
        <svg class="icon"><use href="#i-arrow-r"></use></svg>
      </a>
    </div>

    @if($posts->count() > 0)
    <div class="blog-grid">
      @foreach($posts as $post)
      <a href="{{ route('blog.show', $post->slug) }}" class="post-card">
        <div class="post-card-img">
          @if($post->thumbnail)
          <img src="{{ $post->thumbnail_url }}" alt="{{ $post->judul }}" loading="lazy">
          @else
          <div class="blog-card-placeholder" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--navy-50),var(--blue-50))">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--navy-500)" stroke-width="1.5">
              <rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 15l4-4 3 3 4-5 7 9"/>
            </svg>
          </div>
          @endif
        </div>
        <div class="post-card-body">
          <div class="post-card-cat">{{ $post->kategori }}</div>
          <h3>{{ $post->judul }}</h3>
          <p>{{ $post->ringkasan }}</p>
          <div class="post-card-meta">{{ $post->penulis }} &nbsp;·&nbsp; {{ $post->published_at?->translatedFormat('d M Y') }}</div>
        </div>
      </a>
      @endforeach
    </div>
    @else
    <p style="color:var(--muted);text-align:center;padding:48px 0;font-size:16px">Belum ada artikel. Tambahkan di <a href="/admin/posts" style="color:var(--blue)">panel admin</a>.</p>
    @endif
  </div>
</section>

{{-- CTA --}}
<section style="padding:0 0 96px;border-top:0">
  <div class="wrap">
    <div class="cta">
      <div class="cta-body">
        <h3>Ingin tim Anda tersertifikasi?</h3>
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
