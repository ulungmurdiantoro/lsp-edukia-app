@extends('layouts.app')
{{-- Meta dikelola via $SEOData dari PageController@booklet. --}}
{{-- $booklets: Collection<Booklet> yang ditampilkan, urut kolom `urutan` — dikelola admin di menu Booklet. --}}
@push('head')
<link rel="preload" as="image" href="{{ asset('images/hero-informasi.jpg') }}" fetchpriority="high">
@endpush

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-informasi.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue);letter-spacing:-0.02em}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}

/* auto-fit: satu booklet melebar penuh, dua booklet berdampingan */
.booklet-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,480px),1fr));gap:24px}
.booklet-card{display:grid;grid-template-columns:200px 1fr;gap:28px;align-items:start;background:#fff;border:1px solid var(--line);border-radius:18px;padding:24px;transition:border-color .2s,box-shadow .2s,transform .2s}
.booklet-card:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 12px 32px rgba(15,29,53,.08)}
.booklet-cover{aspect-ratio:3/4;border-radius:10px;overflow:hidden;background:linear-gradient(150deg,var(--navy-700),var(--navy-900));box-shadow:0 10px 24px rgba(10,37,71,.18);display:block}
.booklet-cover img{width:100%;height:100%;object-fit:cover;display:block}
.booklet-cover .ph{height:100%;display:flex;flex-direction:column;justify-content:space-between;padding:18px 16px;color:#fff}
.booklet-cover .ph svg{width:30px;height:30px;color:var(--orange)}
.booklet-cover .ph span{font-weight:700;font-size:15px;line-height:1.3;letter-spacing:-0.01em}
.booklet-body{display:flex;flex-direction:column;gap:10px;min-width:0;padding-top:4px}
.booklet-kind{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--blue-deep)}
.booklet-body h2{font-size:22px;line-height:1.25;letter-spacing:-0.02em}
.booklet-body p{font-size:14.5px;color:var(--muted);line-height:1.6;max-width:60ch}
.booklet-actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:10px}

.booklet-empty{padding:60px 24px;text-align:center;color:var(--muted);font-size:14px;background:#fff;border:1px solid var(--line);border-radius:16px}

@media(max-width:640px){
  .booklet-card{grid-template-columns:110px 1fr;gap:18px;padding:18px}
  .booklet-body h2{font-size:18px}
  .booklet-cover .ph{padding:12px 10px}
  .booklet-cover .ph span{font-size:12px}
  .booklet-actions .btn{height:40px;padding:0 14px;font-size:13.5px}
}
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">Booklet · LSP Edukia</div>
    <h1>Booklet <em>LSP Edukia</em></h1>
    <p class="lead">Kenali LSP Edukasi Global Cendekia lebih dekat — profil lembaga, skema sertifikasi kompetensi, serta alur dan persyaratan uji kompetensi dalam satu booklet yang bisa dibaca online atau diunduh.</p>
  </div>
</div>

<section style="padding:60px 0 96px;background:var(--cream)">
  <div class="wrap">
    @if($booklets->isEmpty())
      <div class="booklet-empty">Belum ada booklet yang dipublikasikan. Silakan cek kembali nanti atau hubungi tim kami via WhatsApp.</div>
    @else
      <div class="booklet-grid">
        @foreach($booklets as $booklet)
        <article class="booklet-card">
          <a class="booklet-cover" href="{{ $booklet->url() }}" target="_blank" rel="noopener" aria-label="Baca {{ $booklet->judul }}">
            @if($booklet->coverUrl())
              <img src="{{ $booklet->coverUrl() }}" alt="Sampul {{ $booklet->judul }}" loading="lazy">
            @else
              <div class="ph">
                <svg><use href="#i-book"></use></svg>
                <span>{{ $booklet->judul }}</span>
              </div>
            @endif
          </a>
          <div class="booklet-body">
            <div class="booklet-kind">{{ $booklet->bisaDiunduh() ? 'Booklet · PDF' : 'Booklet · Online' }}</div>
            <h2>{{ $booklet->judul }}</h2>
            @if($booklet->deskripsi)
              <p>{{ $booklet->deskripsi }}</p>
            @endif
            <div class="booklet-actions">
              <a class="btn btn-primary" href="{{ $booklet->url() }}" target="_blank" rel="noopener">
                <svg class="icon"><use href="#i-book"></use></svg> Baca Booklet
              </a>
              @if($booklet->bisaDiunduh())
                <a class="btn btn-outline" href="{{ $booklet->url() }}" download="{{ $booklet->namaUnduhan() }}">
                  <svg class="icon"><use href="#i-download"></use></svg> Unduh PDF
                </a>
              @endif
            </div>
          </div>
        </article>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
