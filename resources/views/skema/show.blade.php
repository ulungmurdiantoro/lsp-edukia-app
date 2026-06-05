@extends('layouts.app')
{{-- Meta + schema Course/Breadcrumb dikelola via $SEOData dari SkemaController@show. --}}
@push('head')
<link rel="preload" as="image" href="{{ asset('images/hero-skema.jpg') }}" fetchpriority="high">
@endpush

@section('extra-css')
<style>
.sk-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.86) 0%,rgba(6,23,46,.94) 100%),url('/images/hero-skema.jpg');background-size:auto,auto,cover;background-position:center;color:#fff}
.sk-hero-inner{padding:40px 0 48px}
.sk-crumb{display:flex;flex-wrap:wrap;gap:6px;align-items:center;font-size:13px;color:rgba(255,255,255,.6);margin-bottom:18px}
.sk-crumb a{color:rgba(255,255,255,.7)}
.sk-crumb a:hover{color:#fff}
.sk-tag{display:inline-flex;align-items:center;gap:6px;height:30px;padding:0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.2);font-size:12px;font-weight:600;letter-spacing:.03em;margin-bottom:14px}
.sk-hero h1{color:#fff;font-size:clamp(26px,3.4vw,40px);line-height:1.1;margin-bottom:12px}
.sk-meta{display:flex;flex-wrap:wrap;gap:18px;margin-top:18px;font-size:13.5px;color:rgba(255,255,255,.72)}
.sk-meta b{color:#fff;font-weight:700}
.sk-body{padding:48px 0 88px;background:var(--cream)}
.sk-grid{display:grid;grid-template-columns:1fr 320px;gap:40px;align-items:flex-start}
.sk-card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:26px 28px;margin-bottom:24px}
.sk-card h2{font-size:20px;margin-bottom:16px;letter-spacing:-.02em}
.sk-lead{font-size:16px;line-height:1.75;color:var(--ink-2)}
.sk-req{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px}
.sk-req li{display:flex;gap:12px;align-items:flex-start;font-size:14.5px;line-height:1.55;color:var(--ink-2)}
.sk-req .ck{width:22px;height:22px;border-radius:50%;background:var(--blue-50);color:var(--blue-deep);display:grid;place-items:center;flex:0 0 auto;margin-top:1px}
.unit-table{width:100%;border-collapse:collapse}
.unit-table th{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;padding:0 0 10px;text-align:left;border-bottom:1px solid var(--line-2)}
.unit-table td{padding:10px 0;font-size:13.5px;vertical-align:top;border-bottom:1px solid var(--cream-2)}
.unit-table tr:last-child td{border-bottom:none}
.unit-code{color:var(--blue-deep);font-family:ui-monospace,monospace;font-size:11.5px;white-space:nowrap;padding-right:14px;font-weight:600;min-width:130px}
.unit-title{color:var(--ink-2);line-height:1.5}
.sk-side{position:sticky;top:90px}
.sk-cta{background:linear-gradient(135deg,var(--navy-800),var(--navy-900));border-radius:16px;padding:24px;color:#fff}
.sk-cta h3{color:#fff;font-size:18px;margin-bottom:8px}
.sk-cta p{color:rgba(255,255,255,.72);font-size:13.5px;line-height:1.55;margin-bottom:16px}
.sk-cta .btn{width:100%;justify-content:center;margin-bottom:10px}
.sk-cta .wa{display:flex;align-items:center;justify-content:center;gap:8px;background:#25d366;color:#fff;height:46px;border-radius:999px;font-weight:600;font-size:14px}
.sk-rel{margin-top:18px}
.sk-rel h4{font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:12px}
.sk-rel a{display:block;background:#fff;border:1px solid var(--line);border-radius:12px;padding:13px 15px;font-size:13.5px;font-weight:600;color:var(--ink);margin-bottom:8px;line-height:1.4;transition:all .15s}
.sk-rel a:hover{border-color:var(--blue);color:var(--navy-800);transform:translateX(2px)}
@media(max-width:900px){.sk-grid{grid-template-columns:1fr}.sk-side{position:static}}
</style>
@endsection

@section('content')
<div class="sk-hero">
  <div class="wrap sk-hero-inner">
    <nav class="sk-crumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Beranda</a> ›
      <a href="{{ route('skema') }}">Skema Sertifikasi</a> ›
      <a href="{{ route('skema.bidang', $skema['bidang']) }}">{{ $skema['bidang_label'] }}</a> ›
      <span>{{ Str::limit($skema['nama'], 40) }}</span>
    </nav>
    <span class="sk-tag">{{ $skema['bidang_label'] }} · Terakreditasi KAN</span>
    <h1>Sertifikasi {{ $skema['nama'] }}</h1>
    <div class="sk-meta">
      @if($skema['kode'])<span>Kode skema: <b>{{ $skema['kode'] }}</b></span>@endif
      <span>Jumlah unit kompetensi: <b>{{ $skema['jumlah_unit'] }}</b></span>
      <span>Jenis kemasan: <b>{{ $skema['jenis_kemasan'] }}</b></span>
    </div>
  </div>
</div>

<div class="sk-body">
  <div class="wrap sk-grid">
    <div>
      <div class="sk-card">
        <h2>Tentang Skema</h2>
        <p class="sk-lead">Skema sertifikasi <b>{{ $skema['nama'] }}</b> merupakan bagian dari bidang
          <a href="{{ route('skema.bidang', $skema['bidang']) }}" style="color:var(--blue-deep);font-weight:600">{{ $skema['bidang_judul'] }}</a>
          yang diselenggarakan LSP Edukia (LSP Edukasi Global Cendekia), lembaga sertifikasi person
          terakreditasi <b>KAN (Komite Akreditasi Nasional)</b>. Uji kompetensi mencakup <b>{{ $skema['jumlah_unit'] }} unit kompetensi</b>
          dan menghasilkan Sertifikat Kompetensi terakreditasi KAN yang diakui secara nasional.</p>
      </div>

      <div class="sk-card">
        <h2>Persyaratan Pemohon</h2>
        <ul class="sk-req">
          @foreach($skema['persyaratan'] as $req)
            <li><span class="ck"><svg class="icon"><use href="#i-shield"></use></svg></span>{{ $req }}</li>
          @endforeach
        </ul>
      </div>

      <div class="sk-card">
        <h2>Unit Kompetensi ({{ $skema['jumlah_unit'] }})</h2>
        <table class="unit-table">
          <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
          <tbody>
            @foreach($skema['units'] as $unit)
              <tr><td class="unit-code">{{ $unit['kode'] }}</td><td class="unit-title">{{ $unit['judul'] }}</td></tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <aside class="sk-side">
      <div class="sk-cta">
        <h3>Daftar Sertifikasi Ini</h3>
        <p>Konsultasikan jadwal uji kompetensi dan biaya untuk skema {{ Str::limit($skema['nama'], 50) }} bersama tim kami.</p>
        <a class="btn btn-primary" href="https://wa.me/{{ config('site.whatsapp') }}?text={{ urlencode('Halo, saya ingin mendaftar sertifikasi ' . $skema['nama']) }}" target="_blank" rel="noopener">Daftar via WhatsApp
          <svg class="icon"><use href="#i-arrow-r"></use></svg>
        </a>
        <a class="wa" href="{{ route('skema') }}" style="background:rgba(255,255,255,.1)">Lihat semua skema</a>
      </div>

      @if($related->isNotEmpty())
      <div class="sk-rel">
        <h4>Skema {{ $skema['bidang_label'] }} lainnya</h4>
        @foreach($related as $r)
          <a href="{{ route('skema.show', $r['slug']) }}">{{ $r['nama'] }}</a>
        @endforeach
      </div>
      @endif
    </aside>
  </div>
</div>
@endsection
