/* global React */
const T4 = window.LSP_TOKENS;
const SCHEMES = window.LSP_SCHEMES;

// ============================================================
// FILTER CATEGORIES (Skema page)
// ============================================================
const CHIP_CATS = [
  { id: 'all',       label: 'Semua',                count: 26 },
  { id: 'spmi',      label: 'SPMI ISO 21001',       count: 3  },
  { id: 'pt',        label: 'Perguruan Tinggi',     count: 2  },
  { id: 'lab17025',  label: 'Lab ISO 17025',        count: 2  },
  { id: 'lifting',   label: 'Lifting Engineering',  count: 4  },
  { id: 'labtest',   label: 'Lab & Pengujian',      count: 6  },
  { id: 'manajemen', label: 'Sistem Manajemen',     count: 8  },
];

// ============================================================
// SKEMA SECTION (used in home + skema page)
// ============================================================
function SkemaSection({ variant = 'a', sample = 6, title, eyebrow, sub, bg = T4.cream }) {
  const Card = variant === 'a' ? window.SkemaCardA : window.SkemaCardB;
  return (
    <section style={{ padding: '96px 0', background: bg, borderTop: `1px solid ${T4.line}` }}>
      <window.Wrap>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end', marginBottom: 36, gap: 32 }}>
          <window.SectionHead
            eyebrow={eyebrow || 'Skema Kompetensi'}
            title={title || 'Persyaratan dasar pemohon sertifikasi'}
            sub={sub || 'Persyaratan pendidikan, pengalaman, dan sertifikat pelatihan untuk setiap skema kompetensi.'}
          />
          <window.Btn variant="outline" iconR="arrow-r">Semua 26 skema</window.Btn>
        </div>
        <div style={{ marginBottom: 32 }}>
          <window.FilterChips items={CHIP_CATS} variant={variant} />
        </div>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 18 }}>
          {SCHEMES.slice(0, sample).map(s => <Card key={s.no} scheme={s} />)}
        </div>
      </window.Wrap>
    </section>
  );
}

// ============================================================
// KEGIATAN slider (3-up)
// ============================================================
const KEGIATAN_ITEMS = [
  { img: 'assets/kegiatan-1.jpg', date: '12 Mei 2026',   cat: 'PELATIHAN',  title: 'Workshop Asesor Kompetensi ISO 21001',     desc: 'Pelatihan internal asesor kompetensi batch Mei 2026 untuk skema SPMI.' },
  { img: 'assets/kegiatan-2.jpg', date: '28 April 2026', cat: 'ASESMEN',    title: 'Uji Kompetensi Lifting Engineer · Batch 4', desc: 'Asesmen daring untuk 24 peserta dari industri tambang dan EPC.' },
  { img: 'assets/kegiatan-3.jpg', date: '15 April 2026', cat: 'KERJA SAMA', title: 'Penandatanganan MoU dengan Universitas',    desc: 'Kerja sama sertifikasi mahasiswa Teknik dan SPMI Perguruan Tinggi.' },
  { img: 'assets/kegiatan-4.jpg', date: '02 April 2026', cat: 'PELATIHAN',  title: 'Lokakarya QMS ISO 9001 — Surabaya',         desc: 'Lokakarya implementasi ISO 9001:2015 untuk officer industri pangan.' },
];

