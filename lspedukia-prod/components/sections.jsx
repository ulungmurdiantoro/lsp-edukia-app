/* global React */
const T3 = window.LSP_TOKENS;

// ============================================================
// WRAP — content container
// ============================================================
function Wrap({ children, maxW = 1240, style = {}, py }) {
  return (
    <div style={{ maxWidth: maxW, margin: '0 auto', padding: '0 32px', ...(py != null && { paddingTop: py, paddingBottom: py }), ...style }}>
      {children}
    </div>
  );
}

// ============================================================
// HERO HOME — VARIANT A: Editorial / Type-led
// Big Fraunces italic accent, full-bleed image bg, content stacked center-left.
// ============================================================
function HeroHomeA() {
  return (
    <section style={{
      background: `linear-gradient(115deg, ${T3.navy900} 0%, ${T3.navy800}eb 50%, ${T3.navy800}c0 100%), url('assets/hero-index.jpg')`,
      backgroundSize: 'cover', backgroundPosition: 'center',
      color: '#fff', position: 'relative', overflow: 'hidden',
    }}>
      <Wrap style={{ padding: '88px 32px 96px', position: 'relative' }}>
        {/* Editorial date / serial */}
        <div style={{ display: 'flex', alignItems: 'center', gap: 16, fontSize: 12, fontWeight: 600,
                      letterSpacing: '0.2em', textTransform: 'uppercase', color: 'rgba(255,255,255,.55)',
                      marginBottom: 36, fontFamily: 'ui-monospace, monospace' }}>
          <span style={{ width: 32, height: 1, background: T3.orange }} />
          <span>EST. SK No. 001/SK-AK/LSP-EDUKIA/I/2026</span>
          <span style={{ flex: 1, height: 1, background: 'rgba(255,255,255,.12)' }} />
          <span>LSP-033-IDN · BERLISENSI KAN</span>
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: '1.4fr 1fr', gap: 80, alignItems: 'flex-end' }}>
          <div>
            <h1 style={{
              fontSize: 'clamp(48px, 6vw, 84px)', lineHeight: 0.98, letterSpacing: '-0.04em',
              fontWeight: 800, margin: 0, color: '#fff',
            }}>
              Sertifikasi kompetensi <em style={{
                fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 400,
                color: T3.orange, letterSpacing: '-0.05em',
              }}>profesional</em><br/>
              berstandar nasional.
            </h1>
            <p style={{ marginTop: 28, fontSize: 18, lineHeight: 1.55, color: 'rgba(255,255,255,.78)',
                        maxWidth: '52ch' }}>
              26 skema sertifikasi untuk bidang Pendidikan Tinggi, Laboratorium, Lifting Engineering, dan Industri. Uji kompetensi daring, sertifikat berlaku 3 tahun.
            </p>
            <div style={{ display: 'flex', gap: 12, marginTop: 36 }}>
              <window.Btn variant="primary" size="lg" iconR="arrow-r">Lihat 26 skema</window.Btn>
              <window.Btn variant="ghost" size="lg">Konsultasi gratis</window.Btn>
            </div>
          </div>

          {/* Stats — editorial table style */}
          <div style={{ borderTop: '1px solid rgba(255,255,255,.15)', borderBottom: '1px solid rgba(255,255,255,.15)',
                        display: 'flex', flexDirection: 'column' }}>
            {[
              { v: '26', l: 'Skema sertifikasi aktif' },
              { v: '7',  l: 'Kategori bidang keahlian' },
              { v: '3 thn', l: 'Masa berlaku sertifikat' },
              { v: 'Online', l: 'Uji kompetensi fleksibel' },
            ].map((s, i) => (
              <div key={i} style={{
                display: 'flex', justifyContent: 'space-between', alignItems: 'baseline',
                padding: '18px 0', borderBottom: i < 3 ? '1px solid rgba(255,255,255,.08)' : 'none',
              }}>
                <span style={{ fontSize: 13, color: 'rgba(255,255,255,.6)', letterSpacing: '0.02em' }}>{s.l}</span>
                <span style={{
                  fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 400,
                  fontSize: 38, color: '#fff', letterSpacing: '-0.03em', lineHeight: 1,
                }}>{s.v}</span>
              </div>
            ))}
          </div>
        </div>
      </Wrap>
    </section>
  );
}

