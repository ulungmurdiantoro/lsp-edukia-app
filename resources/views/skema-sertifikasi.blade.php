@extends('layouts.app')

@section('title', 'Skema Kompetensi — LSP Edukia')

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
.cat-group{margin-bottom:48px}
.cat-group.hidden{display:none}

/* Scheme grid */
.schemes{display:grid;grid-template-columns:repeat(auto-fill,minmax(420px,1fr));gap:16px}

/* Scheme card */
.scheme{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;transition:all .18s}
.scheme:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 10px 28px rgba(15,29,53,.07)}
.scheme-header{padding:16px 20px;background:linear-gradient(135deg,var(--navy-800),var(--navy-700))}
.scheme-top{display:flex;align-items:flex-start;gap:12px;margin-bottom:6px}
.scheme-badge{background:var(--orange);color:#fff;font-size:12px;font-weight:800;width:28px;height:28px;border-radius:8px;display:grid;place-items:center;flex:0 0 auto;margin-top:2px}
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
</style>
@endsection

@section('content')

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">DP.AK.05 Rev. 02 · 26 Skema Sertifikasi</div>
    <h1>Skema <em>Kompetensi</em></h1>
    <p class="lead">Rincian unit kompetensi lengkap pada seluruh 26 skema sertifikasi LSP Edukasi Global Cendekia — 7 kategori bidang keahlian.</p>
  </div>
</div>

<!-- FILTER -->
<div class="filter-section">
  <div class="wrap">
    <div class="chips" id="chips">
      <button class="chip active" data-filter="all">Semua <span class="count">26</span></button>
      <button class="chip" data-filter="spmi">SPMI ISO 21001 <span class="count">3</span></button>
      <button class="chip" data-filter="pt">Perguruan Tinggi <span class="count">2</span></button>
      <button class="chip" data-filter="lab17025">Lab ISO 17025 <span class="count">2</span></button>
      <button class="chip" data-filter="lifting">Lifting Engineering <span class="count">4</span></button>
      <button class="chip" data-filter="labtest">Lab &amp; Pengujian <span class="count">6</span></button>
      <button class="chip" data-filter="manajemen">Sistem Manajemen <span class="count">8</span></button>
      <button class="chip" data-filter="riset">Research &amp; Innovation <span class="count">1</span></button>
    </div>
  </div>
</div>

<div class="main-content">
  <div class="wrap">

    <!-- CAT 1: SPMI -->
    <div class="cat-group" data-cat="spmi">
      <div class="cat-title">Personil Sistem Penjaminan Mutu Internal (SPMI) Terintegrasi ISO 21001:2018</div>
      <div class="schemes">

        <div class="scheme" data-cat="spmi">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">A</span>
              <div>
                <div class="scheme-name">Auditor Internal SPMI Terintegrasi ISO 21001:2018</div>
                <span class="tag">SPMI ISO 21001</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Auditor Internal SPMI terintegrasi ISO 21001:2018</strong> · EDUKIA-AIL-2024-001</div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.AIL.001.01</td><td class="unit-title">Memahami Pengetahuan Dasar Terkait Audit</td></tr>
                <tr><td class="unit-code">SP.AIL.002.01</td><td class="unit-title">Melaksanakan Kegiatan Audit Internal</td></tr>
                <tr><td class="unit-code">SP.AIL.003.01</td><td class="unit-title">Memahami Konsep Integrasi SPMI dan ISO 21001:2018</td></tr>
                <tr><td class="unit-code">SP.AIL.004.01</td><td class="unit-title">Mengevaluasi Penerapan Integrasi Siklus Plan ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.AIL.005.01</td><td class="unit-title">Mengevaluasi Penerapan Integrasi Siklus Do ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.AIL.006.01</td><td class="unit-title">Mengevaluasi Penerapan Integrasi Siklus Check ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.AIL.007.01</td><td class="unit-title">Mengevaluasi Penerapan Integrasi Siklus Act ISO 21001:2018 ke dalam SPMI</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="spmi">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">B</span>
              <div>
                <div class="scheme-name">Lead Auditor SPMI Terintegrasi ISO 21001:2018</div>
                <span class="tag">SPMI ISO 21001</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Lead Auditor SPMI terintegrasi ISO 21001:2018</strong> · EDUKIA-LAD-2024-002</div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.LAD.001.01</td><td class="unit-title">Memahami Pengetahuan Dasar Terkait Audit</td></tr>
                <tr><td class="unit-code">SP.LAD.002.01</td><td class="unit-title">Melaksanakan Kegiatan Audit Internal</td></tr>
                <tr><td class="unit-code">SP.LAD.003.01</td><td class="unit-title">Memahami Konsep Integrasi SPMI dan ISO 21001:2018</td></tr>
                <tr><td class="unit-code">SP.LAD.004.01</td><td class="unit-title">Mengevaluasi Penerapan Integrasi Siklus Plan ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.LAD.005.01</td><td class="unit-title">Mengevaluasi Penerapan Integrasi Siklus Do ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.LAD.006.01</td><td class="unit-title">Mengevaluasi Penerapan Integrasi Siklus Check ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.LAD.007.01</td><td class="unit-title">Mengevaluasi Penerapan Integrasi Siklus Act ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.LAD.008.01</td><td class="unit-title">Mengelola Program Audit Internal</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="spmi">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">C</span>
              <div>
                <div class="scheme-name">Lead Implementer SPMI Terintegrasi ISO 21001:2018</div>
                <span class="tag">SPMI ISO 21001</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Lead Implementer SPMI Terintegrasi ISO 21001:2018</strong> · EDUKIA-IMR-2024-003</div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.IMR.001.01</td><td class="unit-title">Mengelola Implementasi Standar</td></tr>
                <tr><td class="unit-code">SP.IMR.002.01</td><td class="unit-title">Memahami Konsep SPMI Terintegrasi ISO 21001:2018</td></tr>
                <tr><td class="unit-code">SP.IMR.003.01</td><td class="unit-title">Menyiapkan Kebutuhan Dokumen SPMI</td></tr>
                <tr><td class="unit-code">SP.IMR.004.01</td><td class="unit-title">Menerapkan Siklus Plan ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.IMR.005.01</td><td class="unit-title">Menerapkan Siklus Do ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.IMR.006.01</td><td class="unit-title">Menerapkan Siklus Check ISO 21001:2018 ke dalam SPMI</td></tr>
                <tr><td class="unit-code">SP.IMR.007.01</td><td class="unit-title">Menerapkan Siklus Act ISO 21001:2018 ke dalam SPMI</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <!-- CAT 2: PERGURUAN TINGGI -->
    <div class="cat-group" data-cat="pt">
      <div class="cat-title">Personil Organisasi Perguruan Tinggi</div>
      <div class="schemes">

        <div class="scheme" data-cat="pt">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">D</span>
              <div>
                <div class="scheme-name">Training of Trainer (ToT) Outcome Based Education (OBE)</div>
                <span class="tag">Perguruan Tinggi</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Training of Trainer (ToT) Outcome Based Education (OBE)</strong> · EDUKIA-ToT-2024-004</div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.ToT.001.01</td><td class="unit-title">Mendesain Program Pembelajaran Outcome Based Education (OBE)</td></tr>
                <tr><td class="unit-code">SP.ToT.002.01</td><td class="unit-title">Menyusun RPS dan Bahan Ajar Pembelajaran Outcome Based Education (OBE)</td></tr>
                <tr><td class="unit-code">SP.ToT.003.01</td><td class="unit-title">Merencanakan Pembelajaran Outcome Based Education (OBE)</td></tr>
                <tr><td class="unit-code">SP.ToT.004.01</td><td class="unit-title">Melaksanakan Pembelajaran Outcome Based Education (OBE)</td></tr>
                <tr><td class="unit-code">SP.ToT.005.01</td><td class="unit-title">Mengevaluasi Hasil Pembelajaran Outcome Based Education (OBE)</td></tr>
                <tr><td class="unit-code">SP.ToT.006.01</td><td class="unit-title">Mengembangkan Program Pembelajaran Outcome Based Education (OBE)</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="pt">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">E</span>
              <div>
                <div class="scheme-name">Implementer Tata Kelola Organisasi Perguruan Tinggi</div>
                <span class="tag">Perguruan Tinggi</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Implementer Tata Kelola Organisasi Perguruan Tinggi</strong> · EDUKIA-TKO-2024-005</div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.TKO.001.01</td><td class="unit-title">Menyusun Rencana Bisnis Organisasi Perguruan Tinggi</td></tr>
                <tr><td class="unit-code">SP.TKO.002.01</td><td class="unit-title">Merancang Design Organisasi Perguruan Tinggi (Membangun proses bisnis)</td></tr>
                <tr><td class="unit-code">SP.TKO.003.01</td><td class="unit-title">Mengelola Tata Pamong Organisasi Perguruan Tinggi</td></tr>
                <tr><td class="unit-code">SP.TKO.004.01</td><td class="unit-title">Mengembangkan Pola Kepemimpinan</td></tr>
                <tr><td class="unit-code">SP.TKO.005.01</td><td class="unit-title">Mengelola Organisasi Perguruan Tinggi</td></tr>
                <tr><td class="unit-code">SP.TKO.006.01</td><td class="unit-title">Menerapkan Etika dan Integritas Organisasi Perguruan Tinggi</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <!-- CAT 3: LAB ISO 17025 -->
    <div class="cat-group" data-cat="lab17025">
      <div class="cat-title">Personil Manajemen Laboratorium Standar ISO/IEC 17025:2017</div>
      <div class="schemes">

        <div class="scheme" data-cat="lab17025">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">F</span>
              <div>
                <div class="scheme-name">Auditor Internal Standar Laboratorium ISO/IEC 17025:2017</div>
                <span class="tag">Lab ISO 17025</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Auditor Internal Standar Laboratorium ISO/IEC 17025:2017</strong> · EDUKIA-AUI-2024-006</div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.AUI.001.01</td><td class="unit-title">Memahami Pengetahuan Dasar terkait Audit Internal</td></tr>
                <tr><td class="unit-code">SP.AUI.002.01</td><td class="unit-title">Melaksanakan Kegiatan Audit Internal</td></tr>
                <tr><td class="unit-code">SP.AUI.003.01</td><td class="unit-title">Memahami Konsep Audit Internal ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.AUI.004.01</td><td class="unit-title">Mengevaluasi Penerapan Siklus Plan ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.AUI.005.01</td><td class="unit-title">Mengevaluasi Penerapan Siklus Do ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.AUI.006.01</td><td class="unit-title">Mengevaluasi Penerapan Siklus Check ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.AUI.007.01</td><td class="unit-title">Mengevaluasi Penerapan Siklus Act ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.AUI.008.01</td><td class="unit-title">Mengelola Program Audit Internal</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="lab17025">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">G</span>
              <div>
                <div class="scheme-name">Lead Implementer Standar Laboratorium ISO/IEC 17025:2017</div>
                <span class="tag">Lab ISO 17025</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Lead Implementer Standar Laboratorium ISO/IEC 17025:2017</strong> · EDUKIA-LIM-2024-007</div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.LIM.001.01</td><td class="unit-title">Memahami Implementasi dan Interpretasi Standar ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.LIM.002.01</td><td class="unit-title">Menyiapkan Kebutuhan Dokumen ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.LIM.003.01</td><td class="unit-title">Menerapkan Manajemen Laboratorium</td></tr>
                <tr><td class="unit-code">SP.LIM.004.01</td><td class="unit-title">Menerapkan Siklus Plan ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.LIM.005.01</td><td class="unit-title">Menerapkan Siklus Do ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.LIM.006.01</td><td class="unit-title">Menerapkan Siklus Check ISO/IEC 17025:2017</td></tr>
                <tr><td class="unit-code">SP.LIM.007.01</td><td class="unit-title">Menerapkan Siklus Act ISO/IEC 17025:2017</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <!-- CAT 4: LIFTING -->
    <div class="cat-group" data-cat="lifting">
      <div class="cat-title">Industrial Engineering &amp; Lifting</div>
      <div class="schemes">

        <div class="scheme" data-cat="lifting">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">H</span>
              <div>
                <div class="scheme-name">Lifting Engineer for Medium Lifting</div>
                <span class="tag">Lifting Engineering</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Lifting Engineer for Medium Lifting</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">F.410140.001.01</td><td class="unit-title">Menerapkan Komunikasi di Tempat Kerja</td></tr>
                <tr><td class="unit-code">F.42LFE00.001.1</td><td class="unit-title">Menyusun pekerjaan persiapan perencanaan operasi pesawat angkat &amp; angkut</td></tr>
                <tr><td class="unit-code">F.42LFE00.002.1</td><td class="unit-title">Menyusun rencana operasi pengangkatan (lifting plan) untuk beban kurang dari 50 ton</td></tr>
                <tr><td class="unit-code">F.42LFE00.003.1</td><td class="unit-title">Melakukan kajian risiko dan pengendaliannya</td></tr>
                <tr><td class="unit-code">F.42LFE00.004.1</td><td class="unit-title">Mengawasi proses pengangkatan dan pemasangan beban sesuai Lifting Plan</td></tr>
                <tr><td class="unit-code">F.42LFE00.005.1</td><td class="unit-title">Melakukan evaluasi kinerja pelaksanaan Lifting Plan</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="lifting">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">I</span>
              <div>
                <div class="scheme-name">Lifting Engineer for Heavy &amp; Critical Lifting Operation</div>
                <span class="tag">Lifting Engineering</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Lifting Engineer for Light &amp; Medium Lifting</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">F.410140.001.01</td><td class="unit-title">Menerapkan Komunikasi di Tempat Kerja</td></tr>
                <tr><td class="unit-code">F.42LFE00.001.1</td><td class="unit-title">Menyusun pekerjaan persiapan perencanaan operasi pesawat angkat &amp; angkut</td></tr>
                <tr><td class="unit-code">F.42LFE00.002.1</td><td class="unit-title">Menyusun rencana operasi pengangkatan (lifting plan) untuk beban lebih dari 50 ton atau berjenis critical lifting</td></tr>
                <tr><td class="unit-code">F.42LFE00.003.1</td><td class="unit-title">Melakukan kajian risiko dan pengendaliannya</td></tr>
                <tr><td class="unit-code">F.42LFE00.004.1</td><td class="unit-title">Mengawasi proses pengangkatan dan pemasangan beban sesuai Lifting Plan</td></tr>
                <tr><td class="unit-code">F.42LFE00.005.1</td><td class="unit-title">Melakukan evaluasi kinerja pelaksanaan Lifting Plan</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="lifting">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">J</span>
              <div>
                <div class="scheme-name">2D Lifting Designer</div>
                <span class="tag">Lifting Engineering</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Lifting Drafter</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.LDT.001.01</td><td class="unit-title">Menerapkan Komunikasi di Tempat Kerja</td></tr>
                <tr><td class="unit-code">SP.LDT.002.01</td><td class="unit-title">Memahami Spesifikasi Crane &amp; Lifting Gear</td></tr>
                <tr><td class="unit-code">SP.LDT.003.01</td><td class="unit-title">Memahami Kaidah Operasi Lifting yang Aman</td></tr>
                <tr><td class="unit-code">SP.LDT.004.01</td><td class="unit-title">Memahami Lifting/Rigging Study</td></tr>
                <tr><td class="unit-code">SP.LDT.005.01</td><td class="unit-title">Mampu membuat Lifting Plan Drawing 2D</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="lifting">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">K</span>
              <div>
                <div class="scheme-name">3D Lifting Designer</div>
                <span class="tag">Lifting Engineering</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>3D Lifting Designer</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.DLD.001.01</td><td class="unit-title">Menerapkan Komunikasi di Tempat Kerja</td></tr>
                <tr><td class="unit-code">SP.DLD.002.01</td><td class="unit-title">Memahami Spesifikasi Crane &amp; Lifting Gear</td></tr>
                <tr><td class="unit-code">SP.DLD.003.01</td><td class="unit-title">Memahami Kaidah Operasi Lifting yang Aman</td></tr>
                <tr><td class="unit-code">SP.DLD.004.01</td><td class="unit-title">Memahami Lifting/Rigging Study</td></tr>
                <tr><td class="unit-code">SP.DLD.005.01</td><td class="unit-title">Mampu membuat Lifting Modelling 3D &amp; Lifting Plan Drawing</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <!-- CAT 5: LAB & PENGUJIAN -->
    <div class="cat-group" data-cat="labtest">
      <div class="cat-title">Laboratorium &amp; Pengujian / Laboratory &amp; Testing</div>
      <div class="schemes">

        <div class="scheme" data-cat="labtest">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">L</span>
              <div>
                <div class="scheme-name">Laboratory Quality System Officer ISO/IEC 17025</div>
                <span class="tag">Lab &amp; Pengujian</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Laboratory Quality System Officer ISO/IEC 17025</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.LQO.001.01</td><td class="unit-title">Memahami Prinsip Ketidakberpihakan dan Kerahasiaan (Klausul 4 ISO 17025)</td></tr>
                <tr><td class="unit-code">SP.LQO.002.01</td><td class="unit-title">Memahami Struktur Organisasi Laboratorium yang Sesuai (Klausul 5 ISO 17025)</td></tr>
                <tr><td class="unit-code">SP.LQO.003.01</td><td class="unit-title">Memahami Pengelolaan Persyaratan Sumber Daya (Klausul 6 ISO 17025)</td></tr>
                <tr><td class="unit-code">SP.LQO.004.01</td><td class="unit-title">Memahami dan Menganalisis Persyaratan Proses (Klausul 7 ISO 17025)</td></tr>
                <tr><td class="unit-code">SP.LQO.005.01</td><td class="unit-title">Memahami Pengembangan Sistem Manajemen Laboratorium (Klausul 8 ISO 17025)</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="labtest">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">M</span>
              <div>
                <div class="scheme-name">Food Safety Management Officer / Petugas Sistem Keamanan Pangan</div>
                <span class="tag">Lab &amp; Pengujian</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Food Safety Management Officer</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.FMO.001.01</td><td class="unit-title">Menguasai Prinsip Dasar dan Regulasi Keamanan Pangan</td></tr>
                <tr><td class="unit-code">SP.FMO.002.01</td><td class="unit-title">Mengimplementasikan Program Prasyarat (PRPs - Prerequisite Programs)</td></tr>
                <tr><td class="unit-code">SP.IKP.003.01</td><td class="unit-title">Mengembangkan dan Menerapkan Rencana HACCP</td></tr>
                <tr><td class="unit-code">SP.IKP.004.01</td><td class="unit-title">Mengelola Pengendalian Operasional Keamanan Pangan</td></tr>
                <tr><td class="unit-code">SP.IKP.005.01</td><td class="unit-title">Melaksanakan Verifikasi dan Peningkatan Berkelanjutan FSMS</td></tr>
                <tr><td class="unit-code">SP.IKP.006.01</td><td class="unit-title">Mengelola Komunikasi dan Pelatihan Keamanan Pangan</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="labtest">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">N</span>
              <div>
                <div class="scheme-name">Panelis Terlatih Pengujian Sensori Pangan</div>
                <span class="tag">Lab &amp; Pengujian</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Panelis Terlatih Pengujian Sensori Pangan</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.PSP.001.01</td><td class="unit-title">Menguasai Prinsip Fundamental Analisis Sensori dan Fisiologi Indrawi</td></tr>
                <tr><td class="unit-code">SP.PSP.002.01</td><td class="unit-title">Melaksanakan Prosedur Uji Pembedaan (Discrimination Testing)</td></tr>
                <tr><td class="unit-code">SP.PSP.003.01</td><td class="unit-title">Melaksanakan Prosedur Uji Deskriptif Kuantitatif (Quantitative Descriptive Analysis)</td></tr>
                <tr><td class="unit-code">SP.PSP.004.01</td><td class="unit-title">Menerapkan Praktik Laboratorium Sensori yang Baik (Good Sensory Practices)</td></tr>
                <tr><td class="unit-code">SP.PSP.005.01</td><td class="unit-title">Mengelola Kinerja dan Konsistensi Penilaian Sensori Pribadi</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="labtest">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">O</span>
              <div>
                <div class="scheme-name">GLP Laboratory Technician / Teknisi Laboratorium Berbasis GLP</div>
                <span class="tag">Lab &amp; Pengujian</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>GLP Laboratory Technician</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.GLP.001.01</td><td class="unit-title">Melakukan Persiapan Penerapan GLP</td></tr>
                <tr><td class="unit-code">SP.GLP.002.01</td><td class="unit-title">Melaksanakan Pengujian Sesuai Prinsip GLP</td></tr>
                <tr><td class="unit-code">SP.GLP.003.01</td><td class="unit-title">Melakukan Pengendalian Mutu dan Data</td></tr>
                <tr><td class="unit-code">SP.GLP.004.01</td><td class="unit-title">Mengelola Limbah dan Pasca Pengujian</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="labtest">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">P</span>
              <div>
                <div class="scheme-name">Laboratory HSE Officer / Petugas K3L Laboratorium</div>
                <span class="tag">Lab &amp; Pengujian</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Laboratory HSE Officer / Petugas K3L Laboratorium</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.K3L.001.01</td><td class="unit-title">Melakukan Identifikasi Bahaya dan Penilaian Risiko (HIRADC) di Laboratorium</td></tr>
                <tr><td class="unit-code">SP.K3L.002.01</td><td class="unit-title">Mengelola Penyimpanan dan Penanganan Bahan Kimia Berbahaya (B3)</td></tr>
                <tr><td class="unit-code">SP.K3L.003.01</td><td class="unit-title">Melakukan Pengelolaan dan Penyimpanan Limbah B3 Laboratorium</td></tr>
                <tr><td class="unit-code">SP.K3L.004.01</td><td class="unit-title">Mengelola Tindakan Tanggap Darurat di Laboratorium</td></tr>
                <tr><td class="unit-code">SP.K3L.005.01</td><td class="unit-title">Melakukan Inspeksi K3 dan Lingkungan Kerja Laboratorium</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="labtest">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">Q</span>
              <div>
                <div class="scheme-name">Laboratory Operations Officer / Pranata Laboratorium</div>
                <span class="tag">Lab &amp; Pengujian</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Laboratory Operations Officer / Pranata Laboratorium</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.LOP.001.01</td><td class="unit-title">Menetapkan Konteks Organisasi dan Perencanaan Mutu (Plan)</td></tr>
                <tr><td class="unit-code">SP.LOP.002.01</td><td class="unit-title">Mengelola Sumber Daya dan Operasional (Do)</td></tr>
                <tr><td class="unit-code">SP.LOP.003.01</td><td class="unit-title">Melakukan Evaluasi Kinerja (Check)</td></tr>
                <tr><td class="unit-code">SP.LOP.004.01</td><td class="unit-title">Melakukan Peningkatan Berkelanjutan (Act)</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <!-- CAT 6: SISTEM MANAJEMEN -->
    <div class="cat-group" data-cat="manajemen">
      <div class="cat-title">Sistem Manajemen &amp; Governance / Management Systems &amp; Governance</div>
      <div class="schemes">

        <div class="scheme" data-cat="manajemen">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">R</span>
              <div>
                <div class="scheme-name">Quality Management System (ISO 9001) Officer</div>
                <span class="tag">Sistem Manajemen</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Quality Management System (ISO 9001) Officer</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.QMS.001.01</td><td class="unit-title">Menganalisis Konteks Organisasi dan Pihak Berkepentingan</td></tr>
                <tr><td class="unit-code">SP.QMS.002.01</td><td class="unit-title">Menyusun Perencanaan Mutu dan Manajemen Risiko</td></tr>
                <tr><td class="unit-code">SP.QMS.003.01</td><td class="unit-title">Mengelola Sumber Daya dan Informasi Terdokumentasi</td></tr>
                <tr><td class="unit-code">SP.QMS.004.01</td><td class="unit-title">Mengendalikan Operasional dan Penyedia Eksternal</td></tr>
                <tr><td class="unit-code">SP.QMS.005.01</td><td class="unit-title">Melakukan Evaluasi Kinerja dan Peningkatan Berkelanjutan</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="manajemen">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">S</span>
              <div>
                <div class="scheme-name">QC Laboratory Analyst / Analis QC Laboratorium</div>
                <span class="tag">Sistem Manajemen</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>QC Laboratory Analyst / Analis QC Laboratorium</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.QCA.001.01</td><td class="unit-title">Melakukan Kaji Ulang Permintaan, Tender, dan Kontrak Pengujian</td></tr>
                <tr><td class="unit-code">SP.QCA.002.01</td><td class="unit-title">Memilih, Memverifikasi, dan Memvalidasi Metode Pengujian</td></tr>
                <tr><td class="unit-code">SP.QCA.003.01</td><td class="unit-title">Melaksanakan Pengambilan Sampel (Sampling)</td></tr>
                <tr><td class="unit-code">SP.QCA.004.01</td><td class="unit-title">Menangani dan Menyiapkan Sampel untuk Analisis</td></tr>
                <tr><td class="unit-code">SP.QCA.005.01</td><td class="unit-title">Membuat dan Mengelola Rekaman Teknis Pengujian</td></tr>
                <tr><td class="unit-code">SP.QCA.006.01</td><td class="unit-title">Melaksanakan Penjaminan Mutu Hasil Pengujian</td></tr>
                <tr><td class="unit-code">SP.QCA.007.01</td><td class="unit-title">Mengevaluasi Ketidakpastian Pengukuran</td></tr>
                <tr><td class="unit-code">SP.QCA.008.01</td><td class="unit-title">Menyusun Laporan Hasil Uji</td></tr>
                <tr><td class="unit-code">SP.QCA.009.01</td><td class="unit-title">Mengidentifikasi dan Mengendalikan Pekerjaan yang Tidak Sesuai</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="manajemen">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">T</span>
              <div>
                <div class="scheme-name">Quality Assurance Officer</div>
                <span class="tag">Sistem Manajemen</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Quality Assurance Officer</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.QAO.001.01</td><td class="unit-title">Mengelola dan Mengendalikan Dokumen Sistem Manajemen Mutu</td></tr>
                <tr><td class="unit-code">SP.QAO.002.01</td><td class="unit-title">Mengimplementasikan Sistem Manajemen Mutu Sesuai Standar yang Berlaku</td></tr>
                <tr><td class="unit-code">SP.QAO.003.01</td><td class="unit-title">Melaksanakan Audit Internal Sistem Manajemen Mutu</td></tr>
                <tr><td class="unit-code">SP.QAO.004.01</td><td class="unit-title">Mengidentifikasi dan Mengendalikan Ketidaksesuaian</td></tr>
                <tr><td class="unit-code">SP.QAO.005.01</td><td class="unit-title">Melaksanakan Tindakan Korektif dan Tindakan Pencegahan</td></tr>
                <tr><td class="unit-code">SP.QAO.006.01</td><td class="unit-title">Melakukan Analisis Risiko dan Peluang dalam Sistem Manajemen Mutu</td></tr>
                <tr><td class="unit-code">SP.QAO.007.01</td><td class="unit-title">Melakukan Pemantauan, Pengukuran, dan Evaluasi Kinerja Mutu</td></tr>
                <tr><td class="unit-code">SP.QAO.008.01</td><td class="unit-title">Melaksanakan Pengendalian Rekaman dan Pelaporan Kinerja Mutu</td></tr>
                <tr><td class="unit-code">SP.QAO.009.01</td><td class="unit-title">Menerapkan Prinsip Perbaikan Berkelanjutan (Continuous Improvement)</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="manajemen">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">V</span>
              <div>
                <div class="scheme-name">Regulatory Affairs Officer</div>
                <span class="tag">Sistem Manajemen</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Regulatory Affairs Officer</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.RAQ.001.01</td><td class="unit-title">Menerapkan Prinsip Kepatuhan Regulasi dan Etika Profesi</td></tr>
                <tr><td class="unit-code">SP.RAQ.002.01</td><td class="unit-title">Menyusun dan Mengevaluasi Dokumen Registrasi dan Perizinan Produk</td></tr>
                <tr><td class="unit-code">SP.RAQ.003.01</td><td class="unit-title">Melakukan Proses Pengajuan Registrasi dan Perizinan Produk kepada Otoritas Terkait</td></tr>
                <tr><td class="unit-code">SP.RAQ.004.01</td><td class="unit-title">Melakukan Pemantauan Perubahan Regulasi dan Analisis Dampaknya</td></tr>
                <tr><td class="unit-code">SP.RAQ.005.01</td><td class="unit-title">Mengelola Arsip dan Sistem Dokumentasi Regulatory Affairs</td></tr>
                <tr><td class="unit-code">SP.RAQ.006.01</td><td class="unit-title">Melakukan Evaluasi Kepatuhan Produk dan Menyusun Tindak Lanjut Ketidaksesuaian</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="manajemen">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">W</span>
              <div>
                <div class="scheme-name">Sustainability Officer</div>
                <span class="tag">Sistem Manajemen</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Sustainability Officer</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.SBO.001.01</td><td class="unit-title">Mengidentifikasi aspek dan dampak keberlanjutan operasional</td></tr>
                <tr><td class="unit-code">SP.SBO.002.01</td><td class="unit-title">Merencanakan program peningkatan kinerja lingkungan dan sosial</td></tr>
                <tr><td class="unit-code">SP.SBO.003.01</td><td class="unit-title">Mengimplementasikan program keberlanjutan organisasi</td></tr>
                <tr><td class="unit-code">SP.SBO.004.01</td><td class="unit-title">Memantau dan mengevaluasi capaian target keberlanjutan</td></tr>
                <tr><td class="unit-code">SP.SBO.005.01</td><td class="unit-title">Mengomunikasikan kinerja keberlanjutan internal</td></tr>
                <tr><td class="unit-code">SP.SBO.006.01</td><td class="unit-title">Mendukung pengelolaan data kinerja keberlanjutan</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="manajemen">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">X</span>
              <div>
                <div class="scheme-name">ESG Officer</div>
                <span class="tag">Sistem Manajemen</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>ESG Officer</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.ESG.001.01</td><td class="unit-title">Mengidentifikasi dan memetakan pemangku kepentingan</td></tr>
                <tr><td class="unit-code">SP.ESG.002.01</td><td class="unit-title">Mengidentifikasi isu dan risiko ESG</td></tr>
                <tr><td class="unit-code">SP.ESG.003.01</td><td class="unit-title">Melakukan penilaian dampak dan risiko ESG</td></tr>
                <tr><td class="unit-code">SP.ESG.004.01</td><td class="unit-title">Menyusun matriks materialitas</td></tr>
                <tr><td class="unit-code">SP.ESG.005.01</td><td class="unit-title">Mengintegrasikan risiko ESG ke dalam manajemen risiko organisasi</td></tr>
                <tr><td class="unit-code">SP.ESG.006.01</td><td class="unit-title">Menyiapkan informasi pengungkapan ESG</td></tr>
                <tr><td class="unit-code">SP.ESG.007.01</td><td class="unit-title">Mendukung tata kelola dan kebijakan ESG organisasi</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="manajemen">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">Y</span>
              <div>
                <div class="scheme-name">Environmental Management System (ISO 14001) Officer</div>
                <span class="tag">Sistem Manajemen</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Implementer Sistem Manajemen Lingkungan</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.EMS.001.01</td><td class="unit-title">Menerapkan Konteks Organisasi dalam SML</td></tr>
                <tr><td class="unit-code">SP.EMS.002.01</td><td class="unit-title">Mengidentifikasi Aspek dan Dampak Lingkungan</td></tr>
                <tr><td class="unit-code">SP.EMS.003.01</td><td class="unit-title">Mengidentifikasi dan Mengevaluasi Kewajiban Kepatuhan</td></tr>
                <tr><td class="unit-code">SP.EMS.004.01</td><td class="unit-title">Menyusun Sasaran dan Program Lingkungan</td></tr>
                <tr><td class="unit-code">SP.EMS.005.01</td><td class="unit-title">Mengendalikan Operasional dan Dokumen SML</td></tr>
                <tr><td class="unit-code">SP.EMS.006.01</td><td class="unit-title">Melaksanakan Pemantauan dan Pengukuran Kinerja Lingkungan</td></tr>
                <tr><td class="unit-code">SP.EMS.007.01</td><td class="unit-title">Melaksanakan Audit Internal SML</td></tr>
                <tr><td class="unit-code">SP.EMS.008.01</td><td class="unit-title">Menindaklanjuti Ketidaksesuaian dan Tindakan Perbaikan</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="scheme" data-cat="manajemen">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">Z</span>
              <div>
                <div class="scheme-name">Corporate Legal Officer</div>
                <span class="tag">Sistem Manajemen</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Sertifikasi Corporate Legal Officer</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.CLO.001.01</td><td class="unit-title">Melakukan Pemenuhan Perizinan Usaha dan Legalitas Korporasi</td></tr>
                <tr><td class="unit-code">SP.CLO.002.01</td><td class="unit-title">Menyusun dan Meninjau Dokumen Hukum Perusahaan</td></tr>
                <tr><td class="unit-code">SP.CLO.003.01</td><td class="unit-title">Menyusun Legal Opinion dan Rekomendasi Hukum</td></tr>
                <tr><td class="unit-code">SP.CLO.004.01</td><td class="unit-title">Mengelola Administrasi dan Arsip Hukum Korporasi</td></tr>
                <tr><td class="unit-code">SP.CLO.005.01</td><td class="unit-title">Menyusun Laporan Legal dan Kepatuhan Secara Berkala</td></tr>
                <tr><td class="unit-code">SP.CLO.006.01</td><td class="unit-title">Melakukan Monitoring dan Analisis Perubahan Regulasi</td></tr>
                <tr><td class="unit-code">SP.CLO.007.01</td><td class="unit-title">Melakukan Legal Due Diligence &amp; Audit Kepatuhan Hukum</td></tr>
                <tr><td class="unit-code">SP.CLO.008.01</td><td class="unit-title">Mengelola Hubungan dengan Regulasi dan Stakeholder</td></tr>
                <tr><td class="unit-code">SP.CLO.009.01</td><td class="unit-title">Menangani Pemeriksaan dan Investigasi oleh Regulator</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <!-- CAT 7: RESEARCH & INNOVATION -->
    <div class="cat-group" data-cat="riset">
      <div class="cat-title">Research &amp; Innovation</div>
      <div class="schemes">

        <div class="scheme" data-cat="riset">
          <div class="scheme-header">
            <div class="scheme-top">
              <span class="scheme-badge">U</span>
              <div>
                <div class="scheme-name">Research and Development Officer</div>
                <span class="tag">Research &amp; Innovation</span>
              </div>
            </div>
            <div class="scheme-type">Jenis kemasan: <strong>Research and Development Officer</strong></div>
          </div>
          <div class="scheme-body">
            <table class="unit-table">
              <thead><tr><th>Kode Unit</th><th>Judul Unit Kompetensi</th></tr></thead>
              <tbody>
                <tr><td class="unit-code">SP.RDO.001.01</td><td class="unit-title">Merencanakan Kegiatan Penelitian dan Pengembangan</td></tr>
                <tr><td class="unit-code">SP.RDO.002.01</td><td class="unit-title">Melaksanakan Kegiatan Penelitian dan Pengembangan</td></tr>
                <tr><td class="unit-code">SP.RDO.003.01</td><td class="unit-title">Melakukan Analisis dan Validasi Hasil Penelitian</td></tr>
                <tr><td class="unit-code">SP.RDO.004.01</td><td class="unit-title">Mengelola Dokumentasi dan Pelaporan Kegiatan R&amp;D</td></tr>
                <tr><td class="unit-code">SP.RDO.005.01</td><td class="unit-title">Mengelola Implementasi dan Peningkatan Berkelanjutan Hasil Pengembangan</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

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
      <a class="wa" href="https://wa.me/6285175479385">
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
</script>
@endsection
