/* global React */
const T10 = window.LSP_TOKENS;
const CATS_MOB = window.LSP_CATS;

// ============================================================
// MOBILE HEADER (hamburger)
// ============================================================
function MobileHeader({ title }) {
  return (
    <header style={{
      position: 'sticky', top: 0, zIndex: 50,
      background: '#fff', borderBottom: `1px solid ${T10.line}`,
      display: 'flex', alignItems: 'center', justifyContent: 'space-between',
      padding: '12px 16px', height: 60,
    }}>
      <window.Logo height={36} />
      <button style={{
        width: 40, height: 40, borderRadius: 10, border: `1px solid ${T10.line2}`,
        background: '#fff', display: 'grid', placeItems: 'center', cursor: 'pointer',
      }}>
        <window.Icon name="list" size={18} />
      </button>
    </header>
  );
}

// ============================================================
// MOBILE CTA bar (floating WA)
// ============================================================
function MobileWA() {
  return (
    <a href="#" style={{
      position: 'fixed', bottom: 16, right: 16, zIndex: 99,
      width: 52, height: 52, borderRadius: '50%', background: '#25d366', color: '#fff',
      display: 'grid', placeItems: 'center', boxShadow: '0 6px 24px rgba(37,211,102,.4)',
    }}>
      <window.Icon name="wa" size={26} color="#fff" />
    </a>
  );
}

