@extends('layouts.app')
{{-- Meta (title/description/OG) homepage dikelola config/seo.php (homepage_title + fallback). --}}
{{-- Schema Organization dirender global via partials/schema-organization.blade.php. --}}
@push('head')
<link rel="preload" as="image" href="{{ asset('images/hero-index.jpg') }}" fetchpriority="high">
@endpush

@section('extra-css')
<style>
#schemes{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
@media(max-width:960px){#schemes{grid-template-columns:repeat(2,1fr)}}
@media(max-width:600px){#schemes{grid-template-columns:1fr}}
.hero h1{font-size:clamp(26px,3.6vw,48px)}
</style>
@endsection

@section('content')
<!-- HERO -->
<section class="hero" style="border-top:0;padding:0">
  <div class="wrap hero-grid">
    <div>
      <div class="badge"><span class="dot"></span> Berlisensi KAN · LSP-033-IDN</div>
      <h1>Sertifikasi kompetensi <em>profesional</em> berstandar Nasional dan <em>"Internasional"</em></h1>
      <p class="lead">26 skema sertifikasi untuk bidang Pendidikan Tinggi, Laboratorium, Lifting Engineering, dan Industri. Uji kompetensi daring, sertifikat berlaku 3 tahun.</p>
      <div class="hero-cta">
        <a href="#persyaratan" class="btn btn-primary btn-lg">Lihat persyaratan
          <svg class="icon"><use href="#i-arrow-r"></use></svg>
        </a>
        <a href="{{ route('skema') }}" class="btn btn-ghost btn-lg">Unit kompetensi</a>
      </div>
      <div class="hero-trust">
        <span>DIAKUI KAN</span><span class="line"></span>
        <span>LSP-033-IDN</span><span class="line"></span>
        <span>DP.AK.05 REV.02</span>
      </div>
    </div>
    <div class="stat-grid">
      <div class="stat"><span class="corner">01</span><div class="v">26</div><div class="l">Skema sertifikasi</div></div>
      <div class="stat"><span class="corner">02</span><div class="v">5</div><div class="l">Bidang keahlian</div></div>
      <div class="stat"><span class="corner">03</span><div class="v">3<small>th</small></div><div class="l">Masa berlaku sertifikat</div></div>
      <div class="stat featured"><span class="corner">04</span><div class="v online">Online</div><div class="l">Uji kompetensi fleksibel</div></div>
    </div>
  </div>
</section>

<!-- ALUR SERTIFIKASI -->
<section id="alur">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Alur Sertifikasi</div>
      <h2>Proses sertifikasi dalam 4 tahap</h2>
      <p class="sub">Transparan, objektif, dan sesuai standar KAN. Setiap tahap dipantau asesor independen bersertifikat.</p>
    </div>
    <div class="steps">
      <div class="step">
        <div class="step-num">1</div><div class="step-connector"></div>
        <div class="step-ico"><svg width="22" height="22"><use href="#i-doc"></use></svg></div>
        <h3>Permohonan Sertifikasi</h3>
        <p>Isi formulir FR.APL.01 dan FR.AK.01. Lengkapi dokumen persyaratan sesuai skema yang dipilih.</p>
      </div>
      <div class="step">
        <div class="step-num">2</div><div class="step-connector"></div>
        <div class="step-ico"><svg width="22" height="22"><use href="#i-check-list"></use></svg></div>
        <h3>Pra Asesmen</h3>
        <p>Asesor memverifikasi kelengkapan bukti dokumen — Valid, Asli, Terkini, Memadai (VATM).</p>
      </div>
      <div class="step">
        <div class="step-num">3</div><div class="step-connector"></div>
        <div class="step-ico"><svg width="22" height="22"><use href="#i-monitor"></use></svg></div>
        <h3>Uji Kompetensi</h3>
        <p>Ujian tertulis, lisan, dan/atau keterampilan secara online. Hasil: Kompeten atau Belum Kompeten.</p>
      </div>
      <div class="step">
        <div class="step-num">4</div>
        <div class="step-ico"><svg width="22" height="22"><use href="#i-award"></use></svg></div>
        <h3>Penerbitan Sertifikat</h3>
        <p>Sertifikat disahkan Ketua LSP EDUKIA, berlaku 3 tahun. Jika tidak lulus: remedial atau banding tersedia.</p>
      </div>
    </div>
  </div>
</section>

<!-- PERSYARATAN DASAR -->
<section id="persyaratan" style="background:#fbf9f3">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Persyaratan Sertifikasi</div>
      <h2>Persyaratan Dasar Pemohon Sertifikasi</h2>
      <p class="sub">Persyaratan pendidikan, pengalaman, dan sertifikat pelatihan yang harus dipenuhi untuk setiap skema kompetensi.</p>
    </div>
    <div class="chips" id="chips">
      <button class="chip active" data-filter="all">Semua <span class="count">26</span></button>
      <button class="chip" data-filter="spmi">SPMI ISO 21001 <span class="count">3</span></button>
      <button class="chip" data-filter="pt">Perguruan Tinggi <span class="count">2</span></button>
      <button class="chip" data-filter="lab17025">Lab ISO 17025 <span class="count">2</span></button>
      <button class="chip" data-filter="lifting">Lifting Engineering <span class="count">4</span></button>
      <button class="chip" data-filter="labtest">Lab &amp; Pengujian <span class="count">6</span></button>
      <button class="chip" data-filter="manajemen">Sistem Manajemen <span class="count">8</span></button>
    </div>
    <div id="schemes">
      @foreach($schemes as $i => $scheme)
        <x-skema-card :scheme="$scheme" />
      @endforeach
    </div>
    <div id="showAllWrap" style="text-align:center;margin-top:32px">
      <button id="showAllBtn" class="btn btn-outline" style="gap:10px;">
        Tampilkan semua 26 skema
        <svg style="width:16px;height:16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 9l6 6 6-6"/>
        </svg>
      </button>
    </div>
  </div>
</section>

<!-- AKTIVITAS TERKINI — dinamis dari database -->
<section id="aktivitas">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Aktivitas Terkini</div>
      <h2>Kegiatan &amp; Dokumentasi LSP Edukia</h2>
      <p class="sub">Dokumentasi pelatihan, asesmen, dan kegiatan sertifikasi terbaru dari LSP Edukasi Global Cendekia.</p>
    </div>
    @if($kegiatan->count() > 0)
    <div class="slider-wrap">
      <div class="slider-viewport">
        <div class="slider-track" id="sliderTrack">
          @foreach($kegiatan as $item)
          <div class="slide">
            <div class="slide-img">
              <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}" loading="lazy">
            </div>
            <div class="slide-body">
              <div class="slide-cat">{{ $item->tanggal->translatedFormat('d M Y') }}</div>
              <h4>{{ $item->judul }}</h4>
              @if($item->deskripsi)
              <p>{{ Str::limit($item->deskripsi, 100) }}</p>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="slider-nav">
        <button class="slider-btn" id="prevBtn" aria-label="Sebelumnya"><svg width="18" height="18"><use href="#i-arrow-l"></use></svg></button>
        <div class="slider-dots" id="sliderDots"></div>
        <button class="slider-btn" id="nextBtn" aria-label="Berikutnya"><svg width="18" height="18"><use href="#i-arrow-r"></use></svg></button>
      </div>
    </div>
    @else
    <p style="color:var(--muted);text-align:center;padding:48px 0">Belum ada kegiatan. Tambahkan di <a href="/admin/kegiatans" style="color:var(--blue)">panel admin</a>.</p>
    @endif
    <div style="text-align:center;margin-top:32px">
      <a href="{{ route('kegiatan.index') }}" class="btn btn-outline">Lihat semua kegiatan <svg class="icon"><use href="#i-arrow-r"></use></svg></a>
    </div>
  </div>
</section>

<!-- CTA -->
<section style="padding:0 0 96px;border-top:0">
  <div class="wrap">
    <div class="cta">
      <div class="cta-body">
        <h3>Siap memulai sertifikasi Anda?</h3>
        <p>Konsultasi GRATIS dengan tim kami — hubungi via WhatsApp sekarang.</p>
      </div>
      <a class="btn btn-primary btn-lg" href="{{ route('skema') }}">
        <svg class="icon"><use href="#i-doc"></use></svg> Lihat unit kompetensi
      </a>
      <a class="wa" href="https://wa.me/6285175479385">
        <svg class="icon" style="color:#7ee0a3"><use href="#i-wa"></use></svg>
        +62 851-7547-9385
      </a>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
const chips   = document.querySelectorAll('#chips .chip');
const cards   = Array.from(document.querySelectorAll('#schemes article'));
const showBtn = document.getElementById('showAllBtn');
const showWrap= document.getElementById('showAllWrap');
let activeFilter = 'all';
let showAll = false;

function applyState() {
  cards.forEach((card, i) => {
    const catMatch = activeFilter === 'all' || card.dataset.cat === activeFilter;
    // When a specific category is filtered, show ALL matching across 26.
    // When "Semua" is active, respect the show-all toggle (first 9 by default).
    const visible = catMatch && (activeFilter !== 'all' || showAll || i < 9);
    card.style.display = visible ? '' : 'none';
  });
  // Hide the button once expanded, or when a category filter is active
  showWrap.style.display = (activeFilter === 'all' && !showAll) ? '' : 'none';
}

chips.forEach(chip => {
  chip.addEventListener('click', () => {
    chips.forEach(c => c.classList.remove('active'));
    chip.classList.add('active');
    activeFilter = chip.dataset.filter;
    applyState();
  });
});

showBtn.addEventListener('click', () => {
  showAll = true;
  applyState();
});

applyState();

(function() {
  const track = document.getElementById('sliderTrack');
  if (!track) return;
  const dotsContainer = document.getElementById('sliderDots');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const slides = track.querySelectorAll('.slide');
  const total = slides.length;
  function getSlidesPerView() { return window.innerWidth < 960 ? 1 : 3; }
  let current = 0;
  let perView = getSlidesPerView();
  const maxIndex = () => Math.max(0, total - perView);
  function buildDots() {
    dotsContainer.innerHTML = '';
    for (let i = 0; i <= maxIndex(); i++) {
      const d = document.createElement('button');
      d.className = 'dot' + (i === 0 ? ' active' : '');
      d.setAttribute('aria-label', 'Slide ' + (i + 1));
      d.addEventListener('click', () => goTo(i));
      dotsContainer.appendChild(d);
    }
  }
  function goTo(idx) {
    current = Math.max(0, Math.min(idx, maxIndex()));
    const slideWidth = slides[0].getBoundingClientRect().width + 20;
    track.style.transform = 'translateX(-' + (current * slideWidth) + 'px)';
    dotsContainer.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === current));
    prevBtn.disabled = current === 0;
    nextBtn.disabled = current >= maxIndex();
  }
  prevBtn.addEventListener('click', () => goTo(current - 1));
  nextBtn.addEventListener('click', () => goTo(current + 1));
  function init() { perView = getSlidesPerView(); buildDots(); goTo(0); }
  window.addEventListener('resize', init);
  init();
})();
</script>
@endsection