function KegiatanA() {
  return (
    <section style={{ padding: '96px 0', borderTop: `1px solid ${T4.line}`, background: '#fff' }}>
      <window.Wrap>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end', marginBottom: 36, gap: 32 }}>
          <window.SectionHead
            eyebrow="Aktivitas Terkini"
            title="Dokumentasi pelatihan & asesmen"
            sub="Catatan kegiatan, pelatihan, dan asesmen yang dilaksanakan LSP Edukia."
          />
          <window.Btn variant="outline" iconR="arrow-r">Lihat semua</window.Btn>
        </div>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 24 }}>
          {KEGIATAN_ITEMS.slice(0, 3).map((k, i) => (
            <article key={i} style={{ display: 'flex', flexDirection: 'column', gap: 16, background: 'transparent' }}>
              <div style={{ aspectRatio: '4/3', overflow: 'hidden', background: T4.cream2 }}>
                <img src={k.img} alt={k.title} style={{ width: '100%', height: '100%', objectFit: 'cover', display: 'block' }} />
              </div>
              <div>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline',
                              fontSize: 11, fontWeight: 700, color: T4.muted, letterSpacing: '0.14em',
                              textTransform: 'uppercase', fontFamily: 'ui-monospace, monospace', marginBottom: 10 }}>
                  <span style={{ color: T4.orangeDeep }}>{k.cat}</span>
                  <span>{k.date}</span>
                </div>
                <h4 style={{ fontSize: 19, fontWeight: 700, color: T4.ink, margin: '0 0 8px',
                             letterSpacing: '-0.015em', lineHeight: 1.3, textWrap: 'balance' }}>{k.title}</h4>
                <p style={{ fontSize: 14, color: T4.muted, lineHeight: 1.6, margin: 0 }}>{k.desc}</p>
              </div>
            </article>
          ))}
        </div>
      </window.Wrap>
    </section>
  );
}

function KegiatanB() {
  return (
    <section style={{ padding: '96px 0', borderTop: `1px solid ${T4.line}`, background: '#fff' }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Aktivitas Terkini"
          title="Kegiatan & Dokumentasi LSP Edukia"
          sub="Dokumentasi pelatihan, asesmen, dan kegiatan sertifikasi terbaru."
        />
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 20 }}>
          {KEGIATAN_ITEMS.slice(0, 3).map((k, i) => (
            <article key={i} style={{
              background: '#fff', border: `1px solid ${T4.line}`, borderRadius: 16, overflow: 'hidden',
              transition: 'all .18s',
            }}>
              <div style={{ aspectRatio: '16/9', overflow: 'hidden', background: T4.navy50 }}>
                <img src={k.img} alt={k.title} style={{ width: '100%', height: '100%', objectFit: 'cover', display: 'block' }} />
              </div>
              <div style={{ padding: '18px 22px 22px' }}>
                <div style={{ fontSize: 11, fontWeight: 700, textTransform: 'uppercase',
                              letterSpacing: '0.1em', color: T4.blueDeep, marginBottom: 8 }}>
                  {k.date}
                </div>
                <h4 style={{ fontSize: 16, fontWeight: 700, color: T4.ink, margin: '0 0 8px', lineHeight: 1.35 }}>
                  {k.title}
                </h4>
                <p style={{ fontSize: 13.5, color: T4.muted, lineHeight: 1.55, margin: 0 }}>{k.desc}</p>
              </div>
            </article>
          ))}
        </div>
        <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', gap: 16, marginTop: 32 }}>
          <button style={{ width: 42, height: 42, borderRadius: '50%', border: `1px solid ${T4.line2}`,
                          background: '#fff', display: 'grid', placeItems: 'center', cursor: 'pointer' }}>
            <window.Icon name="arrow-l" size={16} />
          </button>
          <div style={{ display: 'flex', gap: 8 }}>
            {[0, 1, 2].map(i => (
              <span key={i} style={{ width: i === 0 ? 22 : 8, height: 8, borderRadius: i === 0 ? 4 : '50%',
                                     background: i === 0 ? T4.navy800 : T4.line2 }} />
            ))}
          </div>
          <button style={{ width: 42, height: 42, borderRadius: '50%', border: `1px solid ${T4.line2}`,
                          background: '#fff', display: 'grid', placeItems: 'center', cursor: 'pointer' }}>
            <window.Icon name="arrow-r" size={16} />
          </button>
        </div>
      </window.Wrap>
    </section>
  );
}

