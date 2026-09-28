/* global React */
const T7 = window.LSP_TOKENS;
const CATS_M = window.LSP_CATS;

// ============================================================
// FOUR MICRO-VARIATIONS OF VARIANT B (Institutional Bold family)
// Each card uses identical data to allow direct comparison.
// All work in a 3-column grid at ~400px width.
// ============================================================

// ----------- B1 · HEADLINE -----------
// Navy gradient header + checkmark list + pill CTA (the original).
// Best for marketing pages where each card is the main visual.
function CardB1Headline({ scheme }) {
  return <window.SkemaCardB scheme={scheme} />;
}

// ----------- B2 · COMPACT RAIL -----------
// White card with colored left rail. Dense, no header band.
// Best for dashboards / catalog pages where 6-9 cards must be scannable at once.
function CardB2Compact({ scheme }) {
  const cat = CATS_M[scheme.cat];
  const iconName = window.CAT_ICON[scheme.cat] || 'award';
  return (
    <article style={{
      background: '#fff', borderRadius: 14, overflow: 'hidden',
      border: `1px solid ${T7.line}`, position: 'relative',
      display: 'flex', flexDirection: 'column',
    }}>
      {/* Left rail */}
      <div style={{ position: 'absolute', left: 0, top: 0, bottom: 0, width: 4, background: cat.color }} />

      <div style={{ padding: '18px 20px 16px 22px' }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', gap: 12 }}>
          <div style={{ display: 'flex', gap: 10, alignItems: 'center' }}>
            <div style={{
              width: 34, height: 34, borderRadius: 8, background: cat.bg,
              color: cat.color, display: 'grid', placeItems: 'center', flex: '0 0 auto',
            }}>
              <window.Icon name={iconName} size={18} />
            </div>
            <div>
              <div style={{ fontSize: 10.5, fontWeight: 800, letterSpacing: '0.14em',
                            textTransform: 'uppercase', color: cat.color }}>
                {cat.label}
              </div>
              <div style={{ fontSize: 11, color: T7.muted, fontFamily: 'ui-monospace, monospace', marginTop: 1 }}>
                Skema {scheme.no} · {scheme.code}
              </div>
            </div>
          </div>
        </div>
        <h3 style={{ fontSize: 16, lineHeight: 1.3, letterSpacing: '-0.005em', fontWeight: 700,
                     color: T7.ink, margin: '14px 0 0', textWrap: 'balance' }}>
          {scheme.title}
        </h3>
      </div>

      <div style={{ padding: '0 20px 14px 22px', flex: 1 }}>
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 6 }}>
          {scheme.reqs.slice(0, 4).map((r, i) => (
            <div key={i} style={{ display: 'flex', gap: 6, alignItems: 'flex-start',
                                  padding: '8px 0', fontSize: 12.5, color: T7.ink2, lineHeight: 1.45 }}>
              <span style={{ color: cat.color, flex: '0 0 auto', marginTop: 2 }}>
                <window.Icon name="check" size={12} stroke={2.5} />
              </span>
              <span>{r}</span>
            </div>
          ))}
        </div>
      </div>

      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center',
                    padding: '12px 20px 14px 22px', borderTop: `1px solid ${T7.line}` }}>
        <span style={{ fontSize: 12.5, color: T7.muted }}>
          <strong style={{ color: T7.navy800, fontWeight: 800 }}>{scheme.units}</strong> unit kompetensi
        </span>
        <a href="#" style={{ fontSize: 12.5, fontWeight: 700, color: T7.navy800,
                             textDecoration: 'none', display: 'inline-flex', alignItems: 'center', gap: 4 }}>
          Detail <window.Icon name="arrow-r" size={12} />
        </a>
      </div>
    </article>
  );
}

