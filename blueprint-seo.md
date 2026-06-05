# Blueprint SEO — LSP Edukia

> Tujuan: menjadikan **lspedukia.id** mesin akuisisi organik yang dominan untuk kata kunci
> "sertifikasi profesi", "LSP BNSP", dan 26 skema kompetensi yang dimiliki — di pasar Indonesia.
> Dokumen ini disusun berdasarkan kondisi kode saat ini (Laravel 12 + Filament 3.3 + Blade + Tailwind 4).

---

## 0. Ringkasan Kondisi Saat Ini (Audit Cepat)

**Sudah baik (jangan dirombak, cukup dirawat):**
- Meta `title` + `description` dinamis per halaman via `@yield` di [layouts/app.blade.php](resources/views/layouts/app.blade.php)
- `<link rel="canonical">`, Open Graph, Twitter Card lengkap
- `sitemap.xml` dinamis ([SitemapController.php](app/Http/Controllers/SitemapController.php)) + `robots.txt` ([public/robots.txt](public/robots.txt))
- Schema `Article` di [blog/show.blade.php](resources/views/blog/show.blade.php) & `ProfessionalService` di [index.blade.php](resources/views/index.blade.php)
- Short link `/b/{code}` + redirect legacy `301` ([BlogController.php](app/Http/Controllers/BlogController.php)) — bagus untuk menjaga link equity
- `reading_time`, slug otomatis, struktur URL bersih (`/{slug}` tanpa prefix `/blog/`)

**Gap utama (peluang terbesar):**
| # | Gap | Dampak |
|---|-----|--------|
| 1 | Tidak ada Google Search Console / Analytics / verifikasi | Buta data — tidak bisa ukur apa pun |
| 2 | Schema `Organization`/`ProfessionalService` `sameAs` kosong, belum ada `BreadcrumbList`, `FAQPage`, `Course`/`Service` per skema | Kehilangan rich result & entity recognition |
| 3 | Halaman **skema-sertifikasi** (aset terbesar: 26 skema) tidak punya halaman detail per-skema yang ter-index | Kehilangan ribuan long-tail keyword |
| 4 | Performa: Google Fonts render-blocking, gambar tanpa `width/height`/`loading`/WebP, hero LCP tidak di-preload | Core Web Vitals & ranking |
| 5 | Post tidak punya field SEO (`meta_title`, `meta_description`, `og_image`) | Editor tak bisa optimasi per artikel |
| 6 | Sitemap belum cache, belum sertakan gambar/`kegiatan`, belum `lastmod` valid | Crawl efficiency |
| 7 | E-E-A-T lemah: tak ada bio penulis, halaman kontak/legal, sinyal kelembagaan BNSP | Trust untuk topik YMYL (sertifikasi = karier) |
| 8 | Internal linking minim, tak ada halaman kategori/tag blog yang ter-index | Distribusi authority |

---

## 1. Pilar Strategi (Bagaimana Memenangkan)

LSP Edukia adalah situs **YMYL** (Your Money Your Life) — keputusan sertifikasi memengaruhi karier orang.
Google menuntut **E-E-A-T tinggi**. Tiga pilar:

1. **Otoritas Kelembagaan (Authoritativeness/Trust):** tonjolkan akreditasi BNSP, nomor lisensi, alamat fisik, daftar penerima sertifikat yang bisa diverifikasi. Ini pembeda dari kompetitor.
2. **Cakupan Topik (Topical Authority):** kuasai seluruh cluster "sertifikasi [bidang]" — bukan satu halaman, tapi pilar + artikel pendukung + halaman skema detail.
3. **Pengalaman Teknis (Page Experience):** cepat, mobile-first, structured data kaya, zero error crawl.

---

## 2. Roadmap Berfase (Prioritas Eksekusi)

### 🔴 FASE 1 — Fondasi & Pengukuran (Minggu 1) — *Kerjakan duluan, cepat, dampak tinggi*

**1.1 Pasang alat ukur (tanpa ini semua sia-sia)**
- Daftarkan domain di **Google Search Console** (verifikasi via DNS TXT atau meta tag di `<head>`).
- Submit `https://lspedukia.id/sitemap.xml` di GSC.
- Pasang **Google Analytics 4** (atau alternatif privacy-friendly seperti Plausible) — taruh tag di `layouts/app.blade.php` lewat `@stack('head')`.
- Tambah verifikasi **Bing Webmaster Tools** (Bing/ChatGPT search makin relevan).

