{{-- Halaman maintenance (php artisan down). Sengaja berdiri sendiri — tidak extends layouts.app —
     agar tetap tampil walau database/aset Vite sedang diperbarui. Disarankan: php artisan down --render="errors.503" --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<meta name="theme-color" content="#06172e">
<title>Sedang Pemeliharaan — LSP Edukia</title>
<link rel="icon" href="{{ asset('favicon.ico') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@1,9..144,500..700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{
  --navy-900:#06172e;--navy-800:#0a2547;--navy-700:#102d57;
  --blue:#449fe5;--blue-deep:#2a7fc4;--orange:#f4891f;--orange-deep:#d77110;
  --text:#eaf1fb;--text-2:#a9b8cf;--glass:rgba(255,255,255,.06);--glass-line:rgba(255,255,255,.12);
}
*{box-sizing:border-box}html,body{margin:0;padding:0}
body{min-height:100vh;font-family:"Plus Jakarta Sans",system-ui,sans-serif;color:var(--text);background:var(--navy-900);
  -webkit-font-smoothing:antialiased;line-height:1.55;overflow-x:hidden;display:flex;flex-direction:column}
a{color:inherit;text-decoration:none}

/* Latar: roda gigi besar di pojok + cahaya lembut + grid halus */
.bg{position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none;
  background:radial-gradient(circle at 0 0,rgba(42,127,196,.35),transparent 45%),radial-gradient(circle at 100% 100%,rgba(215,113,16,.28),transparent 45%)}
.bg::after{content:"";position:absolute;inset:0;
  background-image:linear-gradient(rgba(255,255,255,.035) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.035) 1px,transparent 1px);
  background-size:56px 56px;mask-image:radial-gradient(ellipse at center,#000 30%,transparent 75%);-webkit-mask-image:radial-gradient(ellipse at center,#000 30%,transparent 75%)}
.bg-gear{position:absolute}
.bg-gear.tl{width:440px;height:440px;top:-170px;left:-170px;color:var(--blue);opacity:.14;animation:spin 60s linear infinite}
.bg-gear.tl2{width:200px;height:200px;top:190px;left:-60px;color:var(--blue);opacity:.09;animation:spin 27s linear infinite reverse}
.bg-gear.tr{width:260px;height:260px;top:-100px;right:-90px;color:var(--orange);opacity:.11;animation:spin 40s linear infinite reverse}
.bg-gear.br{width:480px;height:480px;bottom:-190px;right:-180px;color:var(--orange);opacity:.13;animation:spin 66s linear infinite reverse}
.bg-gear.br2{width:210px;height:210px;bottom:220px;right:-70px;color:var(--orange);opacity:.08;animation:spin 29s linear infinite}
.bg-gear.bl{width:240px;height:240px;bottom:-90px;left:-80px;color:var(--blue);opacity:.1;animation:spin 36s linear infinite}

main{position:relative;z-index:1;flex:1;display:grid;place-items:center;padding:48px 16px}
.card{width:100%;max-width:800px;text-align:center;padding:48px 40px;border-radius:28px;background:var(--glass);
  border:1px solid var(--glass-line);backdrop-filter:blur(18px) saturate(140%);-webkit-backdrop-filter:blur(18px) saturate(140%);
  box-shadow:0 30px 80px rgba(0,0,0,.35),inset 0 1px 0 rgba(255,255,255,.08);animation:rise .8s cubic-bezier(.2,.8,.2,1) both}
@keyframes rise{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:none}}

.logo{height:56px;width:auto;filter:brightness(0) invert(1);opacity:.95;margin-bottom:32px}

/* Ilustrasi roda gigi */
.gears{position:relative;width:132px;height:110px;margin:0 auto 28px}
.gears svg{position:absolute}
.g1{width:84px;height:84px;left:0;top:14px;color:var(--blue);animation:spin 8s linear infinite}
.g2{width:56px;height:56px;left:72px;top:0;color:var(--orange);animation:spin 5.33s linear infinite reverse}
.g3{width:40px;height:40px;left:84px;top:62px;color:#7fb9ec;animation:spin 3.8s linear infinite reverse;opacity:.8}
@keyframes spin{to{transform:rotate(360deg)}}

.pill{display:inline-flex;align-items:center;gap:10px;padding:7px 14px 7px 12px;border-radius:999px;font-size:12px;font-weight:700;
  letter-spacing:.14em;text-transform:uppercase;color:#ffd3a6;background:rgba(244,137,31,.12);border:1px solid rgba(244,137,31,.35)}
.dot{width:8px;height:8px;border-radius:50%;background:var(--orange);box-shadow:0 0 0 0 rgba(244,137,31,.7);animation:pulse 1.8s infinite}
@keyframes pulse{0%{box-shadow:0 0 0 0 rgba(244,137,31,.6)}70%{box-shadow:0 0 0 10px rgba(244,137,31,0)}100%{box-shadow:0 0 0 0 rgba(244,137,31,0)}}

h1{margin:20px 0 14px;font-size:clamp(30px,5.4vw,50px);line-height:1.06;font-weight:800;letter-spacing:-.035em;text-wrap:balance}
h1 em{font-family:"Fraunces",Georgia,serif;font-style:italic;font-weight:600;letter-spacing:-.02em;
  background:linear-gradient(90deg,var(--blue),#9fd0f7 45%,var(--orange));-webkit-background-clip:text;background-clip:text;color:transparent}
.lead{margin:0 auto;max-width:52ch;color:var(--text-2);font-size:16.5px}

.contacts-title{margin:40px 0 14px;font-size:12px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--text-2)}
.contacts{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;max-width:560px;margin:0 auto}
.contact{display:flex;flex-direction:column;align-items:center;gap:10px;padding:20px 14px;border-radius:18px;text-align:center;
  background:rgba(255,255,255,.04);border:1px solid var(--glass-line);transition:transform .2s,background .2s,border-color .2s}
.contact:hover{transform:translateY(-3px);background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.22)}
.contact .ic{flex:none;width:44px;height:44px;border-radius:14px;display:grid;place-items:center}
.contact .ic svg{width:22px;height:22px}
.ic.wa{background:rgba(37,211,102,.15);color:#4ade80}
.ic.mail{background:rgba(68,159,229,.16);color:var(--blue)}
.contact small{display:block;font-size:11.5px;color:var(--text-2);font-weight:500;margin-bottom:2px}
.contact strong{display:block;font-size:13px;font-weight:700;overflow-wrap:anywhere}
.contact div{min-width:0;width:100%}

footer{position:relative;z-index:1;text-align:center;padding:0 16px 28px;font-size:12.5px;color:var(--text-2)}

@media(max-width:640px){
  .card{padding:36px 20px;border-radius:22px}
  .logo{height:44px;margin-bottom:24px}
  .contacts{grid-template-columns:minmax(0,1fr)}
  .contact{flex-direction:row;text-align:left;padding:14px 16px}
  .contact div{width:auto}
  .lead{font-size:15.5px}
}
@media(prefers-reduced-motion:reduce){*,*::before,*::after{animation:none!important;transition:none!important}}
</style>
</head>
<body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="gear" viewBox="0 0 100 100"><path fill="currentColor" d="M43 4h14l2 12a35 35 0 0 1 9 4l10-7 10 10-7 10a35 35 0 0 1 4 9l12 2v14l-12 2a35 35 0 0 1-4 9l7 10-10 10-10-7a35 35 0 0 1-9 4l-2 12H43l-2-12a35 35 0 0 1-9-4l-10 7-10-10 7-10a35 35 0 0 1-4-9L3 57V43l12-2a35 35 0 0 1 4-9l-7-10 10-10 10 7a35 35 0 0 1 9-4zM50 34a16 16 0 1 0 0 32 16 16 0 0 0 0-32z"/></symbol>
</svg>

<div class="bg" aria-hidden="true">
  @foreach (['tl', 'tl2', 'tr', 'br', 'br2', 'bl'] as $pos)
    <svg class="bg-gear {{ $pos }}"><use href="#gear"/></svg>
  @endforeach
</div>

<main>
  <div class="card">
    <img class="logo" src="{{ asset('LOGO-EDUKIA-REV.002-UPD.14032024-001.png') }}" alt="LSP Edukia">

    <div class="gears" aria-hidden="true">
      @foreach (['g1', 'g2', 'g3'] as $g)
        <svg class="{{ $g }}"><use href="#gear"/></svg>
      @endforeach
    </div>

    <span class="pill"><span class="dot"></span>Sedang Pemeliharaan</span>

    <h1>Kami sedang <em>meningkatkan</em> layanan untuk Anda</h1>
    <p class="lead">Website LSP Edukia sedang dalam pemeliharaan terjadwal agar lebih cepat, aman, dan nyaman digunakan.
      Kami akan segera kembali — terima kasih atas kesabaran Anda.</p>

    <p class="contacts-title">Butuh bantuan? Hubungi kami</p>
    <div class="contacts">
      <a class="contact" href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener">
        <span class="ic wa"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm0 18.2a8.2 8.2 0 0 1-4.2-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 1 1 12 20.2zm4.5-6.1c-.2-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.7 6.7 0 0 1-3.3-2.9c-.2-.4.2-.4.7-1.3.1-.2 0-.3 0-.4l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.7 11.8 11.8 0 0 0 4.5 4c1.7.7 2.3.8 3.2.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.2c0-.1-.2-.2-.5-.3z"/></svg></span>
        <div><small>WhatsApp</small><strong>+{{ config('site.whatsapp') }}</strong></div>
      </a>
      <a class="contact" href="mailto:{{ config('site.email') }}">
        <span class="ic mail"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
        <div><small>Email</small><strong>{{ config('site.email') }}</strong></div>
      </a>
    </div>
  </div>
</main>

<footer>&copy; {{ date('Y') }} lspedukia.id · Jl. Teras Bali No.12, Mijen, Kota Semarang</footer>
</body>
</html>