// ----------- B3 · STAMP CORNER -----------
// White card with a "stamp" in the top-right corner showing category abbr
// (Like an official document stamp). More playful, signals "official-ness".
function CardB3Stamp({ scheme }) {
  const cat = CATS_M[scheme.cat];
  const iconName = window.CAT_ICON[scheme.cat] || 'award';
  return (
    <article style={{
      background: '#fff', borderRadius: 16, overflow: 'hidden',
      border: `1px solid ${T7.line}`, display: 'flex', flexDirection: 'column',
      position: 'relative',
    }}>
      {/* Stamp corner */}
      <div style={{
        position: 'absolute', top: 18, right: 18,
        width: 60, height: 60, borderRadius: 14,
        background: cat.bg, color: cat.color, fontWeight: 800,
        display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center',
        border: `2px solid ${cat.color}`,
        transform: 'rotate(4deg)', fontFamily: 'ui-monospace, monospace',
      }}>
        <div style={{ fontSize: 9, letterSpacing: '0.12em', opacity: 0.7 }}>SKEMA</div>
        <div style={{ fontSize: 22, lineHeight: 1, letterSpacing: '-0.05em' }}>{scheme.no}</div>
      </div>

      <div style={{ padding: '24px 24px 18px' }}>
        <div style={{
          width: 48, height: 48, borderRadius: 12,
          background: `linear-gradient(135deg, ${cat.color}, ${cat.color}cc)`,
          color: '#fff', display: 'grid', placeItems: 'center', boxShadow: `0 4px 12px ${cat.color}40`,
          marginBottom: 18,
        }}>
          <window.Icon name={iconName} size={24} />
        </div>
        <div style={{ fontSize: 10.5, fontWeight: 700, letterSpacing: '0.14em',
                      textTransform: 'uppercase', color: cat.color, marginBottom: 8 }}>
          {cat.label}
        </div>
        <h3 style={{ fontSize: 18, lineHeight: 1.3, letterSpacing: '-0.01em', fontWeight: 700,
                     color: T7.ink, margin: 0, textWrap: 'balance', paddingRight: 60 }}>
          {scheme.title}
        </h3>
      </div>

      <div style={{ padding: '0 24px 18px', flex: 1 }}>
        <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                     flexDirection: 'column', gap: 8 }}>
          {scheme.reqs.map((r, i) => (
            <li key={i} style={{ display: 'flex', gap: 10, alignItems: 'flex-start',
                                  fontSize: 13.5, color: T7.ink2, lineHeight: 1.5 }}>
              <span style={{ width: 6, height: 6, borderRadius: '50%', background: cat.color,
                            flex: '0 0 auto', marginTop: 8 }} />
              <span>{r}</span>
            </li>
          ))}
        </ul>
      </div>

      <div style={{ padding: 18, background: T7.cream, display: 'flex',
                    justifyContent: 'space-between', alignItems: 'center' }}>
        <span style={{ fontSize: 12.5, color: T7.muted }}>
          <strong style={{ color: T7.ink, fontWeight: 800 }}>{scheme.units}</strong> unit · {scheme.code.split('-').slice(-1)[0]}
        </span>
        <a href="#" style={{
          background: T7.navy800, color: '#fff', padding: '8px 14px', borderRadius: 999,
          fontSize: 12, fontWeight: 700, textDecoration: 'none',
          display: 'inline-flex', alignItems: 'center', gap: 5,
        }}>
          Lihat unit <window.Icon name="arrow-r" size={12} stroke={2.5} />
        </a>
      </div>
    </article>
  );
}

// ----------- B4 · SPOTLIGHT -----------
// Large icon spotlight at top (filling colored tile), then info.
// Visual-led, great for landing pages where you want to communicate category fast.
function CardB4Spotlight({ scheme }) {
  const cat = CATS_M[scheme.cat];
  const iconName = window.CAT_ICON[scheme.cat] || 'award';
  return (
    <article style={{
      background: '#fff', borderRadius: 18, overflow: 'hidden',
      border: `1px solid ${T7.line}`, display: 'flex', flexDirection: 'column',
    }}>
      {/* Icon spotlight */}
      <div style={{
        height: 160,
        background: `linear-gradient(135deg, ${cat.color}, ${cat.color}d0)`,
        position: 'relative', overflow: 'hidden',
      }}>
        {/* big icon decoration */}
        <div style={{
          position: 'absolute', right: -20, bottom: -30,
          color: 'rgba(255,255,255,.18)',
        }}>
          <window.Icon name={iconName} size={180} stroke={1.2} />
        </div>
        {/* meta */}
        <div style={{ position: 'relative', padding: '20px 22px', display: 'flex',
                      flexDirection: 'column', justifyContent: 'space-between', height: '100%' }}>
          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start' }}>
            <span style={{
              fontSize: 10.5, fontWeight: 800, letterSpacing: '0.16em', textTransform: 'uppercase',
              color: 'rgba(255,255,255,.85)', background: 'rgba(0,0,0,.18)',
              padding: '5px 10px', borderRadius: 999, backdropFilter: 'blur(4px)',
            }}>
              Skema · {scheme.no}
            </span>
            <span style={{ fontSize: 11, color: 'rgba(255,255,255,.7)',
                          fontFamily: 'ui-monospace, monospace' }}>{scheme.code}</span>
          </div>
          <div style={{ color: '#fff' }}>
            <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.14em',
                          textTransform: 'uppercase', opacity: 0.85, marginBottom: 4 }}>
              {cat.label}
            </div>
          </div>
        </div>
      </div>

      <div style={{ padding: '22px 22px 14px' }}>
        <h3 style={{ fontSize: 18, lineHeight: 1.3, letterSpacing: '-0.01em', fontWeight: 700,
                     color: T7.ink, margin: 0, textWrap: 'balance' }}>
          {scheme.title}
        </h3>
      </div>

      <div style={{ padding: '0 22px 18px', flex: 1 }}>
        <div style={{ fontSize: 10.5, fontWeight: 800, letterSpacing: '0.14em', textTransform: 'uppercase',
                      color: T7.muted, marginBottom: 10 }}>
          Persyaratan dasar
        </div>
        <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                     flexDirection: 'column', gap: 8 }}>
          {scheme.reqs.map((r, i) => (
            <li key={i} style={{ display: 'grid', gridTemplateColumns: '20px 1fr', gap: 10,
                                  fontSize: 13.5, color: T7.ink2, lineHeight: 1.5 }}>
              <span style={{ color: cat.color, marginTop: 1 }}>
                <window.Icon name="check" size={14} stroke={2.5} />
              </span>
              <span>{r}</span>
            </li>
          ))}
        </ul>
      </div>

      <div style={{ padding: '14px 22px', borderTop: `1px solid ${T7.line}`,
                    display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <span style={{ fontSize: 12.5, color: T7.muted }}>
          <strong style={{ color: T7.ink, fontWeight: 800 }}>{scheme.units}</strong> unit kompetensi
        </span>
        <a href="#" style={{ fontSize: 13, fontWeight: 700, color: cat.color,
                             textDecoration: 'none', display: 'inline-flex', alignItems: 'center', gap: 4 }}>
          Detail skema <window.Icon name="arrow-r" size={12} stroke={2.5} />
        </a>
      </div>
    </article>
  );
}

