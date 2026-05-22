@extends('layouts.app')
@section('title', 'Daftar Penerima Sertifikat — LSP Edukia')

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-sertifikat.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}

/* Stat strip */
.stat-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:32px}
.stat-card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:20px 22px;position:relative;overflow:hidden}
.stat-card::before{content:"";position:absolute;left:0;top:14px;bottom:14px;width:3px}
.stat-card.navy::before{background:var(--navy-800)}
.stat-card.green::before{background:var(--green-ok)}
.stat-card.orange::before{background:var(--orange)}
.stat-card.red::before{background:#dc2626}
.stat-val{font-size:36px;font-weight:800;color:var(--ink);letter-spacing:-0.025em;line-height:1}
.stat-label{font-size:13px;color:var(--muted);margin-top:8px}

/* Search + table card */
.cert-card{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden}
.cert-search-wrap{padding:24px 24px 0}
.search-bar{display:flex;align-items:center;gap:12px;background:var(--cream);border:1px solid var(--line-2);border-radius:12px;padding:4px 4px 4px 16px}
.search-bar input{flex:1;height:44px;border:0;outline:0;background:transparent;font-size:15px;color:var(--ink);font-family:inherit}
.search-bar .search-ico{color:var(--muted);display:flex}
.search-btn{height:40px;padding:0 22px;border-radius:999px;border:0;background:var(--navy-800);color:#fff;font-weight:700;font-size:13.5px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;font-family:inherit}

/* Filter bar */
.filter-bar{display:flex;flex-wrap:wrap;gap:8px;padding:18px 0 4px;align-items:center;border-bottom:1px solid var(--line)}
.filter-label{font-size:11px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:var(--muted);margin-right:8px}
.f-chip{height:32px;padding:0 12px;border-radius:999px;border:1px solid var(--line-2);background:#fff;color:var(--ink-2);font-size:12.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;font-family:inherit;transition:background .12s,color .12s,border-color .12s}
.f-chip.active,.f-chip:hover{border-color:var(--navy-800);background:var(--navy-800);color:#fff}
.f-chip .cnt{font-size:11px;opacity:.65}

/* Table */
.cert-table-head{display:grid;grid-template-columns:52px 2fr 2.4fr 1.4fr 1fr 120px;padding:14px 24px;border-bottom:1px solid var(--line);font-size:10.5px;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;color:var(--muted);font-family:ui-monospace,monospace}
.cert-row{display:grid;grid-template-columns:52px 2fr 2.4fr 1.4fr 1fr 120px;padding:16px 24px;border-bottom:1px solid var(--line);align-items:center;font-size:13.5px;color:var(--ink-2);transition:background .12s}
.cert-row:last-child{border-bottom:0}
.cert-row:hover{background:var(--cream)}
.cert-row-num{font-size:12px;font-weight:700;color:var(--muted);font-family:ui-monospace,monospace}
.cert-name{font-size:14.5px;font-weight:700;color:var(--ink);line-height:1.3}
.cert-no{font-size:12.5px;color:var(--navy-800);font-family:ui-monospace,monospace;font-weight:600}
.cat-chip{display:inline-flex;align-items:center;gap:5px;font-size:10.5px;font-weight:700;padding:3px 8px;border-radius:5px;margin-top:4px;letter-spacing:0.02em}
.status-pill{display:inline-flex;align-items:center;gap:6px;padding:5px 11px;border-radius:999px;font-size:11.5px;font-weight:700}
.status-pill.aktif{background:#dcfce7;color:#15803d}
.status-pill.expiring{background:#fef3c7;color:#92400e}
.status-pill.kadaluarsa{background:#fee2e2;color:#991b1b}
.status-dot{width:6px;height:6px;border-radius:50%}

/* Empty state */
.cert-empty{padding:60px 24px;text-align:center;color:var(--muted);font-size:14px}

/* Pagination footer */
.cert-footer{padding:20px 24px;display:flex;justify-content:space-between;align-items:center;background:var(--paper-off,#fbf9f3);border-top:1px solid var(--line)}
.cert-footer-info{font-size:13px;color:var(--muted)}
.cert-footer-info strong{color:var(--ink);font-weight:700}

/* Disclaimer */
.cert-disclaimer{margin-top:28px;padding:18px 22px;background:var(--blue-50);border:1px solid #bfdbfe;border-radius:12px;display:flex;gap:14px;align-items:flex-start;font-size:13.5px;color:#1e40af;line-height:1.55}
.cert-disclaimer svg{flex:0 0 auto;margin-top:2px}

@media(max-width:960px){
  .stat-strip{grid-template-columns:1fr 1fr}
  .cert-table-head,.cert-row{grid-template-columns:40px 1fr 1fr;font-size:12px}
  .cert-table-head div:nth-child(n+4),.cert-row>div:nth-child(n+4){display:none}
  .cta{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">Transparansi &amp; Akuntabilitas · {{ $stats['total'] }} Penerima</div>
    <h1>Daftar Penerima Sertifikat</h1>
    <p class="lead">Pemegang sertifikat kompetensi yang diterbitkan LSP Edukasi Global Cendekia. Gunakan pencarian untuk verifikasi sertifikat berdasarkan nama, nomor, atau skema.</p>
  </div>
</div>

<section style="padding:60px 0 96px;background:var(--cream,#fbf9f3)">
  <div class="wrap">

    {{-- Stat strip --}}
    <div class="stat-strip">
      <div class="stat-card navy">
        <div class="stat-val">{{ $stats['total'] }}</div>
        <div class="stat-label">Total sertifikat diterbitkan</div>
      </div>
      <div class="stat-card green">
        <div class="stat-val">{{ $stats['aktif'] }}</div>
        <div class="stat-label">Sertifikat aktif</div>
      </div>
      <div class="stat-card orange">
        <div class="stat-val">{{ $stats['expiring'] }}</div>
        <div class="stat-label">Akan kadaluarsa (&le;90 hari)</div>
      </div>
      <div class="stat-card red">
        <div class="stat-val">{{ $stats['kadaluarsa'] }}</div>
        <div class="stat-label">Sertifikat kadaluarsa</div>
      </div>
    </div>

    {{-- Search + filter + table --}}
    <div class="cert-card">
      <div class="cert-search-wrap">
        {{-- Search bar --}}
        <div class="search-bar">
          <span class="search-ico">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/>
            </svg>
          </span>
          <input type="text" id="certSearch" placeholder="Cari nama, nomor sertifikat, atau skema sertifikasi…" autocomplete="off">
          <button class="search-btn">Cari</button>
        </div>

        {{-- Filter chips --}}
        <div class="filter-bar">
          <span class="filter-label">Filter bidang</span>
          @php
          $catDef = [
            'all'       => ['label'=>'Semua',            'count'=>$sertifikats->count()],
            'spmi'      => ['label'=>'SPMI',             'count'=>$sertifikats->where('kategori','spmi')->count()],
            'pt'        => ['label'=>'Perguruan Tinggi', 'count'=>$sertifikats->where('kategori','pt')->count()],
            'lab17025'  => ['label'=>'Lab ISO 17025',    'count'=>$sertifikats->where('kategori','lab17025')->count()],
            'labtest'   => ['label'=>'Lab & Pengujian',  'count'=>$sertifikats->where('kategori','labtest')->count()],
            'lifting'   => ['label'=>'Lifting',          'count'=>$sertifikats->where('kategori','lifting')->count()],
            'manajemen' => ['label'=>'Sistem Manajemen', 'count'=>$sertifikats->where('kategori','manajemen')->count()],
            'hukum'     => ['label'=>'Hukum',            'count'=>$sertifikats->where('kategori','hukum')->count()],
          ];
          @endphp
          @foreach($catDef as $id => $c)
          <button class="f-chip {{ $id === 'all' ? 'active' : '' }}" data-cat="{{ $id }}">
            {{ $c['label'] }} <span class="cnt">{{ $c['count'] }}</span>
          </button>
          @endforeach
          <span style="flex:1"></span>
          <span class="filter-label" style="margin-right:4px">Status</span>
          <button class="f-chip active" data-status="all">Semua</button>
          <button class="f-chip" data-status="aktif">Aktif</button>
          <button class="f-chip" data-status="expiring">Akan kadaluarsa</button>
          <button class="f-chip" data-status="kadaluarsa">Kadaluarsa</button>
        </div>
      </div>

      {{-- Table --}}
      <div>
        <div class="cert-table-head">
          <div>#</div>
          <div>Nama Lengkap</div>
          <div>Skema Sertifikasi</div>
          <div>Nomor Sertifikat</div>
          <div>Kadaluarsa</div>
          <div style="text-align:center">Status</div>
        </div>

        @php
        $catMeta = [
          'spmi'      => ['label'=>'SPMI ISO 21001',      'color'=>'#1a4a8a','bg'=>'#e0ebff'],
          'pt'        => ['label'=>'Perguruan Tinggi',    'color'=>'#102d57','bg'=>'#eef3fb'],
          'lab17025'  => ['label'=>'Lab ISO 17025',       'color'=>'#1a5c35','bg'=>'#e3f5ea'],
          'labtest'   => ['label'=>'Lab & Pengujian',     'color'=>'#1a5c35','bg'=>'#e3f5ea'],
          'lifting'   => ['label'=>'Lifting Engineering', 'color'=>'#d77110','bg'=>'#fdf0e1'],
          'manajemen' => ['label'=>'Sistem Manajemen',    'color'=>'#922b2b','bg'=>'#fde8e8'],
          'hukum'     => ['label'=>'Hukum Korporasi',     'color'=>'#5a3aa6','bg'=>'#f0ecfa'],
        ];
        @endphp

        @forelse($sertifikats as $idx => $cert)
        @php $cat = $catMeta[$cert->kategori] ?? $catMeta['spmi']; @endphp
        <div class="cert-row"
             data-cat="{{ $cert->kategori }}"
             data-status="{{ $cert->status }}"
             data-search="{{ strtolower($cert->nama . ' ' . $cert->skema . ' ' . $cert->nomor_sertifikat) }}">
          <div class="cert-row-num">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</div>
          <div>
            <div class="cert-name">{{ $cert->nama }}</div>
          </div>
          <div>
            <div style="font-size:13.5px;color:var(--ink-2);line-height:1.4;margin-bottom:4px">{{ $cert->skema }}</div>
            <span class="cat-chip" style="background:{{ $cat['bg'] }};color:{{ $cat['color'] }}">
              <span style="width:5px;height:5px;border-radius:50%;background:{{ $cat['color'] }};flex:0 0 auto"></span>
              {{ $cat['label'] }}
            </span>
          </div>
          <div class="cert-no">{{ $cert->nomor_sertifikat }}</div>
          @php
            $kdColor = match($cert->status) {
              'kadaluarsa' => '#dc2626',
              'expiring'   => '#d97706',
              default      => '#16a34a',
            };
          @endphp
          <div style="font-size:13px;color:{{ $kdColor }};font-weight:600">
            {{ $cert->tanggal_kadaluarsa ? $cert->tanggal_kadaluarsa->translatedFormat('d M Y') : '—' }}
          </div>
          <div style="text-align:center">
            @php
              $dotColor = match($cert->status) {
                'kadaluarsa' => '#dc2626',
                'expiring'   => '#d97706',
                default      => '#16a34a',
              };
              $label = match($cert->status) {
                'kadaluarsa' => 'Kadaluarsa',
                'expiring'   => 'Akan kadaluarsa',
                default      => 'Aktif',
              };
            @endphp
            <span class="status-pill {{ $cert->status }}">
              <span class="status-dot" style="background:{{ $dotColor }}"></span>
              {{ $label }}
            </span>
          </div>
        </div>
        @empty
        <div class="cert-empty">
          Belum ada data penerima sertifikat. Tambahkan melalui
          <a href="/admin/sertifikats" style="color:var(--blue)">panel admin</a>.
        </div>
        @endforelse

        <div class="cert-empty" id="certNoResult" style="display:none">
          Tidak ditemukan sertifikat yang cocok. Coba kata kunci atau filter lain.
        </div>
      </div>

      {{-- Footer --}}
      <div class="cert-footer">
        <span class="cert-footer-info">
          Menampilkan <strong id="certCount">{{ $sertifikats->count() }}</strong>
          dari <strong>{{ $sertifikats->count() }}</strong> sertifikat
        </span>
      </div>
    </div>

    {{-- Disclaimer --}}
    <div class="cert-disclaimer">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
      <div>
        <strong style="color:#1e3a8a;font-weight:700">Verifikasi sertifikat:</strong>
        Untuk memvalidasi keaslian sertifikat, masukkan nomor sertifikat pada kolom pencarian
        atau hubungi tim LSP Edukia via WhatsApp di +62 851-7547-9385. Data dimutakhirkan setiap bulan.
      </div>
    </div>

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

@section('scripts')
<script>
(function () {
  const rows      = Array.from(document.querySelectorAll('.cert-row'));
  const noResult  = document.getElementById('certNoResult');
  const countEl   = document.getElementById('certCount');
  const searchEl  = document.getElementById('certSearch');
  const catChips  = document.querySelectorAll('.f-chip[data-cat]');
  const statChips = document.querySelectorAll('.f-chip[data-status]');

  let activeCat    = 'all';
  let activeStatus = 'all';
  let query        = '';

  function apply() {
    let visible = 0;
    rows.forEach((row, i) => {
      const catOk    = activeCat    === 'all' || row.dataset.cat    === activeCat;
      const statusOk = activeStatus === 'all' || row.dataset.status === activeStatus;
      const searchOk = !query       || row.dataset.search.includes(query);
      const show = catOk && statusOk && searchOk;
      row.style.display = show ? '' : 'none';
      if (show) {
        visible++;
        row.querySelector('.cert-row-num').textContent = String(visible).padStart(2, '0');
      }
    });
    countEl.textContent = visible;
    noResult.style.display = (visible === 0 && rows.length > 0) ? '' : 'none';
  }

  catChips.forEach(c => c.addEventListener('click', () => {
    catChips.forEach(x => x.classList.remove('active'));
    c.classList.add('active');
    activeCat = c.dataset.cat;
    apply();
  }));

  statChips.forEach(c => c.addEventListener('click', () => {
    statChips.forEach(x => x.classList.remove('active'));
    c.classList.add('active');
    activeStatus = c.dataset.status;
    apply();
  }));

  searchEl.addEventListener('input', () => {
    query = searchEl.value.toLowerCase().trim();
    apply();
  });

  document.querySelector('.search-btn').addEventListener('click', () => {
    query = searchEl.value.toLowerCase().trim();
    apply();
  });
})();
</script>
@endsection
