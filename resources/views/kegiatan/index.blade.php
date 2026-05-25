@extends('layouts.app')
@section('title', 'Kegiatan & Dokumentasi — LSP Edukia')
@section('description', 'Dokumentasi kegiatan LSP Edukia: uji kompetensi, pelatihan, workshop sertifikasi, dan berbagai program pengembangan kompetensi profesional di seluruh Indonesia.')

@section('content')
<section class="hero" style="border-top:0;padding:0">
  <div class="wrap" style="padding:64px 32px">
    <div class="badge" style="margin-bottom:20px"><span class="dot"></span> Galeri Kegiatan</div>
    <h1 style="color:#fff;max-width:18ch">Kegiatan &amp; <em>dokumentasi</em> LSP Edukia</h1>
    <p class="lead" style="margin-top:16px">Rekam jejak pelatihan, asesmen, dan kegiatan sertifikasi LSP Edukasi Global Cendekia.</p>
  </div>
</section>

<section>
  <div class="wrap">
    @if($kegiatan->count() > 0)
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px">
      @foreach($kegiatan as $item)
      <div class="post-card">
        <div class="post-card-img">
          <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}" loading="lazy">
        </div>
        <div class="post-card-body">
          <div class="post-card-cat">{{ $item->tanggal->translatedFormat('d M Y') }}</div>
          <h3>{{ $item->judul }}</h3>
          @if($item->deskripsi)
          <p>{{ $item->deskripsi }}</p>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    <div style="margin-top:40px">{{ $kegiatan->links() }}</div>
    @else
    <p style="color:var(--muted);text-align:center;padding:64px 0;font-size:16px">Belum ada kegiatan. Tambahkan di <a href="/admin/kegiatans" style="color:var(--blue)">panel admin</a>.</p>
    @endif
  </div>
</section>
@endsection

@section('extra-css')
<style>
@media(max-width:960px){div[style*="grid-template-columns:repeat(3,1fr)"]{grid-template-columns:1fr!important}}
</style>
@endsection
