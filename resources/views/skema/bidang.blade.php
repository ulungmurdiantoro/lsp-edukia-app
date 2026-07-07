@extends('layouts.app')
{{-- Meta + breadcrumb dikelola via $SEOData dari SkemaController@bidang. --}}
@push('head')
<link rel="preload" as="image" href="{{ asset('images/hero-skema.jpg') }}" fetchpriority="high">
@endpush

@section('extra-css')
<style>
.sk-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.86) 0%,rgba(6,23,46,.94) 100%),url('/images/hero-skema.jpg');background-size:auto,auto,cover;background-position:center;color:#fff}
.sk-hero-inner{padding:48px 0 56px}
.sk-crumb{display:flex;flex-wrap:wrap;gap:6px;align-items:center;font-size:13px;color:rgba(255,255,255,.6);margin-bottom:18px}
.sk-crumb a{color:rgba(255,255,255,.7)}
.sk-crumb a:hover{color:#fff}
.sk-hero h1{color:#fff;font-size:clamp(28px,3.6vw,44px);line-height:1.08;margin-bottom:12px}
.sk-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue)}
.sk-hero p{color:rgba(255,255,255,.78);font-size:16.5px;max-width:60ch;line-height:1.55}
.sk-list{padding:56px 0 88px;background:var(--cream)}
.sk-cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(330px,1fr));gap:18px}
.sk-item{display:flex;flex-direction:column;background:#fff;border:1px solid var(--line);border-radius:16px;padding:22px 24px;transition:all .18s}
.sk-item:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 10px 28px rgba(15,29,53,.07)}
.sk-item .top{display:flex;align-items:center;gap:10px;margin-bottom:12px}
.sk-item .num{width:34px;height:34px;border-radius:9px;background:var(--navy-50);color:var(--navy-700);display:grid;place-items:center;font-weight:800;font-size:14px;flex:0 0 auto}
.sk-item.pop .num{background:var(--orange-50);color:var(--orange-deep)}
.sk-item h3{font-size:15px;line-height:1.35;margin:0}
.sk-item .kode{font-family:ui-monospace,monospace;font-size:11px;color:var(--muted);margin-bottom:14px}
.sk-item .foot{margin-top:auto;display:flex;align-items:center;justify-content:space-between;padding-top:14px;border-top:1px solid var(--line)}
.sk-item .units{font-size:12.5px;color:var(--muted);font-weight:600}
.sk-item .go{font-size:13px;font-weight:700;color:var(--blue-deep);display:inline-flex;align-items:center;gap:5px}
.sk-pill{display:inline-flex;align-items:center;height:22px;padding:0 9px;border-radius:6px;font-size:10px;font-weight:800;letter-spacing:.04em;text-transform:uppercase;background:var(--orange-50);color:var(--orange-deep);margin-left:8px}
.sk-lisensi{align-self:flex-start;display:inline-flex;align-items:center;gap:5px;font-size:10.5px;font-weight:800;letter-spacing:.03em;padding:4px 9px;border-radius:6px;margin-bottom:14px}
.sk-lisensi.yes{background:#e3f5ea;color:#1a5c35}
.sk-lisensi.no{background:#f0f1f4;color:#5a6a85}
.sk-lisensi svg{width:12px;height:12px}
.sk-gelar{align-self:flex-start;display:inline-flex;align-items:center;gap:5px;font-size:10.5px;font-weight:700;padding:4px 9px;border-radius:6px;background:var(--navy-50);color:var(--navy-700);margin-bottom:14px;margin-top:6px}
.sk-gelar svg{width:12px;height:12px}
.sk-back{display:inline-flex;align-items:center;gap:6px;font-size:13.5px;font-weight:600;color:var(--navy-700);margin-top:32px}
.sk-back:hover{color:var(--orange-deep)}
@media(max-width:640px){.sk-cards{grid-template-columns:1fr}}
</style>
@endsection

@section('content')
<div class="sk-hero">
  <div class="wrap sk-hero-inner">
    <nav class="sk-crumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Beranda</a> ›
      <a href="{{ route('skema') }}">Skema Sertifikasi</a> ›
      <span>{{ $info['label'] }}</span>
    </nav>
    <h1>Skema <em>{{ $info['label'] }}</em></h1>
    <p>{{ $info['judul'] }} — {{ $skemas->count() }} skema sertifikasi kompetensi person di LSP Edukia, lembaga sertifikasi person terakreditasi KAN.</p>
  </div>
</div>

<div class="sk-list">
  <div class="wrap">
    <div class="sk-cards">
      @foreach($skemas as $s)
        <a href="{{ route('skema.show', $s['slug']) }}" class="sk-item {{ $s['popular'] ? 'pop' : '' }}">
          <div class="top">
            <span class="num">{{ $s['badge'] }}</span>
            <h3>{{ $s['nama'] }}@if($s['popular'])<span class="sk-pill">Populer</span>@endif</h3>
          </div>
          @if($s['kode'])<div class="kode">Kode Skema: {{ $s['kode'] }}</div>@endif
          @if($s['lisensi_kan'])
            <span class="sk-lisensi yes"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5L20 6"/></svg> Berlisensi KAN</span>
          @else
            <span class="sk-lisensi no">Belum Berlisensi KAN</span>
          @endif
          @if(!empty($s['gelar']))
            <span class="sk-gelar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></svg> Gelar Akademik: {{ $s['gelar'] }}</span>
          @endif
          <div class="foot">
            <span class="units">{{ $s['jumlah_unit'] }} unit kompetensi</span>
            <span class="go">Detail <svg class="icon"><use href="#i-arrow-r"></use></svg></span>
          </div>
        </a>
      @endforeach
    </div>
    <a href="{{ route('skema') }}" class="sk-back"><svg class="icon"><use href="#i-arrow-l"></use></svg> Lihat semua 26 skema sertifikasi</a>
  </div>
</div>
@endsection
