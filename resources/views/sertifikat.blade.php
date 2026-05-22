@extends('layouts.app')

@section('title', 'Daftar Penerima Sertifikat — LSP Edukia')

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-sertifikat.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}
.coming-soon-wrap{padding:96px 0;text-align:center}
.coming-soon-icon{width:80px;height:80px;border-radius:20px;background:var(--navy-50);display:grid;place-items:center;margin:0 auto 24px;color:var(--navy-600)}
.coming-soon-icon svg{width:40px;height:40px}
.coming-soon-wrap h2{margin-bottom:12px}
.coming-soon-wrap p{color:var(--muted);font-size:16px;max-width:48ch;margin:0 auto 32px}
</style>
@endsection

@section('content')

<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">Transparansi &amp; Akuntabilitas</div>
    <h1>Daftar Penerima Sertifikat</h1>
    <p class="lead">Informasi pemegang sertifikat kompetensi yang diterbitkan oleh LSP Edukasi Global Cendekia.</p>
  </div>
</div>

<div class="coming-soon-wrap">
  <div class="wrap">
    <div class="coming-soon-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round">
        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
        <rect x="9" y="3" width="6" height="4" rx="2"></rect>
        <path d="M9 12h6M9 16h4" stroke-linecap="round"></path>
      </svg>
    </div>
    <h2>Segera Hadir</h2>
    <p>Data daftar penerima sertifikat sedang disiapkan. Halaman ini akan segera menampilkan informasi lengkap pemegang sertifikat kompetensi LSP Edukia.</p>
    <a href="{{ route('home') }}" class="btn btn-primary" style="height:48px;padding:0 24px">
      <svg class="icon"><use href="#i-arrow-l"></use></svg>
      Kembali ke Beranda
    </a>
  </div>
</div>

@endsection
