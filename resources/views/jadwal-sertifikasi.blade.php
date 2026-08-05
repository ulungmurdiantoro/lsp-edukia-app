@extends('layouts.app')
{{-- Meta dikelola via $SEOData dari PageController@jadwalSertifikasi (ralphjsmit/laravel-seo). --}}
{{-- $sektor: bidang_code => ['label' => string, 'items' => Collection<JadwalSertifikasi>], hanya bidang yang punya jadwal tampil. --}}

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-skema.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue);letter-spacing:-0.02em}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}

.jadwal-nav{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:32px}
.jadwal-nav a{height:34px;padding:0 16px;border-radius:999px;border:1px solid var(--line-2);background:#fff;color:var(--ink-2);font-size:13px;font-weight:600;display:inline-flex;align-items:center;text-decoration:none;transition:all .12s}
.jadwal-nav a:hover{border-color:var(--navy-800);color:var(--navy-800)}

.jadwal-card{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;margin-bottom:24px}
.jadwal-card-head{padding:20px 24px;background:linear-gradient(135deg,var(--navy-800),var(--navy-700));display:flex;align-items:center;justify-content:space-between;gap:12px}
.jadwal-card-head h2{color:#fff;font-size:18px;margin:0;letter-spacing:-0.01em}
.jadwal-count{font-size:12px;font-weight:700;color:rgba(255,255,255,.7);background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);padding:4px 10px;border-radius:999px;white-space:nowrap}

.jadwal-table-head{display:grid;grid-template-columns:60px 1fr 180px;padding:12px 24px;border-bottom:1px solid var(--line);font-size:10.5px;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);font-family:ui-monospace,monospace}
.jadwal-row{display:grid;grid-template-columns:60px 1fr 180px;padding:14px 24px;border-bottom:1px solid var(--line);align-items:center;font-size:13.5px;color:var(--ink-2)}
.jadwal-row:last-child{border-bottom:0}
.jadwal-row:nth-child(odd){background:var(--cream,#fbf9f3)}
.jadwal-row-num{font-size:12px;font-weight:700;color:var(--muted);font-family:ui-monospace,monospace}
.jadwal-skema{font-weight:600;color:var(--ink)}
.jadwal-tanggal{font-weight:700;color:var(--navy-800)}

.jadwal-empty{padding:60px 24px;text-align:center;color:var(--muted);font-size:14px;background:#fff;border:1px solid var(--line);border-radius:16px}

@media(max-width:640px){
  .jadwal-table-head,.jadwal-row{grid-template-columns:40px 1fr 110px;font-size:12.5px}
  .cta{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">Jadwal Terbaru · {{ $sektor->sum(fn ($s) => $s['items']->count()) }} Sesi Sertifikasi</div>
    <h1>Jadwal <em>Sertifikasi</em> Kompetensi</h1>
    <p class="lead">Jadwal pelaksanaan sertifikasi kompetensi LSP Edukasi Global Cendekia per sektor. Hubungi tim kami untuk informasi pendaftaran & persyaratan tiap skema.</p>
  </div>
</div>

<section style="padding:60px 0 96px;background:var(--cream,#fbf9f3)">
  <div class="wrap">

    @if($sektor->isEmpty())
      <div class="jadwal-empty">Belum ada jadwal sertifikasi yang dipublikasikan. Silakan cek kembali nanti atau hubungi tim kami.</div>
    @else
      <div class="jadwal-nav">
        @foreach($sektor as $bidang => $data)
        <a href="#sektor-{{ $bidang }}">{{ $data['label'] }} <span style="opacity:.6;margin-left:5px">({{ $data['items']->count() }})</span></a>
        @endforeach
      </div>

      @foreach($sektor as $bidang => $data)
      <div class="jadwal-card" id="sektor-{{ $bidang }}">
        <div class="jadwal-card-head">
          <h2>Sektor {{ $data['label'] }}</h2>
          <span class="jadwal-count">{{ $data['items']->count() }} jadwal</span>
        </div>
        <div class="jadwal-table-head">
          <div>No</div><div>Skema</div><div>Tanggal Sertifikasi</div>
        </div>
        @foreach($data['items'] as $i => $item)
        <div class="jadwal-row">
          <div class="jadwal-row-num">{{ $i + 1 }}</div>
          <div class="jadwal-skema">{{ $item->skema }}</div>
          <div class="jadwal-tanggal">{{ $item->tanggal_sertifikasi->translatedFormat('d M Y') }}</div>
        </div>
        @endforeach
      </div>
      @endforeach
    @endif

  </div>
</section>

<section style="padding:0 0 96px;border-top:0">
  <div class="wrap">
    <div class="cta">
      <div class="cta-body">
        <h3>Siap mengikuti sertifikasi kompetensi?</h3>
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
