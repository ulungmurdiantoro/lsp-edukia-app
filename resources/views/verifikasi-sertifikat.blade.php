@extends('layouts.app')
{{-- Tujuan QR code sertifikat/SK — lihat VerifikasiSertifikatController. Meta via $SEOData (noindex). --}}

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-sertifikat.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero-inner{padding:64px 0 72px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:12px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue);letter-spacing:-0.02em}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:60ch;line-height:1.55}

.verif-card{max-width:760px;margin:0 auto;background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden}
.verif-head{display:flex;align-items:center;gap:14px;padding:22px 24px;border-bottom:1px solid var(--line)}
.verif-icon{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex:0 0 auto}
.verif-icon.ok{background:#dcfce7;color:#15803d}
.verif-icon.no{background:#fee2e2;color:#b91c1c}
.verif-title{font-size:18px;font-weight:800;color:var(--ink);line-height:1.3}
.verif-sub{font-size:13.5px;color:var(--muted);margin-top:2px}
.verif-rows{padding:8px 24px 16px}
.verif-row{display:grid;grid-template-columns:190px 1fr;gap:12px;padding:12px 0;border-bottom:1px solid var(--line);font-size:14.5px}
.verif-row:last-child{border-bottom:0}
.verif-label{color:var(--muted);font-size:13px;font-weight:600}
.verif-value{color:var(--ink);font-weight:600;word-break:break-word}
.verif-mono{font-family:ui-monospace,monospace;color:var(--navy-800)}
.status-pill{display:inline-flex;align-items:center;gap:6px;padding:5px 11px;border-radius:999px;font-size:12px;font-weight:700}
.status-dot{width:6px;height:6px;border-radius:50%}
.verif-body{padding:22px 24px;font-size:14.5px;color:var(--ink-2);line-height:1.6}
.verif-body p{margin:0 0 12px}
.verif-btn{display:inline-flex;align-items:center;gap:6px;height:42px;padding:0 20px;border-radius:999px;background:var(--navy-800);color:#fff;font-weight:700;font-size:13.5px;text-decoration:none}
.verif-note{max-width:760px;margin:20px auto 0;font-size:13px;color:var(--muted);text-align:center;line-height:1.55}

@media(max-width:640px){
  .verif-row{grid-template-columns:1fr;gap:2px}
}
</style>
@endsection

@section('content')
@php
  $statusMeta = [
    'aktif'      => ['label' => 'Aktif',           'dot' => '#16a34a', 'text' => '#15803d', 'bg' => '#dcfce7'],
    'expiring'   => ['label' => 'Akan kadaluarsa', 'dot' => '#d97706', 'text' => '#92400e', 'bg' => '#fef3c7'],
    'kadaluarsa' => ['label' => 'Kadaluarsa',      'dot' => '#dc2626', 'text' => '#991b1b', 'bg' => '#fee2e2'],
  ];
@endphp

<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">Verifikasi Sertifikat · LSP Edukia</div>
    @if($sertifikat)
      <h1>Sertifikat <em>Terverifikasi</em></h1>
      <p class="lead">Sertifikat kompetensi ini tercatat sebagai sertifikat resmi yang diterbitkan LSP Edukasi Global Cendekia.</p>
    @else
      <h1>Sertifikat <em>Tidak Ditemukan</em></h1>
      <p class="lead">Nomor yang dipindai tidak ditemukan dalam daftar penerima sertifikat LSP Edukasi Global Cendekia.</p>
    @endif
  </div>
</div>

<section style="padding:56px 0 96px;background:var(--cream,#fbf9f3)">
  <div class="wrap">
    <div class="verif-card">
      @if($sertifikat)
        @php $st = $statusMeta[$sertifikat->status] ?? $statusMeta['aktif']; @endphp
        <div class="verif-head">
          <div class="verif-icon ok">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
          </div>
          <div>
            <div class="verif-title">{{ $sertifikat->nama }}</div>
            @if($sertifikat->gelar)<div class="verif-sub">{{ $sertifikat->gelar }}</div>@endif
          </div>
        </div>
        <div class="verif-rows">
          <div class="verif-row"><div class="verif-label">Skema Sertifikasi</div><div class="verif-value">{{ $sertifikat->skema }}@if($sertifikat->no_skema) <span class="verif-sub">({{ $sertifikat->no_skema }})</span>@endif</div></div>
          <div class="verif-row"><div class="verif-label">Nomor Sertifikat</div><div class="verif-value verif-mono">{{ $sertifikat->nomor_sertifikat }}</div></div>
          @if($sertifikat->no_sk)
          <div class="verif-row"><div class="verif-label">Nomor SK</div><div class="verif-value verif-mono">{{ $sertifikat->no_sk }}</div></div>
          @endif
          <div class="verif-row"><div class="verif-label">Tanggal Terbit</div><div class="verif-value">{{ $sertifikat->tanggal_terbit?->translatedFormat('d F Y') ?? '—' }}</div></div>
          <div class="verif-row"><div class="verif-label">Berlaku Sampai</div><div class="verif-value">{{ $sertifikat->tanggal_kadaluarsa?->translatedFormat('d F Y') ?? '—' }}</div></div>
          <div class="verif-row"><div class="verif-label">Lisensi KAN</div><div class="verif-value">{{ $sertifikat->lisensi ? 'Berlisensi KAN' : 'Tidak berlisensi KAN' }}</div></div>
          <div class="verif-row">
            <div class="verif-label">Status</div>
            <div class="verif-value">
              <span class="status-pill" style="background:{{ $st['bg'] }};color:{{ $st['text'] }}">
                <span class="status-dot" style="background:{{ $st['dot'] }}"></span>{{ $st['label'] }}
              </span>
            </div>
          </div>
        </div>
      @else
        <div class="verif-head">
          <div class="verif-icon no">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
          </div>
          <div>
            <div class="verif-title">Data tidak ditemukan</div>
            <div class="verif-sub">{{ $label }}: <span class="verif-mono">{{ $nomor }}</span></div>
          </div>
        </div>
        <div class="verif-body">
          <p>Data penerima sertifikat diperbarui setiap hari, sehingga sertifikat yang baru diterbitkan mungkin belum tampil.
            Anda juga dapat mencari berdasarkan nama atau nomor di halaman Daftar Penerima Sertifikat.</p>
          <p>Bila ragu dengan keaslian dokumen, silakan hubungi LSP Edukia untuk konfirmasi.</p>
          <a href="{{ route('sertifikat') }}" class="verif-btn">Daftar Penerima Sertifikat</a>
        </div>
      @endif
    </div>

    @if($sertifikat)
      <p class="verif-note">Informasi ini bersumber dari basis data resmi LSP Edukasi Global Cendekia.
        Lihat seluruh penerima di <a href="{{ route('sertifikat') }}">Daftar Penerima Sertifikat</a>.</p>
    @endif
  </div>
</section>
@endsection