// ============================================================
// KOMITMEN (Tentang Kami — visi, misi, etc)
// ============================================================
const KOMITMEN_DATA = [
  { id: 'visi', label: 'Visi', icon: 'compass',
    body: 'Menjadi perusahaan penyedia jasa sertifikasi person terbaik di Indonesia pada tahun 2045 yang independen, berintegritas, mudah diakses dan berorientasi kepada pemerataan peningkatan mutu dan daya saing SDM di level nasional dan internasional.' },
  { id: 'nilai', label: 'Nilai', icon: 'shield',
    body: 'Membentuk budaya kerja internal yang berbasis profesionalisme, kerjasama, berorientasi pada inovasi dan peningkatan terus-menerus, serta menjunjung tinggi kode etik dan integritas.' },
  { id: 'misi', label: 'Misi', icon: 'award', full: true, listed: true,
    body: [
      'Mengembangkan skema sertifikasi strategis untuk penciptaan SDM unggul dan peningkatan budaya mutu organisasi pada level nasional dan internasional.',
      'Meningkatkan kompetensi tim internal guna memastikan kesesuaian skema sertifikasi terbaharukan dan daya saing SDM Indonesia.',
      'Meningkatkan jaringan, komunitas dan peluang kerjasama nasional dan internasional.',
      'Menerapkan teknologi informasi guna memberikan kemudahan akses pada masyarakat luas untuk meningkatkan kompetensinya.',
      'Memastikan kualitas pelayanan terbaik guna mencapai kompetensi SDM unggul dan kepuasan pelanggan.',
    ] },
  { id: 'tujuan', label: 'Tujuan', icon: 'sparkle', listed: true,
    body: [
      'Menerapkan sistem manajemen mutu dalam mengelola LSP Edukasi Global Cendekia.',
      'Menjamin kesesuaian kompetensi peserta asesmen yang memperoleh sertifikat dari LSP Edukasi Global Cendekia.',
    ] },
  { id: 'kebijakan', label: 'Kebijakan Mutu', icon: 'shield', listed: true,
    body: [
      'LSP Edukia berkomitmen menerapkan dan memelihara mutu sesuai panduan KAN K.09 dan SNI LSP-033-IDN.',
      'Seluruh personel berkomitmen menyelenggarakan uji kompetensi sertifikasi secara profesional.',
    ] },
];

// Variant A — Editorial document panels
function KomitmenA() {
  return (
    <section style={{ padding: '96px 0', background: T4.paperOff, borderTop: `1px solid ${T4.line}` }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Komitmen Manajemen"
          title="Visi, misi & nilai organisasi"
          sub="Fondasi dan arah strategis LSP Edukasi Global Cendekia dalam mewujudkan sumber daya manusia Indonesia yang kompeten."
        />
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
          {KOMITMEN_DATA.map((k, idx) => (
            <article key={k.id} style={{
              gridColumn: k.full ? '1 / -1' : 'auto',
              background: '#fff', border: `1px solid ${T4.line}`,
              padding: '32px 36px', display: 'flex', flexDirection: 'column', gap: 18,
              borderRadius: 4,
            }}>
              <div style={{ display: 'flex', alignItems: 'baseline', justifyContent: 'space-between',
                            fontSize: 11, letterSpacing: '0.2em', textTransform: 'uppercase',
                            fontWeight: 700, color: T4.muted, fontFamily: 'ui-monospace, monospace' }}>
                <span>§ {String(idx + 1).padStart(2, '0')} · {k.label}</span>
                <span style={{ color: T4.orangeDeep }}>PM.SM.01 Rev. 3</span>
              </div>
              <h3 style={{
                fontFamily: '"Fraunces", serif', fontWeight: 400, fontSize: 36, lineHeight: 1,
                letterSpacing: '-0.03em', color: T4.navy800, margin: 0, fontStyle: 'italic',
              }}>{k.label}</h3>
              {k.listed ? (
                <ol style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 0,
                             borderTop: `1px solid ${T4.line}` }}>
                  {k.body.map((b, i) => (
                    <li key={i} style={{ display: 'grid', gridTemplateColumns: '40px 1fr', gap: 16,
                                         padding: '16px 0', borderBottom: `1px solid ${T4.line}` }}>
                      <span style={{
                        fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 400,
                        fontSize: 22, color: T4.orangeDeep, lineHeight: 1,
                      }}>{String(i + 1).padStart(2, '0')}</span>
                      <span style={{ fontSize: 15, color: T4.ink2, lineHeight: 1.6 }}>{b}</span>
                    </li>
                  ))}
                </ol>
              ) : (
                <p style={{ fontSize: 15.5, color: T4.ink2, lineHeight: 1.75, margin: 0, textWrap: 'pretty' }}>{k.body}</p>
              )}
            </article>
          ))}
        </div>
      </window.Wrap>
    </section>
  );
}

