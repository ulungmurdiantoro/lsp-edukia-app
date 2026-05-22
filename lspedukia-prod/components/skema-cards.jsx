/* global React */
const T2 = window.LSP_TOKENS;
const CATS = window.LSP_CATS;

// ============================================================
// VARIANT A — "EDITORIAL LEMBAGA"
// Refined editorial feel. Big Fraunces italic numerals,
// generous whitespace, monochrome navy/ink with one orange micro-accent.
// Inspired by McKinsey/government reports + Pentagram editorial.
// ============================================================
function SkemaCardA({ scheme }) {
  const cat = CATS[scheme.cat];
  return (
    <article style={{
      background: '#fff', border: `1px solid ${T2.line}`, borderRadius: 4,
      padding: '0', overflow: 'hidden', display: 'flex', flexDirection: 'column',
      transition: 'transform .2s, box-shadow .2s',
      position: 'relative',
    }}>
      {/* Top category strip */}
      <div style={{ height: 4, background: cat.color }} />

      <div style={{ padding: '28px 32px 24px' }}>
        {/* Eyebrow */}
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline',
                      fontSize: 11, fontWeight: 600, letterSpacing: '0.16em', textTransform: 'uppercase',
                      color: T2.muted, fontFamily: 'ui-monospace, "SF Mono", monospace', marginBottom: 16 }}>
          <span>Skema · No. {scheme.no}</span>
          <span style={{ color: cat.color }}>{cat.label}</span>
        </div>

        {/* Big Fraunces italic number anchor + title */}
        <div style={{ display: 'grid', gridTemplateColumns: 'auto 1fr', gap: 18, alignItems: 'flex-start' }}>
          <div style={{
            fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 400,
            fontSize: 72, lineHeight: 0.85, color: T2.navy800, letterSpacing: '-0.04em',
            paddingTop: 2,
          }}>{scheme.no}</div>
          <h3 style={{
            fontSize: 19, lineHeight: 1.3, letterSpacing: '-0.01em', fontWeight: 700,
            color: T2.ink, margin: 0, textWrap: 'balance', alignSelf: 'flex-end', paddingBottom: 4,
          }}>{scheme.title}</h3>
        </div>

        {/* Code line under title */}
        <div style={{ fontSize: 11.5, color: T2.muted, marginTop: 14,
                      fontFamily: 'ui-monospace, monospace', letterSpacing: '0.04em' }}>
          {scheme.code}
        </div>
      </div>

      {/* Body — requirements */}
      <div style={{ padding: '0 32px 8px', borderTop: `1px solid ${T2.line}` }}>
        <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.14em', textTransform: 'uppercase',
                      color: T2.ink2, padding: '20px 0 14px' }}>
          Persyaratan Dasar Pemohon
        </div>
        <ol style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 0 }}>
          {scheme.reqs.map((r, i) => (
            <li key={i} style={{
              padding: '12px 0', borderBottom: i < scheme.reqs.length - 1 ? `1px dashed ${T2.line2}` : 'none',
              display: 'grid', gridTemplateColumns: '28px 1fr', gap: 12, alignItems: 'baseline',
            }}>
              <span style={{
                fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 500,
                fontSize: 18, color: T2.orangeDeep, lineHeight: 1,
              }}>{String(i + 1).padStart(2, '0')}</span>
              <span style={{ fontSize: 14, lineHeight: 1.55, color: T2.ink2 }}>{r}</span>
            </li>
          ))}
        </ol>
      </div>

      {/* Footer */}
      <div style={{
        marginTop: 'auto', borderTop: `1px solid ${T2.line}`,
        padding: '18px 32px', display: 'flex', justifyContent: 'space-between', alignItems: 'center',
      }}>
        <span style={{ fontSize: 13, color: T2.muted }}>
          <span style={{ color: T2.navy800, fontWeight: 700, fontSize: 15 }}>{scheme.units}</span> unit kompetensi
        </span>
        <a href="#" style={{
          fontSize: 13, fontWeight: 700, color: T2.navy800, textDecoration: 'none',
          display: 'inline-flex', alignItems: 'center', gap: 6, letterSpacing: '0.02em', textTransform: 'uppercase',
          borderBottom: `2px solid ${T2.orange}`, paddingBottom: 2,
        }}>
          Lihat Unit <window.Icon name="arrow-r" size={14} />
        </a>
      </div>
    </article>
  );
}

