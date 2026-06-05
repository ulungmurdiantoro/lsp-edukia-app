@extends('layouts.app')
@section('content')
@push('head')<meta name="robots" content="noindex,follow">@endpush
<section style="padding:96px 0;text-align:center;background:var(--cream)">
  <div class="wrap" style="max-width:680px">
    <div class="eyebrow" style="justify-content:center">Error 404</div>
    <h1 style="margin:16px 0 12px">Halaman tidak ditemukan</h1>
    <p class="sub" style="margin:0 auto 28px">Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.
      Silakan kembali ke beranda atau jelajahi skema sertifikasi & artikel kami.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
      <a class="btn btn-primary btn-lg" href="{{ route('home') }}">Kembali ke Beranda
        <svg class="icon"><use href="#i-arrow-r"></use></svg>
      </a>
      <a class="btn btn-outline btn-lg" href="{{ route('skema') }}">Skema Sertifikasi</a>
      <a class="btn btn-outline btn-lg" href="{{ route('blog.index') }}">Blog</a>
    </div>
  </div>
</section>
@endsection