// Variant B — Color-coded modern cards
function KomitmenB() {
  const colors = {
    visi:      { from: T4.navy800, to: T4.navy600 },
    misi:      { from: '#0d5c3a', to: '#0f7a4e' },
    nilai:     { from: '#6d28d9', to: '#8b5cf6' },
    tujuan:    { from: T4.orangeDeep, to: T4.orange },
    kebijakan: { from: '#0369a1', to: '#0ea5e9' },
  };
  return (
    <section style={{ padding: '96px 0', background: T4.paperOff, borderTop: `1px solid ${T4.line}` }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Komitmen Manajemen"
          title="Visi, misi & nilai organisasi"
          sub="Fondasi dan arah strategis LSP Edukasi Global Cendekia dalam mewujudkan sumber daya manusia Indonesia yang kompeten."
        />
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
          {KOMITMEN_DATA.map(k => {
            const c = colors[k.id] || colors.visi;
            return (
              <article key={k.id} style={{
                gridColumn: k.full ? '1 / -1' : 'auto',
                background: '#fff', border: `1px solid ${T4.line}`, borderRadius: 16, overflow: 'hidden',
              }}>
                <div style={{
                  padding: '14px 22px', display: 'flex', alignItems: 'center', gap: 12,
                  background: `linear-gradient(135deg, ${c.from}, ${c.to})`,
                }}>
                  <div style={{ width: 32, height: 32, borderRadius: 9, background: 'rgba(255,255,255,.12)',
                                color: '#fff', display: 'grid', placeItems: 'center' }}>
                    <window.Icon name={k.icon} size={18} />
                  </div>
                  <h3 style={{ fontSize: 15, letterSpacing: '0.05em', textTransform: 'uppercase',
                               color: '#fff', fontWeight: 700, margin: 0 }}>{k.label}</h3>
                </div>
                <div style={{ padding: '22px 26px' }}>
                  {k.listed ? (
                    <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                                 flexDirection: 'column', gap: 10 }}>
                      {k.body.map((b, i) => (
                        <li key={i} style={{ display: 'grid', gridTemplateColumns: '24px 1fr',
                                             gap: 12, alignItems: 'flex-start' }}>
                          <span style={{
                            width: 22, height: 22, borderRadius: '50%', fontSize: 11.5, fontWeight: 700,
                            display: 'grid', placeItems: 'center', background: c.from, color: '#fff',
                            marginTop: 1,
                          }}>{i + 1}</span>
                          <span style={{ fontSize: 14.5, color: T4.ink2, lineHeight: 1.6 }}>{b}</span>
                        </li>
                      ))}
                    </ul>
                  ) : (
                    <p style={{ fontSize: 14.5, color: T4.ink2, lineHeight: 1.7, margin: 0 }}>{k.body}</p>
                  )}
                </div>
              </article>
            );
          })}
        </div>
      </window.Wrap>
    </section>
  );
}

