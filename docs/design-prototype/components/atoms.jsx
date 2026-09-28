/* global React */
const { useState } = React;
const T = window.LSP_TOKENS;

// ============================================================
// ICON SET — reused across both variants
// ============================================================
function Icon({ name, size = 18, stroke = 1.6, color = 'currentColor' }) {
  const common = { width: size, height: size, viewBox: '0 0 24 24', fill: 'none',
                   stroke: color, strokeWidth: stroke, strokeLinejoin: 'round', strokeLinecap: 'round' };
  switch (name) {
    case 'doc':       return <svg {...common}><path d="M7 3h8l4 4v14H7zM15 3v4h4M9 12h6M9 16h6M9 8h2"/></svg>;
    case 'check':     return <svg {...common}><path d="M4 12l5 5L20 6"/></svg>;
    case 'check-list':return <svg {...common}><path d="M4 6h10M4 12h10M4 18h7M16 6l2 2 4-4M16 12l2 2 4-4"/></svg>;
    case 'shield':    return <svg {...common}><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M9 12l2 2 4-4"/></svg>;
    case 'monitor':   return <svg {...common}><path d="M3 5h18v12H3zM8 21h8M12 17v4"/></svg>;
    case 'award':     return <svg {...common}><path d="M12 3l3 6 7 1-5 4 1 7-6-3-6 3 1-7-5-4 7-1z"/></svg>;
    case 'arrow-r':   return <svg {...common} strokeWidth={2}><path d="M5 12h14M13 6l6 6-6 6"/></svg>;
    case 'arrow-l':   return <svg {...common} strokeWidth={2}><path d="M19 12H5M11 18l-6-6 6-6"/></svg>;
    case 'chev-r':    return <svg {...common} strokeWidth={2}><path d="M9 6l6 6-6 6"/></svg>;
    case 'plus':      return <svg {...common} strokeWidth={2}><path d="M12 5v14M5 12h14"/></svg>;
    case 'pin':       return <svg {...common}><path d="M12 22s7-7 7-13a7 7 0 10-14 0c0 6 7 13 7 13z"/><circle cx="12" cy="9" r="2.5"/></svg>;
    case 'mail':      return <svg {...common}><path d="M3 6h18v12H3zM3 6l9 7 9-7"/></svg>;
    case 'refresh':   return <svg {...common}><path d="M1 4v6h6M23 20v-6h-6M20.49 9A9 9 0 005.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 013.51 15"/></svg>;
    case 'building':  return <svg {...common}><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M13 9h.01M9 13h.01M13 13h.01M9 17h6"/></svg>;
    case 'beaker':    return <svg {...common}><path d="M9 3v6L4 19a2 2 0 002 3h12a2 2 0 002-3l-5-10V3M9 3h6M7 14h10"/></svg>;
    case 'crane':     return <svg {...common}><path d="M3 21h18M6 21V8M6 8h13M6 8L4 6M6 8v3l4 4M19 8v2h-3"/></svg>;
    case 'factory':   return <svg {...common}><path d="M3 21h18M5 21V11l5 3V11l5 3V8l4-3v16"/></svg>;
    case 'scale':     return <svg {...common}><path d="M12 3v18M5 7h14M7 21h10M5 7l-3 7h6L5 7zM19 7l-3 7h6l-3-7z"/></svg>;
    case 'sparkle':   return <svg {...common}><path d="M12 3l2 6 6 2-6 2-2 6-2-6-6-2 6-2z"/></svg>;
    case 'wa':        return <svg width={size} height={size} viewBox="0 0 24 24"><path fill="currentColor" d="M20.5 3.5A11.4 11.4 0 0012.05 0C5.5 0 .2 5.3.2 11.85a11.7 11.7 0 001.6 5.95L0 24l6.35-1.65a11.85 11.85 0 005.7 1.45h.01c6.55 0 11.85-5.3 11.85-11.85a11.7 11.7 0 00-3.41-8.45zm-8.45 18.2a9.95 9.95 0 01-5.05-1.4l-.36-.22-3.77.98 1-3.67-.24-.38a9.85 9.85 0 1118.05-5.46c0 5.45-4.45 9.9-9.63 10.15zM17.5 14.3c-.3-.15-1.75-.85-2-1s-.45-.15-.65.15-.75 1-.9 1.2-.3.2-.6.05a8.1 8.1 0 01-2.4-1.5 9 9 0 01-1.65-2.05c-.2-.3 0-.45.15-.6s.3-.4.45-.55a2.7 2.7 0 00.3-.5.6.6 0 000-.55c0-.15-.65-1.55-.9-2.1s-.5-.5-.7-.5h-.55a1.1 1.1 0 00-.8.4 3.3 3.3 0 00-1 2.5 5.7 5.7 0 001.2 3.1 13.5 13.5 0 005.45 4.65c.75.3 1.35.45 1.8.6a4.4 4.4 0 002 .15 3.3 3.3 0 002.15-1.5 2.65 2.65 0 00.15-1.5c-.05-.1-.25-.2-.55-.35z"/></svg>;
    case 'compass':   return <svg {...common}><circle cx="12" cy="12" r="9"/><path d="M16 8l-2 6-6 2 2-6 6-2z"/></svg>;
    case 'list':      return <svg {...common}><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>;
    case 'cert':      return <svg {...common}><circle cx="12" cy="9" r="6"/><path d="M9 14l-2 7 5-2 5 2-2-7"/></svg>;
    case 'dot':       return <svg width={size} height={size} viewBox="0 0 24 24"><circle cx="12" cy="12" r="4" fill={color}/></svg>;
    default: return null;
  }
}