// ============================================================
// MOBILE HOME
// ============================================================
function MobileHome() {
  return (
    <div style={{
      background: T10.cream, fontFamily: '"Plus Jakarta Sans", sans-serif',
      color: T10.ink, minHeight: 1500, position: 'relative',
    }}>
      <MobileHeader title="LSP Edukia" />

      {/* Hero */}
      <section style={{
        background: `radial-gradient(700px 400px at 90% -10%, rgba(68,159,229,.28), transparent 60%),
                     linear-gradient(165deg, ${T10.navy900} 0%, ${T10.navy800} 50%, ${T10.navy700} 100%),
                     url('assets/hero-index.jpg')`,
        backgroundSize: 'cover', backgroundPosition: 'center',
        color: '#fff', padding: '36px 20px 40px', position: 'relative',
      }}>
        <span style={{
          display: 'inline-flex', alignItems: 'center', gap: 8, height: 28, padding: '0 12px',
          borderRadius: 999, background: 'rgba(255,255,255,.08)', border: '1px solid rgba(255,255,255,.18)',
          fontSize: 10.5, fontWeight: 700, letterSpacing: '0.06em', textTransform: 'uppercase',
        }}>
          <span style={{ width: 6, height: 6, borderRadius: '50%', background: '#7ee0a3' }} />
          LSP-033-IDN · KAN
        </span>
        <h1 style={{
          fontSize: 36, lineHeight: 1.05, letterSpacing: '-0.03em', fontWeight: 800,
          color: '#fff', margin: '18px 0 14px',
        }}>
          Sertifikasi <em style={{ fontFamily: '"Fraunces", serif', fontStyle: 'italic',
                                   fontWeight: 500, color: T10.blue }}>profesional</em> berstandar nasional
        </h1>
        <p style={{ color: 'rgba(255,255,255,.78)', fontSize: 14.5, lineHeight: 1.55, margin: 0 }}>
          26 skema sertifikasi untuk Pendidikan Tinggi, Laboratorium, Lifting Engineering, dan Industri.
        </p>
        <div style={{ display: 'flex', flexDirection: 'column', gap: 10, marginTop: 24 }}>
          <a href="#" style={{
            background: T10.orange, color: '#fff', height: 48, borderRadius: 999,
            display: 'inline-flex', alignItems: 'center', justifyContent: 'center', gap: 8,
            fontWeight: 700, fontSize: 14, textDecoration: 'none', boxShadow: '0 4px 14px rgba(244,137,31,.35)',
          }}>
            Lihat 26 skema <window.Icon name="arrow-r" size={16} />
          </a>
          <a href="#" style={{
            background: 'rgba(255,255,255,.08)', color: '#fff', height: 48, borderRadius: 999,
            display: 'inline-flex', alignItems: 'center', justifyContent: 'center',
            fontWeight: 600, fontSize: 14, textDecoration: 'none', border: '1px solid rgba(255,255,255,.18)',
          }}>
            Konsultasi gratis
          </a>
        </div>
        {/* Stats — 2x2 grid compact */}
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 10, marginTop: 24 }}>
          {[{ v: '26', l: 'Skema' }, { v: '7', l: 'Bidang' },
            { v: '3 thn', l: 'Berlaku' }, { v: 'Online', l: 'Uji daring' }].map((s, i) => (
            <div key={i} style={{
              background: 'rgba(255,255,255,.05)', border: '1px solid rgba(255,255,255,.12)',
              borderRadius: 12, padding: '12px 14px',
            }}>
              <div style={{ fontSize: s.v === 'Online' ? 18 : 26, fontWeight: 800,
                            color: '#fff', lineHeight: 1, letterSpacing: '-0.03em' }}>{s.v}</div>
              <div style={{ fontSize: 11.5, color: 'rgba(255,255,255,.6)', marginTop: 4 }}>{s.l}</div>
            </div>
          ))}
        </div>
      </section>

      {/* Alur Sertifikasi - mobile */}
      <section style={{ padding: '40px 20px', background: '#fff', borderTop: `1px solid ${T10.line}` }}>
        <div style={{ fontSize: 10, fontWeight: 800, letterSpacing: '0.18em', textTransform: 'uppercase',
                      color: T10.orangeDeep, marginBottom: 8 }}>
          Alur Sertifikasi
        </div>
        <h2 style={{ fontSize: 24, fontWeight: 800, color: T10.ink, margin: '0 0 22px',
                     letterSpacing: '-0.02em', lineHeight: 1.15 }}>
          Proses sertifikasi dalam 4 tahap
        </h2>
        <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
          {[
            { i: '1', icon: 'doc', t: 'Permohonan Sertifikasi', d: 'FR.APL.01 & FR.AK.01' },
            { i: '2', icon: 'check-list', t: 'Pra Asesmen', d: 'Verifikasi dokumen VATM' },
            { i: '3', icon: 'monitor', t: 'Uji Kompetensi', d: 'Ujian online fleksibel' },
            { i: '4', icon: 'award', t: 'Penerbitan Sertifikat', d: 'Berlaku 3 tahun' },
          ].map((s, idx) => {
            const bg = [T10.navy800, T10.blueDeep, T10.blue, T10.orange][idx];
            return (
              <div key={idx} style={{
                background: '#fff', border: `1px solid ${T10.line}`, borderRadius: 14,
                padding: '14px 16px', display: 'flex', alignItems: 'center', gap: 14,
              }}>
                <div style={{
                  width: 40, height: 40, borderRadius: '50%', background: bg, color: '#fff',
                  fontSize: 15, fontWeight: 800, display: 'grid', placeItems: 'center',
                  flex: '0 0 auto',
                }}>{s.i}</div>
                <div style={{ flex: 1 }}>
                  <div style={{ fontSize: 15, fontWeight: 700, color: T10.ink }}>{s.t}</div>
                  <div style={{ fontSize: 12.5, color: T10.muted, marginTop: 2 }}>{s.d}</div>
                </div>
                <window.Icon name="chev-r" size={16} color={T10.muted} />
              </div>
            );
          })}
        </div>
      </section>

      {/* Skema cards (compact) */}
      <section style={{ padding: '40px 20px', background: T10.cream }}>
        <div style={{ fontSize: 10, fontWeight: 800, letterSpacing: '0.18em', textTransform: 'uppercase',
                      color: T10.orangeDeep, marginBottom: 8 }}>
          Skema Kompetensi
        </div>
        <h2 style={{ fontSize: 24, fontWeight: 800, color: T10.ink, margin: '0 0 18px',
                     letterSpacing: '-0.02em', lineHeight: 1.15 }}>
          Pilih bidang Anda
        </h2>

        {/* Horizontal scrolling chips */}
        <div style={{
          display: 'flex', gap: 8, overflowX: 'auto', paddingBottom: 8, marginBottom: 18,
          marginLeft: -20, marginRight: -20, padding: '0 20px 8px',
        }}>
          {[
            { id: 'all', label: 'Semua', count: 26, active: true },
            { id: 'spmi', label: 'SPMI', count: 3 },
            { id: 'lab', label: 'Lab ISO 17025', count: 2 },
            { id: 'lifting', label: 'Lifting', count: 4 },
            { id: 'mgt', label: 'Manajemen', count: 8 },
          ].map(c => (
            <span key={c.id} style={{
              flex: '0 0 auto', height: 36, padding: '0 14px', borderRadius: 999,
              border: `1px solid ${c.active ? T10.navy800 : T10.line2}`,
              background: c.active ? T10.navy800 : '#fff',
              color: c.active ? '#fff' : T10.ink2,
              fontSize: 12.5, fontWeight: 600,
              display: 'inline-flex', alignItems: 'center', gap: 6,
            }}>
              {c.label} <span style={{ opacity: 0.7, fontSize: 11 }}>{c.count}</span>
            </span>
          ))}
        </div>

        <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
          {window.LSP_SCHEMES.slice(0, 3).map(s => (
            <window.CardB2Compact key={s.no} scheme={s} />
          ))}
        </div>
        <a href="#" style={{
          marginTop: 18, display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 6,
          background: '#fff', border: `1px solid ${T10.line2}`, borderRadius: 999,
          height: 48, fontSize: 14, fontWeight: 600, color: T10.ink, textDecoration: 'none',
        }}>
          Lihat semua 26 skema <window.Icon name="arrow-r" size={14} />
        </a>
      </section>

      {/* CTA */}
      <section style={{ padding: '32px 20px' }}>
        <div style={{
          background: `linear-gradient(135deg, ${T10.navy800}, ${T10.navy700} 70%, ${T10.navy900})`,
          borderRadius: 20, padding: 24, color: '#fff', position: 'relative', overflow: 'hidden',
        }}>
          <div style={{ position: 'absolute', right: -40, top: -40, width: 140, height: 140, borderRadius: '50%',
                        background: 'radial-gradient(circle, rgba(244,137,31,.3), transparent 70%)' }} />
          <h3 style={{ color: '#fff', fontSize: 20, margin: '0 0 6px', letterSpacing: '-0.02em' }}>
            Siap memulai sertifikasi?
          </h3>
          <p style={{ color: 'rgba(255,255,255,.72)', fontSize: 13.5, margin: '0 0 16px' }}>
            Konsultasi GRATIS via WhatsApp.
          </p>
          <a href="#" style={{
            background: T10.orange, color: '#fff', height: 44, padding: '0 18px', borderRadius: 999,
            display: 'inline-flex', alignItems: 'center', gap: 8, fontWeight: 700, fontSize: 13.5,
            textDecoration: 'none', position: 'relative',
          }}>
            Lihat unit kompetensi <window.Icon name="arrow-r" size={14} />
          </a>
        </div>
      </section>

      <MobileWA />
    </div>
  );
}