// ============================================================
// HERO HOME — VARIANT B: Modern Institutional / Stat-grid
// Strong navy gradient, modern bold sans, stat cards with corner badges
// ============================================================
function HeroHomeB() {
  return (
    <section style={{
      background: `radial-gradient(900px 500px at 90% -10%, rgba(68,159,229,.28), transparent 60%),
                   radial-gradient(700px 400px at 10% 110%, rgba(244,137,31,.18), transparent 60%),
                   linear-gradient(105deg, rgba(10,37,71,.68) 0%, rgba(10,37,71,.85) 45%, rgba(6,23,46,.97) 75%),
                   url('assets/hero-index.jpg')`,
      backgroundSize: 'cover', backgroundPosition: 'center', color: '#fff', position: 'relative', overflow: 'hidden',
    }}>
      {/* grid bg pattern */}
      <div style={{
        position: 'absolute', inset: 0, pointerEvents: 'none',
        backgroundImage: `linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px)`,
        backgroundSize: '64px 64px',
        maskImage: 'radial-gradient(80% 70% at 50% 30%, #000 30%, transparent 80%)',
      }} />
      <Wrap style={{ padding: '92px 32px 104px', position: 'relative' }}>
        <div style={{ display: 'grid', gridTemplateColumns: '1.15fr 1fr', gap: 56, alignItems: 'center' }}>
          <div>
            <span style={{
              display: 'inline-flex', alignItems: 'center', gap: 10, height: 34, padding: '0 14px 0 12px',
              borderRadius: 999, background: 'rgba(255,255,255,.08)', border: '1px solid rgba(255,255,255,.18)',
              fontSize: 12.5, fontWeight: 600, letterSpacing: '0.04em', textTransform: 'uppercase',
            }}>
              <span style={{ width: 7, height: 7, borderRadius: '50%', background: '#7ee0a3',
                             boxShadow: '0 0 0 4px rgba(126,224,163,.18)' }} />
              Berlisensi KAN · LSP-033-IDN
            </span>
            <h1 style={{
              fontSize: 'clamp(40px, 5vw, 68px)', lineHeight: 1.02, letterSpacing: '-0.035em',
              fontWeight: 800, color: '#fff', margin: '24px 0 18px',
            }}>
              Sertifikasi kompetensi{' '}
              <em style={{ fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 500,
                           color: T3.blue, letterSpacing: '-0.04em' }}>profesional</em>{' '}
              berstandar nasional
            </h1>
            <p style={{ color: 'rgba(255,255,255,.78)', fontSize: 17.5, maxWidth: '52ch', lineHeight: 1.55, margin: 0 }}>
              26 skema sertifikasi untuk Pendidikan Tinggi, Laboratorium, Lifting Engineering, dan Industri. Uji kompetensi daring, sertifikat berlaku 3 tahun.
            </p>
            <div style={{ display: 'flex', gap: 12, marginTop: 32 }}>
              <window.Btn variant="primary" size="lg" iconR="arrow-r">Lihat persyaratan</window.Btn>
              <window.Btn variant="ghost" size="lg">Unit kompetensi</window.Btn>
            </div>
            <div style={{ display: 'flex', gap: 18, marginTop: 36, alignItems: 'center',
                          color: 'rgba(255,255,255,.55)', fontSize: 12.5, letterSpacing: '0.02em' }}>
              <span>DIAKUI KAN</span>
              <span style={{ flex: 1, height: 1, background: 'rgba(255,255,255,.12)' }} />
              <span>LSP-033-IDN</span>
              <span style={{ flex: 1, height: 1, background: 'rgba(255,255,255,.12)' }} />
              <span>DP.AK.05 REV.02</span>
            </div>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 14 }}>
            {[
              { v: '26', l: 'Skema sertifikasi', i: '01' },
              { v: '7',  l: 'Bidang keahlian', i: '02' },
              { v: '3', s: 'th', l: 'Masa berlaku sertifikat', i: '03' },
              { v: 'Online', l: 'Uji kompetensi fleksibel', i: '04', featured: true },
            ].map((s, i) => (
              <div key={i} style={{
                background: s.featured ? 'linear-gradient(135deg, rgba(68,159,229,.18), rgba(244,137,31,.1))'
                                       : 'rgba(255,255,255,.04)',
                border: `1px solid ${s.featured ? 'rgba(68,159,229,.32)' : 'rgba(255,255,255,.12)'}`,
                borderRadius: 20, padding: '24px 22px', position: 'relative', overflow: 'hidden',
              }}>
                <span style={{ position: 'absolute', top: 14, right: 14, width: 22, height: 22, borderRadius: 6,
                              display: 'grid', placeItems: 'center', background: 'rgba(255,255,255,.08)',
                              color: 'rgba(255,255,255,.5)', fontSize: 11, fontWeight: 700 }}>{s.i}</span>
                <div style={{
                  fontSize: s.v === 'Online' ? 32 : 54, fontWeight: 800, letterSpacing: '-0.04em',
                  lineHeight: 1, color: '#fff', display: 'flex', alignItems: 'baseline', gap: 4,
                }}>
                  {s.v}
                  {s.s && <small style={{ fontSize: 22, fontWeight: 600, color: 'rgba(255,255,255,.6)', letterSpacing: 0 }}>{s.s}</small>}
                </div>
                <div style={{ marginTop: 8, fontSize: 13.5, color: 'rgba(255,255,255,.65)', fontWeight: 500 }}>{s.l}</div>
              </div>
            ))}
          </div>
        </div>
      </Wrap>
    </section>
  );
}

