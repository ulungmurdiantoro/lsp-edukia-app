@extends('layouts.app')

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-informasi.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue)}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}
</style>
@endsection

@section('content')
<style>
  .jobs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 24px;
    padding: 56px 0;
  }

  .job-card {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 32px;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
  }

  .job-card:hover {
    border-color: var(--blue);
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(15, 29, 53, 0.08);
  }

  .job-card-header {
    margin-bottom: 16px;
  }

  .job-category {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--blue-deep);
    margin-bottom: 8px;
  }

  .job-card h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--ink);
    margin: 0 0 12px;
    line-height: 1.3;
  }

  .job-meta {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin: 20px 0;
    padding: 20px 0;
    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);
    flex-grow: 1;
  }

  .job-meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    color: var(--ink-2);
  }

  .job-meta-item svg {
    width: 18px;
    height: 18px;
    color: var(--blue);
    flex-shrink: 0;
  }

  .job-description {
    font-size: 14.5px;
    color: var(--ink-2);
    line-height: 1.6;
    margin-bottom: 20px;
  }

  .job-button {
    align-self: flex-start;
    margin-top: auto;
  }

  .empty-state {
    text-align: center;
    padding: 56px 24px;
  }

  .empty-state h3 {
    font-size: 24px;
    margin-bottom: 12px;
  }

  .empty-state p {
    color: var(--muted);
    font-size: 15px;
  }
</style>

<div class="page-hero">
  <div class="wrap page-hero-inner">
    <div class="badge">Karier · LSP Edukia</div>
    <h1>Bergabung dengan <em>Tim Kami</em></h1>
    <p class="lead">Kami mencari talenta terbaik untuk memperkuat tim kami dalam misi meningkatkan kualitas sertifikasi kompetensi di Indonesia.</p>
  </div>
</div>

<section>
  <div class="wrap">
    <div class="sec-head">
      <h2>Lowongan Pekerjaan</h2>
      <p>Kami membuka kesempatan karir bagi profesional berpengalaman dan berbakat. Lihat posisi yang tersedia dan daftarkan diri Anda sekarang.</p>
    </div>

    @if ($openings && count($openings) > 0)
      <div class="jobs-grid">
        @foreach ($openings as $opening)
          <div class="job-card">
            <div class="job-card-header">
              <div class="job-category">{{ $opening['kategori'] }}</div>
              <h3>{{ $opening['judul'] }}</h3>
            </div>

            <p class="job-description">{{ substr($opening['deskripsi'], 0, 120) }}...</p>

            <div class="job-meta">
              <div class="job-meta-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
                {{ $opening['lokasi'] }}
              </div>
              <div class="job-meta-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ $opening['tipe'] }}
              </div>
            </div>

            <a href="{{ route('karier.show', $opening['slug']) }}" class="btn btn-primary job-button">
              Lihat Detail & Lamar
              <svg class="icon" style="width: 16px; height: 16px;">
                <use href="#i-arrow-r"></use>
              </svg>
            </a>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state">
        <h3>Belum Ada Lowongan</h3>
        <p>Saat ini kami belum memiliki lowongan pekerjaan yang terbuka. Silakan kunjungi kembali nanti atau hubungi kami untuk informasi lebih lanjut.</p>
      </div>
    @endif
  </div>
</section>

<!-- Additional Info Section -->
<section style="background: var(--cream-2); border-top: none;">
  <div class="wrap">
    <div class="sec-head">
      <h2>Mengapa Bergabung dengan LSP Edukia?</h2>
    </div>

    <div class="step" style="max-width: none; display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
      <div class="step">
        <div class="step-ico" style="background: var(--blue-50); color: var(--blue-deep);">
          <svg class="icon" style="width: 24px; height: 24px;">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" fill="currentColor" />
          </svg>
        </div>
        <h3 style="margin: 16px 0 8px;">Inovasi & Pertumbuhan</h3>
        <p>Bergabunglah dengan organisasi yang terus berkembang dan berinovasi dalam industri sertifikasi kompetensi.</p>
      </div>

      <div class="step">
        <div class="step-ico" style="background: var(--orange-50); color: var(--orange-deep);">
          <svg class="icon" style="width: 24px; height: 24px;">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" fill="none" />
          </svg>
        </div>
        <h3 style="margin: 16px 0 8px;">Kompensasi Kompetitif</h3>
        <p>Kami menawarkan paket kompensasi dan benefit yang kompetitif sesuai dengan pengalaman dan kualifikasi Anda.</p>
      </div>

      <div class="step">
        <div class="step-ico" style="background: var(--navy-50); color: var(--navy-700);">
          <svg class="icon" style="width: 24px; height: 24px;">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" fill="none" />
          </svg>
        </div>
        <h3 style="margin: 16px 0 8px;">Pengembangan Karir</h3>
        <p>Akses ke program pelatihan, mentoring, dan kesempatan pengembangan karir yang berkelanjutan.</p>
      </div>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section>
  <div class="cta">
    <div class="cta-body">
      <h3>Memiliki Pertanyaan?</h3>
      <p>Tim HR kami siap membantu menjawab pertanyaan Anda tentang lowongan dan proses rekrutmen.</p>
    </div>
    <a href="https://wa.me/6285175479385" target="_blank" rel="noopener" class="cta .wa">
      <svg class="icon" style="width: 18px; height: 18px;">
        <use href="#i-wa"></use>
      </svg>
      Hubungi HR
    </a>
  </div>
</section>
@endsection
