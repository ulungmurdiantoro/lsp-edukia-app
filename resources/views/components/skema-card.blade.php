@props(['scheme'])

@php
$iconPaths = [
  'building' => 'M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M13 9h.01M9 13h.01M13 13h.01M9 17h6',
  'beaker'   => 'M9 3v6L4 19a2 2 0 002 3h12a2 2 0 002-3l-5-10V3M9 3h6M7 14h10',
  'crane'    => 'M3 21h18M6 21V8M6 8h13M6 8L4 6M6 8v3l4 4M19 8v2h-3',
  'factory'  => 'M3 21h18M5 21V11l5 3V11l5 3V8l4-3v16',
  'scale'    => 'M12 3v18M5 7h14M7 21h10M5 7l-3 7h6L5 7zM19 7l-3 7h6l-3-7z',
];
$cats = [
  'spmi'      => ['label' => 'SPMI ISO 21001',      'color' => '#1a4a8a', 'bg' => '#e0ebff', 'icon' => 'building'],
  'pt'        => ['label' => 'Perguruan Tinggi',    'color' => '#102d57', 'bg' => '#eef3fb', 'icon' => 'building'],
  'lab17025'  => ['label' => 'Lab ISO 17025',       'color' => '#1a5c35', 'bg' => '#e3f5ea', 'icon' => 'beaker'],
  'labtest'   => ['label' => 'Lab & Pengujian',     'color' => '#1a5c35', 'bg' => '#e3f5ea', 'icon' => 'beaker'],
  'lifting'   => ['label' => 'Lifting Engineering', 'color' => '#d77110', 'bg' => '#fdf0e1', 'icon' => 'crane'],
  'manajemen' => ['label' => 'Sistem Manajemen',    'color' => '#922b2b', 'bg' => '#fde8e8', 'icon' => 'factory'],
  'hukum'     => ['label' => 'Hukum Korporasi',     'color' => '#5a3aa6', 'bg' => '#f0ecfa', 'icon' => 'scale'],
];
$cat = $cats[$scheme['kategori']] ?? $cats['spmi'];
$iconPath = $iconPaths[$cat['icon']] ?? '';
@endphp

<article style="background:#fff;border-radius:18px;overflow:hidden;border:1px solid #e6e9f0;
                display:flex;flex-direction:column;box-shadow:0 1px 0 rgba(15,29,53,.02);
                transition:transform .18s,box-shadow .18s;"
         data-cat="{{ $scheme['kategori'] }}"
         onmouseenter="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(15,29,53,.10)'"
         onmouseleave="this.style.transform='';this.style.boxShadow='0 1px 0 rgba(15,29,53,.02)'">

  {{-- HEADER BAND --}}
  <div style="background:linear-gradient(135deg,#0a2547,#102d57);color:#fff;
              padding:20px 22px;position:relative;overflow:hidden;">

    {{-- Corner glow --}}
    <div style="position:absolute;top:-40px;right:-40px;width:140px;height:140px;
                pointer-events:none;
                background:radial-gradient(circle,{{ $cat['color'] }}40,transparent 70%);"></div>

    {{-- Icon tile + scheme number/code --}}
    <div style="position:relative;display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
      <div style="display:flex;gap:12px;align-items:center;">
        <div style="width:38px;height:38px;border-radius:10px;flex-shrink:0;
                    background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);
                    display:grid;place-items:center;">
          <svg style="width:20px;height:20px;" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <path d="{{ $iconPath }}" />
          </svg>
        </div>
        <div>
          <div style="font-size:10.5px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#f4891f;">
            Skema {{ $scheme['nomor'] }}
          </div>
          <div style="font-size:11.5px;color:rgba(255,255,255,.55);font-family:ui-monospace,monospace;margin-top:2px;">
            {{ $scheme['kode'] }}
          </div>
        </div>
      </div>
    </div>

    {{-- Title --}}
    <h3 style="font-size:17.5px;line-height:1.3;letter-spacing:-0.01em;font-weight:700;
               color:#fff;margin:18px 0 12px;text-wrap:balance;">
      {{ $scheme['judul'] }}
    </h3>

    {{-- Category chip --}}
    <span style="display:inline-flex;align-items:center;gap:6px;
                 padding:5px 10px;border-radius:6px;font-size:11px;font-weight:700;
                 background:{{ $cat['bg'] }};color:{{ $cat['color'] }};">
      <span style="width:8px;height:8px;border-radius:50%;background:{{ $cat['color'] }};flex-shrink:0;"></span>
      {{ $cat['label'] }}
    </span>
  </div>

  {{-- BODY --}}
  <div style="padding:22px 22px 18px;flex:1;">
    <div style="font-size:10.5px;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;
                color:#5a6a85;margin-bottom:14px;">
      Persyaratan Dasar
    </div>
    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
      @foreach($scheme['reqs'] as $req)
      <li style="display:grid;grid-template-columns:22px 1fr;gap:10px;align-items:flex-start;">
        <span style="width:20px;height:20px;border-radius:6px;background:#eef3fb;color:#102d57;
                     display:grid;place-items:center;flex-shrink:0;margin-top:1px;">
          <svg style="width:12px;height:12px;" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 12l5 5L20 6" />
          </svg>
        </span>
        <span style="font-size:13.5px;line-height:1.55;color:#2a3a55;">{{ $req }}</span>
      </li>
      @endforeach
    </ul>
  </div>

  {{-- CTA PILL --}}
  <div style="padding:0 22px 22px;">
    <a href="{{ route('skema') }}"
       style="display:flex;justify-content:space-between;align-items:center;
              background:#f5f1e8;border:1px solid #dfe3ec;border-radius:999px;
              padding:12px 8px 12px 18px;text-decoration:none;
              color:#0f1d35;font-weight:600;font-size:13.5px;">
      <span>
        <span style="color:#0a2547;font-weight:800;">{{ $scheme['jumlah_unit'] }}</span>
        <span style="color:#5a6a85;"> unit kompetensi</span>
      </span>
      <span style="background:#0a2547;color:#fff;border-radius:999px;
                   padding:6px 14px;font-size:12px;font-weight:700;letter-spacing:0.02em;
                   display:inline-flex;align-items:center;gap:6px;">
        Lihat detail
        <svg style="width:12px;height:12px;" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
          <path d="M5 12h14M13 6l6 6-6 6" />
        </svg>
      </span>
    </a>
  </div>
</article>
