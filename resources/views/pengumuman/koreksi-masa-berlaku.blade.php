@extends('layouts.app')
{{-- Pemberitahuan resmi No. 553/SPT/EDUKIA/X/2026 (teks dari dokumen "Informasi di Website"). Meta via $SEOData. --}}

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-sertifikat.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero-inner{padding-top:64px;padding-bottom:72px;position:relative}/* bukan shorthand: padding samping .wrap harus tetap berlaku */
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:12px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue);letter-spacing:-0.02em}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:60ch;line-height:1.55}

.surat{max-width:820px;margin:0 auto;background:#fff;border:1px solid var(--line);border-radius:16px;padding:44px 48px;font-size:15px;line-height:1.7;color:var(--ink-2)}
.surat p{margin:0 0 16px;text-align:justify}
.surat-head{text-align:center;margin-bottom:28px}
.surat-head h2{font-size:17px;line-height:1.45;letter-spacing:0;text-transform:uppercase}
.surat-head p{text-align:center;margin:6px 0 0;font-weight:700;font-size:14px;color:var(--ink);text-transform:uppercase}
.surat-meta{display:grid;grid-template-columns:90px 1fr;gap:4px 8px;margin:0 0 24px}
.surat-meta dt{color:var(--muted)}
.surat-meta dd{margin:0;color:var(--ink)}
.surat-meta dd::before{content:": "}
.surat-kepada{text-align:left!important}
.surat-contoh{margin:4px 0 20px;padding:18px 20px;background:var(--orange-50);border:1px solid #f8d3a8;border-radius:12px}
.surat-contoh-judul{font-weight:700;color:var(--ink);margin-bottom:10px}
.surat-contoh-grid{display:grid;grid-template-columns:1fr auto 1fr;gap:12px;align-items:center}
.surat-contoh-item{background:#fff;border-radius:10px;padding:12px 14px;border:1px solid #f3dcc0}
.surat-contoh-label{font-size:12.5px;color:var(--muted)}
.surat-contoh-val{font-size:16px;font-weight:700;color:var(--navy-800)}
.surat-contoh-panah{color:var(--orange-deep)}
.surat-ttd{text-align:left!important;margin-top:28px!important}
.surat a{color:var(--blue-deep);font-weight:600}
.surat-aksi{max-width:820px;margin:24px auto 0;display:flex;flex-wrap:wrap;gap:12px;justify-content:center}
.surat-btn{display:inline-flex;align-items:center;gap:8px;height:46px;padding:0 22px;border-radius:999px;font-weight:600;font-size:14.5px}
.surat-btn.navy{background:var(--navy-800);color:#fff}
.surat-btn.navy:hover{background:var(--navy-600)}
.surat-btn.wa{background:#fff;color:var(--ink);border:1px solid var(--line-2)}
.surat-btn.wa .icon{color:#25a35a}

@media(max-width:640px){
  .surat{padding:28px 20px;font-size:14.5px}
  .surat p{text-align:left}
  .surat-contoh-grid{grid-template-columns:1fr}
  .surat-contoh-panah{display:none}
}
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">Pemberitahuan Resmi · 20 Oktober 2026</div>
    <h1>Koreksi Administratif <em>Masa Berlaku</em> Sertifikat Kompetensi</h1>
    <p class="lead">Periode sertifikasi kompetensi April 2024 – Agustus 2026.</p>
  </div>
</div>

<section style="padding:56px 0 96px;background:var(--cream,#fbf9f3);border-top:0">
  <div class="wrap">
    <article class="surat">
      <header class="surat-head">
        <h2>Pemberitahuan Koreksi Administratif Masa Berlaku Sertifikat Kompetensi</h2>
        <p>(Periode Sertifikasi Kompetensi April 2024 – Agustus 2026)</p>
      </header>

      <dl class="surat-meta">
        <dt>Nomor</dt><dd>{{ \App\Models\Sertifikat::NOMOR_PEMBERITAHUAN_KOREKSI }}</dd>
        <dt>Lampiran</dt><dd>-</dd>
        <dt>Perihal</dt><dd>Pemberitahuan Koreksi Administratif Masa Berlaku Sertifikat Kompetensi LSP Edukia</dd>
      </dl>

      <p class="surat-kepada">Kepada Yth.<br>Pemegang Sertifikat Kompetensi<br>LSP Edukasi Global Cendekia (Edukia)</p>

      <p>Dalam rangka memastikan ketepatan dan konsistensi informasi sertifikasi, LSP Edukasi Global Cendekia (LSP Edukia) telah melakukan peninjauan terhadap pencantuman masa berlaku pada sertifikat kompetensi yang telah diterbitkan. Berdasarkan hasil peninjauan tersebut, terdapat ketidaktepatan administratif pada pencantuman tanggal berakhir masa berlaku sertifikat. Untuk sertifikat dengan masa berlaku 3 (tiga) tahun, tanggal berakhir sertifikat seharusnya ditetapkan 1 (satu) hari kalender sebelum tanggal yang sama pada tahun ketiga sejak tanggal mulai berlaku sertifikat.</p>

      <div class="surat-contoh">
        <div class="surat-contoh-judul">Sebagai contoh:</div>
        <div class="surat-contoh-grid">
          <div class="surat-contoh-item">
            <div class="surat-contoh-label">Tanggal mulai berlaku</div>
            <div class="surat-contoh-val">18 Juni 2026</div>
          </div>
          <svg class="icon surat-contoh-panah" aria-hidden="true"><use href="#i-arrow-r"></use></svg>
          <div class="surat-contoh-item">
            <div class="surat-contoh-label">Tanggal berakhir yang benar</div>
            <div class="surat-contoh-val">17 Juni 2029</div>
          </div>
        </div>
      </div>

      <p>Koreksi administratif ini tidak mengubah keputusan sertifikasi, kompetensi yang telah dinyatakan, ruang lingkup sertifikasi, nomor sertifikat, maupun tanggal mulai berlaku sertifikat. LSP Edukia telah melakukan penyesuaian informasi masa berlaku pada register/database sertifikasi dan <a href="{{ route('sertifikat') }}">website daftar penerima sertifikat LSP</a>. Pemegang sertifikat dapat mengacu pada informasi masa berlaku yang telah diperbarui pada website daftar penerima sertifikat LSP.</p>

      <p>Sertifikat yang telah diterbitkan sebelumnya tidak dilakukan penerbitan ulang secara massal. Apabila pemegang sertifikat memerlukan klarifikasi atau dokumen sertifikat yang telah disesuaikan, dapat menghubungi narahubung kami melalui WhatsApp di nomor <a href="https://wa.me/6285175479385">0851-7547-9385</a> (Edukia).</p>

      <p>Demikian pemberitahuan ini disampaikan sebagai bentuk komitmen LSP Edukia dalam menjaga keakuratan, ketertelusuran, dan konsistensi informasi sertifikasi. Atas perhatian dan pengertiannya, kami ucapkan terima kasih.</p>

      <p class="surat-ttd">Salam Hormat<br><strong>LSP Edukasi Global Cendekia (Edukia)</strong></p>
    </article>

    {{-- Surat resmi bertanda tangan; tombol muncul begitu file-nya ada di public/downloads. --}}
    @php($pdf = 'downloads/Pemberitahuan Koreksi Administratif Masa Berlaku Sertifikat Kompetensi LSP Edukia.pdf')
    <div class="surat-aksi">
      @if(file_exists(public_path($pdf)))
        <a class="surat-btn wa" href="{{ asset($pdf) }}" target="_blank" rel="noopener"><svg class="icon" style="color:var(--orange-deep)"><use href="#i-download"></use></svg> Unduh surat resmi (PDF)</a>
      @endif
      <a class="surat-btn navy" href="{{ route('sertifikat') }}">Cek data sertifikat Anda <svg class="icon"><use href="#i-arrow-r"></use></svg></a>
      <a class="surat-btn wa" href="https://wa.me/6285175479385"><svg class="icon"><use href="#i-wa"></use></svg> Hubungi via WhatsApp</a>
    </div>
  </div>
</section>
@endsection