// ============================================================
// SERTIFIKAT PAGE (coming soon) — both variants
// ============================================================
function SertifikatA() {
  return (
    <section style={{ padding: '120px 0', background: T4.cream }}>
      <window.Wrap>
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1.4fr', gap: 80, alignItems: 'center' }}>
          <div style={{ position: 'relative' }}>
            {/* Certificate placeholder visual */}
            <div style={{
              aspectRatio: '5/7', background: '#fff', border: `1px solid ${T4.line}`,
              padding: 32, position: 'relative', boxShadow: '0 30px 60px rgba(15,29,53,.12)',
              transform: 'rotate(-2deg)',
            }}>
              <div style={{ borderTop: `3px solid ${T4.orange}`, paddingTop: 24 }}>
                <div style={{ fontSize: 9, fontWeight: 700, letterSpacing: '0.2em',
                              textTransform: 'uppercase', color: T4.muted, fontFamily: 'ui-monospace, monospace' }}>
                  No. EDUKIA-2026-04-001
                </div>
                <h4 style={{ fontFamily: '"Fraunces", serif', fontStyle: 'italic',
                             fontWeight: 400, fontSize: 32, color: T4.navy800,
                             margin: '14px 0 18px', letterSpacing: '-0.03em', lineHeight: 1 }}>
                  Certificate of Competence
                </h4>
                <div style={{ fontSize: 10, fontWeight: 700, letterSpacing: '0.15em',
                              color: T4.muted, textTransform: 'uppercase', marginBottom: 6 }}>Atas Nama</div>
                <div style={{ fontSize: 18, fontWeight: 700, color: T4.ink, marginBottom: 14 }}>—</div>
                <div style={{ fontSize: 10, fontWeight: 700, letterSpacing: '0.15em',
                              color: T4.muted, textTransform: 'uppercase', marginBottom: 6 }}>Skema</div>
                <div style={{ fontSize: 13, fontWeight: 600, color: T4.ink2, lineHeight: 1.4, marginBottom: 18 }}>—</div>
                <div style={{ display: 'flex', justifyContent: 'space-between', borderTop: `1px solid ${T4.line}`,
                              paddingTop: 14, fontSize: 9.5, color: T4.muted, fontFamily: 'ui-monospace, monospace' }}>
                  <span>BERLAKU 3 TAHUN</span>
                  <span>LSP-033-IDN</span>
                </div>
              </div>
            </div>
          </div>
          <div>
            <div style={{ display: 'flex', alignItems: 'center', gap: 14, fontSize: 11,
                          fontWeight: 700, letterSpacing: '0.2em', textTransform: 'uppercase',
                          color: T4.orangeDeep, marginBottom: 24, fontFamily: 'ui-monospace, monospace' }}>
              <span style={{ width: 28, height: 1, background: T4.orange }} />
              Transparansi & Akuntabilitas
            </div>
            <h2 style={{ fontSize: 'clamp(36px, 4vw, 56px)', lineHeight: 1.02,
                         letterSpacing: '-0.035em', fontWeight: 800, margin: 0, color: T4.ink, maxWidth: '14ch' }}>
              Daftar penerima sertifikat <em style={{
                fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 400, color: T4.orange,
              }}>sedang disiapkan</em>.
            </h2>
            <p style={{ fontSize: 17, color: T4.muted, lineHeight: 1.6, marginTop: 22, maxWidth: '54ch' }}>
              Halaman ini akan menampilkan informasi lengkap pemegang sertifikat kompetensi LSP Edukia — nama, skema, nomor sertifikat, dan status keberlakuan.
            </p>
            <div style={{ marginTop: 28, display: 'flex', gap: 32, paddingTop: 24, borderTop: `1px solid ${T4.line}` }}>
              {[
                { v: '26', l: 'Skema aktif' },
                { v: '3 thn', l: 'Masa berlaku' },
                { v: 'KAN', l: 'Lisensi resmi' },
              ].map((s, i) => (
                <div key={i}>
                  <div style={{ fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 400,
                                fontSize: 34, color: T4.navy800, letterSpacing: '-0.03em', lineHeight: 1 }}>{s.v}</div>
                  <div style={{ fontSize: 12.5, color: T4.muted, marginTop: 6, letterSpacing: '0.04em', textTransform: 'uppercase' }}>{s.l}</div>
                </div>
              ))}
            </div>
            <div style={{ marginTop: 36, display: 'flex', gap: 12 }}>
              <window.Btn variant="navy" size="lg" iconR="arrow-r">Verifikasi sertifikat</window.Btn>
              <window.Btn variant="outline" size="lg">Hubungi kami</window.Btn>
            </div>
          </div>
        </div>
      </window.Wrap>
    </section>
  );
}

