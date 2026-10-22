@extends('layouts.app')
{{-- Meta dikelola via $SEOData dari PageController@informasi (ralphjsmit/laravel-seo). --}}

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
.resert-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;align-items:start}
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

/* Kriteria TUK Offline & Online */
.tuk-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;align-items:start}
.tuk-card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:28px;display:flex;flex-direction:column}
.tuk-header{display:flex;align-items:center;gap:14px;margin-bottom:22px}
.tuk-icon{width:48px;height:48px;border-radius:12px;display:grid;place-items:center;flex:0 0 auto}
.tuk-icon.blue{background:var(--blue-50);color:var(--blue-deep)}
.tuk-icon.orange{background:var(--orange-50);color:var(--orange-deep)}
.tuk-card h3{font-size:19px;font-weight:700;color:var(--ink);margin:0}
.tuk-card .sm{font-size:13px;color:var(--muted);margin-top:3px}
.tuk-group{margin-top:20px}
.tuk-group:first-of-type{margin-top:0}
.tuk-group-label{font-size:12px;font-weight:700;color:var(--ink);padding-bottom:8px;margin-bottom:10px;border-bottom:1px dashed var(--line-2)}
.tuk-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px}
.tuk-list li{display:flex;gap:9px;align-items:flex-start;font-size:13.5px;color:var(--ink-2);line-height:1.55}
.tuk-dot{width:5px;height:5px;border-radius:50%;flex:0 0 auto;margin-top:8px}
.tuk-intro{display:flex;flex-direction:column;gap:12px;margin-top:14px}
.tuk-no{font-size:11.5px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);margin-bottom:2px}
.tuk-desc{font-size:14px;color:var(--ink-2);line-height:1.6;margin:0 0 12px}
.tuk-ref{margin-top:18px;padding:12px 14px;border-radius:10px;background:var(--cream);border:1px solid var(--line);font-size:12.5px;color:var(--muted);line-height:1.55}
.tuk-card .kb-dl{margin-top:14px}
.tuk-block{margin-top:18px;background:#fff;border:1px solid var(--line);border-radius:16px;padding:28px}
.tuk-block h3{font-size:19px;font-weight:700;color:var(--ink);margin:0 0 14px}
.tuk-block p{font-size:14.5px;color:var(--ink-2);line-height:1.65;margin:0 0 12px}
.tuk-block p:last-child{margin-bottom:0}
.tuk-verif{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin:4px 0 16px}
.tuk-verif-item{padding:16px 18px;border-radius:12px;background:var(--navy-50);font-size:14px;color:var(--ink-2);line-height:1.6}
.tuk-verif-item strong{display:block;color:var(--navy-800);margin-bottom:4px}
.tuk-result{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin:12px 0 16px}
.tuk-result-item{padding:18px;border-radius:12px;font-size:14px;line-height:1.6}
.tuk-result-item strong{display:inline-block;font-size:12px;letter-spacing:0.08em;padding:3px 10px;border-radius:999px;margin-bottom:8px;color:#fff}
.tuk-result-item.ok{background:#e8f4ee;border:1px solid #c6e3d3;color:#1f5a37}
.tuk-result-item.ok strong{background:var(--green-ok)}
.tuk-result-item.no{background:#fdf0ee;border:1px solid #f3cfc5;color:#7a2e1c}
.tuk-result-item.no strong{background:var(--warn)}

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
.kb-dl-list{display:flex;flex-direction:column;gap:10px}
.kb-dl{display:grid;grid-template-columns:36px 1fr;gap:12px;align-items:center;padding:12px 14px;border:1px solid var(--line);border-radius:10px;background:var(--blue-50);color:var(--navy-800);font-size:13.5px;line-height:1.45;transition:all .15s}
.kb-dl svg{width:36px;height:36px;padding:9px;border-radius:8px;background:var(--navy-800);color:#fff}
.kb-dl strong{color:var(--navy-800);margin-right:4px}
.kb-dl small{display:block;font-size:11.5px;color:var(--muted);margin-top:2px}
.kb-dl:hover{border-color:var(--blue);transform:translateY(-1px)}

/* Proses — tautan tindak lanjut & daftar akomodasi */
.proc-link{display:inline-flex;align-items:center;gap:6px;margin-top:16px;font-size:14px;font-weight:600;color:var(--blue-deep)}
.proc-link:hover{color:var(--navy-800)}
.ak-list{display:grid;grid-template-columns:1fr 1fr;gap:12px 32px}

@media(max-width:960px){
  .hk-grid,.resert-grid,.tuk-grid,.tuk-verif,.tuk-result,.ak-list{grid-template-columns:1fr}
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
    <p class="lead">Hak pemohon, kewajiban pemegang sertifikat, proses sertifikasi, akomodasi peserta berkebutuhan khusus, pembekuan, resertifikasi, dan penanganan keluhan — LSP Edukasi Global Cendekia.</p>
    <a class="btn btn-primary btn-lg" href="{{ asset('downloads/DP.AK.05 Panduan Uji Kompetensi R2.pdf') }}" target="_blank" rel="noopener" style="margin-top:26px">
      <svg class="icon" width="20" height="20"><use href="#i-download"></use></svg> Unduh Dokumen DP.AK.05
    </a>
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
      <p class="sub">Tiga tahap sertifikasi yang transparan, objektif, dan sesuai standar — dari permohonan hingga penerbitan sertifikat.</p>
    </div>
    <div class="proc-steps">
      @php
      $procSteps = [
        ['icon'=>'doc','title'=>'Permohonan Sertifikasi','items'=>[
          'Pemohon mengisi formulir permohonan sertifikasi (FR.APL.01) dan formulir persetujuan asesmen (FR.AK.01) melalui sistem pendaftaran LSP.',
          'Pemohon dengan kebutuhan khusus wajib mengisi Formulir Permohonan Akomodasi Peserta Berkebutuhan Khusus (FR.APL.04).',
          'Pemohon menyatakan setuju memenuhi persyaratan sertifikasi dan memberikan informasi yang diperlukan untuk pengkajian permohonan.',
          'Pengkaji Permohonan meninjau rekaman formulir dan dokumen persyaratan sesuai skema sertifikasi yang dipilih.',
          'Pemohon yang memenuhi persyaratan direkomendasikan lanjut ke proses asesmen setelah menyelesaikan administrasi pembayaran.',
        ], 'link'=>['url'=>config('site.pendaftaran_url'),'label'=>'Buka sistem pendaftaran']],
        ['icon'=>'monitor','title'=>'Pelaksanaan Asesmen','items'=>[
          'Uji kompetensi dapat dilaksanakan secara Offline (tatap muka di Tempat Uji Kompetensi/TUK yang telah diverifikasi LSP) maupun Online (melalui Zoom Meeting & sistem ujian daring dengan pengawasan langsung), sesuai metode yang ditetapkan pada jadwal skema yang dipilih.',
          'LSP Edukia memastikan kesiapan TUK/platform ujian, perangkat asesmen, identitas peserta, dan metode pengumpulan bukti.',
          'Pengawas ujian menjelaskan teknis dan tata tertib ujian, memverifikasi identitas dan TUK peserta, serta mencatat kejadian/ketidaksesuaian selama ujian.',
          'Peserta melaksanakan ujian sesuai skema yang dipilih di bawah pengawasan pengawas ujian.',
          'Uji kompetensi menggunakan metode ujian tertulis, lisan, praktek, tugas keterampilan, atau metode lain yang andal, objektif, dan konsisten dengan skema sertifikasi.',
          'Asesor mengompilasi seluruh bukti dan hasil ujian, lalu menyampaikan rekomendasi hasil asesmen kepada LSP Edukia.',
        ]],
        ['icon'=>'award','title'=>'Keputusan Asesmen','items'=>[
          'LSP Edukia memastikan informasi yang dikumpulkan selama uji kompetensi mencukupi untuk pengambilan keputusan sertifikasi dan penelusuran apabila terjadi banding.',
          'Pengambil keputusan sertifikasi memverifikasi berkas peserta, rekaman hasil ujian, dan rekomendasi asesor untuk menetapkan status kompetensi.',
          'Hasil keputusan: "Kompeten" atau "Belum Kompeten". Peserta Belum Kompeten dapat memilih: menerima hasil apa adanya · remedial · banding (FR.AK.04).',
          'LSP Edukia menerbitkan sertifikat kompetensi kepada peserta yang ditetapkan kompeten.',
          'Sertifikat disahkan Ketua LSP Edukia dengan masa berlaku 3 (tiga) tahun.',
        ]],
      ];
      @endphp
      @foreach($procSteps as $idx => $step)
      <article class="proc-article">
        <div class="proc-left">
          <div class="proc-badge"><svg width="22" height="22"><use href="#i-{{ $step['icon'] }}"></use></svg></div>
          <div class="proc-meta">
            <div class="proc-label">Tahap {{ $idx + 1 }} dari {{ count($procSteps) }}</div>
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
          @if(!empty($step['link']))
          <a class="proc-link" href="{{ $step['link']['url'] }}" target="_blank" rel="noopener">
            {{ $step['link']['label'] }} <svg width="14" height="14"><use href="#i-arrow-r"></use></svg>
          </a>
          @endif
        </div>
      </article>
      @endforeach
    </div>

    {{-- Kemampuan (ability) peserta — ketentuan pemohon/peserta berkebutuhan khusus --}}
    <div id="berkebutuhan-khusus" class="hk-card blue" style="margin-top:28px">
      <div class="hk-header">
        <div class="hk-icon blue">
          <svg width="24" height="24"><use href="#i-shield"></use></svg>
        </div>
        <div>
          <h3>Pemohon / Peserta Berkebutuhan Khusus</h3>
          <div class="sm">Akomodasi diajukan saat permohonan melalui formulir FR.APL.04</div>
        </div>
      </div>
      <ol class="hk-list ak-list">
        @foreach([
          'LSP Edukia memberikan kesempatan yang setara kepada pemohon/peserta berkebutuhan khusus untuk mengikuti sertifikasi.',
          'Pemohon yang membutuhkan akomodasi menyampaikan kebutuhan penyesuaian pada saat permohonan sertifikasi (FR.APL.04).',
          'LSP mengkaji kebutuhan tersebut dengan mempertimbangkan persyaratan kompetensi, elemen/KUK, aspek kritis, metode asesmen, aksesibilitas TUK, keselamatan, dan ketersediaan akomodasi.',
          'Akomodasi dapat berupa penyesuaian akses TUK, media asesmen, tambahan waktu yang proporsional, perangkat bantu, media komunikasi, waktu istirahat, atau penyesuaian lain yang relevan.',
          'Akomodasi tidak mengubah kompetensi yang dinilai, aspek kritis, tingkat kesulitan, dan kriteria kelulusan, serta tidak mengurangi validitas, objektivitas, keamanan, dan integritas asesmen.',
          'Untuk kompetensi dengan tuntutan teknis, sensorik, atau keselamatan tertentu, kemampuan peserta memenuhi tuntutan esensial dinilai berdasarkan persyaratan kompetensi skema dengan mempertimbangkan akomodasi yang tersedia.',
          'Bila kebutuhan tidak dapat difasilitasi tanpa menghilangkan kompetensi esensial atau menimbulkan risiko keselamatan yang tidak dapat dikendalikan, LSP mendokumentasikan hasil kajian, alasan, dan alternatif akomodasi yang dipertimbangkan, lalu menginformasikannya kepada pemohon.',
          'Seluruh informasi kebutuhan khusus peserta dijaga kerahasiaannya dan hanya digunakan untuk penentuan akomodasi serta pelaksanaan sertifikasi.',
        ] as $i => $item)
        <li>
          <span class="hk-num blue">{{ $i + 1 }}</span>
          <span>{{ $item }}</span>
        </li>
        @endforeach
      </ol>
    </div>
  </div>
</section>

{{-- TEMPAT UJI KOMPETENSI (TUK) — teks dari dokumen "Tempat Uji Kompetensi" (SOP.SM.21) --}}
<section id="kriteria-tuk">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Tempat Uji Kompetensi</div>
      <h2>Tempat Uji Kompetensi (TUK)</h2>
      <div class="tuk-intro">
        <p class="sub">Pelaksanaan asesmen LSP Edukasi Global Cendekia (Edukia) dilaksanakan secara online dan offline pada Tempat Uji Kompetensi (TUK) yang telah diverifikasi oleh LSP Edukasi Global Cendekia dan dinyatakan memenuhi persyaratan sesuai dengan metode asesmen yang digunakan.</p>
        <p class="sub">TUK dapat berupa TUK Offline/Fisik dan/atau TUK Online, dengan mempertimbangkan karakteristik kompetensi yang dinilai, metode asesmen, kebutuhan sarana dan prasarana, keamanan, kerahasiaan, serta kemampuan LSP dalam menjamin validitas, objektivitas, dan integritas pelaksanaan asesmen.</p>
      </div>
    </div>
    @php
    $tukJenis = [
      'offline' => [
        'title' => '1. TUK Offline/Fisik',
        'icon' => 'pin',
        'tone' => 'blue',
        'desc' => [
          'TUK Offline/Fisik digunakan untuk pelaksanaan asesmen secara tatap muka pada lokasi yang telah diverifikasi oleh LSP. TUK harus memiliki identitas lokasi dan penanggung jawab yang jelas serta memperoleh persetujuan untuk digunakan sebagai tempat pelaksanaan asesmen.',
        ],
        'label' => 'TUK Offline/Fisik harus memenuhi persyaratan berikut:',
        'items' => [
          'Ruang dan kondisi lingkungan yang memadai sesuai jumlah peserta dan metode asesmen;',
          'Pencahayaan, ventilasi, kebersihan, ketenangan, privasi, dan tata letak yang mendukung pelaksanaan asesmen;',
          'Meja, kursi, komputer, jaringan internet, peralatan, bahan dan/atau sarana khusus yang dipersyaratkan dalam skema dan metode asesmen;',
          'Sumber listrik dan fasilitas pendukung yang berfungsi dengan baik;',
          'Keamanan dan pengendalian akses selama pelaksanaan asesmen;',
          'Perlindungan terhadap materi ujian, dokumen peserta, dan rekaman asesmen dari akses pihak yang tidak berwenang;',
          'Fasilitas keselamatan dan kondisi kedaruratan yang sesuai dengan karakteristik lokasi;',
          'Fasilitas yang memungkinkan asesor dan pengawas ujian menjalankan tugasnya;',
          'Pengaturan bagi peserta berkebutuhan khusus apabila diperlukan dan dapat difasilitasi tanpa mengubah kompetensi yang dinilai; dan',
          'Kapasitas TUK yang sesuai dengan jumlah peserta dan sarana yang tersedia.',
        ],
        'ref' => 'Persyaratan tersebut sesuai dengan pengaturan TUK Offline dalam SOP.SM.21. Verifikasi Tempat Uji Kompetensi (TUK) dan FR.TUK.02 Checklist Verifikasi TUK Offline/Fisik.',
        'form' => [
          'kode' => 'FR.TUK.02',
          'nama' => 'Checklist Verifikasi TUK Offline/Fisik',
          'ket' => 'Rev.04 · PDF',
          'file' => 'downloads/FR.TUK.02 Checklist Verifikasi TUK Offline R4.pdf',
        ],
      ],
      'online' => [
        'title' => '2. TUK Online',
        'icon' => 'monitor',
        'tone' => 'orange',
        'desc' => [
          'TUK Online digunakan untuk pelaksanaan asesmen jarak jauh melalui sarana teknologi informasi dan komunikasi yang ditetapkan oleh LSP. TUK Online dapat berupa lokasi yang disediakan oleh lembaga pelatihan/organisasi maupun lokasi individual peserta seperti tempat tinggal atau kantor asesi, sepanjang lokasi tersebut memenuhi seluruh persyaratan yang ditetapkan LSP.',
          'Apabila asesmen dilakukan dari tempat tinggal atau kantor asesi, lokasi tersebut diperlakukan sebagai lingkungan asesmen dan wajib diverifikasi sebelum asesmen dimulai.',
        ],
        'label' => 'TUK Online harus memenuhi persyaratan berikut:',
        'items' => [
          'Peserta menggunakan ruang atau area yang tenang, cukup terang, kondusif, dan memungkinkan asesmen dilakukan tanpa gangguan yang dapat memengaruhi hasil asesmen;',
          'Peserta mengikuti asesmen secara individual dan tidak memperoleh bantuan dari pihak lain;',
          'Tidak terdapat pihak lain, materi, perangkat, atau alat bantu yang tidak diizinkan pada area asesmen;',
          'Peserta bersedia menunjukkan kondisi ruangan dan area kerja melalui kamera apabila diminta oleh pengawas ujian;',
          'Tersedia komputer atau laptop yang dapat menjalankan aplikasi pertemuan daring dan sistem ujian LSP;',
          'Kamera/webcam, mikrofon, speaker/audio, dan perangkat pendukung lainnya berfungsi dengan baik;',
          'Tersedia device tambahan (tab/HP/laptop) dengan kamera yang jelas dan dapat diarahkan untuk verifikasi area sekitar selama pelaksanaan ujian berlangsung dan tetap aktif selama asesmen sesuai ketentuan metode asesmen;',
          'Tersedia sumber listrik yang memadai dan perangkat dapat digunakan selama keseluruhan proses asesmen;',
          'Tersedia koneksi internet yang memadai untuk menjalankan sistem asesmen dan komunikasi daring secara bersamaan;',
          'Peserta dapat mengakses Zoom Meeting dan/atau sistem ujian yang ditetapkan LSP;',
          'Identitas peserta dapat diverifikasi dan sesuai dengan daftar peserta;',
          'Tersedia mekanisme komunikasi dengan pengawas ujian apabila terjadi gangguan teknis atau koneksi;',
          'Peserta tidak diperkenankan merekam, memotret, menyalin, atau menyebarluaskan materi ujian;',
          'Peserta tidak diperkenankan membuka aplikasi, situs, komunikasi, atau sumber informasi yang tidak diizinkan; dan',
          'Kondisi peserta dan lingkungan asesmen dapat dipantau secara memadai oleh pengawas ujian selama proses asesmen.',
        ],
        'ref' => 'SOP.SM.21 telah menetapkan persyaratan lingkungan, perangkat, koneksi, identifikasi, keamanan, integritas, dan pengawasan untuk TUK Online dalam SOP.SM.21. Verifikasi Tempat Uji Kompetensi (TUK) dan FR.TUK.06 Checklist Verifikasi TUK Online.',
        'form' => [
          'kode' => 'FR.TUK.06',
          'nama' => 'Checklist Verifikasi TUK Online',
          'ket' => 'Rev.1 · PDF',
          'file' => 'downloads/FR.TUK.06 Checklist Verifikasi TUK Online LSP Edukia R1.pdf',
        ],
      ],
    ];
    @endphp
    <div class="tuk-grid">
      @foreach($tukJenis as $tuk)
      <div class="tuk-card">
        <div class="tuk-header">
          <div class="tuk-icon {{ $tuk['tone'] }}">
            <svg width="24" height="24"><use href="#i-{{ $tuk['icon'] }}"></use></svg>
          </div>
          <h3>{{ $tuk['title'] }}</h3>
        </div>
        @foreach($tuk['desc'] as $paragraf)
        <p class="tuk-desc">{{ $paragraf }}</p>
        @endforeach
        <div class="tuk-group">
          <div class="tuk-group-label">{{ $tuk['label'] }}</div>
          <ul class="tuk-list">
            @foreach($tuk['items'] as $item)
            <li><span class="tuk-dot" style="background:var(--{{ $tuk['tone'] }}-deep)"></span><span>{{ $item }}</span></li>
            @endforeach
          </ul>
        </div>
        <div class="tuk-ref">{{ $tuk['ref'] }}</div>
        <a class="kb-dl" href="{{ asset($tuk['form']['file']) }}" target="_blank" rel="noopener">
          <svg width="18" height="18"><use href="#i-download"></use></svg>
          <span><strong>{{ $tuk['form']['kode'] }}</strong> {{ $tuk['form']['nama'] }}<small>{{ $tuk['form']['ket'] }}</small></span>
        </a>
      </div>
      @endforeach
    </div>

    <div class="tuk-block">
      <h3>3. Verifikasi dan Penetapan TUK</h3>
      <p>Setiap TUK harus diverifikasi sebelum digunakan dalam pelaksanaan asesmen.</p>
      <div class="tuk-verif">
        <div class="tuk-verif-item"><strong>TUK Offline/Fisik</strong>Untuk TUK Offline/Fisik, verifikasi dilakukan terhadap kondisi aktual lokasi, sarana-prasarana, peralatan, keamanan, akses, fasilitas pendukung, dan kesesuaiannya dengan skema serta metode asesmen.</div>
        <div class="tuk-verif-item"><strong>TUK Online</strong>Untuk TUK Online, verifikasi dilakukan terhadap identitas peserta, kondisi lingkungan, sarana dan prasarana, perangkat, koneksi, keamanan, serta integritas pelaksanaan asesmen. Pengawas Ujian dapat meminta peserta menunjukkan kondisi ruang dan area kerja melalui kamera sebagai bagian dari proses verifikasi.</div>
      </div>
      <p>Hasil verifikasi TUK ditetapkan dalam dua kategori:</p>
      <div class="tuk-result">
        <div class="tuk-result-item ok"><strong>MEMENUHI</strong><br>Seluruh persyaratan wajib yang relevan telah dipenuhi dan bukti hasil verifikasi dinyatakan memadai. TUK dapat digunakan untuk pelaksanaan asesmen sesuai ruang lingkup yang telah diverifikasi.</div>
        <div class="tuk-result-item no"><strong>TIDAK MEMENUHI</strong><br>Terdapat satu atau lebih persyaratan wajib yang belum atau tidak dapat dipenuhi, atau terdapat kondisi yang dapat memengaruhi validitas, keamanan, keselamatan, ketertiban, objektivitas dan/atau integritas asesmen. TUK tidak dapat digunakan sampai persyaratan tersebut dipenuhi dan dilakukan verifikasi ulang.</div>
      </div>
      <p>Untuk TUK Online, apabila ketidaksesuaian masih dapat diperbaiki sebelum asesmen dimulai, peserta diberikan kesempatan melakukan perbaikan dan Pengawas Ujian melakukan verifikasi ulang. Asesmen hanya dapat dimulai setelah seluruh persyaratan wajib terpenuhi dan hasil verifikasi dinyatakan MEMENUHI.</p>
      <div class="tuk-ref">SOP.SM.21. Verifikasi Tempat Uji Kompetensi (TUK)</div>
    </div>

    <div class="tuk-block">
      <h3>4. Pengendalian TUK</h3>
      <p>Pemilihan jenis TUK harus disesuaikan dengan metode asesmen pada skema ini. Apabila suatu metode asesmen membutuhkan peralatan khusus, fasilitas tertentu, atau kondisi lingkungan tertentu, TUK yang digunakan wajib menyediakan kebutuhan tersebut. Selama pelaksanaan asesmen, kondisi TUK tetap dipantau. Setiap perubahan, gangguan, atau ketidaksesuaian yang berpotensi memengaruhi validitas dan integritas asesmen harus dicatat dan ditindaklanjuti oleh LSP.</p>
      <p>Mekanisme verifikasi, penetapan, penggunaan, pemantauan, dan evaluasi TUK diatur lebih lanjut dalam SOP.SM.21 – Verifikasi Tempat Uji Kompetensi (TUK) beserta formulir yang berlaku.</p>
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
        <div class="tl-item"><div class="tl-dot warn"></div><p>LSP Edukia menerbitkan <strong>surat pencabutan sertifikat</strong> jika perbaikan tidak sesuai. Pemegang harus mengembalikan sertifikat dan tidak boleh menggunakan referensi sertifikasi yang berkaitan dengan kompetensinya.</p></div>
      </div>
    </div>
  </div>
</section>

{{-- RESERTIFIKASI --}}
<section id="resertifikasi" style="background:#fbf9f3">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Proses Survailen dan Resertifikasi</div>
      <h2>Proses Survailen dan Resertifikasi</h2>
      <p class="sub">Pemegang sertifikat wajib mengajukan permohonan sertifikasi ulang minimal <strong>2 bulan sebelum masa berlaku berakhir</strong>.</p>
    </div>
    <div class="resert-grid">
      <div class="resert-card">
        <div class="resert-header">
          <div class="resert-icon blue">
            <svg width="22" height="22"><use href="#i-refresh"></use></svg>
          </div>
          <h3>Proses Survailen</h3>
        </div>
        <div class="resert-sublabel">Berlaku untuk</div>
        @php $semuaSkema = \App\Support\Skemas::all(); @endphp
        <ul class="resert-list">
          {{-- Skema yang menerapkan survailen, sesuai klausul 14.A dokumen skema masing-masing. --}}
          @foreach($semuaSkema->filter(fn ($s) => ! empty($s['survailen']))->pluck('nama') as $s)
          <li><span class="resert-dot" style="background:var(--blue-deep)"></span><span>{{ $s }}</span></li>
          @endforeach
        </ul>
      </div>
      <div class="resert-card">
        <div class="resert-header">
          <div class="resert-icon orange">
            <svg width="22" height="22"><use href="#i-doc"></use></svg>
          </div>
          <h3>Resertifikasi</h3>
        </div>
        <div class="resert-sublabel">Berlaku untuk</div>
        <ul class="resert-list">
          {{-- Semua skema: resertifikasi dengan uji kompetensi kembali (klausul 14.B). --}}
          @foreach($semuaSkema->pluck('nama') as $s)
          <li><span class="resert-dot" style="background:var(--orange-deep)"></span><span>{{ $s }}</span></li>
          @endforeach
        </ul>
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
          <p>LSP Edukia memberikan kesempatan kepada asesi untuk mengajukan keluhan dan banding apabila proses sertifikasi dirasakan tidak sesuai SOP dan prinsip asesmen.</p>
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
          <p>Unduh formulir keluhan dan/atau banding asesmen:</p>
          <div class="kb-dl-list">
            <a class="kb-dl" href="{{ asset('downloads/FR.AK.07 Formulir Pengajuan dan Penanganan Keluhan.docx') }}" download>
              <svg width="18" height="18"><use href="#i-download"></use></svg>
              <span><strong>FR.AK.07</strong> Formulir Pengajuan dan Penanganan Keluhan<small>Dokumen Word (.docx)</small></span>
            </a>
            <a class="kb-dl" href="{{ asset('downloads/FR.AK.04 Banding Asesmen R2.docx') }}" download>
              <svg width="18" height="18"><use href="#i-download"></use></svg>
              <span><strong>FR.AK.04</strong> Formulir Banding Asesmen<small>Dokumen Word (.docx)</small></span>
            </a>
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
