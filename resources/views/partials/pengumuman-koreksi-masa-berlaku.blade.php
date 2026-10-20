{{-- Kotak pemberitahuan koreksi masa berlaku sertifikat — tampil di beranda & daftar penerima. --}}
@once
@push('head')
<style>
.pgm{display:grid;grid-template-columns:auto 1fr auto;gap:18px 20px;align-items:center;padding:20px 24px;background:#fff;border:1px solid var(--line);border-left:4px solid var(--orange);border-radius:14px;box-shadow:0 6px 20px rgba(15,29,53,.06)}
.pgm-ico{width:44px;height:44px;border-radius:12px;background:var(--orange-50);color:var(--orange-deep);display:flex;align-items:center;justify-content:center}
.pgm-ico svg{width:22px;height:22px}
.pgm-meta{font-size:11.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--orange-deep);margin-bottom:4px}
.pgm-title{font-size:16px;font-weight:700;color:var(--ink);line-height:1.35;margin-bottom:4px}
.pgm-text{font-size:13.5px;color:var(--ink-2);line-height:1.55;max-width:80ch}
.pgm-btn{display:inline-flex;align-items:center;gap:6px;height:40px;padding:0 18px;border-radius:999px;background:var(--navy-800);color:#fff;font-weight:600;font-size:13.5px;white-space:nowrap}
.pgm-btn:hover{background:var(--navy-600)}
@media(max-width:760px){
  .pgm{grid-template-columns:1fr;gap:14px;padding:18px}
  .pgm-ico{display:none}
  .pgm-btn{justify-content:center}
}
</style>
@endpush
@endonce
<aside class="pgm" aria-label="Pemberitahuan koreksi masa berlaku sertifikat">
  <div class="pgm-ico"><svg><use href="#i-doc"></use></svg></div>
  <div>
    <div class="pgm-meta">Pemberitahuan · No. {{ \App\Models\Sertifikat::NOMOR_PEMBERITAHUAN_KOREKSI }}</div>
    <div class="pgm-title">Koreksi Administratif Masa Berlaku Sertifikat Kompetensi</div>
    <p class="pgm-text">Untuk sertifikat periode April 2024 – Agustus 2026, tanggal berakhir masa berlaku 3 tahun ditetapkan 1 hari sebelum tanggal yang sama pada tahun ketiga (contoh: berlaku 18 Juni 2026, berakhir 17 Juni 2029). Nomor sertifikat dan tanggal mulai berlaku tidak berubah.</p>
  </div>
  <a class="pgm-btn" href="{{ route('pengumuman.koreksi-masa-berlaku') }}">Baca pemberitahuan <svg class="icon"><use href="#i-arrow-r"></use></svg></a>
</aside>