// ============================================================
// PAGE HERO (for non-home pages) — both variants
// ============================================================
function PageHero({ variant = 'a', image, badge, title, italicWord, lead }) {
  const renderTitle = () => {
    if (!italicWord) return title;
    return title.split(italicWord).map((p, i, arr) =>
      <React.Fragment key={i}>
        {p}
        {i < arr.length - 1 && <em style={{
          fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: variant === 'a' ? 400 : 500,
          color: variant === 'a' ? T3.orange : T3.blue,
        }}>{italicWord}</em>}
      </React.Fragment>
    );
  };
  if (variant === 'a') {
    return (
      <section style={{
        background: `linear-gradient(125deg, ${T3.navy900}f5, ${T3.navy800}c5), url('${image}')`,
        backgroundSize: 'cover', backgroundPosition: 'center', color: '#fff',
        borderTop: 'none', position: 'relative', overflow: 'hidden',
      }}>
        <Wrap style={{ padding: '72px 32px 80px', position: 'relative' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: 14, fontSize: 11,
                        fontWeight: 700, letterSpacing: '0.2em', textTransform: 'uppercase',
                        color: 'rgba(255,255,255,.55)', marginBottom: 28,
                        fontFamily: 'ui-monospace, monospace' }}>
            <span style={{ width: 28, height: 1, background: T3.orange }} />
            {badge}
          </div>
          <h1 style={{ fontSize: 'clamp(44px, 5.5vw, 76px)', lineHeight: 1, letterSpacing: '-0.04em',
                       fontWeight: 800, color: '#fff', margin: 0, maxWidth: '20ch' }}>
            {renderTitle()}
          </h1>
          {lead && <p style={{ marginTop: 24, fontSize: 17, lineHeight: 1.55,
                               color: 'rgba(255,255,255,.78)', maxWidth: '60ch' }}>{lead}</p>}
        </Wrap>
      </section>
    );
  }
  // Variant B
  return (
    <section style={{
      background: `radial-gradient(700px 400px at 80% -10%, rgba(68,159,229,.25), transparent 60%),
                   radial-gradient(600px 300px at 10% 110%, rgba(244,137,31,.15), transparent 60%),
                   linear-gradient(180deg, rgba(10,37,71,.82), rgba(6,23,46,.92)), url('${image}')`,
      backgroundSize: 'cover', backgroundPosition: 'center', color: '#fff',
      borderTop: 'none', position: 'relative', overflow: 'hidden',
    }}>
      <div style={{
        position: 'absolute', inset: 0, pointerEvents: 'none',
        backgroundImage: `linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px)`,
        backgroundSize: '64px 64px',
        maskImage: 'radial-gradient(80% 70% at 50% 30%, #000 30%, transparent 80%)',
      }} />
      <Wrap style={{ padding: '80px 32px 88px', position: 'relative' }}>
        <span style={{
          display: 'inline-flex', alignItems: 'center', gap: 10, height: 34, padding: '0 14px',
          borderRadius: 999, background: 'rgba(255,255,255,.08)', border: '1px solid rgba(255,255,255,.18)',
          fontSize: 12.5, fontWeight: 600, letterSpacing: '0.04em', textTransform: 'uppercase',
          marginBottom: 20,
        }}>{badge}</span>
        <h1 style={{ fontSize: 'clamp(36px, 5vw, 64px)', lineHeight: 1.02, letterSpacing: '-0.035em',
                     fontWeight: 800, color: '#fff', margin: '0 0 16px' }}>
          {renderTitle()}
        </h1>
        {lead && <p style={{ color: 'rgba(255,255,255,.78)', fontSize: 17, maxWidth: '56ch',
                             lineHeight: 1.55, margin: 0 }}>{lead}</p>}
      </Wrap>
    </section>
  );
}

