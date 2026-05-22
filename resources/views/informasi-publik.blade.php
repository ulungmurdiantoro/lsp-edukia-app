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

/* Hak & Kewajiban cards */
.hk-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.hk-card{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;padding:28px;position:relative}
.hk-card::before{content:"";position:absolute;top:0;left:0;right:0;height:4px}
.hk-card.blue::before{background:linear-gradient(90deg,var(--blue-deep),var(--blue))}
.hk-card.orange::before{background:linear-gradient(90deg,var(--orange-deep),var(--orange))}
.hk-header{display:flex;align-items:center;gap:14px;margin-bottom:20px}
.hk-icon{width:48px;height:48px;border-radius:12px;display:grid;place-items:center;flex:0 0 auto}
.hk-icon.blue{background:var(--blue-50);color:var(--blue-deep)}
.hk-icon.orange{background:var(--orange-50);color:var(--orange-deep)}
.hk-card h3{font-size:19px;font-weight:700;color:var(--ink);margin:0}
.hk-card .sm{font-size:13px;color:var(--muted);margin-top:3px}
.hk-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px}
.hk-list li{display:grid;grid-template-columns:26px 1fr;gap:12px;align-items:flex-start;font-size:14px;color:var(--ink-2);line-height:1.55}
.hk-num{width:24px;height:24px;border-radius:50%;font-size:11px;font-weight:800;display:grid;place-items:center;flex:0 0 auto;margin-top:1px}
.hk-num.blue{background:var(--navy-800);color:#fff}
.hk-num.orange{background:var(--orange);color:#fff}
.hk-warn{margin-top:20px;padding:16px;background:#fdf3ec;border:1px solid #f3d0b0;border-radius:10px;font-size:13.5px;color:#7d3e10;line-height:1.55}
.hk-warn strong{display:block;margin-bottom:4px;color:#5a2c0c}

/* Proses Sertifikasi — 2-column article */
.proc-steps{display:flex;flex-direction:column;gap:16px}
.proc-article{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;display:grid;grid-template-columns:280px 1fr;min-height:200px}
.proc-left{background:linear-gradient(135deg,var(--navy-800),var(--navy-700));padding:28px;color:#fff;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden}
.proc-left::after{content:"";position:absolute;bottom:-30px;right:-30px;width:140px;height:140px;border-radius:50%;background:radial-gradient(circle,rgba(244,137,31,.18),transparent 70%);pointer-events:none}
.proc-badge{width:44px;height:44px;border-radius:50%;background:var(--orange);color:#fff;font-size:20px;font-weight:800;display:grid;place-items:center;text-transform:uppercase;position:relative;z-index:1}
.proc-meta{position:relative;z-index:1}
.proc-label{font-size:11px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:6px}
.proc-title{font-size:20px;font-weight:700;color:#fff;margin:0;line-height:1.25}
.proc-right{padding:28px 32px}
.proc-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px}
.proc-list li{display:grid;grid-template-columns:22px 1fr;gap:12px;align-items:flex-start;font-size:14.5px;color:var(--ink-2);line-height:1.6}
.proc-num{width:20px;height:20px;border-radius:6px;background:var(--blue-50);color:var(--navy-700);font-size:11px;font-weight:700;display:grid;place-items:center;flex:0 0 auto;margin-top:2px}

/* Timeline (Pembekuan) */
.tl-wrap{background:var(--cream);border:1px solid var(--line);border-radius:16px;padding:36px 40px}
.timeline{display:flex;flex-direction:column;position:relative;padding-left:36px}
.timeline::before{content:"";position:absolute;left:10px;top:14px;bottom:14px;width:2px;background:var(--line-2)}
.tl-item{position:relative;padding-bottom:26px}
.tl-item:last-child{padding-bottom:0}
.tl-dot{position:absolute;left:-30px;top:4px;width:14px;height:14px;border-radius:50%;background:var(--blue);border:2px solid var(--cream);box-shadow:0 0 0 2px var(--blue)}
.tl-dot.green{background:var(--green-ok);box-shadow:0 0 0 2px var(--green-ok)}
.tl-dot.orange{background:var(--orange);box-shadow:0 0 0 2px var(--orange)}
.tl-dot.warn{background:var(--warn);box-shadow:0 0 0 2px var(--warn)}
.tl-item p{font-size:15px;color:var(--ink-2);line-height:1.65;margin:0}
.tl-item p strong{color:var(--ink);font-weight:600}

/* Resertifikasi */
.resert-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.resert-card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:28px;display:flex;flex-direction:column}
.resert-header{display:flex;align-items:center;gap:12px;margin-bottom:18px}
.resert-icon{width:44px;height:44px;border-radius:12px;display:grid;place-items:center;flex:0 0 auto}
.resert-icon.blue{background:var(--blue-50);color:var(--blue-deep)}
.resert-icon.orange{background:var(--orange-50);color:var(--orange-deep)}
.resert-card h3{font-size:19px;font-weight:700;color:var(--ink);margin:0}
.resert-sublabel{font-size:11.5px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);margin-bottom:10px}
.resert-list{list-style:none;padding:0;margin:0;flex:1;display:flex;flex-direction:column;gap:6px}
.resert-list li{display:flex;gap:10px;align-items:flex-start;font-size:13.5px;color:var(--ink-2);line-height:1.5}
.resert-dot{width:5px;height:5px;border-radius:50%;flex:0 0 auto;margin-top:8px}
.resert-note{margin-top:18px;padding:14px;border-radius:10px;font-size:13px;line-height:1.55}
.resert-note.blue{background:var(--blue-50);color:#1e40af}
.resert-note.blue strong{color:#1e3a8a;display:block;margin-bottom:4px}
.resert-note.green{background:#e8f4ee;border:1px solid #c6e3d3;color:#1f5a37}
.resert-note.green strong{color:#0f3d24;display:block;margin-bottom:4px}

/* Keluhan & Banding — 3-column grid */
.kb-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.kb-card{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;display:flex;flex-direction:column}
.kb-header{padding:18px 22px;background:linear-gradient(135deg,var(--navy-800),var(--navy-700));display:flex;align-items:center;gap:12px}
.kb-badge{width:32px;height:32px;border-radius:50%;background:var(--blue);color:#fff;font-size:13px;font-weight:800;display:grid;place-items:center;font-family:ui-monospace,monospace;flex:0 0 auto}
.kb-title{color:#fff;font-size:15px;font-weight:700;margin:0;line-height:1.3}
.kb-body{padding:22px 24px;flex:1;display:flex;flex-direction:column;gap:14px}
.kb-body p{font-size:14px;color:var(--ink-2);line-height:1.6;margin:0}
.kb-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px}
.kb-list li{display:flex;gap:10px;align-items:flex-start;font-size:13.5px;color:var(--ink-2);line-height:1.55}
.kb-check{color:var(--blue-deep);flex:0 0 auto;margin-top:2px}
.kb-note{margin-top:auto;padding:12px;border-radius:8px;font-size:12.5px;line-height:1.5}
.kb-note.warn{background:#fdf3ec;border:1px solid #f3d0b0;color:#7d3e10}
.kb-note.info{background:var(--blue-50);border:1px solid #bfdbfe;color:#1e40af}
.kb-note strong{display:block;margin-bottom:2px}

@media(max-width:960px){
  .hk-grid,.resert-grid{grid-template-columns:1fr}
  .proc-article{grid-template-columns:1fr}
  .kb-grid{grid-template-columns:1fr}
  .cta{grid-template-columns:1fr}
}
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

{{-- HAK & KEWAJIBAN --}}
<section id="hak-kewajiban">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Hak &amp; Kewajiban</div>
      <h2>Hak Pemohon &amp; Kewajiban Pemegang Sertifikat</h2>
      <p class="sub">LSP EDUKIA menjamin transparansi, kerahasiaan, dan keadilan dalam setiap proses sertifikasi.</p>
    </div>
    <div class="hk-grid">
      {{-- Hak --}}
      <div class="hk-card blue">
        <div class="hk-header">
          <div class="hk-icon blue">
            <svg width="24" height="24"><use href="#i-shield"></use></svg>
          </div>
          <div>
            <h3>Hak Pemohon Sertifikasi</h3>
            <div class="sm">Apa yang Anda dapatkan dari LSP EDUKIA</div>
          </div>
        </div>
        <ol class="hk-list">
          @foreach([
            'Berhak mengikuti pra-asesmen dan asesmen dengan asesor yang ditugaskan LSP Edukia.',
            'Memperoleh penjelasan tentang proses sertifikasi sesuai dengan skema.',
            'Hak bertanya berkaitan dengan kompetensi.',
            'Hak banding atas keputusan sertifikasi.',
            'Hak menyampaikan keluhan terkait pelaksanaan proses sertifikasi.',
            'Jaminan kerahasiaan atas proses sertifikasi.',
            'Peserta kompeten memperoleh sertifikat kompetensi.',
            'Sertifikat menjadi alat bukti keahlian sesuai jenis skema.',
          ] as $i => $item)
          <li>
            <span class="hk-num blue">{{ $i + 1 }}</span>
            <span>{{ $item }}</span>
          </li>
          @endforeach
        </ol>
      </div>
      {{-- Kewajiban --}}
      <div class="hk-card orange">
        <div class="hk-header">
          <div class="hk-icon orange">
            <svg width="24" height="24"><use href="#i-check-list"></use></svg>
          </div>
          <div>
            <h3>Kewajiban Pemegang Sertifikat</h3>
            <div class="sm">Tanggung jawab Anda sebagai profesional bersertifikat</div>
          </div>
        </div>
        <ol class="hk-list">
          @foreach([
            'Menjamin sertifikasi kompetensi tidak disalahgunakan.',
            'Menjamin terpeliharanya kompetensi sesuai sertifikat.',
            'Menjamin pertanyaan dan informasi yang diberikan terbaru, benar, dan dapat dipertanggungjawabkan.',
            'Menjamin mentaati peraturan sertifikat.',
          ] as $i => $item)
          <li>
            <span class="hk-num orange">{{ $i + 1 }}</span>
            <span>{{ $item }}</span>
          </li>
          @endforeach
        </ol>
        <div class="hk-warn">
          <strong>Pembekuan &amp; pencabutan sertifikat</strong>
          Pelanggaran kewajiban → surat peringatan → pembekuan 3 bulan → pencabutan sertifikat.
        </div>
      </div>
    </div>
  </div>
</section>

{{-- PROSES SERTIFIKASI --}}
<section id="proses-sertifikasi" style="background:#fbf9f3">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Proses Sertifikasi</div>
      <h2>Proses Sertifikasi</h2>
      <p class="sub">Empat tahap sertifikasi yang transparan, objektif, dan sesuai standar — dari permohonan hingga penerbitan sertifikat.</p>
    </div>
    <div class="proc-steps">
      @php
      $procSteps = [
        ['icon'=>'doc','title'=>'Permohonan Sertifikasi','items'=>[
          'Calon peserta mengisi berkas FR.APL.01 dan FR.AK.01.',
          'Peserta menyatakan setuju memenuhi persyaratan dan memberikan informasi yang diperlukan.',
          'LSP Edukia melakukan pengkajian terhadap permohonan asesmen.',
          'Peserta yang memenuhi syarat direkomendasikan untuk tindak lanjut asesmen.',
        ]],
        ['icon'=>'check-list','title'=>'Proses Pra Asesmen','items'=>[
          'Asesmen direncanakan untuk memastikan verifikasi objektif dan sistematis.',
          'LSP Edukia menugaskan asesor kompetensi.',
          'Asesor melakukan verifikasi perangkat dan metode asesmen.',
          'Asesor menjelaskan dan menyepakati rencana asesmen dengan peserta.',
          'Pengkajian kecukupan bukti dari dokumen pendukung (APL 02).',
        ]],
        ['icon'=>'monitor','title'=>'Pelaksanaan Asesmen / Uji Kompetensi','items'=>[
          'Metode: ujian tertulis, lisan, keterampilan, atau metode lain yang andal.',
          'Bukti dievaluasi: Valid, Asli, Terkini, Memadai (VATM).',
          'Hasil: "Kompeten" atau "Belum Kompeten".',
          'Asesor menyampaikan rekaman hasil dan rekomendasi kepada LSP Edukia.',
        ]],
        ['icon'=>'award','title'=>'Keputusan Asesmen','items'=>[
          'LSP Edukia melakukan rapat verifikasi berkas dan menetapkan status kompetensi.',
          'Tim asesor membuat keputusan sertifikasi.',
          'Peserta tidak lulus dapat: menerima hasil · remedial · banding (FR.AK.04).',
          'Sertifikat disahkan Ketua LSP Edukia dengan masa berlaku 3 tahun.',
        ]],
      ];
      @endphp
      @foreach($procSteps as $idx => $step)
      <article class="proc-article">
        <div class="proc-left">
          <div class="proc-badge"><svg width="22" height="22"><use href="#i-{{ $step['icon'] }}"></use></svg></div>
          <div class="proc-meta">
            <div class="proc-label">Tahap {{ $idx + 1 }} dari 4</div>
            <h3 class="proc-title">{{ $step['title'] }}</h3>
          </div>
        </div>
        <div class="proc-right">
          <ol class="proc-list">
            @foreach($step['items'] as $j => $item)
            <li>
              <span class="proc-num">{{ $j + 1 }}</span>
              <span>{{ $item }}</span>
            </li>
            @endforeach
          </ol>
        </div>
      </article>
      @endforeach
    </div>
  </div>
</section>

{{-- PEMBEKUAN & PENCABUTAN --}}
<section id="pembekuan">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Pembekuan dan Pencabutan</div>
      <h2>Pembekuan dan Pencabutan Sertifikat</h2>
      <p class="sub">Mekanisme sanksi bertahap yang diterapkan apabila pemegang sertifikat melanggar kewajiban.</p>
    </div>
    <div class="tl-wrap">
      <div class="timeline">
        <div class="tl-item"><div class="tl-dot"></div><p><strong>Pembekuan dan pencabutan sertifikat</strong> dilakukan jika pemegang sertifikat melanggar kewajiban.</p></div>
        <div class="tl-item"><div class="tl-dot"></div><p>LSP Edukia melakukan pembekuan dan pencabutan melalui <strong>tahap peringatan terlebih dahulu</strong>.</p></div>
        <div class="tl-item"><div class="tl-dot green"></div><p>LSP Edukia menerbitkan <strong>surat pengaktifan kembali</strong> setelah tindakan perbaikan dalam <strong>1 bulan</strong> setelah surat peringatan.</p></div>
        <div class="tl-item"><div class="tl-dot orange"></div><p>LSP Edukia menerbitkan <strong>surat pembekuan</strong> jika tidak ada perbaikan. Periode: <strong>3 bulan</strong> — sertifikat tidak boleh digunakan.</p></div>
        <div class="tl-item"><div class="tl-dot warn"></div><p>LSP Edukia menerbitkan <strong>surat pencabutan sertifikat</strong> jika perbaikan tidak sesuai. Pemegang harus mengembalikan sertifikat.</p></div>
      </div>
    </div>
  </div>
</section>

{{-- RESERTIFIKASI --}}
<section id="resertifikasi" style="background:#fbf9f3">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Proses Resertifikasi</div>
      <h2>Proses Resertifikasi</h2>
      <p class="sub">Pemegang sertifikat wajib mengajukan permohonan sertifikasi ulang minimal <strong>2 bulan sebelum masa berlaku berakhir</strong>.</p>
    </div>
    <div class="resert-grid">
      <div class="resert-card">
        <div class="resert-header">
          <div class="resert-icon blue">
            <svg width="22" height="22"><use href="#i-refresh"></use></svg>
          </div>
          <h3>Perpanjangan Sertifikat</h3>
        </div>
        <div class="resert-sublabel">Berlaku untuk</div>
        <ul class="resert-list">
          @foreach(['Auditor Internal SPMI Terintegrasi ISO 21001:2018','Lead Auditor SPMI Terintegrasi ISO 21001:2018','Auditor Internal Standar Laboratorium ISO/IEC 17025:2017'] as $s)
          <li><span class="resert-dot" style="background:var(--blue-deep)"></span><span>{{ $s }}</span></li>
          @endforeach
        </ul>
        <div class="resert-note blue">
          <strong>Persyaratan Portofolio:</strong>
          Auditor Internal — pengalaman audit min. 2 kali dalam 3 tahun. Lead Auditor — sebagai Lead minimal 1 kali dalam 3 tahun. Jika tidak memenuhi, akan diberikan uji kompetensi kembali.
        </div>
      </div>
      <div class="resert-card">
        <div class="resert-header">
          <div class="resert-icon orange">
            <svg width="22" height="22"><use href="#i-doc"></use></svg>
          </div>
          <h3>Uji Kompetensi Kembali</h3>
        </div>
        <div class="resert-sublabel">Berlaku untuk</div>
        <ul class="resert-list">
          @foreach(['Lead Implementer SPMI ISO 21001','Training of Trainer (ToT) OBE','Implementer Tata Kelola PT','Lead Implementer Lab ISO 17025','Lifting Engineer Medium / Heavy','2D / 3D Lifting Designer','Lab Quality / Food Safety / GLP / HSE / Operations','QMS ISO 9001 / QC / QA / R&D / Regulatory','Sustainability / ESG / EMS ISO 14001','Corporate Legal Officer'] as $s)
          <li><span class="resert-dot" style="background:var(--orange-deep)"></span><span>{{ $s }}</span></li>
          @endforeach
        </ul>
        <div class="resert-note green">
          <strong>Catatan:</strong>
          Proses resertifikasi mengikuti prosedur yang sama dengan sertifikasi awal (klausul 5a–5d).
        </div>
      </div>
    </div>
  </div>
</section>

{{-- KELUHAN & BANDING --}}
<section id="keluhan-banding">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Keluhan dan Banding</div>
      <h2>Penanganan Keluhan dan Banding</h2>
      <p class="sub">LSP EDUKIA menjamin proses banding dilakukan secara objektif dan tidak memihak.</p>
    </div>
    <div class="kb-grid">
      <article class="kb-card">
        <div class="kb-header">
          <div class="kb-badge">i</div>
          <h3 class="kb-title">Hak Pengajuan Keluhan dan Banding</h3>
        </div>
        <div class="kb-body">
          <p>LSP Edukia memberikan kesempatan kepada asesi untuk mengajukan keluhan dan banding apabila proses sertifikasi dirasakan tidak sesuai SOP.</p>
          <div class="kb-note warn">
            <strong>Batas waktu:</strong>
            Maksimal 7 hari sejak keputusan sertifikasi ditetapkan.
          </div>
        </div>
      </article>
      <article class="kb-card">
        <div class="kb-header">
          <div class="kb-badge">ii</div>
          <h3 class="kb-title">Formulir Keluhan dan Banding</h3>
        </div>
        <div class="kb-body">
          <p>Formulir yang digunakan:</p>
          <ul class="kb-list">
            <li>
              <svg class="kb-check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5L20 6"/></svg>
              <span>Formulir keluhan asesmen: <strong>FR.AK.07</strong></span>
            </li>
            <li>
              <svg class="kb-check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5L20 6"/></svg>
              <span>Formulir banding asesmen: <strong>FR.AK.04</strong></span>
            </li>
          </ul>
          <div class="kb-note info">
            <strong>Akses formulir:</strong>
            Dapat diunduh melalui website LSP Edukia.
          </div>
        </div>
      </article>
      <article class="kb-card">
        <div class="kb-header">
          <div class="kb-badge">iii</div>
          <h3 class="kb-title">Proses Investigasi dan Keputusan</h3>
        </div>
        <div class="kb-body">
          <ul class="kb-list">
            @foreach([
              'LSP Edukia membentuk tim investigasi dari personel yang tidak terlibat dengan subjek banding.',
              'Proses banding dilakukan secara objektif dan tidak memihak.',
              'Keputusan dituangkan dalam laporan selambat-lambatnya 14 hari kerja sejak permohonan.',
              'Keputusan banding bersifat mengikat kedua belah pihak.',
            ] as $item)
            <li>
              <svg class="kb-check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5L20 6"/></svg>
              <span>{{ $item }}</span>
            </li>
            @endforeach
          </ul>
        </div>
      </article>
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