function SertifikatB() {
  return (
    <section style={{ padding: '96px 0', background: T4.cream }}>
      <window.Wrap>
        <div style={{
          background: '#fff', border: `1px solid ${T4.line}`, borderRadius: 24,
          padding: '64px 56px', textAlign: 'center', maxWidth: 760, margin: '0 auto',
        }}>
          <div style={{
            width: 80, height: 80, borderRadius: 20, background: T4.navy50,
            display: 'grid', placeItems: 'center', margin: '0 auto 28px', color: T4.navy600,
          }}>
            <window.Icon name="cert" size={40} />
          </div>
          <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.18em', textTransform: 'uppercase',
                        color: T4.orangeDeep, marginBottom: 14 }}>
            Transparansi & Akuntabilitas
          </div>
          <h2 style={{ fontSize: 'clamp(28px, 3.5vw, 40px)', lineHeight: 1.08, letterSpacing: '-0.025em',
                       fontWeight: 700, color: T4.ink, margin: '0 0 18px' }}>
            Segera hadir
          </h2>
          <p style={{ fontSize: 16, color: T4.muted, lineHeight: 1.6, maxWidth: '52ch', margin: '0 auto 32px' }}>
            Data daftar penerima sertifikat sedang disiapkan. Halaman ini akan menampilkan nama pemegang sertifikat, skema, nomor sertifikat, dan masa berlaku.
          </p>
          {/* Mini search preview */}
          <div style={{
            background: T4.cream, border: `1px solid ${T4.line2}`, borderRadius: 999,
            padding: '6px 6px 6px 22px', display: 'flex', alignItems: 'center', gap: 14,
            maxWidth: 480, margin: '0 auto 28px',
          }}>
            <span style={{ fontSize: 14.5, color: T4.muted, flex: 1, textAlign: 'left' }}>
              Cari nomor sertifikat atau nama…
            </span>
            <button style={{ background: T4.navy800, color: '#fff', border: 0, height: 40,
                             padding: '0 22px', borderRadius: 999, fontWeight: 700, fontSize: 13.5, opacity: 0.4 }}>
              Cari
            </button>
          </div>
          <div style={{ fontSize: 13, color: T4.muted }}>
            atau <a href="#" style={{ color: T4.navy800, fontWeight: 600 }}>hubungi tim kami</a> via WhatsApp untuk verifikasi langsung.
          </div>
        </div>
      </window.Wrap>
    </section>
  );
}

// ============================================================
// BLOG GRID
// ============================================================
const BLOG_POSTS = [
  { img: 'assets/kegiatan-3.jpg', cat: 'Tips Sertifikasi',  title: 'Persiapan Asesmen ISO/IEC 17025: Checklist dokumen yang sering terlewat',
    excerpt: 'Lima dokumen krusial yang sering luput saat menyiapkan pra-asesmen Laboratorium ISO/IEC 17025:2017.',
    author: 'Tim LSP Edukia', date: '15 Mei 2026' },
  { img: 'assets/kegiatan-1.jpg', cat: 'Info Skema', title: '7 skema baru LSP Edukia: dari ESG Officer hingga Corporate Legal',
    excerpt: 'Kenali tujuh skema sertifikasi terbaru kami untuk mendukung profesional sustainability dan hukum korporasi.',
    author: 'Tim LSP Edukia', date: '02 Mei 2026' },
  { img: 'assets/kegiatan-2.jpg', cat: 'Industri', title: 'Mengapa Lifting Engineer wajib bersertifikat? Studi kasus 2025',
    excerpt: 'Insiden lifting di sektor migas turun signifikan setelah penerapan sertifikasi kompetensi wajib.',
    author: 'Tim LSP Edukia', date: '20 April 2026' },
];