// ============================================================
// ALUR SERTIFIKASI — 4 steps
// ============================================================
const ALUR_STEPS = [
  { i: '1', icon: 'doc',        title: 'Permohonan Sertifikasi',  desc: 'Isi formulir FR.APL.01 dan FR.AK.01. Lengkapi dokumen persyaratan sesuai skema yang dipilih.' },
  { i: '2', icon: 'check-list', title: 'Pra Asesmen',             desc: 'Asesor memverifikasi kelengkapan bukti dokumen — Valid, Asli, Terkini, Memadai (VATM).' },
  { i: '3', icon: 'monitor',    title: 'Uji Kompetensi',          desc: 'Ujian tertulis, lisan, dan/atau keterampilan secara online. Hasil: Kompeten atau Belum Kompeten.' },
  { i: '4', icon: 'award',      title: 'Penerbitan Sertifikat',   desc: 'Sertifikat disahkan Ketua LSP EDUKIA, berlaku 3 tahun. Remedial atau banding tersedia.' },
];

function AlurA() {
  return (
    <section style={{ padding: '96px 0', background: T3.cream, borderTop: `1px solid ${T3.line}` }}>
      <Wrap>
        <window.SectionHead
          eyebrow="Alur Sertifikasi"
          title="Proses sertifikasi dalam 4 tahap"
          sub="Transparan, objektif, dan sesuai standar KAN. Setiap tahap dipantau asesor independen bersertifikat."
        />
        {/* Horizontal numbered timeline */}
        <div style={{ position: 'relative' }}>
          <div style={{
            position: 'absolute', top: 36, left: '10%', right: '10%', height: 1,
            background: `repeating-linear-gradient(90deg, ${T3.line2} 0 6px, transparent 6px 12px)`,
          }} />
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: 28, position: 'relative' }}>
            {ALUR_STEPS.map((s, idx) => (
              <div key={idx}>
                <div style={{
                  width: 72, height: 72, borderRadius: '50%', background: '#fff',
                  border: `1px solid ${T3.line}`, display: 'grid', placeItems: 'center', position: 'relative',
                  marginBottom: 22,
                }}>
                  <span style={{
                    fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 400,
                    fontSize: 38, color: T3.navy800, lineHeight: 1,
                  }}>{s.i}</span>
                  <span style={{
                    position: 'absolute', bottom: -8, right: -8, width: 30, height: 30, borderRadius: 8,
                    background: T3.navy800, color: '#fff', display: 'grid', placeItems: 'center',
                  }}>
                    <window.Icon name={s.icon} size={14} color="#fff" />
                  </span>
                </div>
                <div style={{ fontSize: 10.5, fontWeight: 700, letterSpacing: '0.18em',
                              textTransform: 'uppercase', color: T3.orangeDeep, marginBottom: 8 }}>
                  Tahap {s.i}
                </div>
                <h3 style={{ fontSize: 18, fontWeight: 700, color: T3.ink, margin: '0 0 8px', letterSpacing: '-0.01em' }}>
                  {s.title}
                </h3>
                <p style={{ fontSize: 14, color: T3.muted, lineHeight: 1.6, margin: 0 }}>{s.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </Wrap>
    </section>
  );
}

function AlurB() {
  return (
    <section style={{ padding: '96px 0', background: T3.cream, borderTop: `1px solid ${T3.line}` }}>
      <Wrap>
        <window.SectionHead
          eyebrow="Alur Sertifikasi"
          title="Proses sertifikasi dalam 4 tahap"
          sub="Transparan, objektif, dan sesuai standar KAN. Setiap tahap dipantau asesor independen bersertifikat."
        />
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: 18 }}>
          {ALUR_STEPS.map((s, idx) => {
            const bg = [T3.navy800, T3.blueDeep, T3.blue, T3.orange][idx];
            return (
              <div key={idx} style={{
                background: '#fff', border: `1px solid ${T3.line}`, borderRadius: 18, padding: 24,
                position: 'relative', transition: 'all .2s',
              }}>
                <div style={{
                  width: 34, height: 34, borderRadius: '50%', background: bg, color: '#fff',
                  display: 'grid', placeItems: 'center', fontWeight: 800, fontSize: 14,
                  boxShadow: `0 4px 12px ${bg}50`,
                }}>{s.i}</div>
                <div style={{
                  marginTop: 22, marginBottom: 14, width: 42, height: 42, borderRadius: 10,
                  background: T3.navy50, color: T3.navy700, display: 'grid', placeItems: 'center',
                }}>
                  <window.Icon name={s.icon} size={22} />
                </div>
                <h3 style={{ fontSize: 17, fontWeight: 700, color: T3.ink, margin: '0 0 8px' }}>{s.title}</h3>
                <p style={{ fontSize: 14, color: T3.muted, lineHeight: 1.55, margin: 0 }}>{s.desc}</p>
              </div>
            );
          })}
        </div>
      </Wrap>
    </section>
  );
}