// ============================================================
// VARIANT B — "INSTITUTIONAL BOLD"
// Navy header band with icon + scheme code, colored category chip,
// checkmark requirements, pill CTA. Confident, modern corporate.
// ============================================================
function SkemaCardB({ scheme }) {
  const cat = CATS[scheme.cat];
  const iconName = window.CAT_ICON[scheme.cat] || 'award';
  return (
    <article style={{
      background: '#fff', borderRadius: 18, overflow: 'hidden',
      border: `1px solid ${T2.line}`,
      display: 'flex', flexDirection: 'column',
      boxShadow: '0 1px 0 rgba(15,29,53,.02)',
    }}>
      {/* Navy header */}
      <div style={{
        background: `linear-gradient(135deg, ${T2.navy800}, ${T2.navy700})`,
        color: '#fff', padding: '20px 22px', position: 'relative', overflow: 'hidden',
      }}>
        {/* corner pattern */}
        <div style={{
          position: 'absolute', top: -40, right: -40, width: 140, height: 140,
          background: `radial-gradient(circle, ${cat.color}40, transparent 70%)`, pointerEvents: 'none',
        }} />

        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', gap: 12, position: 'relative' }}>
          <div style={{ display: 'flex', gap: 12, alignItems: 'center' }}>
            <div style={{
              width: 38, height: 38, borderRadius: 10, background: 'rgba(255,255,255,.08)',
              border: '1px solid rgba(255,255,255,.18)',
              display: 'grid', placeItems: 'center', color: '#fff', flex: '0 0 auto',
            }}>
              <window.Icon name={iconName} size={20} />
            </div>
            <div>
              <div style={{ fontSize: 10.5, fontWeight: 700, letterSpacing: '0.18em', textTransform: 'uppercase',
                            color: T2.orange }}>
                Skema {scheme.no}
              </div>
              <div style={{ fontSize: 11.5, color: 'rgba(255,255,255,.55)',
                            fontFamily: 'ui-monospace, monospace', marginTop: 2 }}>
                {scheme.code}
              </div>
            </div>
          </div>
        </div>

        <h3 style={{
          fontSize: 17.5, lineHeight: 1.3, letterSpacing: '-0.01em', fontWeight: 700,
          color: '#fff', margin: '18px 0 12px', textWrap: 'balance',
        }}>{scheme.title}</h3>

        <span style={{
          display: 'inline-flex', alignItems: 'center', gap: 6,
          padding: '5px 10px', borderRadius: 6, fontSize: 11, fontWeight: 700,
          background: cat.bg, color: cat.color, letterSpacing: '0.02em',
        }}>
          <window.Icon name="dot" size={8} color={cat.color} />
          {cat.label}
        </span>
      </div>

      {/* Body */}
      <div style={{ padding: '22px 22px 18px', flex: 1 }}>
        <div style={{ fontSize: 10.5, fontWeight: 800, letterSpacing: '0.16em', textTransform: 'uppercase',
                      color: T2.muted, marginBottom: 14 }}>
          Persyaratan Dasar
        </div>
        <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 10 }}>
          {scheme.reqs.map((r, i) => (
            <li key={i} style={{ display: 'grid', gridTemplateColumns: '22px 1fr', gap: 10, alignItems: 'flex-start' }}>
              <span style={{
                width: 20, height: 20, borderRadius: 6, background: T2.navy50,
                color: T2.navy700, display: 'grid', placeItems: 'center', flex: '0 0 auto', marginTop: 1,
              }}>
                <window.Icon name="check" size={12} stroke={2.5} />
              </span>
              <span style={{ fontSize: 13.5, lineHeight: 1.55, color: T2.ink2 }}>{r}</span>
            </li>
          ))}
        </ul>
      </div>

      {/* CTA pill */}
      <div style={{ padding: '0 22px 22px' }}>
        <a href="#" style={{
          display: 'flex', justifyContent: 'space-between', alignItems: 'center',
          background: T2.cream, border: `1px solid ${T2.line2}`, borderRadius: 999,
          padding: '12px 8px 12px 18px', textDecoration: 'none',
          color: T2.ink, fontWeight: 600, fontSize: 13.5,
        }}>
          <span>
            <span style={{ color: T2.navy800, fontWeight: 800 }}>{scheme.units}</span>
            <span style={{ color: T2.muted }}> unit kompetensi</span>
          </span>
          <span style={{
            background: T2.navy800, color: '#fff', borderRadius: 999,
            padding: '6px 14px', fontSize: 12, fontWeight: 700, letterSpacing: '0.02em',
            display: 'inline-flex', alignItems: 'center', gap: 6,
          }}>
            Lihat detail <window.Icon name="arrow-r" size={12} stroke={2.5} />
          </span>
        </a>
      </div>
    </article>
  );
}

// ============================================================
// "BEFORE" — current production card, for comparison context
// ============================================================
function SkemaCardOrig({ scheme }) {
  const cat = CATS[scheme.cat];
  return (
    <article style={{
      background: '#fff', border: `1px solid ${T2.line}`, borderRadius: 16,
      padding: 22, display: 'flex', flexDirection: 'column', gap: 12,
    }}>
      <span style={{ fontSize: 11, fontWeight: 700, color: T2.muted,
                     fontFamily: 'ui-monospace, monospace', background: T2.cream2,
                     padding: '3px 8px', borderRadius: 5, alignSelf: 'flex-start' }}>Skema {scheme.no}</span>
      <span style={{ alignSelf: 'flex-start', fontSize: 11.5, fontWeight: 600,
                     padding: '5px 10px', borderRadius: 6, background: cat.bg, color: cat.color }}>{cat.label}</span>
      <h3 style={{ fontSize: 15, lineHeight: 1.35, color: T2.ink, margin: 0, fontWeight: 700 }}>{scheme.title}</h3>
      <ul style={{ listStyle: 'none', padding: 0, margin: '4px 0 0', display: 'flex', flexDirection: 'column', gap: 7 }}>
        {scheme.reqs.map((r, i) => (
          <li key={i} style={{
            fontSize: 13, color: T2.ink2, paddingLeft: 16, position: 'relative', lineHeight: 1.5,
          }}>
            <span style={{ position: 'absolute', left: 0, top: 8, width: 5, height: 5,
                           borderRadius: '50%', background: T2.blue, opacity: 0.7 }} />
            {r}
          </li>
        ))}
      </ul>
      <div style={{ marginTop: 'auto', paddingTop: 14, borderTop: `1px dashed ${T2.line2}`,
                    display: 'flex', justifyContent: 'flex-end' }}>
        <a href="#" style={{ fontSize: 13, color: T2.blueDeep, fontWeight: 600,
                             textDecoration: 'none', display: 'inline-flex', alignItems: 'center', gap: 4 }}>
          Unit kompetensi <window.Icon name="chev-r" size={14} />
        </a>
      </div>
    </article>
  );
}

Object.assign(window, { SkemaCardA, SkemaCardB, SkemaCardOrig });