// Map category to icon
const CAT_ICON = {
  spmi: 'building', pt: 'building', lab17025: 'beaker', lifting: 'crane',
  labtest: 'beaker', manajemen: 'factory', hukum: 'scale',
};

// ============================================================
// LOGO
// ============================================================
function Logo({ height = 44, invert = false }) {
  return (
    <img src="assets/logo-edukia.png" alt="LSP Edukia"
         style={{ height, width: 'auto', display: 'block', objectFit: 'contain',
                  filter: invert ? 'brightness(0) invert(1)' : 'none' }} />
  );
}

// ============================================================
// BUTTONS
// ============================================================
function Btn({ children, variant = 'primary', size = 'md', icon, iconR, style = {}, ...rest }) {
  const sizes = {
    sm: { h: 36, px: 14, fs: 13 },
    md: { h: 44, px: 20, fs: 14.5 },
    lg: { h: 52, px: 26, fs: 15.5 },
  };
  const s = sizes[size];
  const base = {
    display: 'inline-flex', alignItems: 'center', gap: 8, height: s.h, padding: `0 ${s.px}px`,
    borderRadius: 999, fontWeight: 600, fontSize: s.fs, letterSpacing: '-0.005em',
    transition: 'all .2s', border: 0, cursor: 'pointer', fontFamily: 'inherit',
  };
  const variants = {
    primary: { background: T.orange, color: '#fff', boxShadow: '0 4px 14px rgba(244,137,31,.32)' },
    navy:    { background: T.navy800, color: '#fff' },
    ghost:   { background: 'rgba(255,255,255,.08)', color: '#fff', border: '1px solid rgba(255,255,255,.18)' },
    outline: { background: '#fff', color: T.ink, border: `1px solid ${T.line2}` },
    text:    { background: 'transparent', color: T.navy800, padding: '0', height: 'auto' },
  };
  return (
    <button style={{ ...base, ...variants[variant], ...style }} {...rest}>
      {icon && <Icon name={icon} size={16} />}
      <span>{children}</span>
      {iconR && <Icon name={iconR} size={16} />}
    </button>
  );
}

// ============================================================
// EYEBROW (small section label)
// ============================================================
function Eyebrow({ children, color = T.orangeDeep }) {
  return (
    <span style={{
      fontSize: 12, fontWeight: 700, letterSpacing: '0.18em', textTransform: 'uppercase',
      color, display: 'inline-flex', alignItems: 'center', gap: 8,
    }}>
      <span style={{ width: 18, height: 2, background: color, borderRadius: 2 }} />
      {children}
    </span>
  );
}

// ============================================================
// SECTION HEAD
// ============================================================
function SectionHead({ eyebrow, eyebrowColor, title, sub, align = 'left', maxWidth = 720 }) {
  return (
    <div style={{ marginBottom: 40, maxWidth, textAlign: align }}>
      {eyebrow && <Eyebrow color={eyebrowColor}>{eyebrow}</Eyebrow>}
      <h2 style={{
        fontSize: 'clamp(26px, 3.5vw, 38px)', lineHeight: 1.08, letterSpacing: '-0.025em',
        fontWeight: 700, color: T.ink, margin: '14px 0 14px', textWrap: 'balance',
      }}>{title}</h2>
      {sub && <p style={{ color: T.muted, fontSize: 15.5, lineHeight: 1.6, margin: 0, textWrap: 'pretty' }}>{sub}</p>}
    </div>
  );
}

