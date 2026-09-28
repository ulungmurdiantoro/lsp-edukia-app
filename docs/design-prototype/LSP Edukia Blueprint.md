# Skema Card B1 — Implementation Blueprint

> Developer handoff untuk implementasi Card Skema Kompetensi varian **B1 (Headline)** ke aplikasi `lsp-edukia-app` (Laravel 11 + Tailwind v4 + Blade).

| | |
|---|---|
| **Tech stack** | Laravel 11 · Blade · Tailwind v4 · Vite |
| **Output** | 1 Blade component + CSS tokens + minor refactor |
| **Estimasi** | 2–3 jam implementasi |
| **Versi** | v1.0 · 2026 |

---

## Daftar Isi

1. [Overview](#1-overview)
2. [Design tokens](#2-design-tokens)
3. [Tailwind v4 config](#3-tailwind-v4-config)
4. [Anatomy card](#4-anatomy-card)
5. [Blade component](#5-blade-component)
6. [Usage di halaman](#6-usage-di-halaman)
7. [Mobile responsive](#7-mobile-responsive)
8. [Integration steps](#8-integration-steps)
9. [QA checklist](#9-qa-checklist)

---

## 1. Overview

Card **B1 Headline** adalah varian terpilih sebagai master untuk seluruh sistem. Karakteristik:

- **Navy gradient header band** (navy-800 → navy-700) dengan ikon kategori dalam tile semi-transparan
- **Badge "Skema 0X"** berwarna oranye di atas, kode dokumen mono di bawahnya
- **Title putih** 17.5px / bold / balanced text wrap
- **Category chip berwarna** sesuai bidang (7 kategori distinct)
- **Body putih** dengan eyebrow "Persyaratan Dasar" + checkmark list dalam tile navy-50
- **CTA pil** di bottom: jumlah unit kompetensi + tombol "Lihat detail" navy

Anatomi visual: lihat preview di file [`LSP Edukia Blueprint.html`](LSP%20Edukia%20Blueprint.html) section 4, atau di [`LSP Edukia Redesign.html`](LSP%20Edukia%20Redesign.html) artboard "4 Micro-variations · B1–B4" (kolom B1).

---

## 2. Design tokens

Saat ini, brand colors hardcoded sebagai CSS variables di `resources/views/layouts/app.blade.php`. Pindahkan ke Tailwind `@theme` agar bisa diakses sebagai utility class.

### 2.1 Brand colors

| Token | Hex | Tailwind class | Usage |
|---|---|---|---|
| Navy 900 | `#06172e` | `bg-navy-900` | Footer, deep backgrounds |
| Navy 800 | `#0a2547` | `bg-navy-800` | Card header gradient start, nav active |
| Navy 700 | `#102d57` | `bg-navy-700` | Card header gradient end |
| Navy 600 | `#173a6b` | `bg-navy-600` | Hover, gradient mid |
| Navy 500 | `#21528f` | `bg-navy-500` | Decorative |
| Navy 50 | `#eef3fb` | `bg-navy-50` | Checkmark icon bg, soft tint |
| Orange | `#f4891f` | `bg-orange` / `text-orange` | CTA buttons, "Skema 0X" label |
| Orange Deep | `#d77110` | `bg-orange-deep` | CTA hover, eyebrow text |
| Orange 50 | `#fdf0e1` | `bg-orange-50` | Tint accent |
| Blue | `#449fe5` | `bg-blue` / `text-blue` | Italic display accent (Fraunces) |
| Blue Deep | `#2a7fc4` | `bg-blue-deep` | Link hover |
| Blue 50 | `#eaf4fd` | `bg-blue-50` | Info callout bg |
| Cream | `#f5f1e8` | `bg-cream` | Page bg, CTA pill bg |
| Cream 2 | `#efeadc` | `bg-cream-2` | Subtle alternation |
| Line | `#e6e9f0` | `border-line` | Card borders, dividers |
| Line 2 | `#dfe3ec` | `border-line-2` | Subtle borders |
| Ink | `#0f1d35` | `text-ink` | Body text primary |
| Ink 2 | `#2a3a55` | `text-ink-2` | Body text secondary |
| Muted | `#5a6a85` | `text-muted` | Captions, meta, labels |

### 2.2 Category colors (mapping ke field `kategori`)

| Kategori | Color (text) | Background | Hex |
|---|---|---|---|
| `spmi` | SPMI ISO 21001 | `#e0ebff` | `#1a4a8a` / `#e0ebff` |
| `pt` | Perguruan Tinggi | `#eef3fb` | `#102d57` / `#eef3fb` |
| `lab17025` | Lab ISO 17025 | `#e3f5ea` | `#1a5c35` / `#e3f5ea` |
| `labtest` | Lab & Pengujian | `#e3f5ea` | `#1a5c35` / `#e3f5ea` |
| `lifting` | Lifting Engineering | `#fdf0e1` | `#d77110` / `#fdf0e1` |
| `manajemen` | Sistem Manajemen | `#fde8e8` | `#922b2b` / `#fde8e8` |
| `hukum` | Hukum Korporasi | `#f0ecfa` | `#5a3aa6` / `#f0ecfa` |

### 2.3 Typography

| Role | Family | Weight | Tailwind |
|---|---|---|---|
| UI / Body / Headings | Plus Jakarta Sans | 400 / 500 / 700 / 800 | `font-sans` |
| Italic display accent | Fraunces | 400 italic | `font-display italic` |
| Code / metadata | JetBrains Mono | 500 / 600 | `font-mono` |

---

## 3. Tailwind v4 config

Aplikasi sudah pakai Tailwind v4 dengan `@theme` directive. Update `resources/css/app.css`:

```css
@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../**/*.blade.php';
@source '../**/*.js';

@theme {
  /* Typography */
  --font-sans:    "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
  --font-display: "Fraunces", ui-serif, Georgia, serif;
  --font-mono:    "JetBrains Mono", ui-monospace, SFMono-Regular, monospace;

  /* Navy scale */
  --color-navy-50:  #eef3fb;
  --color-navy-500: #21528f;
  --color-navy-600: #173a6b;
  --color-navy-700: #102d57;
  --color-navy-800: #0a2547;
  --color-navy-900: #06172e;

  /* Accents */
  --color-orange:      #f4891f;
  --color-orange-deep: #d77110;
  --color-orange-50:   #fdf0e1;
  --color-blue:        #449fe5;
  --color-blue-deep:   #2a7fc4;
  --color-blue-50:     #eaf4fd;

  /* Ink (text) */
  --color-ink:    #0f1d35;
  --color-ink-2:  #2a3a55;
  --color-muted:  #5a6a85;

  /* Surfaces */
  --color-cream:   #f5f1e8;
  --color-cream-2: #efeadc;
  --color-line:    #e6e9f0;
  --color-line-2:  #dfe3ec;
}

@layer base {
  body {
    font-family: theme(--font-sans);
    color: theme(--color-ink);
    background: theme(--color-cream);
  }
}
```

> 💡 **Tip:** Setelah ini, utility class `bg-navy-800`, `text-orange`, `border-line`, `font-display` langsung tersedia di Blade.

### 3.1 Load fonts

Update `<head>` di `resources/views/layouts/app.blade.php` (Plus Jakarta Sans + Fraunces sudah ada, tambahkan JetBrains Mono):

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
```

---

## 4. Anatomy card

Card terdiri dari **3 region** utama. Semua ukuran fixed, kecuali width yang fluid mengikuti grid container.

| Region | Padding | Background | Notes |
|---|---|---|---|
| Card wrapper | — | `#fff` | `border 1px line`, `border-radius 18px`, `overflow hidden` |
| Header band | `20px 22px` | linear-gradient navy-800 → navy-700 | `position: relative`; corner radial pattern di top-right |
| Icon tile | 9px padding (38×38) | `rgba(255,255,255,.08)` | `border 1px white/18`, `rounded-lg` |
| "Skema 0X" label | — | — | 10.5px / 700 / 0.18em / uppercase / `text-orange` |
| Code line | — | — | 11.5px / mono / `white/55` |
| Title (h3) | margin `18/0 12/0` | — | 17.5px / 700 / leading-1.3 / -0.01em / `text-balance` |
| Category chip | `5px 10px` | `cat.bg` | `border-radius 6px`, 11px/700, with dot indicator |
| Body | 22px top, 18px bottom | `#fff` | Eyebrow "Persyaratan Dasar" + `ul` |
| Check icon tile | — (20×20) | `bg-navy-50` | `rounded 6px`, `text-navy-700`, stroke 2.5 |
| Requirement item | `grid 22px / 1fr / gap 10px` | — | 13.5px / leading-1.55 / `text-ink-2` |
| CTA pill | `12px 8px 12px 18px` | `bg-cream` | `border-radius 999px`, navy-800 detail button inset |

---

## 5. Blade component

### 5.1 File: `resources/views/components/skema-card.blade.php`

```blade
@props(['scheme'])

@php
// Map category → chip color + icon name
$cats = [
  'spmi'      => ['label' => 'SPMI ISO 21001',   'color' => '#1a4a8a', 'bg' => '#e0ebff', 'icon' => 'building'],
  'pt'        => ['label' => 'Perguruan Tinggi', 'color' => '#102d57', 'bg' => '#eef3fb', 'icon' => 'building'],
  'lab17025'  => ['label' => 'Lab ISO 17025',    'color' => '#1a5c35', 'bg' => '#e3f5ea', 'icon' => 'beaker'],
  'labtest'   => ['label' => 'Lab & Pengujian',  'color' => '#1a5c35', 'bg' => '#e3f5ea', 'icon' => 'beaker'],
  'lifting'   => ['label' => 'Lifting Eng.',     'color' => '#d77110', 'bg' => '#fdf0e1', 'icon' => 'crane'],
  'manajemen' => ['label' => 'Sistem Manajemen', 'color' => '#922b2b', 'bg' => '#fde8e8', 'icon' => 'factory'],
  'hukum'     => ['label' => 'Hukum Korporasi',  'color' => '#5a3aa6', 'bg' => '#f0ecfa', 'icon' => 'scale'],
];
$cat = $cats[$scheme['kategori']] ?? $cats['spmi'];
@endphp

<article class="bg-white rounded-2xl overflow-hidden border border-line flex flex-col
                shadow-[0_1px_0_rgba(15,29,53,0.02)] transition hover:-translate-y-0.5 hover:shadow-lg">

  {{-- ===== HEADER BAND ===== --}}
  <div class="relative overflow-hidden p-4 sm:p-5 bg-gradient-to-br from-navy-800 to-navy-700 text-white">
    {{-- Decorative corner glow --}}
    <div class="absolute -top-10 -right-10 w-36 h-36 rounded-full pointer-events-none"
         style="background: radial-gradient(circle, {{ $cat['color'] }}40, transparent 70%);"></div>

    {{-- Top row: icon + number/code --}}
    <div class="relative flex justify-between items-start gap-3">
      <div class="flex gap-3 items-center">
        <div class="w-9 h-9 rounded-lg bg-white/10 border border-white/20 grid place-items-center">
          <x-icon :name="$cat['icon']" class="w-5 h-5" />
        </div>
        <div>
          <div class="text-[10.5px] font-bold tracking-[0.18em] uppercase text-orange">
            Skema {{ $scheme['nomor'] }}
          </div>
          <div class="text-[11.5px] text-white/55 font-mono mt-0.5">
            {{ $scheme['kode'] }}
          </div>
        </div>
      </div>
    </div>

    {{-- Title --}}
    <h3 class="text-[16px] sm:text-[17.5px] leading-tight tracking-tight font-bold text-white
               mt-4 mb-3 text-balance">
      {{ $scheme['judul'] }}
    </h3>

    {{-- Category chip --}}
    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                 text-[11px] font-bold tracking-wider"
          style="background: {{ $cat['bg'] }}; color: {{ $cat['color'] }};">
      <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $cat['color'] }}"></span>
      {{ $cat['label'] }}
    </span>
  </div>

  {{-- ===== BODY ===== --}}
  <div class="p-4 sm:p-5 sm:pt-[22px] flex-1">
    <div class="text-[10.5px] font-extrabold tracking-[0.16em] uppercase text-muted mb-3.5">
      Persyaratan Dasar
    </div>
    <ul class="space-y-2.5 list-none p-0 m-0">
      @foreach($scheme['reqs'] as $req)
      <li class="grid grid-cols-[22px_1fr] gap-2.5 items-start">
        <span class="w-5 h-5 rounded-md bg-navy-50 text-navy-700
                     grid place-items-center mt-px flex-shrink-0">
          <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 12l5 5L20 6" />
          </svg>
        </span>
        <span class="text-[13.5px] leading-relaxed text-ink-2">{{ $req }}</span>
      </li>
      @endforeach
    </ul>
  </div>

  {{-- ===== CTA PILL ===== --}}
  <div class="px-4 sm:px-5 pb-4 sm:pb-5">
    <a href="{{ route('skema') }}#skema-{{ $scheme['nomor'] }}"
       class="flex justify-between items-center bg-cream border border-line-2
              rounded-full py-3 pl-4 pr-1.5 no-underline text-ink font-semibold text-[13.5px]
              hover:bg-cream-2 transition">
      <span>
        <span class="text-navy-800 font-extrabold">{{ $scheme['jumlah_unit'] }}</span>
        <span class="text-muted"> unit kompetensi</span>
      </span>
      <span class="bg-navy-800 text-white rounded-full px-3.5 py-1.5
                   text-xs font-bold tracking-wider inline-flex items-center gap-1.5">
        Lihat detail
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
          <path d="M5 12h14M13 6l6 6-6 6" />
        </svg>
      </span>
    </a>
  </div>
</article>
```

### 5.2 Helper: `resources/views/components/icon.blade.php`

```blade
@props(['name'])

@php
$paths = [
  'building' => 'M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M13 9h.01M9 13h.01M13 13h.01M9 17h6',
  'beaker'   => 'M9 3v6L4 19a2 2 0 002 3h12a2 2 0 002-3l-5-10V3M9 3h6M7 14h10',
  'crane'    => 'M3 21h18M6 21V8M6 8h13M6 8L4 6M6 8v3l4 4M19 8v2h-3',
  'factory'  => 'M3 21h18M5 21V11l5 3V11l5 3V8l4-3v16',
  'scale'    => 'M12 3v18M5 7h14M7 21h10M5 7l-3 7h6L5 7zM19 7l-3 7h6l-3-7z',
];
@endphp

<svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none',
                            'stroke' => 'currentColor', 'stroke-width' => '1.6',
                            'stroke-linejoin' => 'round', 'stroke-linecap' => 'round']) }}>
  <path d="{{ $paths[$name] ?? '' }}" />
</svg>
```

---

## 6. Usage di halaman

### 6.1 Loop di home page

Update `resources/views/index.blade.php`:

```blade
{{-- index.blade.php · section persyaratan --}}
<section id="persyaratan" class="py-24 bg-cream">
  <div class="wrap">
    {{-- ... section head ... --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="schemes">
      @foreach($schemes as $scheme)
        <x-skema-card :scheme="$scheme" />
      @endforeach
    </div>
  </div>
</section>
```

### 6.2 Controller data shape

Pastikan `app/Http/Controllers/PageController.php` memasok struktur ini ke view:

```php
public function home()
{
    $schemes = [
        [
            'nomor'       => '01',
            'kode'        => 'EDUKIA-AIL-2024-001',
            'judul'       => 'Auditor Internal SPMI Terintegrasi ISO 21001:2018',
            'kategori'    => 'spmi',
            'jumlah_unit' => 7,
            'reqs'        => [
                'Pendidikan minimal S2',
                'Pengalaman kerja di bidang Perguruan Tinggi',
                'Sertifikat Pelatihan Auditor Internal',
            ],
        ],
        // ... 25 skema lainnya dari sumber data Anda
    ];

    $kegiatan = \App\Models\Kegiatan::orderByDesc('tanggal')->take(6)->get();

    return view('index', compact('schemes', 'kegiatan'));
}
```

> ⚠️ **Catatan data:** Saat ini 26 skema hard-coded sebagai HTML di Blade. Memindahkannya ke array PHP (atau database model `Skema`) akan membuat card component reusable dan editable lewat admin panel Filament yang sudah ada.

---

## 7. Mobile responsive

Card menggunakan Tailwind responsive utilities. Tidak perlu component terpisah — cukup tambahkan modifier breakpoint pada elemen yang perlu disesuaikan.

### 7.1 Adjustments di mobile (<768px)

| Element | Desktop | Mobile |
|---|---|---|
| Card grid | `lg:grid-cols-3` | `grid-cols-1` |
| Header padding | `p-5` | `p-4` |
| Title size | `text-[17.5px]` | `text-[16px]` |
| Body padding | `p-5` | `p-4` |
| CTA pill | full row dengan "Lihat detail" | min height 44px (touch target) — sudah aman dengan `py-3` |

Komponen di section 5 sudah include semua modifier responsive di atas. Cukup atur grid container di parent:

```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
```

### 7.2 Filter chips — mobile horizontal scroll

Chip kategori di mobile perlu horizontal scroll agar tidak overflow:

```blade
<div class="flex gap-2 overflow-x-auto -mx-5 px-5 pb-2
            md:flex-wrap md:overflow-visible md:mx-0 md:px-0" id="chips">
  @foreach($categories as $cat)
    <button class="flex-shrink-0 chip ..." data-filter="{{ $cat['id'] }}">
      {{ $cat['label'] }} <span class="count">{{ $cat['count'] }}</span>
    </button>
  @endforeach
</div>
```

### 7.3 Hasil di mobile (390px)

- Card otomatis full-width dengan padding `p-4`
- Header gradient tetap kebaca, kategori chip tetap visible
- CTA pill tetap mudah di-tap (target 44px)
- Filter chips di parent page horizontal-scroll dengan `overflow-x-auto` + `flex-shrink-0`

---

## 8. Integration steps

Langkah berurutan untuk integrasi ke aplikasi `lsp-edukia-app`:

### Step 1 · Update Tailwind tokens
Edit `resources/css/app.css`. Tambahkan `@theme` block dari [section 3](#3-tailwind-v4-config).

**Verifikasi:** jalankan `npm run dev` dan inspect element untuk pastikan utility seperti `bg-navy-800` bekerja.

### Step 2 · Buat icon component
Buat file `resources/views/components/icon.blade.php` dengan code dari [section 5.2](#52-helper-resourcesviewscomponentsiconbladephp).

### Step 3 · Buat skema-card component
Buat file `resources/views/components/skema-card.blade.php` dengan code utama dari [section 5.1](#51-file-resourcesviewscomponentsskema-cardbladephp).

### Step 4 · Refactor data 26 skema
Pindahkan data skema dari hard-coded HTML di Blade ke salah satu opsi:

- **Opsi A (cepat):** Array PHP di `PageController` — lihat [section 6.2](#62-controller-data-shape).
- **Opsi B (recommended):** Buat migration + model `Skema` + seeder. Bisa dikelola via Filament admin yang sudah ada.

```bash
php artisan make:model Skema -m
php artisan make:seeder SkemaSeeder
php artisan migrate --seed
```

### Step 5 · Refactor halaman
Ganti loop manual di:
- `resources/views/index.blade.php`
- `resources/views/skema-sertifikasi.blade.php`

…dengan `<x-skema-card :scheme="$scheme" />` di dalam `@foreach`.

### Step 6 · Bersihkan CSS lama
Di `layouts/app.blade.php`, hapus block CSS lama yang sudah digantikan utility Tailwind:
- `.scheme`, `.scheme-header`, `.scheme-top`
- `.scheme-badge`, `.scheme-name`, `.scheme-type`
- `.tag` dan turunannya `.scheme[data-cat="*"] .tag`
- `.unit-table`, `.unit-link`
- `.req-list`, `.req-group-label`, `.scheme-foot`

> CSS lain (hero, header, footer, alur) bisa tetap dipertahankan sampai siap migrasi penuh ke Tailwind.

### Step 7 · Mobile responsive
Update grid container di parent — gunakan `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4`. Modifier responsive di card sudah included.

### Step 8 · Test cross-browser & accessibility
Lihat [QA checklist](#9-qa-checklist). Pastikan kontras warna OK (chip kategori vs bg), keyboard navigation jalan, screen reader bisa baca struktur card dengan benar.

---

## 9. QA checklist

### 9.1 Visual fidelity

- [ ] Header band gradient match (navy-800 → navy-700) di semua kategori
- [ ] Corner glow di top-right header mengikuti warna kategori
- [ ] "Skema 0X" label oranye tampil di header, code mono di bawahnya
- [ ] Title white, 17.5px, balance, max 3 lines (test dengan judul panjang)
- [ ] Category chip warna sesuai mapping (7 kategori distinct)
- [ ] Checkmark icon dalam tile navy-50 dengan navy-700 stroke
- [ ] CTA pill `bg-cream` dengan navy-800 detail button inset
- [ ] Hover state: subtle lift (`-translate-y-0.5`) + shadow

### 9.2 Responsive

- [ ] Grid: 1 kolom di mobile (<640), 2 di tablet (md), 3 di desktop (lg)
- [ ] Padding berkurang `p-5 → p-4` di mobile
- [ ] Title tidak overflow di mobile (`text-balance` + max-width container)
- [ ] CTA pill mudah di-tap (min height 44px)
- [ ] Filter chips horizontal-scroll di mobile

### 9.3 Accessibility

- [ ] Semantic: `<article>` wrapper, `<h3>` untuk title
- [ ] Link CTA punya text deskriptif ("Lihat detail [Nama Skema]") — tambahkan `aria-label` jika perlu
- [ ] Kontras: chip kategori meet WCAG AA (test setiap kategori)
- [ ] Keyboard: tab order natural, focus visible dengan `outline-2 outline-blue`
- [ ] Icon decorative punya `aria-hidden="true"` atau dimasukkan ke dalam link

### 9.4 Performance

- [ ] Fonts: `font-display: swap` di Google Fonts URL
- [ ] Tailwind v4 sudah otomatis purge — tidak ada CSS bloat dari token tambahan
- [ ] SVG icons inline, bukan separate file requests
- [ ] Lighthouse CLS < 0.1 (test dengan card terisi data sebenarnya)

---

✅ **Ready to ship** — Setelah 4 sub-section di atas tercentang semua, card sudah siap di-merge. Test di staging dengan data 26 skema lengkap sebelum push ke production.

---

## Referensi

- [Design canvas (HTML)](LSP%20Edukia%20Redesign.html) — semua mockup interaktif
- [Blueprint HTML (printable)](LSP%20Edukia%20Blueprint.html) — versi yang sama dengan styling
- Original code: `resources/views/index.blade.php`, `resources/views/skema-sertifikasi.blade.php`
- Tailwind v4 docs: <https://tailwindcss.com/docs/v4-beta>
- Laravel Blade components: <https://laravel.com/docs/11.x/blade#components>

---

*Blueprint v1.0 · Skema Card B1 · LSP Edukia · 2026*