// ============================================================
// MOBILE SKEMA PAGE
// ============================================================
function MobileSkema() {
  return (
    <div style={{
      background: T10.cream, fontFamily: '"Plus Jakarta Sans", sans-serif',
      color: T10.ink, minHeight: 1500, position: 'relative',
    }}>
      <MobileHeader />
      {/* Page hero */}
      <section style={{
        background: `linear-gradient(180deg, rgba(10,37,71,.85), rgba(6,23,46,.92)), url('assets/hero-skema.jpg')`,
        backgroundSize: 'cover', backgroundPosition: 'center', color: '#fff',
        padding: '32px 20px 36px',
      }}>
        <span style={{
          display: 'inline-flex', alignItems: 'center', gap: 8, height: 26, padding: '0 10px',
          borderRadius: 999, background: 'rgba(255,255,255,.08)', border: '1px solid rgba(255,255,255,.18)',
          fontSize: 10, fontWeight: 700, letterSpacing: '0.06em', textTransform: 'uppercase',
        }}>
          26 Skema · DP.AK.05 Rev. 02
        </span>
        <h1 style={{
          fontSize: 32, lineHeight: 1.05, letterSpacing: '-0.03em', fontWeight: 800,
          color: '#fff', margin: '16px 0 12px',
        }}>
          Skema <em style={{ fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 500, color: T10.blue }}>Kompetensi</em>
        </h1>
        <p style={{ color: 'rgba(255,255,255,.78)', fontSize: 14, lineHeight: 1.55, margin: 0 }}>
          Rincian 26 skema sertifikasi LSP Edukia — 7 kategori bidang keahlian.
        </p>
      </section>

      {/* Search */}
      <div style={{ padding: '20px 20px 0', background: T10.cream }}>
        <div style={{
          display: 'flex', alignItems: 'center', gap: 8, background: '#fff',
          border: `1px solid ${T10.line2}`, borderRadius: 12, padding: '0 14px', height: 48,
        }}>
          <window.Icon name="dot" size={14} color={T10.muted} />
          <span style={{ color: T10.muted, fontSize: 13.5, flex: 1 }}>Cari skema atau bidang…</span>
        </div>
      </div>

      {/* Filter scrolling */}
      <div style={{
        display: 'flex', gap: 8, overflowX: 'auto', padding: '16px 20px 4px',
        background: T10.cream,
      }}>
        {[
          { id: 'all', label: 'Semua', count: 26, active: true },
          { id: 'spmi', label: 'SPMI ISO 21001', count: 3 },
          { id: 'pt', label: 'Perguruan Tinggi', count: 2 },
          { id: 'lab', label: 'Lab ISO 17025', count: 2 },
          { id: 'lifting', label: 'Lifting', count: 4 },
          { id: 'manajemen', label: 'Sistem Mgmt', count: 8 },
        ].map(c => (
          <span key={c.id} style={{
            flex: '0 0 auto', height: 36, padding: '0 14px', borderRadius: 999,
            border: `1px solid ${c.active ? T10.navy800 : T10.line2}`,
            background: c.active ? T10.navy800 : '#fff',
            color: c.active ? '#fff' : T10.ink2,
            fontSize: 12.5, fontWeight: 600,
            display: 'inline-flex', alignItems: 'center', gap: 6, whiteSpace: 'nowrap',
          }}>
            {c.label} <span style={{ opacity: 0.7, fontSize: 11 }}>{c.count}</span>
          </span>
        ))}
      </div>

      {/* Cards list */}
      <div style={{ padding: '20px', display: 'flex', flexDirection: 'column', gap: 12 }}>
        {window.LSP_SCHEMES.slice(0, 5).map(s => (
          <window.CardB2Compact key={s.no} scheme={s} />
        ))}
      </div>

      <MobileWA />
    </div>
  );
}