**1.2 Konfigurasi `APP_URL` & canonical absolut**
- Pastikan `APP_URL=https://lspedukia.id` di `.env` produksi (canonical & schema pakai ini).
- Paksa HTTPS + non-www → www konsisten (pilih satu, `301` redirect di server/middleware).

**1.3 Perkuat `<head>` global** (di [layouts/app.blade.php](resources/views/layouts/app.blade.php)):
```blade
{{-- Tambahan yang disarankan --}}
<meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
<meta name="theme-color" content="#0a2547">
<meta name="author" content="LSP Edukia">
{{-- ganti @yield('schema-json') agar bisa banyak blok schema --}}
@stack('head')
@stack('schema')
```
- Ganti `@yield('schema-json')` → `@stack('schema')` supaya tiap halaman bisa menumpuk beberapa blok JSON-LD (Organization + Breadcrumb + Page-specific).

**1.4 Organization/ProfessionalService schema global + `sameAs`**
- Pindahkan schema `ProfessionalService` ke **layout** (muncul di semua halaman, bukan cuma home) sebagai identitas entity.
- Isi `sameAs` dengan URL resmi: Instagram, Facebook, LinkedIn, YouTube, akun BNSP (jika ada). Ini menghubungkan brand sebagai entity di Knowledge Graph.
- Tambah properti: `"foundingDate"`, `"@id": "https://lspedukia.id/#organization"`, `"priceRange"`, dan jika ada — `"hasCredential"` yang menunjuk lisensi BNSP.

---

### 🟠 FASE 2 — Aset Konten Inti: Halaman Skema Detail (Minggu 2–3) — *Peluang keyword terbesar*

26 skema sertifikasi saat ini hanya hidup di satu halaman daftar. Setiap skema layak jadi **halaman ter-index sendiri** — masing-masing menargetkan keyword spesifik ("sertifikasi auditor SPMI", "sertifikasi K3 lifting", dst).

**2.1 Model & migrasi `Skema`**
```
skemas: id, nama, slug, kode_skema, bidang(kategori), ringkasan,
        deskripsi(longText), unit_kompetensi(json/text), persyaratan(text),
        durasi, biaya(nullable), meta_title, meta_description, og_image,
        thumbnail, published, urutan, timestamps
```
- Resource Filament untuk admin kelola skema (CRUD + editor rich text).
- Route: `Route::get('/skema-sertifikasi/{slug}', [SkemaController::class, 'show'])`.
- Update daftar di [skema-sertifikasi.blade.php](resources/views/skema-sertifikasi.blade.php) agar tiap kartu nge-link ke halaman detail.

**2.2 Tiap halaman skema wajib punya:**
- `H1` = nama skema + intent ("Sertifikasi [Nama] BNSP — LSP Edukia")
- Schema **`Course`** atau **`Service`** (`provider` → Organization `@id`, `offers`, `hasCourseInstance`)
- Schema **`BreadcrumbList`** (Home › Skema › Nama Skema)
- Daftar unit kompetensi (konten kaya, ini yang dicari user)
- Persyaratan, alur sertifikasi, CTA WhatsApp daftar
- Internal link ke artikel blog terkait + skema serumpun

**2.3 Halaman kategori bidang** (`/skema-sertifikasi/bidang/{slug}`): hub untuk tiap bidang (Pendidikan Tinggi, Laboratorium, Lifting, dst) → memperkuat topical cluster.

---

### 🟡 FASE 3 — Optimasi Blog & Field SEO (Minggu 3–4)

**3.1 Tambah field SEO ke `posts`** (migrasi):
```
meta_title (nullable), meta_description (nullable), og_image (nullable),
focus_keyword (nullable), updated_seo_at
```
- Update [blog/show.blade.php](resources/views/blog/show.blade.php) & PostResource Filament:
  - `@section('title', $post->meta_title ?: $post->judul . ' — LSP Edukia')`
  - description pakai `meta_description` jika ada, fallback ke ringkasan.
  - Beri **preview snippet Google** + hitung karakter di form Filament (title ≤ 60, desc ≤ 155).

**3.2 Perkaya schema Article** → jadikan `BlogPosting` + tambah `wordCount`, `articleSection` (kategori), `author` sebagai `Person` dengan halaman bio (E-E-A-T), `BreadcrumbList`, dan `keywords`.