// ============================================================
// HEADER (shared nav bar — slight variants apply background)
// ============================================================
function Header({ active = 'home', variant = 'a' }) {
  const items = [
    { id: 'home',       label: 'Beranda' },
    { id: 'tentang',    label: 'Tentang Kami' },
    { id: 'skema',      label: 'Skema Kompetensi' },
    { id: 'informasi',  label: 'Informasi Publik' },
    { id: 'sertifikat', label: 'Penerima Sertifikat' },
    { id: 'blog',       label: 'Blog' },
  ];
  return (
    <header style={{
      position: 'sticky', top: 0, zIndex: 50,
      background: 'rgba(255,255,255,.96)', backdropFilter: 'saturate(140%) blur(10px)',
      borderBottom: `1px solid ${T.line}`,
    }}>
      <div style={{ maxWidth: 1240, margin: '0 auto', padding: '0 32px', display: 'flex',
                    alignItems: 'center', gap: 32, height: 76 }}>
        <a href="#" style={{ display: 'flex', alignItems: 'center', marginRight: 'auto' }}>
          <Logo height={52} />
        </a>
        <nav style={{ display: 'flex', gap: 26 }}>
          {items.map(it => (
            <a key={it.id} href="#"
               style={{
                 fontSize: 13.5, fontWeight: it.id === active ? 700 : 500,
                 color: it.id === active ? T.navy800 : T.ink2, position: 'relative',
                 padding: '6px 0', textDecoration: 'none',
               }}>
              {it.label}
              {it.id === active && (
                <span style={{
                  position: 'absolute', left: 0, right: 0, bottom: -4, height: 2,
                  background: variant === 'a'
                    ? T.orange
                    : `linear-gradient(90deg, ${T.blue}, ${T.orange})`,
                  borderRadius: 2,
                }}/>
              )}
            </a>
          ))}
        </nav>
        <Btn variant="primary" iconR="arrow-r">Daftar Sekarang</Btn>
      </div>
    </header>
  );
}

// ============================================================
// FOOTER
// ============================================================
function Footer() {
  return (
    <footer style={{ background: T.navy900, color: 'rgba(255,255,255,.7)', padding: '64px 0 28px' }}>
      <div style={{ maxWidth: 1240, margin: '0 auto', padding: '0 32px' }}>
        <div style={{
          display: 'grid', gridTemplateColumns: '1.4fr 1fr 1fr 1.2fr', gap: 48,
          paddingBottom: 40, borderBottom: '1px solid rgba(255,255,255,.08)',
        }}>
          <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
            <Logo height={48} invert />
            <p style={{ color: 'rgba(255,255,255,.55)', fontSize: 13.5, lineHeight: 1.65, maxWidth: '32ch', margin: 0 }}>
              Lembaga Sertifikasi Profesi terpercaya untuk SDM unggul di bidang pendidikan tinggi, laboratorium, lifting engineering, dan industri.
            </p>
          </div>
          <FooterCol title="Navigasi" items={['Beranda', 'Tentang Kami', 'Skema Kompetensi', 'Informasi Publik']} />
          <FooterCol title="Bidang Skema" items={['Pendidikan Tinggi & SPMI (5)', 'Laboratorium & Pengujian (9)', 'Lifting Engineering (4)', 'Sistem Manajemen (7)', 'Hukum Korporasi (1)']} />
          <div>
            <h4 style={{ fontSize: 13, fontWeight: 700, letterSpacing: '0.08em', textTransform: 'uppercase',
                         color: '#fff', marginBottom: 18, margin: '0 0 18px' }}>Kontak</h4>
            <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 12, fontSize: 14 }}>
              {[
                ['pin', 'Jl. Teras Bali No.12, Mijen, Kota Semarang'],
                ['mail', 'edukasi.cendekia@gmail.com'],
              ].map(([ic, txt], i) => (
                <li key={i} style={{ display: 'flex', gap: 10, alignItems: 'flex-start', color: 'rgba(255,255,255,.65)', lineHeight: 1.5 }}>
                  <span style={{ color: T.blue, flex: '0 0 auto', marginTop: 2 }}><Icon name={ic} size={16} /></span>
                  <span>{txt}</span>
                </li>
              ))}
            </ul>
          </div>
        </div>
        <div style={{ display: 'flex', justifyContent: 'space-between', paddingTop: 24, fontSize: 13, color: 'rgba(255,255,255,.4)' }}>
          <span>© 2024 lspedukia.id — Hak cipta dilindungi · DP.AK.05 Rev. 02</span>
          <span><a href="#" style={{ color: 'rgba(255,255,255,.55)', textDecoration: 'none' }}>Informasi Publik</a> · <a href="#" style={{ color: 'rgba(255,255,255,.55)', textDecoration: 'none' }}>Tentang Kami</a></span>
        </div>
      </div>
    </footer>
  );
}
function FooterCol({ title, items }) {
  return (
    <div>
      <h4 style={{ fontSize: 13, fontWeight: 700, letterSpacing: '0.08em', textTransform: 'uppercase',
                   color: '#fff', margin: '0 0 18px' }}>{title}</h4>
      <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 10, fontSize: 14 }}>
        {items.map((it, i) => <li key={i} style={{ color: 'rgba(255,255,255,.6)' }}>{it}</li>)}
      </ul>
    </div>
  );
}

// expose to other component files
Object.assign(window, { Icon, Logo, Btn, Eyebrow, SectionHead, Header, Footer, CAT_ICON });