// ============================================================
// MOBILE SERTIFIKAT (search + list as cards)
// ============================================================
function MobileSertifikat() {
  return (
    <div style={{
      background: T10.cream, fontFamily: '"Plus Jakarta Sans", sans-serif',
      color: T10.ink, minHeight: 1500, position: 'relative',
    }}>
      <MobileHeader />
      <section style={{
        background: `linear-gradient(180deg, rgba(10,37,71,.85), rgba(6,23,46,.92)), url('assets/hero-sertifikat.jpg')`,
        backgroundSize: 'cover', backgroundPosition: 'center', color: '#fff',
        padding: '32px 20px 36px',
      }}>
        <span style={{
          display: 'inline-flex', alignItems: 'center', gap: 8, height: 26, padding: '0 10px',
          borderRadius: 999, background: 'rgba(255,255,255,.08)', border: '1px solid rgba(255,255,255,.18)',
          fontSize: 10, fontWeight: 700, letterSpacing: '0.06em', textTransform: 'uppercase',
        }}>
          Transparansi · 20 Penerima
        </span>
        <h1 style={{
          fontSize: 30, lineHeight: 1.05, letterSpacing: '-0.03em', fontWeight: 800,
          color: '#fff', margin: '16px 0 12px',
        }}>
          Daftar Penerima Sertifikat
        </h1>
        <p style={{ color: 'rgba(255,255,255,.78)', fontSize: 13.5, lineHeight: 1.55, margin: 0 }}>
          Verifikasi pemegang sertifikat kompetensi LSP Edukia.
        </p>
      </section>

      {/* Search */}
      <div style={{ padding: '20px 20px 0' }}>
        <div style={{
          display: 'flex', alignItems: 'center', gap: 10, background: '#fff',
          border: `1px solid ${T10.line2}`, borderRadius: 12, padding: '4px 4px 4px 14px', height: 48,
        }}>
          <window.Icon name="dot" size={14} color={T10.muted} />
          <span style={{ color: T10.muted, fontSize: 13, flex: 1 }}>Cari nama atau nomor sertifikat…</span>
          <button style={{
            background: T10.navy800, color: '#fff', border: 0, height: 36, padding: '0 16px',
            borderRadius: 999, fontWeight: 700, fontSize: 12.5,
          }}>Cari</button>
        </div>
      </div>

      {/* Stats compact */}
      <div style={{ padding: '16px 20px 0', display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 10 }}>
        {[
          { v: '20', l: 'Total sertifikat', accent: T10.navy800 },
          { v: '18', l: 'Aktif', accent: T10.greenOk },
        ].map((s, i) => (
          <div key={i} style={{
            background: '#fff', border: `1px solid ${T10.line}`, borderRadius: 12, padding: '12px 14px',
            position: 'relative', overflow: 'hidden',
          }}>
            <div style={{ position: 'absolute', left: 0, top: 12, bottom: 12, width: 3, background: s.accent }} />
            <div style={{ fontSize: 22, fontWeight: 800, color: T10.ink, lineHeight: 1, letterSpacing: '-0.02em' }}>{s.v}</div>
            <div style={{ fontSize: 11.5, color: T10.muted, marginTop: 4 }}>{s.l}</div>
          </div>
        ))}
      </div>

      {/* Card list */}
      <div style={{ padding: '20px', display: 'flex', flexDirection: 'column', gap: 10 }}>
        {window.LSP_CERTIFICATES.slice(0, 5).map((c, idx) => {
          const cat = CATS_MOB[c.cat];
          const isExp = c.status === 'expiring';
          return (
            <article key={c.no} style={{
              background: '#fff', border: `1px solid ${T10.line}`, borderRadius: 12,
              padding: 14, position: 'relative', overflow: 'hidden',
            }}>
              <div style={{ position: 'absolute', left: 0, top: 0, bottom: 0, width: 3, background: cat.color }} />
              <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', gap: 10 }}>
                <div style={{ flex: 1 }}>
                  <div style={{ fontSize: 14.5, fontWeight: 700, color: T10.ink, lineHeight: 1.25 }}>
                    {c.name}
                  </div>
                  <div style={{ fontSize: 12.5, color: T10.ink2, lineHeight: 1.4, marginTop: 4 }}>
                    {c.skema}
                  </div>
                </div>
                <span style={{
                  display: 'inline-flex', alignItems: 'center', gap: 4, padding: '4px 9px', borderRadius: 999,
                  fontSize: 10.5, fontWeight: 700,
                  background: isExp ? '#fef3c7' : '#dcfce7',
                  color: isExp ? '#92400e' : '#15803d',
                  flex: '0 0 auto',
                }}>
                  <span style={{ width: 5, height: 5, borderRadius: '50%',
                                 background: isExp ? '#d97706' : '#16a34a' }} />
                  {isExp ? 'Akan kadaluarsa' : 'Aktif'}
                </span>
              </div>
              <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: 12,
                            paddingTop: 10, borderTop: `1px dashed ${T10.line2}`,
                            fontSize: 11, color: T10.muted, fontFamily: 'ui-monospace, monospace' }}>
                <span style={{ color: T10.navy800, fontWeight: 600 }}>{c.no}</span>
                <span>{c.date}</span>
              </div>
            </article>
          );
        })}
      </div>

      <MobileWA />
    </div>
  );
}