// ============================================================
// FILTER CHIPS (for skema page)
// ============================================================
function FilterChips({ items, activeId = 'all', variant = 'a' }) {
  return (
    <div style={{ display: 'flex', flexWrap: 'wrap', gap: 10 }}>
      {items.map(c => {
        const isActive = c.id === activeId;
        return (
          <span key={c.id} style={{
            height: 40, padding: '0 18px', borderRadius: variant === 'a' ? 4 : 999,
            border: `1px solid ${isActive ? T3.navy800 : T3.line2}`,
            background: isActive ? T3.navy800 : '#fff',
            color: isActive ? '#fff' : T3.ink2,
            fontSize: 13.5, fontWeight: 500,
            display: 'inline-flex', alignItems: 'center', gap: 10,
          }}>
            {c.label}
            <span style={{
              fontSize: 11.5, color: isActive ? 'rgba(255,255,255,.7)' : T3.muted, fontWeight: 600,
              padding: '2px 7px', borderRadius: variant === 'a' ? 3 : 999,
              background: isActive ? 'rgba(255,255,255,.12)' : T3.cream2,
            }}>{c.count}</span>
          </span>
        );
      })}
    </div>
  );
}

// ============================================================
// CTA — shared
// ============================================================
function CtaBlock() {
  return (
    <Wrap style={{ padding: '0 32px 96px' }}>
      <div style={{
        background: `linear-gradient(135deg, ${T3.navy800}, ${T3.navy700} 70%, ${T3.navy900})`,
        borderRadius: 24, padding: 42, color: '#fff',
        display: 'grid', gridTemplateColumns: '1fr auto auto', gap: 18,
        alignItems: 'center', position: 'relative', overflow: 'hidden',
      }}>
        <div style={{ position: 'absolute', right: -80, top: -80, width: 280, height: 280, borderRadius: '50%',
                      background: 'radial-gradient(circle, rgba(244,137,31,.3), transparent 70%)', pointerEvents: 'none' }} />
        <div style={{ position: 'absolute', left: -80, bottom: -80, width: 240, height: 240, borderRadius: '50%',
                      background: 'radial-gradient(circle, rgba(68,159,229,.28), transparent 70%)', pointerEvents: 'none' }} />
        <div style={{ position: 'relative', zIndex: 1 }}>
          <h3 style={{ color: '#fff', fontSize: 26, letterSpacing: '-0.02em', margin: '0 0 6px', fontWeight: 700 }}>
            Siap memulai sertifikasi Anda?
          </h3>
          <p style={{ color: 'rgba(255,255,255,.72)', fontSize: 15, margin: 0 }}>
            Konsultasi GRATIS dengan tim kami — hubungi via WhatsApp sekarang.
          </p>
        </div>
        <window.Btn variant="primary" size="lg" icon="doc" style={{ position: 'relative', zIndex: 1 }}>
          Lihat unit kompetensi
        </window.Btn>
        <a href="#" style={{
          display: 'inline-flex', alignItems: 'center', gap: 10,
          background: 'rgba(255,255,255,.08)', border: '1px solid rgba(255,255,255,.18)',
          height: 52, padding: '0 22px', borderRadius: 999, fontWeight: 600, color: '#fff',
          textDecoration: 'none', position: 'relative', zIndex: 1, fontSize: 14.5,
        }}>
          <span style={{ color: '#7ee0a3' }}><window.Icon name="wa" size={18} /></span>
          +62 851-7547-9385
        </a>
      </div>
    </Wrap>
  );
}

Object.assign(window, { Wrap, HeroHomeA, HeroHomeB, PageHero, AlurA, AlurB, FilterChips, CtaBlock });