// ============================================================
// MICRO-VARIATIONS COMPARISON BOARD
// 4 variants × 1 scheme, side by side
// ============================================================
function SkemaCardMicroVariants() {
  const featured = window.LSP_SCHEMES[5]; // Lifting Engineer (visually interesting category)
  const featured2 = window.LSP_SCHEMES[0]; // SPMI
  return (
    <div style={{ padding: '40px 48px', background: T7.cream, minHeight: '100%',
                  fontFamily: '"Plus Jakarta Sans", sans-serif' }}>
      <div style={{ marginBottom: 32 }}>
        <div style={{ fontSize: 11, fontWeight: 800, letterSpacing: '0.2em',
                      textTransform: 'uppercase', color: T7.orangeDeep, marginBottom: 8 }}>
          Refine variant B · 4 micro-variations
        </div>
        <h2 style={{ fontSize: 36, fontWeight: 800, color: T7.ink, margin: 0, letterSpacing: '-0.025em' }}>
          Refine Card Skema — 4 arah dari Variant B
        </h2>
        <p style={{ fontSize: 14.5, color: T7.muted, marginTop: 8, maxWidth: '76ch' }}>
          Semua menggunakan brand B (navy + kategori berwarna), tapi dengan layout, density, dan visual rhythm yang berbeda.
          Pilih salah satu sebagai master, atau campur (mis. B1 untuk hero section, B2 untuk catalog page).
        </p>
      </div>
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: 18, alignItems: 'stretch' }}>
        {[
          { id: 'B1', name: 'Headline', desc: 'Navy header + check list + pil CTA. Untuk marketing/hero, paling confident.', Comp: CardB1Headline },
          { id: 'B2', name: 'Compact rail', desc: 'Rail kategori di kiri. Dense, scannable. Untuk catalog/dashboard.', Comp: CardB2Compact },
          { id: 'B3', name: 'Stamp', desc: 'Cap nomor skema di kanan atas + ikon gradient. Lebih playful, official.', Comp: CardB3Stamp },
          { id: 'B4', name: 'Spotlight', desc: 'Hero ikon berwarna penuh. Visual-led, kategori langsung "kebaca".', Comp: CardB4Spotlight },
        ].map(({ id, name, desc, Comp }) => (
          <div key={id} style={{ display: 'flex', flexDirection: 'column' }}>
            <div style={{
              fontSize: 11, fontWeight: 800, letterSpacing: '0.14em', textTransform: 'uppercase',
              color: T7.navy800, marginBottom: 4, fontFamily: 'ui-monospace, monospace',
            }}>{id} · {name}</div>
            <p style={{ fontSize: 12, color: T7.muted, lineHeight: 1.5, margin: '0 0 16px', minHeight: 36 }}>{desc}</p>
            <div style={{ flex: 1, display: 'flex' }}>
              <Comp scheme={featured} />
            </div>
          </div>
        ))}
      </div>

      {/* Second row — same variants with a different scheme to test resilience */}
      <div style={{ marginTop: 36, paddingTop: 28, borderTop: `1px dashed ${T7.line2}` }}>
        <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.14em', textTransform: 'uppercase',
                      color: T7.muted, marginBottom: 16 }}>
          Test dengan data berbeda — SPMI / Education category
        </div>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: 18, alignItems: 'stretch' }}>
          {[CardB1Headline, CardB2Compact, CardB3Stamp, CardB4Spotlight].map((Comp, i) => (
            <div key={i} style={{ display: 'flex' }}>
              <Comp scheme={featured2} />
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}

Object.assign(window, {
  CardB1Headline, CardB2Compact, CardB3Stamp, CardB4Spotlight,
  SkemaCardMicroVariants,
});
