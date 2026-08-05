@extends('layouts.app')
{{-- Meta dikelola via $SEOData dari PageController@jadwalSertifikasi (ralphjsmit/laravel-seo). --}}
{{-- $bulan: "Bulan YYYY" => Collection<JadwalSertifikasi>, urut kronologis. Tiap item punya skema_slug (nullable). --}}
{{-- Layout daftar per bulan mengikuti pola mutululusan.id/jadwal-pelatihan-2026; hero & tipografi mengikuti halaman lain di situs ini. --}}
@push('head')
<link rel="preload" as="image" href="{{ asset('images/hero-jadwal.jpg') }}" fetchpriority="high">
@endpush

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-jadwal.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue);letter-spacing:-0.02em}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}

.jadwal-group{margin-bottom:44px}
.jadwal-group-head{display:flex;align-items:center;gap:12px;margin-bottom:16px}
.jadwal-group-head h2{font-size:18px;font-weight:700;color:var(--ink);margin:0;letter-spacing:-0.01em;display:flex;align-items:center;gap:12px}
.jadwal-group-head h2::before{content:"";width:4px;height:20px;background:var(--orange);border-radius:2px;flex:0 0 auto}
.jadwal-group-head .cnt{font-size:12.5px;font-weight:600;color:var(--muted)}

.jadwal-list{display:flex;flex-direction:column;gap:12px}
.jadwal-item{position:relative;display:flex;flex-direction:column;gap:12px;border-radius:14px;border:1px solid var(--line);background:#fff;padding:16px 18px;transition:border-color .15s,box-shadow .15s,transform .15s}
.jadwal-item.linked:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 10px 28px rgba(15,29,53,.07)}
.jadwal-item.past{border-color:var(--line);background:var(--cream,#fbf9f3);opacity:.62}
.jadwal-item-info{min-width:0}
.jadwal-item-meta{font-size:12.5px;font-weight:700;color:var(--blue-deep,#1a5c9e);margin:0 0 4px;display:flex;align-items:center;gap:7px;flex-wrap:wrap}
.jadwal-item-skema{display:block;font-weight:700;color:var(--ink);font-size:15px;line-height:1.35;text-decoration:none}
a.jadwal-item-skema::after{content:"";position:absolute;inset:0;border-radius:14px}
.jadwal-item.linked:hover .jadwal-item-skema{color:var(--navy-800)}
.jadwal-bidang{display:inline-flex;align-items:center;font-size:10.5px;font-weight:700;padding:3px 8px;border-radius:5px;letter-spacing:.02em;background:var(--navy-50,#eef3fb);color:var(--navy-600,#1a4a8a)}
.jadwal-item-action{position:relative;z-index:2;display:flex;align-items:center;gap:10px;flex-shrink:0}
.jadwal-status-done{font-size:12.5px;font-weight:600;color:var(--muted)}
.jadwal-btn{height:36px;padding:0 18px;border-radius:999px;background:var(--navy-800);color:#fff;font-size:12.5px;font-weight:700;display:inline-flex;align-items:center;gap:6px;text-decoration:none;white-space:nowrap;transition:background .12s}
.jadwal-btn:hover{background:var(--orange,#f4891f)}

.jadwal-empty{padding:60px 24px;text-align:center;color:var(--muted);font-size:14px;background:#fff;border:1px solid var(--line);border-radius:16px}

.jadwal-note{margin-top:28px;padding:18px 22px;background:var(--blue-50);border:1px solid #bfdbfe;border-radius:12px;display:flex;gap:14px;align-items:flex-start;font-size:13.5px;color:#1e40af;line-height:1.55}
.jadwal-note svg{flex:0 0 auto;margin-top:2px}

@media(min-width:640px){
  .jadwal-item{flex-direction:row;align-items:center;justify-content:space-between;gap:18px}
}
@media(max-width:640px){
  .cta{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">Kalender Sertifikasi · {{ $bulan->sum(fn ($items) => $items->count()) }} Jadwal</div>
    <h1>Jadwal <em>Sertifikasi</em> Kompetensi</h1>
    <p class="lead">Kalender pelaksanaan uji kompetensi LSP Edukasi Global Cendekia. Pilih skema yang sesuai, lalu daftar melalui tim kami untuk informasi persyaratan dan biaya.</p>
  </div>
</div>

<section style="padding:60px 0 96px;background:var(--cream,#fbf9f3)">
  <div class="wrap">

    @if($bulan->isEmpty())
      <div class="jadwal-empty">Belum ada jadwal sertifikasi yang dipublikasikan. Silakan cek kembali nanti atau hubungi tim kami via WhatsApp.</div>
    @else
      @php $bidangLabels = \App\Support\Skemas::bidangs(); @endphp
      @foreach($bulan as $label => $items)
      <div class="jadwal-group">
        <div class="jadwal-group-head">
          <h2>{{ $label }}</h2>
          <span class="cnt">{{ $items->count() }} jadwal</span>
        </div>
        <div class="jadwal-list">
          @foreach($items as $item)
          @php
            $lewat = $item->tanggal_sertifikasi->lt(now()->startOfDay());
            $tautSkema = ! $lewat && $item->skema_slug;
          @endphp
          <div @class(['jadwal-item', 'past' => $lewat, 'linked' => $tautSkema])>
            <div class="jadwal-item-info">
              <p class="jadwal-item-meta">
                {{ $item->tanggal_sertifikasi->translatedFormat('d M Y') }}
                <span class="jadwal-bidang">{{ $bidangLabels[$item->bidang]['label'] ?? $item->bidang }}</span>
              </p>
              @if($tautSkema)
                <a class="jadwal-item-skema" href="{{ route('skema.show', $item->skema_slug) }}">{{ $item->skema }}</a>
              @else
                <span class="jadwal-item-skema">{{ $item->skema }}</span>
              @endif
            </div>
            <div class="jadwal-item-action">
              @if($lewat)
                <span class="jadwal-status-done">Selesai</span>
              @else
                <a class="jadwal-btn" href="https://wa.me/{{ config('site.whatsapp') }}?text={{ urlencode('Halo, saya ingin mendaftar sertifikasi ' . $item->skema . ' pada jadwal ' . $item->tanggal_sertifikasi->translatedFormat('d M Y') . '.') }}" target="_blank" rel="noopener">Daftar</a>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endforeach

      <div class="jadwal-note">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 8h.01M11 12h1v4h1"/></svg>
        <div>
          <strong style="color:#1e3a8a;font-weight:700">Catatan:</strong>
          Klik nama skema untuk melihat detail unit kompetensi &amp; persyaratan pemohon. Jadwal dapat berubah sewaktu-waktu —
          konfirmasikan ke tim LSP Edukia via WhatsApp di +62 851-7547-9385 sebelum mendaftar.
        </div>
      </div>
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
