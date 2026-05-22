@extends('layouts.app')
@section('title', 'Informasi Publik — LSP Edukia')

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-informasi.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;padding:0;border-top:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue)}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.panel ul{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px}
.panel ul li{display:flex;gap:10px;font-size:14.5px;color:var(--ink-2);line-height:1.5}
.panel ul li::before{content:"";width:6px;height:6px;border-radius:50%;background:var(--blue);flex:0 0 auto;margin-top:9px}
.panel ul.orange li::before{background:var(--orange)}
.panel .callout{margin-top:16px;background:var(--cream);border:1px dashed var(--line-2);border-radius:10px;padding:14px;font-size:13.5px;color:var(--ink-2)}
.panel .callout.warn{background:#fdf3ec;border-color:#f3d0b0;color:#7d3e10}
.panel .callout strong{color:var(--ink);display:block;margin-bottom:4px;font-weight:700}
.steps{display:flex;flex-direction:column;gap:16px}
.step{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;transition:border-color .2s}
.step:hover{border-color:var(--blue)}
.step-header{background:linear-gradient(135deg,var(--navy-800),var(--navy-700));padding:16px 24px;display:flex;align-items:center;gap:14px}
.step-alpha{width:32px;height:32px;border-radius:50%;background:var(--orange);color:#fff;font-size:14px;font-weight:800;display:grid;place-items:center;flex:0 0 auto;text-transform:uppercase}
.step-alpha.blue{background:var(--blue)}
.step-title{color:#fff;font-weight:700;font-size:16px}
.step-body{padding:24px 28px}
.step-body ol{padding-left:20px;display:flex;flex-direction:column;gap:10px}
.step-body ol li{font-size:14.5px;color:var(--ink-2);line-height:1.6}
.step-body ol li strong{color:var(--ink);font-weight:600}
.step-body .sub-list{list-style:none;padding:0;margin:8px 0 0;display:flex;flex-direction:column;gap:5px}
.step-body .sub-list li{font-size:14px;color:var(--ink-2);padding-left:16px;position:relative;line-height:1.5}
.step-body .sub-list li::before{content:"";position:absolute;left:0;top:8px;width:5px;height:5px;border-radius:50%;background:var(--blue);opacity:.8}
.info-callout{background:var(--blue-50);border:1px solid #bfdbfe;border-radius:10px;padding:12px 16px;margin-top:10px;font-size:13.5px;color:#1e40af}
.warn-callout{background:var(--orange-50);border:1px solid #f3d0b0;border-radius:10px;padding:12px 16px;margin-top:10px;font-size:13.5px;color:#7d3e10}
.timeline{display:flex;flex-direction:column;gap:0;position:relative;padding-left:36px}
.timeline::before{content:"";position:absolute;left:10px;top:14px;bottom:14px;width:2px;background:var(--line-2)}
.tl-item{position:relative;padding-bottom:24px}
.tl-item:last-child{padding-bottom:0}
.tl-dot{position:absolute;left:-30px;top:4px;width:14px;height:14px;border-radius:50%;background:var(--blue);border:2px solid var(--cream);box-shadow:0 0 0 2px var(--blue)}
.tl-dot.orange{background:var(--orange);box-shadow:0 0 0 2px var(--orange)}
.tl-dot.warn{background:var(--warn);box-shadow:0 0 0 2px var(--warn)}
.tl-item p{font-size:14.5px;color:var(--ink-2);line-height:1.6}
.tl-item p strong{color:var(--ink);font-weight:600}
.resert-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.resert{background:#fff;border:1px solid var(--line);border-radius:16px;padding:26px 28px}
.resert h3{display:flex;align-items:center;gap:10px;font-size:18px;margin-bottom:16px}
.resert h3 .ico{width:32px;height:32px;border-radius:9px;display:grid;place-items:center}
.resert h3 .ico.blue{background:var(--blue-50);color:var(--blue-deep)}
.resert h3 .ico.orange{background:var(--orange-50);color:var(--orange-deep)}
.resert-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px}
.resert-list li{font-size:13.5px;color:var(--ink-2);padding-left:16px;position:relative;line-height:1.5}
.resert-list li::before{content:"";position:absolute;left:0;top:8px;width:5px;height:5px;background:var(--orange);border-radius:50%}
.resert .note{margin-top:16px;background:#e8f4ee;border:1px solid #c6e3d3;color:#1f5a37;border-radius:10px;padding:14px 16px;font-size:13.5px;line-height:1.55}
.resert .note b{color:#0f3d24;font-weight:600}
.resert .note.blue-note{background:var(--blue-50);border-color:#bfdbfe;color:#1e40af}
.resert .note.blue-note b{color:#1e3a8a}
@media(max-width:960px){.grid-2,.resert-grid{grid-template-columns:1fr}.cta{grid-template-columns:1fr}}
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">DP.AK.05 Rev. 02 · Informasi Publik</div>
    <h1>Informasi <em>Publik</em></h1>
    <p class="lead">Hak pemohon, kewajiban pemegang sertifikat, proses sertifikasi, pembekuan, resertifikasi, dan penanganan keluhan — LSP Edukasi Global Cendekia.</p>
  </div>
</div>

<section id="hak-kewajiban">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Bagian 4</div>
      <h2>Hak Pemohon &amp; Kewajiban Pemegang Sertifikat</h2>
      <p class="sub">LSP EDUKIA menjamin transparansi, kerahasiaan, dan keadilan dalam setiap proses sertifikasi.</p>
    </div>
    <div class="grid-2">
      <div class="panel">
        <div class="panel-head">
          <div class="ico blue"><svg width="20" height="20"><use href="#i-shield"></use></svg></div>
          <div><h3>Hak Pemohon Sertifikasi</h3><div class="sm">Apa yang Anda dapatkan dari LSP EDUKIA</div></div>
        </div>
        <ol class="num-list blue">
          <li><span class="n">1</span><p>Bagi peserta yang telah memenuhi persyaratan berhak mengikuti proses pra asesmen dan asesmen dengan asesor yang telah ditugaskan oleh LSP Edukia</p></li>
          <li><span class="n">2</span><p>Memperoleh penjelasan tentang gambaran proses sertifikasi sesuai dengan skema sertifikasi</p></li>
          <li><span class="n">3</span><p>Mendapatkan hak bertanya berkaitan dengan kompetensi</p></li>
          <li><span class="n">4</span><p>Memperoleh hak banding atas keputusan sertifikasi</p></li>
          <li><span class="n">5</span><p>Memperoleh hak menyampaikan keluhan terkait pelaksanaan proses sertifikasi</p></li>
          <li><span class="n">6</span><p>Memperoleh jaminan kerahasiaan atas proses sertifikasi</p></li>
          <li><span class="n">7</span><p>Peserta yang dinyatakan <b>kompeten</b> akan memperoleh sertifikat kompetensi</p></li>
          <li><span class="n">8</span><p>Menggunakan sertifikat tersebut sebagai alat bukti keahlian sesuai jenis skema sertifikasinya</p></li>
        </ol>
      </div>
      <div class="panel">
        <div class="panel-head">
          <div class="ico orange"><svg width="20" height="20"><use href="#i-check-list"></use></svg></div>
          <div><h3>Kewajiban Pemegang Sertifikat</h3><div class="sm">Tanggung jawab Anda sebagai profesional bersertifikat</div></div>
        </div>
        <ol class="num-list orange">
          <li><span class="n">1</span><p>Menjamin bahwa sertifikasi kompetensi tidak disalahgunakan</p></li>
          <li><span class="n">2</span><p>Menjamin terpeliharanya kompetensi yang sesuai pada sertifikat kompetensi</p></li>
          <li><span class="n">3</span><p>Menjamin bahwa seluruh pertanyaan dan informasi yang diberikan adalah terbaru, benar dan dapat dipertanggungjawabkan</p></li>
          <li><span class="n">4</span><p>Menjamin mentaati peraturan sertifikat</p></li>
        </ol>
        <div class="callout warn">
          <strong>Pembekuan &amp; pencabutan sertifikat</strong>
          Pelanggaran kewajiban → surat peringatan → pembekuan 3 bulan → pencabutan sertifikat.
        </div>
      </div>
    </div>
  </div>
</section>

<section id="proses-sertifikasi" style="background:#fbf9f3">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Bagian 5</div>
      <h2>Proses Sertifikasi</h2>
      <p class="sub">Empat tahap sertifikasi yang transparan, objektif, dan sesuai standar — dari permohonan hingga penerbitan sertifikat.</p>
    </div>
    <div class="steps">
      <div class="step">
        <div class="step-header"><span class="step-alpha">a</span><span class="step-title">Permohonan Sertifikasi</span></div>
        <div class="step-body">
          <ol>
            <li>Calon Peserta mengisi berkas permohonan asesmen:<ul class="sub-list" style="margin-top:8px"><li>Formulir permohonan sertifikasi <strong>(FR.APL.01)</strong></li><li>Formulir persetujuan asesmen <strong>(FR.AK.01)</strong></li></ul><div class="info-callout">Dapat didownload melalui website LSP Edukasi Global Cendekia atau diberikan oleh admin.</div></li>
            <li>Peserta menyatakan setuju untuk memenuhi persyaratan sertifikasi dan memberikan setiap informasi yang diperlukan untuk penilaian.</li>
            <li>LSP Edukasi melakukan pengkajian terhadap permohonan asesmen. Meninjau ulang rekaman formulir dan dokumen persyaratan sesuai skema yang dipilih.</li>
            <li>Peserta yang memenuhi persyaratan direkomendasikan untuk tindak lanjut asesmen.</li>
          </ol>
        </div>
      </div>
      <div class="step">
        <div class="step-header"><span class="step-alpha">b</span><span class="step-title">Proses Pra Asesmen</span></div>
        <div class="step-body">
          <ol>
            <li>Asesmen direncanakan dan disusun untuk memastikan verifikasi persyaratan skema sertifikasi dilakukan secara objektif dan sistematis.</li>
            <li>LSP Edukia menugaskan asesor kompetensi untuk melaksanakan asesmen.</li>
            <li>Asesor melakukan verifikasi perangkat dan metode asesmen untuk mengonfirmasikan bukti yang akan dikumpulkan.</li>
            <li>Asesor menjelaskan, membahas, dan menyepakati rincian rencana asesmen dengan peserta.</li>
            <li>Asesor melakukan pengkajian kecukupan bukti dari dokumen pendukung pada lampiran APL 02.</li>
            <li>Peserta yang memenuhi persyaratan bukti direkomendasikan untuk mengikuti uji kompetensi.</li>
          </ol>
        </div>
      </div>
      <div class="step">
        <div class="step-header"><span class="step-alpha">c</span><span class="step-title">Pelaksanaan Asesmen / Uji Kompetensi</span></div>
        <div class="step-body">
          <ol>
            <li>Uji kompetensi menggunakan metode:<ul class="sub-list" style="margin-top:8px"><li>Ujian tertulis</li><li>Ujian lisan</li><li>Ujian keterampilan</li><li>Metode lainnya yang andal dan objektif</li></ul></li>
            <li>Bukti dievaluasi untuk memastikan memenuhi aturan: <strong>Valid, Asli, Terkini, Memadai (VATM)</strong>.</li>
            <li>Hasil: <strong>"Kompeten"</strong> atau <strong>"Belum Kompeten"</strong>.</li>
            <li>Asesor menyampaikan rekaman hasil uji kompetensi dan rekomendasi kepada LSP Edukia.</li>
          </ol>
        </div>
      </div>
      <div class="step">
        <div class="step-header"><span class="step-alpha">d</span><span class="step-title">Keputusan Asesmen</span></div>
        <div class="step-body">
          <ol>
            <li>LSP Edukia menjamin informasi yang dikumpulkan mencukupi untuk mengambil keputusan sertifikasi.</li>
            <li>LSP Edukia melakukan rapat verifikasi berkas dan menetapkan status kompetensi.</li>
            <li>Tim asesor membuat keputusan sertifikasi apakah persyaratan telah dipenuhi.</li>
            <li>Keputusan: <strong>lulus</strong> atau <strong>tidak lulus</strong>. Peserta tidak lulus dapat:<ul class="sub-list" style="margin-top:8px"><li><strong>Menerima hasil</strong> — menandatangani surat pernyataan.</li><li><strong>Remedial</strong> — mengikuti jadwal remedial.</li><li><strong>Banding</strong> — mengisi formulir banding FR.AK.04.</li></ul></li>
            <li>LSP Edukia menerbitkan sertifikat kompetensi kepada asesi yang ditetapkan kompeten.</li>
            <li>Sertifikat disahkan oleh Ketua LSP Edukia dengan <strong>masa berlaku 3 (tiga) tahun</strong>.</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="pembekuan">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Bagian 6</div>
      <h2>Pembekuan dan Pencabutan Sertifikat</h2>
      <p class="sub">Mekanisme sanksi bertahap yang diterapkan apabila pemegang sertifikat melanggar kewajiban.</p>
    </div>
    <div class="panel" style="padding:32px 36px">
      <div class="timeline">
        <div class="tl-item"><div class="tl-dot"></div><p><strong>Pembekuan dan pencabutan sertifikat</strong> dilakukan jika pemegang sertifikat melanggar kewajiban.</p></div>
        <div class="tl-item"><div class="tl-dot"></div><p>LSP Edukia melakukan pembekuan dan pencabutan melalui <strong>tahap peringatan terlebih dahulu</strong>.</p></div>
        <div class="tl-item"><div class="tl-dot" style="background:var(--green-ok);box-shadow:0 0 0 2px var(--green-ok)"></div><p>LSP Edukia menerbitkan <strong>surat pengaktifan kembali</strong> setelah tindakan perbaikan dalam <strong>1 bulan</strong> setelah surat peringatan.</p></div>
        <div class="tl-item"><div class="tl-dot orange"></div><p>LSP Edukia menerbitkan <strong>surat pembekuan</strong> jika tidak ada tindakan perbaikan. <strong>Periode pembekuan: 3 bulan</strong> — pemegang sertifikat tidak diperkenankan memanfaatkan sertifikat.</p></div>
        <div class="tl-item"><div class="tl-dot warn"></div><p>LSP Edukia menerbitkan <strong>surat pencabutan sertifikat</strong> jika tindakan perbaikan tidak sesuai. Setelah pencabutan, pemegang sertifikat harus mengembalikan sertifikat.</p></div>
      </div>
    </div>
  </div>
</section>

<section id="resertifikasi" style="background:#fbf9f3">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Bagian 7</div>
      <h2>Proses Resertifikasi</h2>
      <p class="sub">Pemegang sertifikat wajib mengajukan permohonan sertifikasi ulang minimal <strong>2 bulan sebelum masa berlaku berakhir</strong>.</p>
    </div>
    <div class="resert-grid">
      <div class="resert">
        <h3><span class="ico blue"><svg width="18" height="18"><use href="#i-refresh"></use></svg></span>Perpanjangan Sertifikat</h3>
        <p style="font-size:13px;color:var(--muted);margin-bottom:12px">Berlaku untuk skema:</p>
        <ul class="resert-list">
          <li>Auditor Internal SPMI Terintegrasi ISO 21001:2018</li>
          <li>Lead Auditor SPMI Terintegrasi ISO 21001:2018</li>
          <li>Auditor Internal Standar Laboratorium ISO/IEC 17025:2017</li>
        </ul>
        <div class="note blue-note" style="margin-top:18px">
          <b>Persyaratan Portofolio Auditor Internal:</b> Pengalaman audit internal minimal 2 kali dalam 3 tahun terakhir.<br><br>
          <b>Persyaratan Portofolio Lead Auditor:</b> Pengalaman audit internal sebagai Lead auditor minimal 1 kali dalam 3 tahun terakhir.<br><br>
          Jika tidak memenuhi persyaratan, akan diberikan uji kompetensi kembali.
        </div>
      </div>
      <div class="resert">
        <h3><span class="ico orange"><svg width="18" height="18"><use href="#i-doc"></use></svg></span>Uji Kompetensi Kembali</h3>
        <p style="font-size:13px;color:var(--muted);margin-bottom:12px">Berlaku pada semua skema lainnya</p>
        <ul class="resert-list" style="columns:2;gap:8px 16px;display:block">
          <li>Lead Implementer SPMI ISO 21001</li><li>Training of Trainer (ToT) OBE</li><li>Implementer Tata Kelola PT</li><li>Lead Implementer Lab ISO 17025</li><li>Lifting Engineer Medium / Heavy</li><li>2D / 3D Lifting Designer</li><li>Laboratory Quality System Officer</li><li>Food Safety Management Officer</li><li>GLP Laboratory Technician</li><li>Laboratory HSE Officer</li><li>QMS ISO 9001 Officer</li><li>QC Laboratory Analyst</li><li>Quality Assurance Officer</li><li>R&amp;D Officer</li><li>Regulatory Affairs Officer</li><li>Sustainability / ESG Officer</li><li>EMS ISO 14001 Officer</li><li>Corporate Legal Officer</li>
        </ul>
        <div class="note"><b>Catatan:</b> Proses resertifikasi mengikuti prosedur yang sama dengan sertifikasi awal (klausul 5a–5d).</div>
      </div>
    </div>
  </div>
</section>

<section id="keluhan-banding">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Bagian 8</div>
      <h2>Penanganan Keluhan dan Banding</h2>
      <p class="sub">LSP EDUKIA menjamin proses banding dilakukan secara objektif dan tidak memihak.</p>
    </div>
    <div class="steps">
      <div class="step">
        <div class="step-header"><span class="step-alpha blue">i</span><span class="step-title">Hak Pengajuan Keluhan dan Banding</span></div>
        <div class="step-body">
          <p style="font-size:14.5px;color:var(--ink-2);line-height:1.6">LSP Edukia memberikan kesempatan kepada asesi untuk mengajukan keluhan dan banding apabila proses sertifikasi dirasakan tidak sesuai SOP dan prinsip asesmen.</p>
          <div class="warn-callout"><strong>Batas waktu pengajuan:</strong> Maksimal <strong>7 hari</strong> sejak keputusan sertifikasi ditetapkan.</div>
        </div>
      </div>
      <div class="step">
        <div class="step-header"><span class="step-alpha blue">ii</span><span class="step-title">Formulir Keluhan dan Banding</span></div>
        <div class="step-body">
          <p style="font-size:14.5px;color:var(--ink-2);line-height:1.6">Formulir yang digunakan:</p>
          <ul class="sub-list" style="margin-top:10px"><li>Formulir keluhan asesmen: <strong>FR.AK.07</strong></li><li>Formulir banding asesmen: <strong>FR.AK.04</strong></li></ul>
          <div class="info-callout">Formulir dapat didownload melalui website LSP Edukasi Global Cendekia.</div>
        </div>
      </div>
      <div class="step">
        <div class="step-header"><span class="step-alpha blue">iii</span><span class="step-title">Proses Investigasi dan Keputusan</span></div>
        <div class="step-body">
          <ol>
            <li>LSP Edukia membentuk tim investigasi dari personel yang <strong>tidak terlibat</strong> dengan subjek yang dibanding.</li>
            <li>Proses banding dilakukan secara <strong>objektif dan tidak memihak</strong>.</li>
            <li>Keputusan banding dituangkan dalam laporan selambat-lambatnya <strong>14 hari kerja</strong> sejak permohonan diterima.</li>
            <li>Keputusan banding bersifat <strong>mengikat kedua belah pihak</strong>.</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<section style="padding:0 0 96px;border-top:0">
  <div class="wrap">
    <div class="cta">
      <div class="cta-body">
        <h3>Ada pertanyaan tentang proses sertifikasi?</h3>
        <p>Konsultasi GRATIS dengan tim kami — hubungi via WhatsApp sekarang.</p>
      </div>
      <a class="btn btn-primary btn-lg" href="{{ route('home') }}">
        <svg class="icon"><use href="#i-doc"></use></svg> Lihat persyaratan
      </a>
      <a class="wa" href="https://wa.me/6285175479385">
        <svg class="icon" style="color:#7ee0a3"><use href="#i-wa"></use></svg>
        +62 851-7547-9385
      </a>
    </div>
  </div>
</section>
@endsection