**3.3 Halaman kategori blog ter-index** (`/blog/kategori/{slug}`) dengan title/description unik + canonical sendiri (jangan `noindex` jika kontennya cukup). Sekarang `?kategori=` hanya query param — buat versi path yang ramah SEO.

**3.4 Strategi Topic Cluster (Pillar → Cluster):**
- Buat **pillar page** panjang per bidang, mis. "Panduan Lengkap Sertifikasi Profesi BNSP 2026".
- Artikel pendukung saling link ke pillar & ke halaman skema terkait (internal linking otomatis berdasarkan `kategori`).
- Target keyword informasional ("apa itu sertifikasi BNSP", "syarat ikut LSP", "beda LSP P1/P2/P3") → tarik top-of-funnel → konversi ke pendaftaran.

---

### 🟢 FASE 4 — Performa / Core Web Vitals (Minggu 4–5)

Ranking factor langsung + pengalaman pengguna. Target: LCP < 2.5s, CLS < 0.1, INP < 200ms.

**4.1 Google Fonts (saat ini render-blocking 3 family):**
- Self-host font via `@font-face` + `font-display: swap`, atau minimal preload + `media="print" onload`.
- Pertimbangkan kurangi ke 2 family / subset `latin` saja.

**4.2 Gambar:**
- Semua `<img>` wajib `width` + `height` (cegah CLS) + `loading="lazy"` kecuali LCP/hero.
- **Preload hero** LCP: `<link rel="preload" as="image" href="/images/hero-index.jpg" fetchpriority="high">`.
- Konversi aset besar ke **WebP/AVIF**; pasang pipeline (Intervention Image / `spatie/laravel-medialibrary` untuk konten Filament) agar thumbnail otomatis responsif (`srcset`).
- Thumbnail blog & skema: srcset 3 ukuran.

**4.3 Aset:**
- CSS inline besar di layout — ekstrak ke file via Vite + Tailwind (sudah ada), aktifkan caching `Cache-Control: public, max-age=31536000, immutable` untuk `build/`.
- Aktifkan kompresi Gzip/Brotli + HTTP/2 di server.
- Lazy-load slider JS & WhatsApp float.

**4.4 Caching aplikasi:** `route:cache`, `view:cache`, `config:cache` di deploy ([deploy.sh](deploy.sh)). Cache hasil sitemap (lihat 5.1).

---

### 🔵 FASE 5 — Technical SEO Lanjutan (Berkelanjutan)

**5.1 Upgrade Sitemap** ([SitemapController.php](app/Http/Controllers/SitemapController.php)):
- Cache output 6–24 jam (`Cache::remember`).
- Sertakan halaman **skema detail** & **kategori blog** & **kegiatan**.
- Tambah tag gambar (`<image:image>`) — `thumbnail` sudah di-select tapi belum dipakai di [sitemap.blade.php](resources/views/sitemap.blade.php).
- `lastmod` pakai `updated_at->toAtomString()`.
- Jika konten tumbuh > 1000 URL: pecah jadi sitemap index (`sitemap-posts.xml`, `sitemap-skema.xml`).

**5.2 robots.txt:** sudah blokir `/admin`. Pastikan juga `Disallow: /storage/framework`, izinkan asset; jangan blokir CSS/JS.

**5.3 Custom 404** yang membantu (link ke blog populer + skema) — kurangi bounce, jaga crawl.

**5.4 Breadcrumb visual + schema** di semua halaman dalam (skema, blog, kegiatan). Blog show sudah punya breadcrumb visual — tambahkan JSON-LD `BreadcrumbList`-nya.

**5.5 FAQ Schema** (`FAQPage`) di home & halaman skema (mis. "Apakah LSP Edukia terakreditasi BNSP?", "Berapa biaya sertifikasi?") → rich result + jawab People Also Ask.

**5.6 Verifikasi sertifikat sebagai aset SEO:** halaman `/daftar-penerima-sertifikat` adalah sinyal trust kuat. Pertimbangkan halaman verifikasi per-sertifikat (`/verifikasi/{nomor}`) dengan schema — bukti sosial + backlink alami.

---

## 2.5. Plugin / Package SEO (Padanan "Yoast SEO" untuk Laravel)

> Yoast adalah plugin **WordPress**. Karena situs ini **Laravel 12 + Filament 3.3**, padanannya
> adalah **package Composer**. Berikut peta fitur Yoast → package Laravel terbaik, plus rekomendasi stack.

