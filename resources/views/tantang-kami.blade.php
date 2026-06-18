@extends('layouts.app')
{{-- Meta dikelola via $SEOData dari PageController@tentang (ralphjsmit/laravel-seo). --}}

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-tentang.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;padding:0;border-top:0}
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
.profil-paras p{font-size:15px;line-height:1.75}
.profil-paras p:nth-child(odd){color:rgba(255,255,255,.90)}
.profil-paras p:nth-child(even){color:#f4891f}
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
.chart-card{background:#fff;border:1px solid var(--line);border-radius:20px;padding:40px 36px;position:relative;overflow:hidden}
.chart-card-bg{position:absolute;inset:0;pointer-events:none;background-image:radial-gradient(#e6e9f0 1px,transparent 1px);background-size:24px 24px;opacity:.3;mask-image:radial-gradient(60% 60% at 50% 50%,#000 30%,transparent)}
.chart-head{position:relative;display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:28px;padding-bottom:18px;border-bottom:1px solid var(--line)}
.chart-legend{position:relative;margin-top:28px;padding-top:20px;border-top:1px solid var(--line);display:flex;flex-wrap:wrap;gap:20px;align-items:center;font-size:12.5px}
.legend-item{display:inline-flex;align-items:center;gap:8px;color:var(--ink-2)}
.roster-grid{margin-top:28px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.roster-card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:22px}
.roster-title{font-size:11px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--orange-deep);margin-bottom:14px}
.roster-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:6px}
.roster-list li{padding:8px 12px;border-radius:8px;font-size:13.5px;font-weight:600}
@media(max-width:960px){.roster-grid{grid-template-columns:1fr}.chart-head{flex-direction:column;gap:8px;align-items:flex-start}}
@media(max-width:960px){.komitmen-grid{grid-template-columns:1fr}.komitmen-card.full{grid-column:auto}.cta{grid-template-columns:1fr}.profil-hero{padding:32px}.doc-card{flex-direction:column}}
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">PM.SM.01 Rev. 3 · Panduan Mutu</div>
    <h1>Tentang <em>Kami</em></h1>
    <p class="lead">Profil, visi, misi, komitmen manajemen, struktur organisasi, dan landasan hukum LSP Edukasi Global Cendekia.</p>
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
      <div class="komitmen-card tujuan-card full">
        <div class="komitmen-header tujuan"><div class="ico"><svg width="16" height="16"><use href="#i-award"></use></svg></div><h3>Tujuan</h3></div>
        <div class="komitmen-body">
          <ul class="komitmen-num-list">
            <li><span class="n">1</span><span>Menerapkan sistem manajemen mutu dalam mengelola LSP Edukasi Global Cendekia.</span></li>
            <li><span class="n">2</span><span>Menjamin kesesuaian kompetensi peserta asesmen yang memperoleh sertifikat kompetensi dari LSP Edukasi Global Cendekia.</span></li>
          </ul>
        </div>
      </div>
      {{-- <div class="komitmen-card kebijakan-card">
        <div class="komitmen-header kebijakan"><div class="ico"><svg width="16" height="16"><use href="#i-shield"></use></svg></div><h3>Kebijakan Mutu</h3></div>
        <div class="komitmen-body">
          <ul class="komitmen-num-list">
            <li><span class="n">1</span><span>LSP Edukasi Global Cendekia berkomitmen menerapkan dan memelihara mutu sesuai dengan panduan KAN K.09 dan SNI LSP-033-IDN.</span></li>
            <li><span class="n">2</span><span>Seluruh personel berkomitmen untuk menyelenggarakan uji kompetensi sertifikasi secara profesional.</span></li>
          </ul>
        </div>
      </div> --}}
      {{-- <div class="komitmen-card sasaran-card full">
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
      </div> --}}
    </div>
  </div>
</section>

<section id="komitmen">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Kebijakan LSP</div>
      <h2>Pernyataan Komitmen Ketidakberpihakan</h2>
    </div>
    <div class="panel">
      <p style="font-size:15px;color:var(--ink-2);line-height:1.7;margin-bottom:24px">Lembaga Sertifikasi Person (LSP) PT Edukasi Global Cendekia berkomitmen untuk menjalankan seluruh kegiatan operasionalnya secara jujur, adil dan berintegritas mengikuti seluruh ketentuan regulasi dan pedoman yang dipersyaratkan. Dalam menjalankan kegiatan sertifikasi, LSP PT Edukasi Global Cendekia menerapkan kebijakan sebagai berikut.</p>
      <ol class="num-list navy">
        <li><span class="n">1</span><p>Menjamin bahwa kegiatan sertifikasi dilaksanakan secara objektif dan tidak berpihak.</p></li>
        <li><span class="n">2</span><p>Menjamin bahwa kebijakan dan prosedur sertifikasi dilaksanakan secara adil untuk semua pemohon sertifikasi, calon peserta sertifikasi dan pemegang sertifikat sesuai dengan segala ketentuan, regulasi dan pedoman yang terkait.</p></li>
        <li><span class="n">3</span><p>Menjamin proses sertifikasi tidak dibatasi atas dasar keterbatasan keuangan atau keterbatasan lainnya, seperti keanggotaan asosiasi atau kelompok. Tidak satupun dalam mekanisme operasional sertifikasi ini yang dapat menghambat atau menghalangi akses pemohon atau calon peserta sertifikasi.</p></li>
        <li><span class="n">4</span><p>Menjamin proses sertifikasi tidak akan mengijinkan tekanan komersial, keuangan atau tekanan lain untuk mengkompromikan ketidakberpihakan.</p></li>
        <li><span class="n">5</span><p>Menjamin ketersediaan dan kemudahan akses untuk publik tanpa permintaan yang menyatakan dan memberikan pemahaman tentang pentingnya ketidakberpihakan dalam pelaksanaan sertifikasi, pengelolaan konflik kepentingan dan jaminan objektivitas sertifikasi.</p></li>
        <li><span class="n">6</span><p>Berkomitmen untuk selalu mengidentifikasi, menghilangkan, mengurangi atau mengelola seluruh risiko dan ancaman terhadap ketidakberpihakan secara berkelanjutan, yang mencakup dari internal operasional sertifikasi, lembaga lain atau hubungan dengan pihak lain yang terkait, dan hubungan dari personil di dalam lembaga sertifikasi kepada pihak lain terkait dan yang berkepentingan.</p></li>
        <li><span class="n">7</span><p>Menjamin keamanan informasi dalam pengelolaan seluruh proses sertifikasi termasuk materi ujian, sesuai dengan hukum dan regulasi yang berlaku dan mengambil langkah-langkah tindakan korektif bila terjadi pelanggaran keamanan informasi.</p></li>
        <li><span class="n">8</span><p>Menangani semua keluhan dan banding secara konstruktif, netral, dan tepat waktu sesuai dengan prosedur yang telah ditentukan.</p></li>
        <li><span class="n">9</span>
          <p> Berkomitmen untuk memisahkan secara tegas fungsi sertifikasi person dengan aktivitas pelatihan, pendampingan, konsultansi, dan kegiatan pengembangan kompetensi lainnya yang dilakukan oleh pihak manapun, termasuk personel yang terlibat dalam manajemen dan operasional sertifikasi. LSP Edukia menerapkan pengendalian risiko ketidakberpihakan terhadap seluruh personel sesuai peran dan jabatannya sebagaimana ditetapkan dalam kebijakan dan/atau keputusan yang berlaku di LSP Edukia.
          <br><br> Pengendalian tersebut mencakup pembatasan aktivitas tertentu bagi personel yang berdasarkan hasil kajian risiko ditetapkan memiliki tingkat risiko tinggi terhadap ketidakberpihakan, sesuai dengan kebijakan dan/atau keputusan yang berlaku di LSP Edukia.
          <br><br> Khusus bagi Ketua LSP Edukia, selama menjabat tidak diperkenankan menjadi trainer, konsultan, pendamping, maupun melakukan aktivitas promosi yang berkaitan secara langsung dengan skema sertifikasi, layanan sertifikasi, atau kegiatan persiapan sertifikasi yang diselenggarakan oleh LSP Edukia. Ketua LSP Edukia hanya diperkenankan melakukan publikasi yang bersifat edukatif, informatif, akademik, dan kelembagaan sepanjang tidak menimbulkan persepsi ketidakberpihakan maupun konflik kepentingan terhadap proses sertifikasi person.</p>
        </li>
        <li><span class="n">10</span><p>Dalam hal skema sertifikasi mensyaratkan bukti pelatihan atau pengembangan kompetensi sebagai bagian dari persyaratan sertifikasi, LSP Edukia menerima bukti pelatihan yang relevan tanpa membatasi atau mewajibkan peserta untuk mengikuti pelatihan dari penyelenggara tertentu, termasuk dari lembaga pelatihan yang bermitra dengan LSP Edukia. Kepemilikan sertifikat pelatihan tidak menjamin kelulusan sertifikasi dan tidak mempengaruhi objektivitas proses asesmen maupun keputusan sertifikasi. LSP Edukia tidak memberikan perlakuan khusus, kemudahan proses, maupun keuntungan dalam proses sertifikasi kepada peserta yang mengikuti pelatihan dari penyelenggara tertentu.</p></li>
      </ol>
    </div>
  </div>
</section>

<section id="struktur" style="background:#fbf9f3;padding:96px 0;border-top:1px solid var(--line)">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Tata Kelola</div>
      <h2>Struktur Organisasi</h2>
      <p class="sub">Susunan pengurus dan personel LSP Edukasi Global Cendekia berdasarkan SK No: 001/SK-AK/LSP-EDUKIA/I/2026.</p>
    </div>

    {{-- Chart card --}}
    <div class="chart-card">
      <div class="chart-card-bg"></div>

      {{-- Header strip --}}
      <div class="chart-head">
        <div>
          <div style="font-size:11px;font-weight:800;letter-spacing:0.18em;text-transform:uppercase;color:var(--orange-deep);font-family:ui-monospace,monospace;margin-bottom:6px">
            Bagan Tata Kelola · v2026
          </div>
          <h3 style="font-size:22px;font-weight:700;color:var(--ink);margin:0;letter-spacing:-0.015em">
            Struktur Organisasi LSP Edukasi Global Cendekia
          </h3>
        </div>
        <div style="font-size:12.5px;color:var(--muted);text-align:right">
          <div style="font-family:ui-monospace,monospace">SK No. 001/SK-AK/LSP-EDUKIA/I/2026</div>
          <div style="margin-top:2px">Efektif sejak Januari 2026</div>
        </div>
      </div>

      {{-- SVG Org Chart --}}
      <div style="overflow-x:auto">
        <svg viewBox="0 0 1240 680" xmlns="http://www.w3.org/2000/svg"
             style="width:100%;min-width:600px;height:auto;display:block;font-family:'Plus Jakarta Sans',sans-serif">

          {{-- Connector lines --}}
          <g stroke="#5a6a85" stroke-width="1.5" fill="none">
            {{-- Central spine: Ketua → operational bus --}}
            <line x1="620" y1="90"  x2="620" y2="530"/>
            {{-- Bus at y=150 → Manajer Teknis & Mutu --}}
            <line x1="370" y1="150" x2="840" y2="150"/>
            <line x1="370" y1="150" x2="370" y2="220"/>
            <line x1="840" y1="150" x2="840" y2="220"/>
            {{-- Manajer Mutu → Tim Audit Internal --}}
            <line x1="840" y1="280" x2="840" y2="320"/>
            {{-- Wide bus at y=385 → 4 Manajer --}}
            <line x1="120"  y1="385" x2="1120" y2="385"/>
            <line x1="120"  y1="385" x2="120"  y2="420"/>
            <line x1="400"  y1="385" x2="400"  y2="420"/>
            <line x1="790"  y1="385" x2="790"  y2="420"/>
            <line x1="1120" y1="385" x2="1120" y2="420"/>
            {{-- Operational bus at y=530 → TUK / Asesor / Pengawas --}}
            <line x1="275" y1="530" x2="895" y2="530"/>
            <line x1="275" y1="530" x2="275" y2="560"/>
            <line x1="620" y1="530" x2="620" y2="560"/>
            <line x1="895" y1="530" x2="895" y2="560"/>
          </g>

          {{-- Dashed advisory: exits bottom of Ketua at spine (x=620), drops to Komite level, turns right --}}
          <g stroke="#f4891f" stroke-width="2" stroke-dasharray="6 5" fill="none">
            <line x1="620" y1="90"  x2="620" y2="120"/>
            <line x1="620" y1="120" x2="900" y2="120"/>
          </g>

          {{-- Ketua LSP (primary) --}}
          <rect x="472" y="34" width="300" height="60" rx="8" fill="#06172e" opacity="0.18"/>
          <rect x="470" y="30"  width="300" height="60" rx="8" fill="#0a2547"/>
          <foreignObject x="470" y="30" width="300" height="60">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px;color:#fff;font-weight:700;font-size:18px;text-align:center;line-height:1.3;letter-spacing:-0.01em">Ketua LSP</div>
          </foreignObject>

          {{-- Komite Ketidakberpihakan (dashed) — between Ketua and Manajer rows --}}
          <rect x="900" y="90" width="280" height="60" rx="8" fill="#fff" stroke="#f4891f" stroke-width="2" stroke-dasharray="6 4"/>
          <foreignObject x="900" y="90" width="280" height="60">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px;color:#0f1d35;font-weight:600;font-size:14px;text-align:center;line-height:1.3">Komite Ketidakberpihakan</div>
          </foreignObject>

          {{-- Manajer Teknis (manager) --}}
          <rect x="240" y="220" width="260" height="60" rx="8" fill="#fff" stroke="#0a2547" stroke-width="1.5"/>
          <rect x="240" y="220" width="4"   height="60" rx="2" fill="#f4891f"/>
          <foreignObject x="240" y="220" width="260" height="60">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px 0 18px;color:#0a2547;font-weight:600;font-size:14px;text-align:center;line-height:1.3">Manajer Teknis</div>
          </foreignObject>

          {{-- Manajer Mutu dan Administrasi (manager) --}}
          <rect x="680" y="220" width="320" height="60" rx="8" fill="#fff" stroke="#0a2547" stroke-width="1.5"/>
          <rect x="680" y="220" width="4"   height="60" rx="2" fill="#f4891f"/>
          <foreignObject x="680" y="220" width="320" height="60">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px 0 18px;color:#0a2547;font-weight:600;font-size:14px;text-align:center;line-height:1.3">Manajer Mutu dan Administrasi</div>
          </foreignObject>

          {{-- Tim Audit Internal (sub) --}}
          <rect x="720" y="320" width="240" height="50" rx="8" fill="#eef3fb" stroke="#102d57" stroke-width="1"/>
          <foreignObject x="720" y="320" width="240" height="50">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px;color:#102d57;font-weight:600;font-size:13px;text-align:center;line-height:1.3">Tim Audit Internal</div>
          </foreignObject>

          {{-- Manajer Skema (manager) --}}
          <rect x="20"  y="420" width="200" height="90" rx="8" fill="#fff" stroke="#0a2547" stroke-width="1.5"/>
          <rect x="20"  y="420" width="4"   height="90" rx="2" fill="#f4891f"/>
          <foreignObject x="20" y="420" width="200" height="90">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px 0 18px;color:#0a2547;font-weight:600;font-size:14px;text-align:center;line-height:1.3">Manajer Skema</div>
          </foreignObject>

          {{-- Manajer Ketidakberpihakan, Kerahasiaan dan Keamanan MUK (manager) --}}
          <rect x="240" y="420" width="320" height="90" rx="8" fill="#fff" stroke="#0a2547" stroke-width="1.5"/>
          <rect x="240" y="420" width="4"   height="90" rx="2" fill="#f4891f"/>
          <foreignObject x="240" y="420" width="320" height="90">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px 0 18px;color:#0a2547;font-weight:600;font-size:14px;text-align:center;line-height:1.3">Manajer Ketidakberpihakan, Kerahasiaan dan Keamanan MUK</div>
          </foreignObject>

          {{-- Manajer HR, Keuangan dan Sales (manager) — shifted right so spine is visible --}}
          <rect x="650" y="420" width="280" height="90" rx="8" fill="#fff" stroke="#0a2547" stroke-width="1.5"/>
          <rect x="650" y="420" width="4"   height="90" rx="2" fill="#f4891f"/>
          <foreignObject x="650" y="420" width="280" height="90">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px 0 18px;color:#0a2547;font-weight:600;font-size:14px;text-align:center;line-height:1.3">Manajer HR, Keuangan dan Sales</div>
          </foreignObject>

          {{-- Manajer Sertifikasi (manager) --}}
          <rect x="1020" y="420" width="200" height="90" rx="8" fill="#fff" stroke="#0a2547" stroke-width="1.5"/>
          <rect x="1020" y="420" width="4"   height="90" rx="2" fill="#f4891f"/>
          <foreignObject x="1020" y="420" width="200" height="90">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px 0 18px;color:#0a2547;font-weight:600;font-size:14px;text-align:center;line-height:1.3">Manajer Sertifikasi</div>
          </foreignObject>

          {{-- TUK (operational) --}}
          <rect x="170" y="560" width="210" height="50" rx="8" fill="#f5f1e8" stroke="#dfe3ec" stroke-width="1.5"/>
          <foreignObject x="170" y="560" width="210" height="50">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px;color:#0a2547;font-weight:700;font-size:15px;text-align:center;line-height:1.3">TUK</div>
          </foreignObject>

          {{-- Asesor (operational) — centered on spine x=620 --}}
          <rect x="490" y="560" width="260" height="50" rx="8" fill="#f5f1e8" stroke="#dfe3ec" stroke-width="1.5"/>
          <foreignObject x="490" y="560" width="260" height="50">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px;color:#0a2547;font-weight:700;font-size:15px;text-align:center;line-height:1.3">Asesor</div>
          </foreignObject>

          {{-- Pengawas (operational) --}}
          <rect x="790" y="560" width="210" height="50" rx="8" fill="#f5f1e8" stroke="#dfe3ec" stroke-width="1.5"/>
          <foreignObject x="790" y="560" width="210" height="50">
            <div xmlns="http://www.w3.org/1999/xhtml" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:0 14px;color:#0a2547;font-weight:700;font-size:15px;text-align:center;line-height:1.3">Pengawas</div>
          </foreignObject>
        </svg>
      </div>

      {{-- Legend --}}
      <div class="chart-legend">
        <span style="font-size:11px;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;color:var(--ink)">Legenda</span>
        <span class="legend-item">
          <span style="width:14px;height:14px;border-radius:3px;background:#0a2547;display:inline-block;flex-shrink:0"></span>
          Posisi puncak
        </span>
        <span class="legend-item">
          <span style="width:14px;height:14px;border-radius:3px;background:#fff;border:2px dashed #f4891f;display:inline-block;flex-shrink:0"></span>
          Komite independen
        </span>
        <span class="legend-item">
          <span style="width:14px;height:14px;border-radius:3px;background:#fff;border:1.5px solid #0a2547;display:inline-block;flex-shrink:0;position:relative">
            <span style="position:absolute;left:0;top:0;bottom:0;width:3px;background:#f4891f;border-radius:1px"></span>
          </span>
          Manajemen
        </span>
        <span class="legend-item">
          <span style="width:14px;height:14px;border-radius:3px;background:#eef3fb;border:1px solid #102d57;display:inline-block;flex-shrink:0"></span>
          Tim pendukung
        </span>
        <span class="legend-item">
          <span style="width:14px;height:14px;border-radius:3px;background:#f5f1e8;border:1.5px solid #dfe3ec;display:inline-block;flex-shrink:0"></span>
          Operasional
        </span>
        <span style="flex:1"></span>
        <span class="legend-item">
          <svg width="28" height="10" viewBox="0 0 28 10">
            <line x1="0" y1="5" x2="28" y2="5" stroke="#f4891f" stroke-width="2" stroke-dasharray="6 4"/>
          </svg>
          Hubungan independen / advisory
        </span>
      </div>
    </div>

    {{-- Roster --}}
    {{-- <div class="roster-grid">

      <div class="roster-card">
        <div class="roster-title">Pimpinan &amp; Pengawasan</div>
        <ul class="roster-list">
          <li style="background:#0a2547;color:#fff;">Ketua LSP</li>
          <li style="background:#fff;color:var(--ink);border:1.5px dashed #f4891f;">Komite Ketidakberpihakan</li>
          <li style="background:#eef3fb;color:#102d57;">Tim Audit Internal</li>
        </ul>
      </div>

      <div class="roster-card">
        <div class="roster-title">Manajemen</div>
        <ul class="roster-list">
          @foreach(['Manajer Teknis','Manajer Mutu dan Administrasi','Manajer Skema','Manajer Ketidakberpihakan, Kerahasiaan &amp; Keamanan MUK','Manajer HR, Keuangan dan Sales','Manajer Sertifikasi'] as $role)
          <li style="background:#fff;color:#0a2547;border:1px solid var(--line);padding-left:18px;position:relative">
            <span style="position:absolute;left:6px;top:6px;bottom:6px;width:2px;border-radius:1px;background:#f4891f"></span>
            {!! $role !!}
          </li>
          @endforeach
        </ul>
      </div>

      <div class="roster-card">
        <div class="roster-title">Operasional</div>
        <ul class="roster-list">
          @foreach(['TUK (Tempat Uji Kompetensi)','Asesor Kompetensi','Pengawas','Anggota Teknis','Staff Administrasi','Staff Sales'] as $role)
          <li style="background:#f5f1e8;color:#0a2547;">{!! $role !!}</li>
          @endforeach
        </ul>
      </div>

    </div> --}}
  </div>
</section>

<section id="acuan-normatif">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Referensi Regulasi</div>
      <h2>Landasan Hukum</h2>
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
