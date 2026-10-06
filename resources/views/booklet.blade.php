@extends('layouts.app')
{{-- Mode baca booklet (PageController@booklet). $booklet: Booklet aktif yang punya file PDF. --}}
{{-- PDF dirender per halaman ke <canvas> dengan PDF.js (public/vendor/pdfjs) — iframe PDF tidak tampil di
     kebanyakan browser HP. Halaman hanya digambar saat mendekati layar & dilepas saat jauh agar hemat memori. --}}
@push('head')
<link rel="modulepreload" href="{{ asset('vendor/pdfjs/pdf.min.js') }}">
@endpush

@section('extra-css')
<style>
.reader{padding:0;border-top:0;background:#e8e4da;min-height:70vh}
.reader-bar{background:#fff;border-bottom:1px solid var(--line)}
.reader-bar .wrap{display:flex;align-items:center;gap:16px;padding-top:12px;padding-bottom:12px}
.reader-title{display:flex;align-items:center;gap:10px;min-width:0;margin-right:auto}
.reader-title svg{width:22px;height:22px;color:var(--orange);flex:0 0 auto}
.reader-title h1{font-size:17px;line-height:1.3;letter-spacing:-0.01em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.reader-bar .btn{height:38px;padding:0 16px;font-size:13.5px;flex:0 0 auto}
.reader-pages{max-width:920px;margin:0 auto;padding:24px 16px 72px;display:flex;flex-direction:column;gap:16px}
/* Tinggi placeholder lewat padding-bottom (rasio halaman) — aman untuk browser lama tanpa aspect-ratio */
.reader-page{position:relative;height:0;background:#fff;box-shadow:0 6px 24px rgba(15,29,53,.12);border-radius:3px;overflow:hidden}
.reader-page canvas{position:absolute;top:0;left:0;width:100%;height:100%;display:block}
.reader-msg{max-width:520px;margin:0 auto;padding:72px 24px;text-align:center;color:var(--muted);font-size:14.5px}
.reader-msg .btn{margin-top:18px}
.reader-pos{position:fixed;left:28px;bottom:34px;z-index:98;height:40px;padding:0 16px;border-radius:999px;background:rgba(6,23,46,.88);color:#fff;font-size:13px;font-weight:600;display:flex;align-items:center;font-variant-numeric:tabular-nums;box-shadow:0 6px 20px rgba(6,23,46,.25)}
.reader-pos[hidden]{display:none}
@media(max-width:640px){
  .reader-bar .wrap{gap:12px;padding-top:10px;padding-bottom:10px}
  .reader-title h1{font-size:15px}
  .reader-pages{padding:12px 8px 88px;gap:10px}
  .reader-pos{left:16px}
}
</style>
@endsection

@section('content')
<section class="reader">
  <div class="reader-bar">
    <div class="wrap">
      <div class="reader-title">
        <svg aria-hidden="true"><use href="#i-book"></use></svg>
        <h1>{{ $booklet->judul }}</h1>
      </div>
      <a class="btn btn-outline" href="{{ $booklet->url() }}" download="{{ $booklet->namaUnduhan() }}">
        <svg class="icon" aria-hidden="true"><use href="#i-download"></use></svg> Unduh
      </a>
    </div>
  </div>

  <div class="reader-pages" id="reader-pages" aria-label="Halaman booklet"></div>
  <div class="reader-msg" id="reader-msg" role="status"><p>Memuat booklet…</p></div>
  <div class="reader-pos" id="reader-pos" aria-live="polite" hidden></div>

  <template id="reader-fallback">
    <p>Booklet tidak dapat ditampilkan di browser ini. Silakan buka file PDF-nya langsung.</p>
    <a class="btn btn-primary" href="{{ $booklet->url() }}" target="_blank" rel="noopener">Buka PDF
      <svg class="icon" aria-hidden="true"><use href="#i-arrow-r"></use></svg>
    </a>
  </template>
</section>
@endsection

@section('scripts')
<script nomodule>
document.getElementById('reader-msg').innerHTML = document.getElementById('reader-fallback').innerHTML;
</script>
<script type="module">
const SRC = @json($booklet->url());
const LIB = @json(asset('vendor/pdfjs/pdf.min.js'));
const WORKER = @json(asset('vendor/pdfjs/pdf.worker.min.js'));
const DPR = Math.min(window.devicePixelRatio || 1, 2);

const pagesEl = document.getElementById('reader-pages');
const msgEl = document.getElementById('reader-msg');
const posEl = document.getElementById('reader-pos');

function showFallback(err) {
  if (err) console.error(err);
  pagesEl.hidden = true;
  posEl.hidden = true;
  msgEl.hidden = false;
  msgEl.innerHTML = document.getElementById('reader-fallback').innerHTML;
}

async function run(pdfjsLib) {
  pdfjsLib.GlobalWorkerOptions.workerSrc = WORKER;

  const task = pdfjsLib.getDocument({ url: SRC });
  task.onProgress = ({ loaded, total }) => {
    if (total) msgEl.firstElementChild.textContent = 'Memuat booklet… ' + Math.min(99, Math.round(loaded / total * 100)) + '%';
  };
  const pdf = await task.promise;
  const total = pdf.numPages;

  // Semua placeholder memakai rasio halaman 1 (booklet umumnya seragam); tiap halaman
  // mengoreksi rasionya sendiri saat digambar.
  const first = (await pdf.getPage(1)).getViewport({ scale: 1 });
  const ratio = (first.height / first.width * 100) + '%';
  const pages = [];
  for (let n = 1; n <= total; n++) {
    const el = document.createElement('div');
    el.className = 'reader-page';
    el.style.paddingBottom = ratio;
    el.dataset.i = String(n - 1);
    el.setAttribute('aria-label', 'Halaman ' + n);
    pagesEl.appendChild(el);
    pages.push({ n, el, page: null, canvas: null, task: null, near: false });
  }
  msgEl.hidden = true;

  async function draw(p) {
    if (p.canvas) return;
    const canvas = document.createElement('canvas');
    p.canvas = canvas; // dipasang lebih dulu agar draw() ganda untuk halaman yang sama diabaikan
    try {
      p.page = p.page || await pdf.getPage(p.n);
      if (p.canvas !== canvas) return; // sudah dilepas selagi menunggu
      const base = p.page.getViewport({ scale: 1 });
      p.el.style.paddingBottom = (base.height / base.width * 100) + '%';
      const viewport = p.page.getViewport({ scale: p.el.clientWidth / base.width * DPR });
      canvas.width = Math.floor(viewport.width);
      canvas.height = Math.floor(viewport.height);
      p.el.appendChild(canvas);
      p.task = p.page.render({ canvas, viewport });
      await p.task.promise;
    } catch (err) {
      if (!(err instanceof pdfjsLib.RenderingCancelledException)) console.error(err);
    } finally {
      if (p.canvas === canvas) p.task = null;
    }
  }

  function release(p) {
    if (!p.canvas) return;
    if (p.task) p.task.cancel();
    p.task = null;
    p.canvas.width = p.canvas.height = 0; // bebaskan memori kanvas segera, tidak menunggu GC
    p.canvas.remove();
    p.canvas = null;
  }

  const io = new IntersectionObserver((entries) => {
    for (const e of entries) {
      const p = pages[e.target.dataset.i];
      p.near = e.isIntersecting;
      if (p.near) draw(p); else release(p);
    }
  }, { rootMargin: '1200px 0px' });
  pages.forEach((p) => io.observe(p.el));

  // Penanda "halaman X / N": halaman yang melintasi tengah layar.
  let ticking = false;
  function updatePos() {
    ticking = false;
    const mid = window.innerHeight / 2;
    const cur = pages.find((p) => p.el.getBoundingClientRect().bottom > mid) || pages[total - 1];
    posEl.textContent = cur.n + ' / ' + total;
  }
  window.addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(updatePos); } }, { passive: true });
  updatePos();
  posEl.hidden = false;

  // Lebar berubah jauh (putar layar, ubah ukuran jendela) → gambar ulang agar tetap tajam.
  let lastWidth = pagesEl.clientWidth;
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      const w = pagesEl.clientWidth;
      if (Math.abs(w - lastWidth) / lastWidth < 0.15) return;
      lastWidth = w;
      pages.forEach((p) => { if (p.canvas) { release(p); if (p.near) draw(p); } });
    }, 200);
  });
}

if (!('IntersectionObserver' in window)) {
  showFallback();
} else {
  import(LIB).then(run).catch(showFallback);
}
</script>
@endsection