### 🏆 Rekomendasi utama (paling mirip pengalaman Yoast)

**`ralphjsmit/laravel-seo`** — *ini "Yoast"-nya Laravel + Filament.*
- Punya **trait `HasSEO`** untuk model (Post, Skema) → tiap record menyimpan meta sendiri di tabel `seo` (polymorphic).
- Menyediakan **komponen form Filament** (`SEO::make()`) → editor dapat field **meta title, meta description, OG image, dengan preview** langsung di panel admin — persis pengalaman edit Yoast di WordPress.
- Render otomatis `<x-seo::meta />` di `<head>`: title, description, canonical, OG, Twitter, robots, dan JSON-LD `Article`/`WebPage`.
- Kompatibel Laravel 11/12 & Filament 3. **Pilih ini untuk Fase 3.1** (menggantikan field SEO manual yang saya usulkan di blueprint — lebih rapi & teruji).

```bash
composer require ralphjsmit/laravel-seo
php artisan vendor:publish --tag="seo-migrations"
php artisan migrate
```
```php
// app/Models/Post.php
use RalphJSmit\Laravel\SEO\Support\HasSEO;
class Post extends Model { use HasSEO; }
```
```php
// di PostResource Filament — beri editor pengalaman ala Yoast
use RalphJSmit\Filament\SEO\SEO;
SEO::make(), // field title/description/og image + preview
```

### 🔧 Stack pelengkap (gabungkan sesuai kebutuhan)

| Fitur Yoast | Package Laravel | Catatan |
|-------------|-----------------|---------|
| Meta title/desc/OG/Twitter dinamis | **`ralphjsmit/laravel-seo`** *(utama)* atau **`artesaos/seotools`** | seotools = API fasad `SEOMeta`, `OpenGraph`, `JsonLd`; cocok jika ingin kontrol manual di controller |
| Snippet preview di editor | **`ralphjsmit/laravel-seo`** (Filament) | satu-satunya yang memberi preview ala Yoast di admin |
| XML Sitemap otomatis | **`spatie/laravel-sitemap`** | crawl & generate otomatis; bisa gantikan `SitemapController` manual (lihat Fase 5.1) |
| Schema / JSON-LD (Course, FAQ, Breadcrumb, Org) | **`spatie/schema-org`** | builder fluent, type-safe — jauh lebih aman dari menulis JSON manual di Blade |
| Breadcrumbs (visual + schema) | **`diglactic/laravel-breadcrumbs`** | definisikan sekali, render HTML + feed ke schema |
| Redirect manager (fitur Yoast Premium) | **`spatie/laravel-missing-page-redirector`** | kelola 301 saat slug berubah; cegah 404 |
| Optimasi gambar (WebP/srcset) untuk Fase 4.2 | **`spatie/laravel-medialibrary`** + **`spatie/image`** | konversi & responsive image otomatis; terintegrasi Filament |
| Readability / analisis konten | *(tidak ada padanan langsung)* | gunakan editor guideline manual di form Filament (hitung karakter, dll) |

### Rekomendasi keputusan
- **Jalur tercepat & paling "Yoast-like":** `ralphjsmit/laravel-seo` (meta + Filament editor) **+** `spatie/schema-org` (JSON-LD) **+** `spatie/laravel-sitemap` (sitemap).
- **Jika ingin minim dependensi / kontrol penuh:** pertahankan implementasi `@yield`/`@stack` manual yang sudah ada (sudah 80% jalan) dan hanya tambahkan `spatie/schema-org` untuk schema kompleks (Course/FAQ/Breadcrumb).
- ⚠️ Jangan pasang dua manajer meta sekaligus (mis. seotools **dan** ralphjsmit) — pilih satu agar tidak ada tag `<title>`/canonical ganda.

> Setelah memilih, ini menggantikan/menyederhanakan **Fase 3.1** (field SEO) dan **Fase 5.1** (sitemap) di roadmap.
> Saya bisa langsung memasang & mengkonfigurasi stack pilihan Anda — sebutkan paket yang diinginkan.

---

## 3. Strategi Kata Kunci (Kerangka)

