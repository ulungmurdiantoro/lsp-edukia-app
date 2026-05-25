@extends('layouts.app')
@section('title', 'Daftar Penerima Sertifikat — LSP Edukia')

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-sertifikat.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue);letter-spacing:-0.02em}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}

.stat-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:32px}
.stat-card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:20px 22px;position:relative;overflow:hidden}
.stat-card::before{content:"";position:absolute;left:0;top:14px;bottom:14px;width:3px}
.stat-card.navy::before{background:var(--navy-800)}
.stat-card.green::before{background:var(--green-ok)}
.stat-card.orange::before{background:var(--orange)}
.stat-card.red::before{background:#dc2626}
.stat-val{font-size:36px;font-weight:800;color:var(--ink);letter-spacing:-0.025em;line-height:1}
.stat-label{font-size:13px;color:var(--muted);margin-top:8px}

.cert-card{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden}
.cert-search-wrap{padding:24px 24px 0}
.search-bar{display:flex;align-items:center;gap:12px;background:var(--cream);border:1px solid var(--line-2);border-radius:12px;padding:4px 4px 4px 16px}
.search-bar input{flex:1;height:44px;border:0;outline:0;background:transparent;font-size:15px;color:var(--ink);font-family:inherit}
.search-bar .search-ico{color:var(--muted);display:flex}
.search-btn{height:40px;padding:0 22px;border-radius:999px;border:0;background:var(--navy-800);color:#fff;font-weight:700;font-size:13.5px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;font-family:inherit}

.filter-bar{display:flex;flex-wrap:wrap;gap:8px;padding:18px 0 4px;align-items:center;border-bottom:1px solid var(--line)}
.filter-label{font-size:11px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:var(--muted);margin-right:8px}
.f-chip{height:32px;padding:0 12px;border-radius:999px;border:1px solid var(--line-2);background:#fff;color:var(--ink-2);font-size:12.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;font-family:inherit;transition:background .12s,color .12s,border-color .12s}
.f-chip.active,.f-chip:hover{border-color:var(--navy-800);background:var(--navy-800);color:#fff}
.f-chip .cnt{font-size:11px;opacity:.65}

.cert-table-head{display:grid;grid-template-columns:52px 2fr 2.4fr 1.4fr 1fr 120px;padding:14px 24px;border-bottom:1px solid var(--line);font-size:10.5px;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;color:var(--muted);font-family:ui-monospace,monospace}
.cert-row{display:grid;grid-template-columns:52px 2fr 2.4fr 1.4fr 1fr 120px;padding:16px 24px;border-bottom:1px solid var(--line);align-items:center;font-size:13.5px;color:var(--ink-2);transition:background .12s}
.cert-row:last-child{border-bottom:0}
.cert-row:hover{background:var(--cream)}
.cert-row-num{font-size:12px;font-weight:700;color:var(--muted);font-family:ui-monospace,monospace}
.cert-name{font-size:14.5px;font-weight:700;color:var(--ink);line-height:1.3}
.cert-no{font-size:12.5px;color:var(--navy-800);font-family:ui-monospace,monospace;font-weight:600}
.cat-chip{display:inline-flex;align-items:center;gap:5px;font-size:10.5px;font-weight:700;padding:3px 8px;border-radius:5px;margin-top:4px;letter-spacing:0.02em}
.status-pill{display:inline-flex;align-items:center;gap:6px;padding:5px 11px;border-radius:999px;font-size:11.5px;font-weight:700}
.status-dot{width:6px;height:6px;border-radius:50%}

.cert-empty{padding:60px 24px;text-align:center;color:var(--muted);font-size:14px}
.cert-loading{padding:40px 24px;text-align:center;color:var(--muted)}

.cert-footer{padding:16px 24px;display:flex;justify-content:space-between;align-items:center;background:var(--paper-off,#fbf9f3);border-top:1px solid var(--line);flex-wrap:wrap;gap:12px}
.cert-footer-info{font-size:13px;color:var(--muted)}
.cert-footer-info strong{color:var(--ink);font-weight:700}
.cert-pages{display:flex;gap:6px;align-items:center}
.page-btn{height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1px solid var(--line-2);background:#fff;font-size:13px;font-weight:600;color:var(--ink-2);cursor:pointer;font-family:inherit;transition:all .12s}
.page-btn:hover:not(:disabled){border-color:var(--navy-800);color:var(--navy-800)}
.page-btn.active{background:var(--navy-800);color:#fff;border-color:var(--navy-800)}
.page-btn:disabled{opacity:.4;cursor:not-allowed}

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
    <h1>Daftar Penerima <em>Sertifikat</em></h1>
    <p class="lead">Pemegang sertifikat kompetensi yang diterbitkan LSP Edukasi Global Cendekia. Gunakan pencarian untuk verifikasi sertifikat berdasarkan nama, nomor, atau skema.</p>
  </div>
</div>

<section style="padding:60px 0 96px;background:var(--cream,#fbf9f3)">
  <div class="wrap">

    <div class="stat-strip">
      <div class="stat-card navy"><div class="stat-val">{{ $stats['total'] }}</div><div class="stat-label">Total sertifikat diterbitkan</div></div>
      <div class="stat-card green"><div class="stat-val">{{ $stats['aktif'] }}</div><div class="stat-label">Sertifikat aktif</div></div>
      <div class="stat-card orange"><div class="stat-val">{{ $stats['expiring'] }}</div><div class="stat-label">Akan kadaluarsa (&le;90 hari)</div></div>
      <div class="stat-card red"><div class="stat-val">{{ $stats['kadaluarsa'] }}</div><div class="stat-label">Sertifikat kadaluarsa</div></div>
    </div>

    <div class="cert-card">
      <div class="cert-search-wrap">
        <div class="search-bar">
          <span class="search-ico">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
          </span>
          <input type="text" id="certSearch" placeholder="Cari nama, nomor sertifikat, atau skema…" autocomplete="off">
          <button class="search-btn" id="searchBtn">Cari</button>
        </div>

        @php
        $catDef = [
          'all'       => ['label' => 'Semua',            'count' => $stats['total']],
          'spmi'      => ['label' => 'SPMI',             'count' => $catCounts['spmi'] ?? 0],
          'pt'        => ['label' => 'Perguruan Tinggi', 'count' => $catCounts['pt'] ?? 0],
          'lab17025'  => ['label' => 'Lab ISO 17025',    'count' => $catCounts['lab17025'] ?? 0],
          'labtest'   => ['label' => 'Lab & Pengujian',  'count' => $catCounts['labtest'] ?? 0],
          'lifting'   => ['label' => 'Lifting',          'count' => $catCounts['lifting'] ?? 0],
          'manajemen' => ['label' => 'Sistem Manajemen', 'count' => $catCounts['manajemen'] ?? 0],
          'hukum'     => ['label' => 'Hukum',            'count' => $catCounts['hukum'] ?? 0],
        ];
        @endphp
        <div class="filter-bar">
          <span class="filter-label">Bidang</span>
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

      <div>
        <div class="cert-table-head">
          <div>#</div><div>Nama Lengkap</div><div>Skema Sertifikasi</div>
          <div>Nomor Sertifikat</div><div>Kadaluarsa</div><div style="text-align:center">Status</div>
        </div>
        <div id="certTableBody">
          <div class="cert-loading">Memuat data…</div>
        </div>
      </div>

      <div class="cert-footer">
        <span class="cert-footer-info" id="certInfo">—</span>
        <div class="cert-pages" id="certPages"></div>
      </div>
    </div>

    <div class="cert-disclaimer">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
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
  const SEARCH_URL = '{{ route('sertifikat.search') }}';
  const catMeta = {
    spmi:      { label: 'SPMI ISO 21001',      color: '#1a4a8a', bg: '#e0ebff' },
    pt:        { label: 'Perguruan Tinggi',    color: '#102d57', bg: '#eef3fb' },
    lab17025:  { label: 'Lab ISO 17025',       color: '#1a5c35', bg: '#e3f5ea' },
    labtest:   { label: 'Lab & Pengujian',     color: '#1a5c35', bg: '#e3f5ea' },
    lifting:   { label: 'Lifting Engineering', color: '#d77110', bg: '#fdf0e1' },
    manajemen: { label: 'Sistem Manajemen',    color: '#922b2b', bg: '#fde8e8' },
    hukum:     { label: 'Hukum Korporasi',     color: '#5a3aa6', bg: '#f0ecfa' },
  };
  const statusMeta = {
    aktif:      { label: 'Aktif',          dot: '#16a34a', textColor: '#15803d', bg: '#dcfce7' },
    expiring:   { label: 'Akan kadaluarsa', dot: '#d97706', textColor: '#92400e', bg: '#fef3c7' },
    kadaluarsa: { label: 'Kadaluarsa',     dot: '#dc2626', textColor: '#991b1b', bg: '#fee2e2' },
  };

  let activeCat = 'all', activeStatus = 'all', currentPage = 1, debounceTimer;

  const bodyEl   = document.getElementById('certTableBody');
  const infoEl   = document.getElementById('certInfo');
  const pagesEl  = document.getElementById('certPages');
  const searchEl = document.getElementById('certSearch');

  function fetchData(page = 1) {
    currentPage = page;
    const params = new URLSearchParams({ page });
    const q = searchEl.value.trim();
    if (q)                        params.set('q', q);
    if (activeCat !== 'all')      params.set('kategori', activeCat);
    if (activeStatus !== 'all')   params.set('status', activeStatus);

    bodyEl.innerHTML = '<div class="cert-loading">Memuat data…</div>';

    fetch(SEARCH_URL + '?' + params)
      .then(r => r.json())
      .then(render)
      .catch(() => {
        bodyEl.innerHTML = '<div class="cert-empty">Gagal memuat data. Coba muat ulang halaman.</div>';
      });
  }

  function render(res) {
    if (!res.data.length) {
      bodyEl.innerHTML = '<div class="cert-empty">Tidak ditemukan sertifikat yang cocok. Coba kata kunci atau filter lain.</div>';
      infoEl.innerHTML = 'Tidak ada hasil';
      pagesEl.innerHTML = '';
      return;
    }

    const offset = (res.current_page - 1) * res.per_page;
    bodyEl.innerHTML = res.data.map((c, i) => {
      const cat  = catMeta[c.kategori] || catMeta.spmi;
      const stat = statusMeta[c.status] || statusMeta.aktif;
      const num  = String(offset + i + 1).padStart(2, '0');
      return `
        <div class="cert-row">
          <div class="cert-row-num">${num}</div>
          <div>
            <div class="cert-name">${esc(c.nama)}${c.gelar ? '<br><span style="font-size:12px;font-weight:500;color:var(--muted)">' + esc(c.gelar) + '</span>' : ''}</div>
          </div>
          <div>
            <div style="font-size:13.5px;color:var(--ink-2);line-height:1.4;margin-bottom:4px">${esc(c.skema)}</div>
            <span class="cat-chip" style="background:${cat.bg};color:${cat.color}">
              <span style="width:5px;height:5px;border-radius:50%;background:${cat.color};flex:0 0 auto"></span>
              ${cat.label}
            </span>
          </div>
          <div class="cert-no">${esc(c.nomor_sertifikat)}</div>
          <div style="font-size:13px;color:${stat.dot};font-weight:600">${c.tanggal_kadaluarsa || '—'}</div>
          <div style="text-align:center">
            <span class="status-pill" style="background:${stat.bg};color:${stat.textColor}">
              <span class="status-dot" style="background:${stat.dot}"></span>
              ${stat.label}
            </span>
          </div>
        </div>`;
    }).join('');

    infoEl.innerHTML = `Menampilkan <strong>${res.from}–${res.to}</strong> dari <strong>${res.total}</strong> sertifikat`;
    renderPages(res);
  }

  function renderPages(res) {
    if (res.last_page <= 1) { pagesEl.innerHTML = ''; return; }
    let html = `<button class="page-btn" ${res.current_page === 1 ? 'disabled' : ''} data-page="${res.current_page - 1}">‹</button>`;
    for (let p = 1; p <= res.last_page; p++) {
      if (p === 1 || p === res.last_page || Math.abs(p - res.current_page) <= 1) {
        html += `<button class="page-btn ${p === res.current_page ? 'active' : ''}" data-page="${p}">${p}</button>`;
      } else if (Math.abs(p - res.current_page) === 2) {
        html += `<span style="color:var(--muted);padding:0 4px">…</span>`;
      }
    }
    html += `<button class="page-btn" ${res.current_page === res.last_page ? 'disabled' : ''} data-page="${res.current_page + 1}">›</button>`;
    pagesEl.innerHTML = html;
    pagesEl.querySelectorAll('[data-page]').forEach(btn =>
      btn.addEventListener('click', () => fetchData(+btn.dataset.page))
    );
  }

  function esc(str) {
    return (str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

  document.querySelectorAll('.f-chip[data-cat]').forEach(c => c.addEventListener('click', () => {
    document.querySelectorAll('.f-chip[data-cat]').forEach(x => x.classList.remove('active'));
    c.classList.add('active'); activeCat = c.dataset.cat; fetchData(1);
  }));
  document.querySelectorAll('.f-chip[data-status]').forEach(c => c.addEventListener('click', () => {
    document.querySelectorAll('.f-chip[data-status]').forEach(x => x.classList.remove('active'));
    c.classList.add('active'); activeStatus = c.dataset.status; fetchData(1);
  }));
  searchEl.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => fetchData(1), 350);
  });
  document.getElementById('searchBtn').addEventListener('click', () => fetchData(1));

  fetchData(1);
})();
</script>
@endsection