function BlogA() {
  return (
    <section style={{ padding: '96px 0', background: T4.cream }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Blog & Artikel"
          title="Wawasan terbaru seputar sertifikasi"
          sub="Tips persiapan asesmen, ulasan skema, dan kabar terkini dari LSP Edukasi Global Cendekia."
        />
        <div style={{ display: 'grid', gridTemplateColumns: '1.4fr 1fr 1fr', gap: 28 }}>
          {/* Hero post — first */}
          {BLOG_POSTS.slice(0, 1).map((p, i) => (
            <article key={i} style={{ gridRow: 'span 2', display: 'flex', flexDirection: 'column', gap: 18 }}>
              <div style={{ aspectRatio: '4/3', overflow: 'hidden', background: T4.navy50, position: 'relative' }}>
                <img src={p.img} alt={p.title} style={{ width: '100%', height: '100%', objectFit: 'cover', display: 'block' }} />
                <div style={{ position: 'absolute', top: 20, left: 20,
                              background: '#fff', padding: '6px 12px', fontSize: 11, fontWeight: 700,
                              letterSpacing: '0.12em', textTransform: 'uppercase', color: T4.orangeDeep }}>
                  Featured · {p.cat}
                </div>
              </div>
              <div style={{ fontSize: 11.5, fontWeight: 600, color: T4.muted, letterSpacing: '0.14em',
                            textTransform: 'uppercase', fontFamily: 'ui-monospace, monospace' }}>
                {p.author} · {p.date}
              </div>
              <h3 style={{ fontSize: 32, fontWeight: 700, color: T4.ink, margin: 0,
                           letterSpacing: '-0.025em', lineHeight: 1.15, textWrap: 'balance' }}>
                {p.title}
              </h3>
              <p style={{ fontSize: 15.5, color: T4.muted, lineHeight: 1.65, margin: 0, maxWidth: '52ch' }}>
                {p.excerpt}
              </p>
              <a href="#" style={{
                fontSize: 13, fontWeight: 700, color: T4.navy800, textDecoration: 'none',
                display: 'inline-flex', alignItems: 'center', gap: 6, letterSpacing: '0.04em',
                textTransform: 'uppercase', borderBottom: `2px solid ${T4.orange}`, paddingBottom: 4,
                alignSelf: 'flex-start',
              }}>
                Baca selengkapnya <window.Icon name="arrow-r" size={14} />
              </a>
            </article>
          ))}
          {/* Side posts */}
          {BLOG_POSTS.slice(1).map((p, i) => (
            <article key={i} style={{ display: 'flex', flexDirection: 'column', gap: 14,
                                       borderTop: i > 0 ? `1px solid ${T4.line}` : 'none',
                                       paddingTop: i > 0 ? 0 : 0 }}>
              <div style={{ aspectRatio: '4/3', overflow: 'hidden', background: T4.navy50 }}>
                <img src={p.img} alt={p.title} style={{ width: '100%', height: '100%', objectFit: 'cover', display: 'block' }} />
              </div>
              <div style={{ fontSize: 11, fontWeight: 700, color: T4.orangeDeep, letterSpacing: '0.14em',
                            textTransform: 'uppercase', fontFamily: 'ui-monospace, monospace' }}>
                {p.cat}
              </div>
              <h4 style={{ fontSize: 18, fontWeight: 700, color: T4.ink, margin: 0,
                           letterSpacing: '-0.015em', lineHeight: 1.3, textWrap: 'balance' }}>
                {p.title}
              </h4>
              <div style={{ fontSize: 12, color: T4.muted, marginTop: 'auto' }}>
                {p.author} · {p.date}
              </div>
            </article>
          ))}
        </div>
      </window.Wrap>
    </section>
  );
}

function BlogB() {
  return (
    <section style={{ padding: '96px 0', background: T4.cream }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Blog & Artikel"
          title="Artikel & informasi sertifikasi"
          sub="Tips sertifikasi, info skema terbaru, dan berita dari LSP Edukasi Global Cendekia."
        />
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 24 }}>
          {BLOG_POSTS.map((p, i) => (
            <a key={i} href="#" style={{
              background: '#fff', border: `1px solid ${T4.line}`, borderRadius: 16, overflow: 'hidden',
              textDecoration: 'none', color: 'inherit', display: 'block',
            }}>
              <div style={{ aspectRatio: '16/9', overflow: 'hidden', background: T4.navy50 }}>
                <img src={p.img} alt={p.title} style={{ width: '100%', height: '100%', objectFit: 'cover', display: 'block' }} />
              </div>
              <div style={{ padding: 22 }}>
                <div style={{ fontSize: 11, fontWeight: 700, color: T4.blueDeep,
                              letterSpacing: '0.1em', textTransform: 'uppercase', marginBottom: 10 }}>{p.cat}</div>
                <h3 style={{ fontSize: 17, fontWeight: 700, color: T4.ink, margin: '0 0 10px', lineHeight: 1.35 }}>
                  {p.title}
                </h3>
                <p style={{ fontSize: 13.5, color: T4.muted, lineHeight: 1.6, margin: 0 }}>{p.excerpt}</p>
                <div style={{ fontSize: 12, color: T4.muted, marginTop: 16, paddingTop: 14, borderTop: `1px solid ${T4.line}` }}>
                  {p.author} · {p.date}
                </div>
              </div>
            </a>
          ))}
        </div>
      </window.Wrap>
    </section>
  );
}

Object.assign(window, {
  SkemaSection, KegiatanA, KegiatanB, KomitmenA, KomitmenB,
  SertifikatA, SertifikatB, BlogA, BlogB, CHIP_CATS,
});
