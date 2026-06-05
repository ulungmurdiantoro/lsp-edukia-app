@extends('layouts.app')
{{-- Meta dikelola via $SEOData dari PageController@skema (ralphjsmit/laravel-seo). --}}
{{-- Data skema dari App\Support\Skemas — tiap skema punya halaman detail terindeks sendiri. --}}
@push('head')
<link rel="preload" as="image" href="{{ asset('images/hero-skema.jpg') }}" fetchpriority="high">
@endpush

@section('extra-css')
<style>
/* Page hero */
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-skema.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue)}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}

/* Filter chips */
.filter-section{padding:40px 0 0;border-top:1px solid var(--line);background:var(--cream)}
.chips{display:flex;flex-wrap:wrap;gap:10px;margin:0 0 36px}
.chip{height:38px;padding:0 16px;border-radius:999px;border:1px solid var(--line-2);background:#fff;font-size:14px;font-weight:500;color:var(--ink-2);display:inline-flex;align-items:center;gap:8px;transition:all .15s;cursor:pointer}
.chip:hover{border-color:var(--navy-500);color:var(--navy-800)}
.chip.active{background:var(--navy-800);color:#fff;border-color:var(--navy-800)}
.chip .count{font-size:12px;color:var(--muted);font-weight:600}
.chip.active .count{color:rgba(255,255,255,.7)}

/* Category */
.cat-title{font-size:17px;font-weight:700;color:var(--ink);margin:0 0 20px;display:flex;align-items:center;gap:12px}
.cat-title::before{content:"";width:4px;height:20px;background:var(--orange);border-radius:2px;flex:0 0 auto}
.cat-title .hub-link{margin-left:auto;font-size:13px;font-weight:600;color:var(--blue-deep);display:inline-flex;align-items:center;gap:5px}
.cat-title .hub-link:hover{color:var(--orange-deep)}
.cat-group{margin-bottom:48px}
.cat-group.hidden{display:none}

/* Scheme grid */
.schemes{display:grid;grid-template-columns:repeat(auto-fill,minmax(420px,1fr));gap:16px}

/* Scheme card */
.scheme{display:block;background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;transition:all .18s}
.scheme:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 10px 28px rgba(15,29,53,.07)}
.scheme-header{padding:16px 20px;background:linear-gradient(135deg,var(--navy-800),var(--navy-700))}
.scheme-top{display:flex;align-items:flex-start;gap:12px;margin-bottom:6px}
.scheme-badge{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);color:#fff;width:38px;height:38px;border-radius:10px;display:grid;place-items:center;flex:0 0 auto}
.scheme-name{color:#fff;font-weight:700;font-size:14.5px;line-height:1.35}
.scheme-type{font-size:11.5px;color:rgba(255,255,255,.5);margin-top:4px;line-height:1.4}
.scheme-type strong{color:rgba(255,255,255,.75);font-weight:500}
.tag{display:inline-flex;align-items:center;font-size:11px;font-weight:700;padding:4px 9px;border-radius:5px;letter-spacing:0.02em;margin-top:4px}
.scheme[data-cat="spmi"] .tag{background:#e0ebff;color:#1a4a8a}
.scheme[data-cat="pt"] .tag{background:var(--navy-50);color:var(--navy-600)}
.scheme[data-cat="lab17025"] .tag{background:#e3f5ea;color:#1a5c35}
.scheme[data-cat="lifting"] .tag{background:var(--orange-50);color:var(--orange-deep)}
.scheme[data-cat="labtest"] .tag{background:#e3f5ea;color:#1a5c35}
.scheme[data-cat="manajemen"] .tag{background:#fde8e8;color:#922b2b}
.scheme[data-cat="riset"] .tag{background:#f0ecfa;color:#5a3aa6}

/* Unit table */
.scheme-body{padding:18px 20px}
.unit-table{width:100%;border-collapse:collapse}
.unit-table th{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.06em;padding:0 0 8px 0;text-align:left;border-bottom:1px solid var(--line-2)}
.unit-table th:last-child{padding-left:12px}
.unit-table td{padding:7px 0;font-size:13px;vertical-align:top;border-bottom:1px solid var(--cream-2)}
.unit-table tr:last-child td{border-bottom:none}
.unit-code{color:var(--blue-deep);font-family:ui-monospace,monospace;font-size:11.5px;white-space:nowrap;padding-right:12px;font-weight:600;min-width:140px}
.unit-title{color:var(--ink-2);line-height:1.5}
.scheme-more{margin-top:14px;padding-top:12px;border-top:1px solid var(--line-2);text-align:right;font-size:13px;font-weight:700;color:var(--blue-deep)}
.scheme:hover .scheme-more{color:var(--orange-deep)}

.main-content{padding:40px 0 96px}

/* CTA */
.cta{background:linear-gradient(135deg,var(--navy-800),var(--navy-700) 70%,var(--navy-900));border-radius:24px;padding:42px;color:#fff;display:grid;grid-template-columns:1fr auto auto;gap:18px;align-items:center;position:relative;overflow:hidden}
.cta::before{content:"";position:absolute;right:-80px;top:-80px;width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(244,137,31,.3),transparent 70%);pointer-events:none}
.cta::after{content:"";position:absolute;left:-80px;bottom:-80px;width:240px;height:240px;border-radius:50%;background:radial-gradient(circle,rgba(68,159,229,.28),transparent 70%);pointer-events:none}
.cta-body{position:relative;z-index:1}
.cta h3{color:#fff;font-size:26px;letter-spacing:-0.02em;margin-bottom:6px}
.cta p{color:rgba(255,255,255,.72);font-size:15px}
.cta .btn{position:relative;z-index:1}
.cta .wa{display:inline-flex;align-items:center;gap:10px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);height:52px;padding:0 22px;border-radius:999px;font-weight:600;position:relative;z-index:1;color:#fff;text-decoration:none}
.cta .wa:hover{background:rgba(255,255,255,.14)}

@media(max-width:960px){.schemes{grid-template-columns:1fr}.cta{grid-template-columns:1fr}}
@media(max-width:640px){.unit-code{min-width:100px;font-size:10.5px}}

/* Popular / paling diminati highlight */
.scheme--popular{border:2px solid #f4891f;box-shadow:0 0 0 4px rgba(244,137,31,.10),0 2px 4px rgba(15,29,53,.05)}
.scheme--popular:hover{border-color:#d95f00;box-shadow:0 0 0 4px rgba(244,137,31,.20),0 12px 32px rgba(244,137,31,.15);transform:translateY(-2px)}
.scheme--popular .scheme-header{background:linear-gradient(135deg,#b84c00,#d95f00 50%,#e8750a)}
.scheme--popular .scheme-badge{background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.35)}
/* Beri ruang agar judul tidak tertutup ribbon "Paling Diminati" */
.scheme--popular .scheme-top{padding-right:140px}
@media(max-width:640px){.scheme--popular .scheme-top{padding-right:120px}}
.popular-ribbon{position:absolute;top:14px;right:-1px;background:#fff;color:#b84c00;font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;padding:4px 14px 4px 10px;border-radius:999px 0 0 999px;box-shadow:0 2px 8px rgba(0,0,0,.20);display:inline-flex;align-items:center;gap:5px;white-space:nowrap}
</style>
@endsection

@section('content')

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">DP.AK.05 Rev. 02 · 26 Skema Sertifikasi</div>
    <h1>Skema <em>Kompetensi</em></h1>
    <p class="lead">Rincian unit kompetensi lengkap pada seluruh 26 skema sertifikasi LSP Edukasi Global Cendekia — 7 kategori bidang keahlian. Klik tiap skema untuk persyaratan & detail.</p>
  </div>
</div>

<!-- FILTER -->
<div class="filter-section">
  <div class="wrap">
    <div class="chips" id="chips">
      <button class="chip active" data-filter="all">Semua <span class="count">{{ $skemas->flatten(1)->count() }}</span></button>
      @foreach($bidangs as $key => $b)
        @if(isset($skemas[$key]))
          <button class="chip" data-filter="{{ $key }}">{{ $b['label'] }} <span class="count">{{ $skemas[$key]->count() }}</span></button>
        @endif
      @endforeach
    </div>
  </div>
</div>

<div class="main-content">
  <div class="wrap">

    @foreach($bidangs as $key => $b)
      @if(isset($skemas[$key]))
        <div class="cat-group" data-cat="{{ $key }}">
          <div class="cat-title">
            {{ $b['judul'] }}
            <a href="{{ route('skema.bidang', $key) }}" class="hub-link">Lihat bidang {{ $b['label'] }} <svg class="icon"><use href="#i-arrow-r"></use></svg></a>
          </div>
          <div class="schemes">
            @foreach($skemas[$key] as $s)
              <a href="{{ route('skema.show', $s['slug']) }}" class="scheme {{ $s['popular'] ? 'scheme--popular' : '' }}" data-cat="{{ $key }}">
                <div class="scheme-header" style="position:relative;overflow:hidden;">
                  @if($s['popular'])
                  <span class="popular-ribbon">
                    <svg style="width:11px;height:11px;fill:#f4891f;" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    Paling Diminati
                  </span>
                  @endif
                  <div class="scheme-top">
                    <span class="scheme-badge">{{ $s['badge'] }}</span>
                    <div>
                      <div class="scheme-name">{{ $s['nama'] }}</div>
                      <span class="tag">{{ $s['bidang_label'] }}</span>
                    </div>
                  </div>
                  <div class="scheme-type">Jenis kemasan: <strong>{{ $s['jenis_kemasan'] }}</strong>@if($s['kode']) · {{ $s['kode'] }}@endif</div>
                </div>
                <div class="scheme-body">
                  <table class="unit-table">
                    <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
                    <tbody>
                      @foreach($s['units'] as $u)
                        <tr><td class="unit-code">{{ $u['kode'] }}</td><td class="unit-title">{{ $u['judul'] }}</td></tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="scheme-more">Lihat persyaratan & detail &rarr;</div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif
    @endforeach

    <!-- CTA -->
    <div class="cta" style="margin-top:16px">
      <div class="cta-body">
        <h3>Siap mendaftar sertifikasi?</h3>
        <p>Lihat persyaratan pemohon atau hubungi tim kami via WhatsApp.</p>
      </div>
      <a class="btn btn-primary" style="height:52px;padding:0 24px;font-size:15.5px" href="{{ route('home') }}">
        <svg class="icon"><use href="#i-doc"></use></svg>
        Persyaratan pemohon
      </a>
      <a class="wa" href="https://wa.me/{{ config('site.whatsapp') }}">
        <svg class="icon" style="color:#7ee0a3"><use href="#i-wa"></use></svg>
        +62 851-7547-9385
      </a>
    </div>

  </div>
</div>

@endsection

@section('scripts')
<script>
const chips = document.querySelectorAll('#chips .chip');
const groups = document.querySelectorAll('.cat-group');
chips.forEach(chip => {
  chip.addEventListener('click', () => {
    chips.forEach(c => c.classList.remove('active'));
    chip.classList.add('active');
    const filter = chip.dataset.filter;
    groups.forEach(group => {
      if (filter === 'all' || group.dataset.cat === filter) {
        group.classList.remove('hidden');
      } else {
        group.classList.add('hidden');
      }
    });
  });
});

// Replace letter badges with category SVG icons (same as homepage cards)
const catIcons = {
  spmi:     'M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M13 9h.01M9 13h.01M13 13h.01M9 17h6',
  pt:       'M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M13 9h.01M9 13h.01M13 13h.01M9 17h6',
  lab17025: 'M9 3v6L4 19a2 2 0 002 3h12a2 2 0 002-3l-5-10V3M9 3h6M7 14h10',
  labtest:  'M9 3v6L4 19a2 2 0 002 3h12a2 2 0 002-3l-5-10V3M9 3h6M7 14h10',
  lifting:  'M3 21h18M6 21V8M6 8h13M6 8L4 6M6 8v3l4 4M19 8v2h-3',
  manajemen:'M3 21h18M5 21V11l5 3V11l5 3V8l4-3v16',
  riset:    'M12 3v18M5 7h14M7 21h10M5 7l-3 7h6L5 7zM19 7l-3 7h6l-3-7z',
  hukum:    'M12 3v18M5 7h14M7 21h10M5 7l-3 7h6L5 7zM19 7l-3 7h6l-3-7z',
};
document.querySelectorAll('.scheme[data-cat]').forEach(scheme => {
  const path = catIcons[scheme.dataset.cat];
  if (!path) return;
  const badge = scheme.querySelector('.scheme-badge');
  if (badge) badge.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="${path}"/></svg>`;
});
</script>
@endsection
