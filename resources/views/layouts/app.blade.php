<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'LSP Edukia — Sertifikasi Profesi')</title>
<meta name="description" content="@yield('description', 'LSP Edukia adalah lembaga sertifikasi profesi terakreditasi BNSP dengan 26 skema kompetensi di bidang pendidikan, manajemen, laboratorium, dan hukum korporasi.')">
<link rel="canonical" href="{{ url()->current() }}">
<link rel="icon" href="/favicon.ico" sizes="any">
<!-- Open Graph -->
<meta property="og:type" content="@yield('og-type', 'website')">
<meta property="og:title" content="@yield('title', 'LSP Edukia — Sertifikasi Profesi')">
<meta property="og:description" content="@yield('description', 'LSP Edukia adalah lembaga sertifikasi profesi terakreditasi BNSP dengan 26 skema kompetensi di bidang pendidikan, manajemen, laboratorium, dan hukum korporasi.')">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="@yield('og-image', asset('images/hero-index.jpg'))">
<meta property="og:site_name" content="LSP Edukia">
<meta property="og:locale" content="id_ID">
<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', 'LSP Edukia — Sertifikasi Profesi')">
<meta name="twitter:description" content="@yield('description', 'LSP Edukia adalah lembaga sertifikasi profesi terakreditasi BNSP dengan 26 skema kompetensi.')">
<meta name="twitter:image" content="@yield('og-image', asset('images/hero-index.jpg'))">
@yield('schema-json')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<style>
:root{
  --navy-900:#06172e;--navy-800:#0a2547;--navy-700:#102d57;
  --navy-600:#173a6b;--navy-500:#21528f;--navy-50:#eef3fb;
  --ink:#0f1d35;--ink-2:#2a3a55;--muted:#5a6a85;
  --line:#e6e9f0;--line-2:#dfe3ec;
  --cream:#f5f1e8;--cream-2:#efeadc;--card:#ffffff;
  --blue:#449fe5;--blue-deep:#2a7fc4;--blue-50:#eaf4fd;
  --orange:#f4891f;--orange-deep:#d77110;--orange-50:#fdf0e1;
  --green-ok:#2f8a55;--warn:#c0532e;
}
*{box-sizing:border-box}html,body{margin:0;padding:0}
body{font-family:"Plus Jakarta Sans",system-ui,sans-serif;color:var(--ink);background:var(--cream);-webkit-font-smoothing:antialiased;line-height:1.5}
a{color:inherit;text-decoration:none}button{font:inherit;cursor:pointer;border:0;background:none;color:inherit}
.wrap{max-width:1240px;margin:0 auto;padding:0 32px}
h1,h2,h3,h4{font-family:"Plus Jakarta Sans",sans-serif;font-weight:700;letter-spacing:-0.02em;margin:0;color:var(--ink);text-wrap:balance}
h1{font-size:clamp(36px,5vw,64px);line-height:1.02;font-weight:800;letter-spacing:-0.035em}
h2{font-size:clamp(26px,4vw,40px);line-height:1.08;letter-spacing:-0.025em}
h3{font-size:18px;line-height:1.3;font-weight:700}
p{margin:0;color:var(--ink-2)}
.eyebrow{font-size:12px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:var(--orange-deep);display:inline-flex;align-items:center;gap:8px}
.eyebrow::before{content:"";width:18px;height:2px;background:var(--orange);display:inline-block;border-radius:2px}
.sub{color:var(--muted);font-size:16px;max-width:62ch}
/* Header */
header{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.92);backdrop-filter:saturate(140%) blur(10px);border-bottom:1px solid var(--line)}
.nav{display:flex;align-items:center;gap:32px;padding:14px 0}
.brand{display:flex;align-items:center;gap:12px;margin-right:auto;text-decoration:none}
.brand-logo{height:52px;width:auto;display:block;object-fit:contain}
nav.menu{display:flex;gap:20px}
nav.menu a{font-size:13.5px;font-weight:500;color:var(--ink-2);position:relative;padding:6px 0}
nav.menu a:hover{color:var(--navy-800)}
nav.menu a.active{color:var(--navy-800);font-weight:600}
nav.menu a.active::after{content:"";position:absolute;left:0;right:0;bottom:-2px;height:2px;background:linear-gradient(90deg,var(--blue),var(--orange));border-radius:2px}
.btn{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 18px;border-radius:999px;font-weight:600;font-size:14.5px;letter-spacing:-0.005em;transition:transform .15s ease,box-shadow .2s ease,background .2s ease}
.btn-primary{background:var(--orange);color:#fff;box-shadow:0 4px 14px rgba(244,137,31,.35)}
.btn-primary:hover{background:var(--orange-deep);transform:translateY(-1px);box-shadow:0 6px 20px rgba(244,137,31,.4)}
.btn-ghost{background:rgba(255,255,255,.08);color:#fff;border:1px solid rgba(255,255,255,.18)}
.btn-ghost:hover{background:rgba(255,255,255,.14)}
.btn-outline{border:1px solid var(--line-2);color:var(--ink);background:#fff}
.btn-outline:hover{border-color:var(--navy-500);color:var(--navy-800)}
.btn-lg{height:52px;padding:0 24px;font-size:15.5px}
/* Hero */
.hero{background:radial-gradient(900px 500px at 90% -10%,rgba(68,159,229,.28),transparent 60%),radial-gradient(700px 400px at 10% 110%,rgba(244,137,31,.18),transparent 60%),linear-gradient(105deg,rgba(10,37,71,.68) 0%,rgba(10,37,71,.75) 45%,rgba(6,23,46,.97) 75%),url('/images/hero-index.jpg');background-size:auto,auto,auto,cover;background-position:top right,bottom left,center,left center;color:#fff;position:relative;overflow:hidden}
.hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.hero-grid{display:grid;grid-template-columns:1.15fr 1fr;gap:56px;align-items:center;padding:88px 0 104px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase}
.badge .dot{width:7px;height:7px;border-radius:50%;background:#7ee0a3;box-shadow:0 0 0 4px rgba(126,224,163,.18)}
.hero h1{color:#fff;margin:20px 0 18px}
.hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue);letter-spacing:-0.04em}
.hero p.lead{color:rgba(255,255,255,.78);font-size:17.5px;max-width:52ch;line-height:1.55}
.hero-cta{display:flex;gap:12px;margin-top:32px;align-items:center}
.hero-trust{display:flex;gap:18px;margin-top:36px;align-items:center;color:rgba(255,255,255,.6);font-size:12.5px;letter-spacing:0.02em}
.hero-trust .line{flex:1;height:1px;background:rgba(255,255,255,.12)}
.stat-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.stat{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.12);border-radius:20px;padding:24px 22px;position:relative;overflow:hidden;transition:border-color .2s,transform .2s,background .2s}
.stat:hover{border-color:rgba(68,159,229,.5);transform:translateY(-2px)}
.stat .v{font-family:"Plus Jakarta Sans";font-size:54px;font-weight:800;letter-spacing:-0.04em;line-height:1;color:#fff;display:flex;align-items:baseline;gap:4px}
.stat .v small{font-size:22px;font-weight:600;color:rgba(255,255,255,.6);letter-spacing:0}
.stat .v.online{font-size:36px;font-weight:700}
.stat .l{margin-top:8px;font-size:13.5px;color:rgba(255,255,255,.65);font-weight:500}
.stat.featured{background:linear-gradient(135deg,rgba(68,159,229,.18),rgba(244,137,31,.1));border-color:rgba(68,159,229,.32)}
.stat .corner{position:absolute;top:14px;right:14px;width:22px;height:22px;border-radius:6px;display:grid;place-items:center;background:rgba(255,255,255,.08);color:rgba(255,255,255,.5);font-size:11px;font-weight:700}
/* Sections */
section{padding:96px 0;border-top:1px solid var(--line)}
.sec-head{margin-bottom:48px;max-width:760px}
.sec-head h2{margin:8px 0 14px}
/* Panel */
.panel{background:#fff;border:1px solid var(--line);border-radius:16px;padding:26px 28px}
.panel-head{display:flex;align-items:center;gap:12px;margin-bottom:16px}
.panel-head .ico{width:42px;height:42px;border-radius:12px;display:grid;place-items:center;background:var(--navy-50);color:var(--navy-700)}
.panel-head .ico.orange{background:var(--orange-50);color:var(--orange-deep)}
.panel-head .ico.blue{background:var(--blue-50);color:var(--blue-deep)}
.panel-head h3{font-size:18px}
.panel-head .sm{font-size:13px;color:var(--muted);font-weight:500;margin-top:2px}
/* Num list */
.num-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:14px}
.num-list li{display:flex;gap:14px;align-items:flex-start}
.num-list .n{width:24px;height:24px;border-radius:50%;background:var(--cream-2);color:var(--ink);font-size:12px;font-weight:700;display:grid;place-items:center;flex:0 0 auto;margin-top:1px}
.num-list.blue .n{background:var(--blue);color:#fff}
.num-list.orange .n{background:var(--orange);color:#fff}
.num-list.navy .n{background:var(--navy-800);color:#fff}
.num-list li p{font-size:14.5px;color:var(--ink-2);line-height:1.55}
.num-list li b{color:var(--ink);font-weight:600}
/* Step cards */
.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.step{background:var(--card);border:1px solid var(--line);border-radius:18px;padding:24px;position:relative;transition:border-color .2s,transform .2s}
.step:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 12px 32px rgba(15,29,53,.06)}
.step-num{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;font-weight:800;background:var(--navy-800);color:#fff;font-size:14px;box-shadow:0 4px 12px rgba(10,37,71,.25)}
.step:nth-child(2) .step-num{background:var(--blue-deep)}
.step:nth-child(3) .step-num{background:var(--blue)}
.step:nth-child(4) .step-num{background:var(--orange)}
.step-ico{margin:22px 0 14px;width:42px;height:42px;border-radius:10px;background:var(--navy-50);color:var(--navy-700);display:grid;place-items:center}
.step h3{margin-bottom:8px}
.step p{font-size:14px;color:var(--muted);line-height:1.55}
.step-connector{position:absolute;top:38px;right:-15px;width:30px;height:2px;background:repeating-linear-gradient(90deg,var(--line-2) 0 4px,transparent 4px 8px);z-index:1}
.step:last-child .step-connector{display:none}
/* Filter chips */
.chips{display:flex;flex-wrap:wrap;gap:10px;margin:0 0 28px}
.chip{height:40px;padding:0 18px;border-radius:999px;border:1px solid var(--line-2);background:#fff;font-size:13.5px;font-weight:500;color:var(--ink-2);display:inline-flex;align-items:center;gap:10px;transition:all .15s;cursor:pointer}
.chip:hover{border-color:var(--navy-500);color:var(--navy-800)}
.chip.active{background:var(--navy-800);color:#fff;border-color:var(--navy-800)}
.chip .count{font-size:11.5px;color:var(--muted);font-weight:600;padding:2px 7px;border-radius:999px;background:var(--cream-2)}
.chip.active .count{color:rgba(255,255,255,.7);background:rgba(255,255,255,.12)}
/* Slider */
.slider-wrap{position:relative}
.slider-viewport{overflow:hidden;border-radius:20px}
.slider-track{display:flex;gap:20px;transition:transform .4s cubic-bezier(.4,0,.2,1)}
.slide{flex:0 0 calc(33.333% - 14px);min-width:0;background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden}
.slide-img{aspect-ratio:16/9;background:linear-gradient(135deg,var(--navy-50),var(--cream-2));display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
.slide-img img{width:100%;height:100%;object-fit:cover;display:block}
.slide-img .placeholder{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;color:var(--muted);font-size:13px;font-weight:500}
.slide-img .placeholder svg{opacity:.4}
.slide-body{padding:18px 20px}
.slide-body .slide-cat{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--blue-deep);margin-bottom:6px}
.slide-body h4{font-size:15px;font-weight:700;color:var(--ink);line-height:1.35;margin:0 0 6px}
.slide-body p{font-size:13px;color:var(--muted);line-height:1.55}
.slider-nav{display:flex;align-items:center;justify-content:center;gap:16px;margin-top:28px}
.slider-btn{width:42px;height:42px;border-radius:50%;border:1px solid var(--line-2);background:#fff;color:var(--ink-2);display:grid;place-items:center;cursor:pointer;transition:all .15s;flex:0 0 auto}
.slider-btn:hover{border-color:var(--navy-500);color:var(--navy-800);background:var(--navy-50)}
.slider-btn:disabled{opacity:.35;cursor:not-allowed}
.slider-dots{display:flex;gap:8px;align-items:center}
.dot{width:8px;height:8px;border-radius:50%;background:var(--line-2);border:0;cursor:pointer;padding:0;transition:all .2s}
.dot.active{background:var(--navy-800);width:22px;border-radius:4px}
/* CTA */
.cta{background:linear-gradient(135deg,var(--navy-800),var(--navy-700) 70%,var(--navy-900));border-radius:24px;padding:42px;color:#fff;display:grid;grid-template-columns:1fr auto auto;gap:18px;align-items:center;position:relative;overflow:hidden}
.cta::before{content:"";position:absolute;right:-80px;top:-80px;width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(244,137,31,.3),transparent 70%);pointer-events:none}
.cta::after{content:"";position:absolute;left:-80px;bottom:-80px;width:240px;height:240px;border-radius:50%;background:radial-gradient(circle,rgba(68,159,229,.28),transparent 70%);pointer-events:none}
.cta-body{position:relative;z-index:1}
.cta h3{color:#fff;font-size:26px;letter-spacing:-0.02em;margin-bottom:6px}
.cta p{color:rgba(255,255,255,.72);font-size:15px}
.cta .btn{position:relative;z-index:1}
.cta .wa{display:inline-flex;align-items:center;gap:10px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);height:52px;padding:0 22px;border-radius:999px;font-weight:600;position:relative;z-index:1}
.cta .wa:hover{background:rgba(255,255,255,.14)}
/* Footer */
footer{background:var(--navy-900);color:rgba(255,255,255,.7);padding:64px 0 28px;border-top:0}
.foot-grid{display:grid;grid-template-columns:1.4fr 1fr 1fr 1.2fr;gap:48px;padding-bottom:40px;border-bottom:1px solid rgba(255,255,255,.08)}
.foot-brand{display:flex;flex-direction:column;gap:16px}
.foot-brand p{color:rgba(255,255,255,.55);font-size:13.5px;line-height:1.65;max-width:32ch}
.foot-col h4{font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#fff;margin-bottom:18px}
.foot-col ul{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;font-size:14px}
.foot-col ul li{color:rgba(255,255,255,.6)}
.foot-col ul li a:hover{color:#fff}
.foot-col.contact ul li{display:flex;gap:10px;align-items:flex-start;line-height:1.5}
.foot-col.contact .ico{color:var(--blue);flex:0 0 auto;margin-top:2px}
.foot-bot{display:flex;justify-content:space-between;padding-top:24px;font-size:13px;color:rgba(255,255,255,.4)}
.foot-bot a{color:rgba(255,255,255,.55)}
.foot-bot a:hover{color:#fff}
.icon{width:1em;height:1em;display:inline-block;vertical-align:-0.125em}
/* Blog */
.blog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.post-card{background:#fff;border:1px solid var(--line);border-radius:16px;overflow:hidden;transition:all .18s}
.post-card:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 10px 28px rgba(15,29,53,.07)}
.post-card-img{aspect-ratio:16/9;overflow:hidden;background:var(--navy-50)}
.post-card-img img{width:100%;height:100%;object-fit:cover}
.post-card-body{padding:20px}
.post-card-cat{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--blue-deep);margin-bottom:8px}
.post-card-body h3{font-size:16px;line-height:1.4;margin-bottom:8px}
.post-card-body p{font-size:13.5px;color:var(--muted);line-height:1.6}
.post-card-meta{font-size:12px;color:var(--muted);margin-top:14px;padding-top:14px;border-top:1px solid var(--line)}
/* Floating WA Button */
.wa-float{position:fixed;bottom:28px;right:28px;z-index:99;display:flex;align-items:center;gap:10px;background:#25d366;color:#fff;padding:0 20px 0 14px;height:52px;border-radius:999px;font-weight:600;font-size:15px;box-shadow:0 6px 24px rgba(37,211,102,.4);transition:transform .2s,box-shadow .2s;white-space:nowrap}
.wa-float:hover{transform:translateY(-3px);box-shadow:0 12px 36px rgba(37,211,102,.5)}
.wa-float .wa-ico{width:28px;height:28px;flex:0 0 auto}
.wa-float .wa-text{font-size:14px}
@media(max-width:960px){
  .hero-grid,.schemes,.steps,.foot-grid,.blog-grid{grid-template-columns:1fr}
  .hero-grid{padding:64px 0}
  .cta{grid-template-columns:1fr;text-align:left}
  nav.menu{display:none}
  section{padding:64px 0}
  .wrap{padding:0 20px}
  .slide{flex:0 0 calc(80% - 10px)}
  .wa-float .wa-text{display:none}
  .wa-float{padding:0;width:52px;justify-content:center}
}
@media(max-width:640px){
  .slide{flex:0 0 calc(90% - 10px)}
}
</style>
@yield('extra-css')
</head>
<body>

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
<defs>
  <symbol id="i-doc" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" d="M7 3h8l4 4v14H7zM15 3v4h4M9 12h6M9 16h6M9 8h2"></path></symbol>
  <symbol id="i-check-list" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M4 6h10M4 12h10M4 18h7M16 6l2 2 4-4M16 12l2 2 4-4"></path></symbol>
  <symbol id="i-shield" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"></path><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"></path></symbol>
  <symbol id="i-monitor" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" d="M3 5h18v12H3zM8 21h8M12 17v4"></path></symbol>
  <symbol id="i-award" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" d="M12 3l3 6 7 1-5 4 1 7-6-3-6 3 1-7-5-4 7-1z"></path></symbol>
  <symbol id="i-image" viewBox="0 0 24 24"><rect fill="none" stroke="currentColor" stroke-width="1.6" x="3" y="3" width="18" height="18" rx="3"></rect><circle fill="none" stroke="currentColor" stroke-width="1.6" cx="8.5" cy="8.5" r="1.5"></circle><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" d="M21 15l-5-5L5 21"></path></symbol>
  <symbol id="i-download" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" d="M12 4v12m0 0l-5-5m5 5l5-5M4 20h16"></path></symbol>
  <symbol id="i-wa" viewBox="0 0 24 24"><path fill="currentColor" d="M20.5 3.5A11.4 11.4 0 0012.05 0C5.5 0 .2 5.3.2 11.85a11.7 11.7 0 001.6 5.95L0 24l6.35-1.65a11.85 11.85 0 005.7 1.45h.01c6.55 0 11.85-5.3 11.85-11.85a11.7 11.7 0 00-3.41-8.45zm-8.45 18.2a9.95 9.95 0 01-5.05-1.4l-.36-.22-3.77.98 1-3.67-.24-.38a9.85 9.85 0 1118.05-5.46c0 5.45-4.45 9.9-9.63 10.15zM17.5 14.3c-.3-.15-1.75-.85-2-1s-.45-.15-.65.15-.75 1-.9 1.2-.3.2-.6.05a8.1 8.1 0 01-2.4-1.5 9 9 0 01-1.65-2.05c-.2-.3 0-.45.15-.6s.3-.4.45-.55a2.7 2.7 0 00.3-.5.6.6 0 000-.55c0-.15-.65-1.55-.9-2.1s-.5-.5-.7-.5h-.55a1.1 1.1 0 00-.8.4 3.3 3.3 0 00-1 2.5 5.7 5.7 0 001.2 3.1 13.5 13.5 0 005.45 4.65c.75.3 1.35.45 1.8.6a4.4 4.4 0 002 .15 3.3 3.3 0 002.15-1.5 2.65 2.65 0 00.15-1.5c-.05-.1-.25-.2-.55-.35z"></path></symbol>
  <symbol id="i-arrow-r" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"></path></symbol>
  <symbol id="i-arrow-l" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M11 18l-6-6 6-6"></path></symbol>
  <symbol id="i-chev-r" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"></path></symbol>
  <symbol id="i-pin" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" d="M12 22s7-7 7-13a7 7 0 10-14 0c0 6 7 13 7 13z"></path><circle cx="12" cy="9" r="2.5" fill="none" stroke="currentColor" stroke-width="1.6"></circle></symbol>
  <symbol id="i-mail" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" d="M3 6h18v12H3zM3 6l9 7 9-7"></path></symbol>
  <symbol id="i-refresh" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" d="M1 4v6h6M23 20v-6h-6M20.49 9A9 9 0 005.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 013.51 15"></path></symbol>
</defs>
</svg>

<header>
  <div class="wrap nav">
    <a class="brand" href="{{ route('home') }}">
      <img src="{{ asset('LOGO-EDUKIA-REV.002-UPD.14032024-001.png') }}" class="brand-logo" alt="LSP Edukia">
    </a>
    <nav class="menu">
      <a href="{{ route('home') }}" @class(['active' => ($activeNav ?? '') === 'home'])>Beranda</a>
      <a href="{{ route('tentang') }}" @class(['active' => ($activeNav ?? '') === 'tentang'])>Tentang Kami</a>
      <a href="{{ route('skema') }}" @class(['active' => ($activeNav ?? '') === 'skema'])>Skema Kompetensi</a>
      <a href="{{ route('informasi') }}" @class(['active' => ($activeNav ?? '') === 'informasi'])>Informasi Publik</a>
      <a href="{{ route('sertifikat') }}" @class(['active' => ($activeNav ?? '') === 'sertifikat'])>Daftar Penerima Sertifikat</a>
      <a href="{{ route('blog.index') }}" @class(['active' => ($activeNav ?? '') === 'blog'])>Blog</a>
    </nav>
    <a href="https://wa.me/6285175479385" target="_blank" rel="noopener" class="btn btn-primary">Daftar Sekarang
      <svg class="icon"><use href="#i-arrow-r"></use></svg>
    </a>
  </div>
</header>

@yield('content')

<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <a class="brand" href="{{ route('home') }}" style="margin:0">
          <img src="{{ asset('LOGO-EDUKIA-REV.002-UPD.14032024-001.png') }}" class="brand-logo" alt="LSP Edukia" style="filter:brightness(0) invert(1)">
        </a>
        <p>Lembaga Sertifikasi Profesi terpercaya untuk SDM unggul di bidang pendidikan tinggi, laboratorium, lifting engineering, dan industri.</p>
      </div>
      <div class="foot-col">
        <h4>Navigasi</h4>
        <ul>
          <li><a href="{{ route('home') }}">Beranda</a></li>
          <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
          <li><a href="{{ route('skema') }}">Skema Kompetensi</a></li>
          <li><a href="{{ route('informasi') }}">Informasi Publik</a></li>
        </ul>
      </div>
      <div class="foot-col">
        <h4>Bidang Skema</h4>
        <ul>
          <li>Pendidikan Tinggi &amp; SPMI (5)</li>
          <li>Laboratorium &amp; Pengujian (9)</li>
          <li>Lifting Engineering (4)</li>
          <li>Sistem Manajemen &amp; Industri (7)</li>
          <li>Hukum Korporasi (1)</li>
        </ul>
      </div>
      <div class="foot-col contact">
        <h4>Kontak</h4>
        <ul>
          <li><svg class="icon ico"><use href="#i-pin"></use></svg> Jl. Teras Bali No.12, Mijen, Kota Semarang</li>
          <li><svg class="icon ico"><use href="#i-mail"></use></svg> edukasi.cendekia@gmail.com</li>
        </ul>
      </div>
    </div>
    <div class="foot-bot">
      <div>© 2024 lspedukia.id — Hak cipta dilindungi · DP.AK.05 Rev. 02</div>
      <div><a href="{{ route('informasi') }}">Informasi Publik</a> · <a href="{{ route('tentang') }}">Tentang Kami</a></div>
    </div>
  </div>
</footer>

<a class="wa-float" href="https://wa.me/6285175479385" target="_blank" rel="noopener" aria-label="Hubungi via WhatsApp">
  <svg class="wa-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11.4 11.4 0 0012.05 0C5.5 0 .2 5.3.2 11.85a11.7 11.7 0 001.6 5.95L0 24l6.35-1.65a11.85 11.85 0 005.7 1.45h.01c6.55 0 11.85-5.3 11.85-11.85a11.7 11.7 0 00-3.41-8.45zm-8.45 18.2a9.95 9.95 0 01-5.05-1.4l-.36-.22-3.77.98 1-3.67-.24-.38a9.85 9.85 0 1118.05-5.46c0 5.45-4.45 9.9-9.63 10.15zM17.5 14.3c-.3-.15-1.75-.85-2-1s-.45-.15-.65.15-.75 1-.9 1.2-.3.2-.6.05a8.1 8.1 0 01-2.4-1.5 9 9 0 01-1.65-2.05c-.2-.3 0-.45.15-.6s.3-.4.45-.55a2.7 2.7 0 00.3-.5.6.6 0 000-.55c0-.15-.65-1.55-.9-2.1s-.5-.5-.7-.5h-.55a1.1 1.1 0 00-.8.4 3.3 3.3 0 00-1 2.5 5.7 5.7 0 001.2 3.1 13.5 13.5 0 005.45 4.65c.75.3 1.35.45 1.8.6a4.4 4.4 0 002 .15 3.3 3.3 0 002.15-1.5 2.65 2.65 0 00.15-1.5c-.05-.1-.25-.2-.55-.35z"></path></svg>
  <span class="wa-text">Hubungi Kami</span>
</a>

@yield('scripts')
</body>
</html>