| Cluster | Pillar (top funnel) | Halaman konversi (bottom funnel) |
|---------|--------------------|----------------------------------|
| Sertifikasi BNSP umum | "Panduan Sertifikasi Profesi BNSP" | Home, /skema-sertifikasi |
| Pendidikan Tinggi & SPMI | "Sertifikasi Auditor SPMI: Syarat & Alur" | /skema/auditor-spmi |
| Laboratorium & Pengujian | "Sertifikasi Personel Laboratorium ISO 17025" | /skema/[lab] |
| Lifting Engineering | "Sertifikasi K3 Operator/Rigger Lifting" | /skema/[lifting] |
| Sistem Manajemen & Industri | "Sertifikasi Auditor ISO 9001" | /skema/[iso] |
| Hukum Korporasi | "Sertifikasi Legal Officer Korporasi" | /skema/[hukum] |

- Riset volume via GSC (query yang sudah masuk) + Google Keyword Planner + "People Also Ask".
- Prioritaskan keyword **transaksional/lokal** ("sertifikasi BNSP Semarang", "LSP terdekat") — konversi tinggi, kompetisi rendah.

---

## 4. Off-Page & Local SEO

- **Google Business Profile**: klaim & lengkapi (kategori "Certification agency", alamat Mijen Semarang, foto, jam, link). Konsistenkan **NAP** (Name-Address-Phone) dengan footer & schema.
- **Backlink**: daftar di direktori BNSP, asosiasi industri, kampus mitra, halaman alumni/perusahaan klien. Press release saat batch sertifikasi.
- **Social signals**: isi `sameAs` (Fase 1.4) + posting konsisten link ke artikel.
- **Internal linking**: tiap artikel link ke ≥2 skema + 1 pillar; tiap skema link ke skema serumpun.

---

## 5. Checklist Eksekusi (urut & bisa dicentang)

**Fase 1 — Fondasi**
- [ ] Google Search Console + submit sitemap
- [ ] Google Analytics 4 / Plausible terpasang via `@stack('head')`
- [ ] Bing Webmaster Tools
- [ ] `APP_URL` produksi benar + paksa HTTPS + kanonikalisasi www
- [ ] `<head>`: robots meta, theme-color, `@stack('schema')`
- [ ] Schema Organization global + `sameAs` terisi

**Fase 2 — Skema detail**
- [ ] Migrasi + Model `Skema` + Filament Resource
- [ ] Route + controller + view `/skema-sertifikasi/{slug}`
- [ ] Schema `Course`/`Service` + `BreadcrumbList` per skema
- [ ] Halaman hub per bidang

**Fase 3 — Blog**
- [ ] Field SEO di `posts` + form Filament (preview snippet)
- [ ] `BlogPosting` schema + author `Person` + bio
- [ ] Halaman kategori blog ber-path
- [ ] 2–3 pillar page + 8–10 artikel cluster

**Fase 4 — Performa**
- [ ] Self-host/optimasi font
- [ ] `width/height` + `loading` + WebP + `srcset` semua gambar
- [ ] Preload hero LCP
- [ ] Caching deploy (route/view/config) + Brotli

**Fase 5 — Technical lanjutan**
- [ ] Sitemap: cache + skema + gambar + lastmod valid
- [ ] Custom 404
- [ ] FAQ schema
- [ ] Breadcrumb JSON-LD semua halaman dalam
- [ ] Halaman verifikasi sertifikat

---

## 6. KPI & Pemantauan

| Metrik | Alat | Target 3 bln | Target 6 bln |
|--------|------|--------------|--------------|
| Halaman ter-index | GSC Coverage | +40 (skema+blog) | +80 |
| Klik organik / bln | GSC Performance | +50% | +150% |
| Kata kunci di top-10 | GSC / Ahrefs | 15 | 40 |
| Core Web Vitals "Good" | PageSpeed/CrUX | 75% URL | 90% URL |
| Rich result valid | GSC Enhancements | Article+Breadcrumb | +FAQ+Course |
| Konversi WA dari organik | GA4 event | baseline | +100% |

Review GSC tiap minggu (query baru, error crawl), audit teknis tiap bulan (Screaming Frog / PSI).

---

### Catatan Implementasi
Item paling cepat berdampak & low-risk untuk dikerjakan lebih dulu: **Fase 1 seluruhnya** (sehari kerja) lalu **Fase 2** (aset konten dengan ROI keyword tertinggi). Saya bisa langsung mengeksekusi item mana pun — sebutkan saja, mis. "kerjakan Fase 1.3–1.4" atau "buat model + halaman Skema detail".
