@extends('layouts.app')
@section('title', 'Tentang Kami — LSP Edukia')

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-tentang.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue)}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}
.profil-hero{background:linear-gradient(135deg,var(--navy-800) 0%,var(--navy-700) 60%,var(--navy-900) 100%);border-radius:24px;padding:48px;color:#fff;position:relative;overflow:hidden}
.profil-hero::before{content:"";position:absolute;right:-80px;top:-80px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(68,159,229,.25),transparent 70%);pointer-events:none}
.profil-hero::after{content:"";position:absolute;left:-60px;bottom:-60px;width:240px;height:240px;border-radius:50%;background:radial-gradient(circle,rgba(244,137,31,.2),transparent 70%);pointer-events:none}
.profil-hero-inner{position:relative;z-index:1}
.profil-hero h3{color:var(--orange);font-size:13px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;margin-bottom:10px}
.profil-hero h2{color:#fff;font-size:clamp(20px,3vw,28px);margin-bottom:28px}
.profil-paras{display:flex;flex-direction:column;gap:16px}
.profil-paras p{color:rgba(255,255,255,.82);font-size:15px;line-height:1.75}
.profil-paras p strong{color:#fff}
.komitmen-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.komitmen-card{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;transition:border-color .2s}
.komitmen-card:hover{border-color:var(--blue)}
.komitmen-card.full{grid-column:1/-1}
.komitmen-header{padding:14px 20px;display:flex;align-items:center;gap:12px}
.komitmen-header .ico{width:32px;height:32px;border-radius:9px;display:grid;place-items:center;flex:0 0 auto;background:rgba(255,255,255,.12);color:#fff}
.komitmen-header h3{font-size:15px;letter-spacing:0.05em;text-transform:uppercase;color:#fff;font-weight:700}
.komitmen-header.visi{background:linear-gradient(135deg,var(--navy-800),var(--navy-600))}
.komitmen-header.misi{background:linear-gradient(135deg,#0d5c3a,#0f7a4e)}
.komitmen-header.nilai{background:linear-gradient(135deg,#6d28d9,#8b5cf6)}
.komitmen-header.tujuan{background:linear-gradient(135deg,var(--orange-deep),var(--orange))}
.komitmen-header.kebijakan{background:linear-gradient(135deg,#0369a1,#0ea5e9)}
.komitmen-header.sasaran{background:linear-gradient(135deg,#b45309,#d97706)}
.komitmen-body{padding:22px 24px}
.komitmen-body p{font-size:14.5px;color:var(--ink-2);line-height:1.7}
.komitmen-body p strong{color:var(--ink);font-weight:600}
.komitmen-num-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px}
.komitmen-num-list li{display:flex;gap:12px;align-items:flex-start;font-size:14.5px;color:var(--ink-2);line-height:1.55}
.komitmen-num-list .n{width:22px;height:22px;border-radius:50%;font-size:11.5px;font-weight:700;display:grid;place-items:center;flex:0 0 auto;margin-top:1px;background:var(--cream-2);color:var(--ink)}
.komitmen-card.visi-card .n,.komitmen-card.misi-card .n{background:var(--navy-800);color:#fff}
.komitmen-card.tujuan-card .n{background:var(--orange);color:#fff}
.komitmen-card.kebijakan-card .n{background:var(--blue-deep);color:#fff}
.komitmen-card.sasaran-card .n{background:#b45309;color:#fff}
.komitmen-card.nilai-card .n{background:#6d28d9;color:#fff}
.doc-card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:26px 28px;display:flex;align-items:flex-start;gap:18px}
.doc-ico{width:52px;height:52px;border-radius:14px;display:grid;place-items:center;flex:0 0 auto;background:var(--blue-50);color:var(--blue-deep)}
.doc-info h3{font-size:17px;margin-bottom:8px}
.doc-info p{font-size:14px;color:var(--ink-2);line-height:1.65}
.doc-meta{font-size:12px;color:var(--muted);margin-top:8px;font-family:ui-monospace,monospace}
.coming-soon{background:#fff;border:2px dashed var(--line-2);border-radius:16px;padding:56px 32px;text-align:center}
.coming-soon h4{font-size:18px;color:var(--muted);font-weight:600;margin-bottom:8px}
.coming-soon p{font-size:14px;color:var(--muted);max-width:40ch;margin:0 auto}
.org-card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:24px 28px;margin-top:16px}
.org-card h4{font-size:15px;font-weight:700;color:var(--ink);margin-bottom:14px}
.org-roles{display:flex;flex-wrap:wrap;gap:8px}
.org-role{background:var(--cream-2);color:var(--ink-2);font-size:12.5px;font-weight:500;padding:5px 12px;border-radius:6px}
@media(max-width:960px){.komitmen-grid{grid-template-columns:1fr}.komitmen-card.full{grid-column:auto}.cta{grid-template-columns:1fr}.profil-hero{padding:32px}.doc-card{flex-direction:column}}
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">PM.SM.01 Rev. 3 · Panduan Mutu</div>
    <h1>Tentang <em>Kami</em></h1>
    <p class="lead">Profil, visi, misi, komitmen manajemen, struktur organisasi, dan acuan normatif LSP Edukasi Global Cendekia.</p>
  </div>
</div>

<section id="profil" style="border-top:0">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Profil Lembaga</div>
      <h2>LSP Edukasi Global Cendekia</h2>
      <p class="sub">Lembaga Sertifikasi Person berlisensi KAN untuk bidang pendidikan tinggi, laboratorium, lifting engineering, dan industri.</p>
    </div>
    <div class="profil-hero">
      <div class="profil-hero-inner">
        <h3>LSP EDUKASI GLOBAL CENDEKIA</h3>
        <h2>Mengakreditasi Kompetensi, Meningkatkan Daya Saing SDM Indonesia</h2>
        <div class="profil-paras">
          <p>Lembaga Sertifikasi Person merupakan lembaga yang bertanggung jawab melaksanakan sertifikasi kompetensi person yang memperoleh lisensi dari lembaga penjaminan mutu. LSP Edukasi Global Cendekia memperoleh lisensi dari <strong>Komite Akreditasi Nasional (KAN)</strong>.</p>
          <p>LSP Edukasi Global Cendekia bertujuan melaksanakan sertifikasi kompetensi para asesi, dimana pelaksanaan sertifikasi kompetensi dilakukan oleh tim penguji (asesor) yang terseleksi dari praktisi industri sektor jasa di bidang pendidikan dan pendidikan tinggi.</p>
          <p>LSP Edukasi Global Cendekia bertugas mengembangkan standar kompetensi, melaksanakan uji kompetensi, menerbitkan sertifikat kompetensi serta melakukan sertifikasi di tempat uji kompetensi.</p>
          <p>Dalam melaksanakan tugas dan fungsinya, LSP Edukasi Global Cendekia mengacu pada Pedoman yang dikeluarkan KAN dan ISO 17024 untuk menjamin prosedur sertifikasi yang konsisten dan profesional.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="komitmen" style="background:#fbf9f3">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Komitmen Manajemen</div>
      <h2>Visi, Misi &amp; Nilai Organisasi</h2>
      <p class="sub">Fondasi dan arah strategis LSP Edukasi Global Cendekia dalam mewujudkan sumber daya manusia Indonesia yang kompeten.</p>
    </div>
    <div class="komitmen-grid">
      <div class="komitmen-card visi-card">
        <div class="komitmen-header visi"><div class="ico"><svg width="16" height="16"><use href="#i-award"></use></svg></div><h3>Visi</h3></div>
        <div class="komitmen-body"><p>Menjadi perusahaan penyedia jasa sertifikasi person terbaik di Indonesia pada tahun 2045 yang independen, berintegritas, mudah diakses dan berorientasi kepada pemerataan peningkatan mutu dan daya saing SDM di level nasional dan internasional.</p></div>
      </div>
      <div class="komitmen-card nilai-card">
        <div class="komitmen-header nilai"><div class="ico"><svg width="16" height="16"><use href="#i-shield"></use></svg></div><h3>Nilai</h3></div>
        <div class="komitmen-body"><p>Membentuk budaya kerja internal yang berbasis <strong>profesionalisme</strong>, <strong>kerjasama</strong>, berorientasi pada <strong>inovasi</strong> dan <strong>peningkatan terus-menerus</strong>, serta menjunjung tinggi kode etik dan integritas.</p></div>
      </div>
      <div class="komitmen-card misi-card full">
        <div class="komitmen-header misi"><div class="ico"><svg width="16" height="16"><use href="#i-award"></use></svg></div><h3>Misi</h3></div>
        <div class="komitmen-body">
          <ul class="komitmen-num-list">
            <li><span class="n">1</span><span>Mengembangkan dan menyediakan skema sertifikasi pada bidang yang strategis pada penciptaan SDM unggul dan peningkatan budaya mutu organisasi pada level standar nasional dan internasional.</span></li>
            <li><span class="n">2</span><span>Senantiasa meningkatkan kompetensi tim internal guna memastikan kesesuaian skema sertifikasi yang paling terbaharukan dan meningkatkan daya saing SDM Indonesia.</span></li>
            <li><span class="n">3</span><span>Meningkatkan jaringan, komunitas dan peluang kerjasama baik secara nasional dan internasional.</span></li>
            <li><span class="n">4</span><span>Menerapkan teknologi informasi guna memberikan kemudahan akses pada masyarakat luas untuk meningkatkan kompetensinya.</span></li>
            <li><span class="n">5</span><span>Memastikan kualitas pelayanan terbaik guna mencapai kompetensi SDM yang unggul dan kepuasan pelanggan.</span></li>
          </ul>
        </div>
      </div>
      <div class="komitmen-card tujuan-card">
        <div class="komitmen-header tujuan"><div class="ico"><svg width="16" height="16"><use href="#i-award"></use></svg></div><h3>Tujuan</h3></div>
        <div class="komitmen-body">
          <ul class="komitmen-num-list">
            <li><span class="n">1</span><span>Menerapkan sistem manajemen mutu dalam mengelola LSP Edukasi Global Cendekia.</span></li>
            <li><span class="n">2</span><span>Menjamin kesesuaian kompetensi peserta asesmen yang memperoleh sertifikat kompetensi dari LSP Edukasi Global Cendekia.</span></li>
          </ul>
        </div>
      </div>
      <div class="komitmen-card kebijakan-card">
        <div class="komitmen-header kebijakan"><div class="ico"><svg width="16" height="16"><use href="#i-shield"></use></svg></div><h3>Kebijakan Mutu</h3></div>
        <div class="komitmen-body">
          <ul class="komitmen-num-list">
            <li><span class="n">1</span><span>LSP Edukasi Global Cendekia berkomitmen menerapkan dan memelihara mutu sesuai dengan panduan KAN K.09 dan SNI LSP-033-IDN.</span></li>
            <li><span class="n">2</span><span>Seluruh personel berkomitmen untuk menyelenggarakan uji kompetensi sertifikasi secara profesional.</span></li>
          </ul>
        </div>
      </div>
      <div class="komitmen-card sasaran-card full">
        <div class="komitmen-header sasaran"><div class="ico"><svg width="16" height="16"><use href="#i-award"></use></svg></div><h3>Sasaran Mutu</h3></div>
        <div class="komitmen-body">
          <ul class="komitmen-num-list">
            <li><span class="n">1</span><span>Waktu penyelesaian sertifikasi maksimal <strong>30 hari kerja</strong> sejak pelaksanaan hingga terbit sertifikat.</span></li>
            <li><span class="n">2</span><span>Menerapkan standar pelayanan prima dengan kepuasan pelanggan <strong>nilai minimum 85%</strong>.</span></li>
            <li><span class="n">3</span><span>Maksimal jumlah keluhan pelanggan <strong>dua kali per tahun</strong>.</span></li>
            <li><span class="n">4</span><span>Peningkatan sumber daya untuk mendukung proses pelaksanaan kegiatan sertifikasi.</span></li>
            <li><span class="n">5</span><span>Mengembangkan atau melakukan survei pasar untuk menambah <strong>minimal 5 skema sertifikasi baru</strong>.</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="pernyataan">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Dokumen Mutu</div>
      <h2>Pernyataan Komitmen</h2>
      <p class="sub">Panduan Mutu LSP Edukasi Global Cendekia sebagai dasar penyelenggaraan sertifikasi yang konsisten dan profesional.</p>
    </div>
    <div class="doc-card">
      <div class="doc-ico"><svg width="24" height="24"><use href="#i-doc"></use></svg></div>
      <div class="doc-info">
        <h3>Dokumen Pernyataan Komitmen — Panduan Mutu LSP</h3>
        <p>Salinan terkendali dari dokumen Panduan Mutu LSP Edukasi Global Cendekia tersedia dalam bentuk PDF bertanda tangan digital dalam server jaringan PT. EDUKASI GLOBAL CENDEKIA dan dapat diakses oleh pengguna yang memiliki otorisasi.</p>
        <div class="doc-meta">No. Dokumen: PM.SM.01 &nbsp;|&nbsp; Nomor Revisi: 3 &nbsp;|&nbsp; Tgl. Efektif: 29 April 2026</div>
      </div>
    </div>
  </div>
</section>

<section id="struktur" style="background:#fbf9f3">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Tata Kelola</div>
      <h2>Struktur Organisasi</h2>
      <p class="sub">Susunan pengurus dan personel LSP Edukasi Global Cendekia berdasarkan SK No: 001/SK-AK/LSP-EDUKIA/I/2026.</p>
    </div>
    <div class="coming-soon">
      <h4>Bagan Struktur Organisasi</h4>
      <p>Struktur organisasi LSP Edukasi Global Cendekia sedang dalam proses pengunggahan.</p>
    </div>
    <div class="org-card">
      <h4>Susunan Pengurus &amp; Personel</h4>
      <div class="org-roles">
        <span class="org-role">Ketua LSP</span>
        <span class="org-role">Manajer Teknis</span>
        <span class="org-role">Manajer Mutu &amp; Administrasi</span>
        <span class="org-role">Manajer Skema</span>
        <span class="org-role">Manajer Ketidakberpihakan, Kerahasiaan &amp; Keamanan MUK</span>
        <span class="org-role">Manajer HR, Keuangan &amp; Sales</span>
        <span class="org-role">Manajer Sertifikasi</span>
        <span class="org-role">Anggota Teknis</span>
        <span class="org-role">Staff Administrasi</span>
        <span class="org-role">Staff Sales</span>
        <span class="org-role">Tim Auditor Internal</span>
        <span class="org-role">Asesor &amp; Pengawas</span>
      </div>
    </div>
  </div>
</section>

<section id="acuan-normatif">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Referensi Regulasi</div>
      <h2>Acuan Normatif</h2>
      <p class="sub">Regulasi dan standar yang menjadi landasan penyelenggaraan LSP Edukasi Global Cendekia (PM.SM.01 Rev. 3).</p>
    </div>
    <div class="panel">
      <ol class="num-list navy">
        <li><span class="n">a</span><p>UU RI No. 13 Tahun 2003 tentang Ketenagakerjaan</p></li>
        <li><span class="n">b</span><p>PP RI No. 31 Tahun 2006 tentang Sistem Pelatihan Kerja Nasional</p></li>
        <li><span class="n">c</span><p>PP RI No. 10 Tahun 2018 tentang Badan Nasional Sertifikasi Profesi</p></li>
        <li><span class="n">d</span><p>Perpres RI No. 8 Tahun 2012 tentang Kerangka Kualifikasi Nasional Indonesia</p></li>
        <li><span class="n">e</span><p>Permenaker RI No. 2 Tahun 2016 tentang sistem standarisasi kompetensi kerja nasional</p></li>
        <li><span class="n">f</span><p>Permenaker RI No. 3 Tahun 2016 tentang tata cara penetapan standarisasi kompetensi kerja nasional</p></li>
        <li><span class="n">g</span><p>Peraturan BNSP No. 09/BNSP.301/XI/2013 Tentang Pedoman Pelaksanaan Asesmen Kompetensi</p></li>
        <li><span class="n">h</span><p>Peraturan BNSP No. 1/BNSP/III/2014 Tentang Pedoman Penilaian Kesesuaian Persyaratan Umum LSP</p></li>
        <li><span class="n">i</span><p>Peraturan BNSP No. 2/BNSP/III/2014 Tentang Pedoman Pembentukan Lembaga Sertifikasi Profesi</p></li>
        <li><span class="n">j</span><p>Peraturan BNSP No. 3/BNSP/III/2014 Tentang Pedoman Ketentuan Umum Lisensi LSP</p></li>
        <li><span class="n">k</span><p>Peraturan BNSP No. 5/BNSP/VII/2014 Tentang Pedoman Persyaratan Umum Tempat Uji Kompetensi</p></li>
        <li><span class="n">l</span><p>Peraturan BNSP No. 2/BNSP/VIII/2017 Tentang Pedoman Pengembangan dan Pemeliharaan Skema Sertifikasi Profesi</p></li>
        <li><span class="n">m</span><p>SNI LSP-033-IDN Penilaian Kesesuaian Persyaratan Umum Lembaga Sertifikasi Person</p></li>
        <li><span class="n">n</span><p>KAN K.09 Rev.1 Persyaratan Khusus Akreditasi Lembaga Sertifikasi Person</p></li>
        <li><span class="n">o</span><p>ISO 19011:2018 Pedoman Audit Sistem Manajemen</p></li>
      </ol>
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