// ============================================================
// MOBILE TENTANG KAMI
// ============================================================
function MobileTentang() {
  return (
    <div style={{
      background: T10.cream, fontFamily: '"Plus Jakarta Sans", sans-serif',
      color: T10.ink, minHeight: 1500, position: 'relative',
    }}>
      <MobileHeader />
      <section style={{
        background: `linear-gradient(180deg, rgba(10,37,71,.85), rgba(6,23,46,.92)), url('assets/hero-tentang.jpg')`,
        backgroundSize: 'cover', backgroundPosition: 'center', color: '#fff',
        padding: '32px 20px 36px',
      }}>
        <span style={{
          display: 'inline-flex', alignItems: 'center', gap: 8, height: 26, padding: '0 10px',
          borderRadius: 999, background: 'rgba(255,255,255,.08)', border: '1px solid rgba(255,255,255,.18)',
          fontSize: 10, fontWeight: 700, letterSpacing: '0.06em', textTransform: 'uppercase',
        }}>
          PM.SM.01 Rev. 3
        </span>
        <h1 style={{
          fontSize: 32, lineHeight: 1.05, letterSpacing: '-0.03em', fontWeight: 800,
          color: '#fff', margin: '16px 0 12px',
        }}>
          Tentang <em style={{ fontFamily: '"Fraunces", serif', fontStyle: 'italic',
                               fontWeight: 500, color: T10.blue }}>Kami</em>
        </h1>
        <p style={{ color: 'rgba(255,255,255,.78)', fontSize: 14, lineHeight: 1.55, margin: 0 }}>
          Profil, visi, misi, dan komitmen manajemen LSP Edukia.
        </p>
      </section>

      {/* Profil card */}
      <section style={{ padding: '32px 20px' }}>
        <div style={{
          background: `linear-gradient(135deg, ${T10.navy800}, ${T10.navy700} 60%, ${T10.navy900})`,
          borderRadius: 20, padding: 24, color: '#fff', position: 'relative', overflow: 'hidden',
        }}>
          <div style={{ position: 'absolute', right: -40, top: -40, width: 140, height: 140, borderRadius: '50%',
                        background: 'radial-gradient(circle, rgba(68,159,229,.2), transparent 70%)' }} />
          <div style={{ position: 'relative' }}>
            <div style={{ color: T10.orange, fontSize: 10.5, fontWeight: 700, letterSpacing: '0.14em',
                          textTransform: 'uppercase', marginBottom: 10 }}>
              LSP Edukasi Global Cendekia
            </div>
            <h3 style={{ color: '#fff', fontSize: 22, lineHeight: 1.2, margin: '0 0 16px', fontWeight: 700 }}>
              Mengakreditasi kompetensi, meningkatkan daya saing SDM Indonesia
            </h3>
            <p style={{ color: 'rgba(255,255,255,.82)', fontSize: 13.5, lineHeight: 1.75, margin: 0 }}>
              LSP Edukia memperoleh lisensi dari <strong style={{ color: '#fff' }}>KAN</strong>,
              mengacu pada ISO 17024 untuk prosedur sertifikasi yang konsisten dan profesional.
            </p>
          </div>
        </div>
      </section>

      {/* Komitmen cards stacked */}
      <section style={{ padding: '8px 20px 40px' }}>
        <div style={{ fontSize: 10, fontWeight: 800, letterSpacing: '0.18em', textTransform: 'uppercase',
                      color: T10.orangeDeep, marginBottom: 8 }}>
          Komitmen Manajemen
        </div>
        <h2 style={{ fontSize: 24, fontWeight: 800, color: T10.ink, margin: '0 0 18px',
                     letterSpacing: '-0.02em', lineHeight: 1.15 }}>
          Visi, misi & nilai organisasi
        </h2>
        <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
          {[
            { label: 'Visi', icon: 'compass', color: T10.navy700, body: 'Menjadi penyedia jasa sertifikasi person terbaik di Indonesia pada 2045.' },
            { label: 'Misi', icon: 'award', color: '#0f7a4e', body: 'Mengembangkan 5 misi strategis untuk SDM unggul nasional & internasional.', count: 5 },
            { label: 'Nilai', icon: 'shield', color: '#6d28d9', body: 'Profesionalisme, kerjasama, inovasi, peningkatan berkelanjutan, integritas.' },
            { label: 'Kebijakan Mutu', icon: 'check-list', color: '#0369a1', body: 'Sesuai panduan KAN K.09 dan SNI LSP-033-IDN, profesional dan konsisten.' },
          ].map((k, i) => (
            <article key={i} style={{
              background: '#fff', border: `1px solid ${T10.line}`, borderRadius: 14, overflow: 'hidden',
            }}>
              <div style={{ padding: '12px 16px', background: k.color, display: 'flex',
                            alignItems: 'center', gap: 10 }}>
                <div style={{ width: 28, height: 28, borderRadius: 8, background: 'rgba(255,255,255,.15)',
                              color: '#fff', display: 'grid', placeItems: 'center' }}>
                  <window.Icon name={k.icon} size={16} />
                </div>
                <h3 style={{ color: '#fff', fontSize: 13, letterSpacing: '0.06em',
                             textTransform: 'uppercase', fontWeight: 700, margin: 0 }}>{k.label}</h3>
                {k.count && (
                  <span style={{ marginLeft: 'auto', background: 'rgba(255,255,255,.15)',
                                 color: '#fff', padding: '2px 8px', borderRadius: 999,
                                 fontSize: 11, fontWeight: 700 }}>{k.count} poin</span>
                )}
              </div>
              <div style={{ padding: '16px 18px' }}>
                <p style={{ fontSize: 13.5, color: T10.ink2, lineHeight: 1.55, margin: 0 }}>{k.body}</p>
              </div>
            </article>
          ))}
        </div>
      </section>

      <MobileWA />
    </div>
  );
}

Object.assign(window, { MobileHome, MobileSkema, MobileSertifikat, MobileTentang });
