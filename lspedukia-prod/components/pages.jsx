/* global React */
const T5 = window.LSP_TOKENS;

// ============================================================
// FOUNDATIONS — design tokens overview
// ============================================================
function Foundations() {
  return (
    <div style={{
      background: T5.cream, padding: '48px 56px', minHeight: '100%',
      fontFamily: '"Plus Jakarta Sans", sans-serif',
    }}>
      <div style={{ marginBottom: 32 }}>
        <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.2em',
                      textTransform: 'uppercase', color: T5.orangeDeep, marginBottom: 10 }}>
          Fondasi Visual
        </div>
        <h2 style={{ fontSize: 42, fontWeight: 800, color: T5.ink, margin: 0, letterSpacing: '-0.025em' }}>
          Brand foundations — preserved
        </h2>
        <p style={{ fontSize: 15, color: T5.muted, marginTop: 8, maxWidth: '60ch' }}>
          Warna, tipografi, dan token yang dipertahankan dari produksi. Kedua varian visual dibangun di atas fondasi ini.
        </p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: '1.4fr 1fr', gap: 32 }}>
        {/* Colors */}
        <div>
          <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.16em',
                        textTransform: 'uppercase', color: T5.muted, marginBottom: 14 }}>Palette Brand</div>

          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(6, 1fr)', gap: 0, marginBottom: 20,
                        borderRadius: 8, overflow: 'hidden', border: `1px solid ${T5.line}` }}>
            {[
              { v: T5.navy900, n: '900' },
              { v: T5.navy800, n: '800' },
              { v: T5.navy700, n: '700' },
              { v: T5.navy600, n: '600' },
              { v: T5.navy500, n: '500' },
              { v: T5.navy50,  n: '50', dark: true },
            ].map((s, i) => (
              <div key={i} style={{ background: s.v, aspectRatio: '1/1.1', padding: 12, position: 'relative' }}>
                <div style={{ position: 'absolute', bottom: 10, left: 12, fontSize: 11, fontWeight: 700,
                              color: s.dark ? T5.ink : '#fff', fontFamily: 'ui-monospace, monospace' }}>
                  Navy {s.n}
                </div>
              </div>
            ))}
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: 12 }}>
            {[
              { v: T5.orange, n: 'Orange', sub: 'CTA / accent' },
              { v: T5.blue, n: 'Blue', sub: 'Link / info' },
              { v: T5.cream, n: 'Cream', sub: 'Surface', dark: true },
            ].map((s, i) => (
              <div key={i} style={{ background: s.v, padding: '20px 18px', borderRadius: 12,
                                    border: `1px solid ${T5.line}`, height: 100, display: 'flex',
                                    flexDirection: 'column', justifyContent: 'flex-end' }}>
                <div style={{ fontSize: 15, fontWeight: 700, color: s.dark ? T5.ink : '#fff' }}>{s.n}</div>
                <div style={{ fontSize: 12, color: s.dark ? T5.muted : 'rgba(255,255,255,.7)', marginTop: 2 }}>{s.sub}</div>
              </div>
            ))}
          </div>
        </div>

        {/* Type */}
        <div>
          <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.16em',
                        textTransform: 'uppercase', color: T5.muted, marginBottom: 14 }}>Tipografi</div>

          <div style={{ background: '#fff', border: `1px solid ${T5.line}`, borderRadius: 12,
                        padding: 24, marginBottom: 12 }}>
            <div style={{ fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 400,
                          fontSize: 56, color: T5.navy800, lineHeight: 1, letterSpacing: '-0.04em' }}>
              Fraunces
            </div>
            <div style={{ fontSize: 12, color: T5.muted, marginTop: 8, fontFamily: 'ui-monospace, monospace' }}>
              Display italic · accent angka
            </div>
          </div>

          <div style={{ background: '#fff', border: `1px solid ${T5.line}`, borderRadius: 12, padding: 24 }}>
            <div style={{ fontWeight: 800, fontSize: 32, color: T5.ink, letterSpacing: '-0.025em', lineHeight: 1 }}>
              Plus Jakarta Sans
            </div>
            <div style={{ fontSize: 12, color: T5.muted, marginTop: 8, fontFamily: 'ui-monospace, monospace' }}>
              UI · heading · body · 400 / 600 / 700 / 800
            </div>
          </div>
        </div>
      </div>

      {/* Bottom strip — variant summaries */}
      <div style={{ marginTop: 36, display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
        <div style={{ background: '#fff', border: `1px solid ${T5.line}`, borderRadius: 12, padding: 24 }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: 10, marginBottom: 10 }}>
            <span style={{ width: 28, height: 28, borderRadius: 6, background: T5.navy800, color: '#fff',
                           display: 'grid', placeItems: 'center', fontWeight: 800, fontSize: 13 }}>A</span>
            <h3 style={{ fontSize: 17, fontWeight: 700, color: T5.ink, margin: 0 }}>Editorial Lembaga</h3>
          </div>
          <p style={{ fontSize: 13.5, color: T5.muted, lineHeight: 1.6, margin: 0 }}>
            Refined editorial — Fraunces italic display, hairline borders, banyak whitespace.
            Mono-navy + 1 aksen oranye. Cocok untuk audiens institusi & akademik.
          </p>
        </div>
        <div style={{ background: '#fff', border: `1px solid ${T5.line}`, borderRadius: 12, padding: 24 }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: 10, marginBottom: 10 }}>
            <span style={{ width: 28, height: 28, borderRadius: 6, background: T5.orange, color: '#fff',
                           display: 'grid', placeItems: 'center', fontWeight: 800, fontSize: 13 }}>B</span>
            <h3 style={{ fontSize: 17, fontWeight: 700, color: T5.ink, margin: 0 }}>Institutional Bold</h3>
          </div>
          <p style={{ fontSize: 13.5, color: T5.muted, lineHeight: 1.6, margin: 0 }}>
            Modern corporate — header navy gradient + ikon, kategori berwarna, checkmark, pil CTA.
            Lebih confident, visual rhythm yang jelas, cocok untuk audiens industri.
          </p>
        </div>
      </div>
    </div>
  );
}

// ============================================================
// SKEMA CARD COMPARISON — the featured pain-point artboard
// Shows: Before · A · B side by side with the same scheme
// ============================================================
function SkemaCardCompare() {
  const featured = window.LSP_SCHEMES[0]; // Auditor Internal SPMI
  return (
    <div style={{ padding: '40px 48px', background: T5.cream, minHeight: '100%',
                  fontFamily: '"Plus Jakarta Sans", sans-serif' }}>
      <div style={{ marginBottom: 28 }}>
        <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.2em',
                      textTransform: 'uppercase', color: T5.orangeDeep, marginBottom: 8 }}>
          Pain point · Redesign
        </div>
        <h2 style={{ fontSize: 36, fontWeight: 800, color: T5.ink, margin: 0, letterSpacing: '-0.025em' }}>
          Card Skema Kompetensi — sebelum & sesudah
        </h2>
        <p style={{ fontSize: 14.5, color: T5.muted, marginTop: 8, maxWidth: '68ch' }}>
          Tiga pendekatan card dengan data yang sama (Skema 01: Auditor Internal SPMI ISO 21001).
          Bandingkan struktur informasi, hierarki visual, dan call-to-action.
        </p>
      </div>
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 20, alignItems: 'stretch' }}>
        {[
          { label: 'BEFORE — Production', sub: 'Kondisi saat ini di lspedukia.id', accent: T5.muted, Comp: window.SkemaCardOrig },
          { label: 'VARIANT A — Editorial', sub: 'Refined · Fraunces · hairlines', accent: T5.navy800, Comp: window.SkemaCardA },
          { label: 'VARIANT B — Institutional', sub: 'Bold · navy header · check-list', accent: T5.orange, Comp: window.SkemaCardB },
        ].map(({ label, sub, accent, Comp }, i) => (
          <div key={i} style={{ display: 'flex', flexDirection: 'column' }}>
            <div style={{ fontSize: 10.5, fontWeight: 800, letterSpacing: '0.18em', textTransform: 'uppercase',
                          color: accent, marginBottom: 4, fontFamily: 'ui-monospace, monospace' }}>{label}</div>
            <div style={{ fontSize: 12, color: T5.muted, marginBottom: 14 }}>{sub}</div>
            <div style={{ flex: 1, display: 'flex' }}>
              <Comp scheme={featured} />
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

// ============================================================
// SKEMA CARDS GRID — A
// 6 cards in 3-column grid, real data variety
// ============================================================
function SkemaCardsGridA() {
  return (
    <div style={{ background: T5.cream, padding: 40, minHeight: '100%',
                  fontFamily: '"Plus Jakarta Sans", sans-serif' }}>
      <div style={{ marginBottom: 28 }}>
        <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.2em',
                      textTransform: 'uppercase', color: T5.orangeDeep, marginBottom: 8 }}>
          Variant A · Editorial
        </div>
        <h2 style={{ fontSize: 30, fontWeight: 800, color: T5.ink, margin: 0, letterSpacing: '-0.025em' }}>
          Skema kompetensi — grid view
        </h2>
      </div>
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 18 }}>
        {window.LSP_SCHEMES.slice(0, 6).map(s => <window.SkemaCardA key={s.no} scheme={s} />)}
      </div>
    </div>
  );
}

function SkemaCardsGridB() {
  return (
    <div style={{ background: T5.cream, padding: 40, minHeight: '100%',
                  fontFamily: '"Plus Jakarta Sans", sans-serif' }}>
      <div style={{ marginBottom: 28 }}>
        <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.2em',
                      textTransform: 'uppercase', color: T5.orangeDeep, marginBottom: 8 }}>
          Variant B · Institutional
        </div>
        <h2 style={{ fontSize: 30, fontWeight: 800, color: T5.ink, margin: 0, letterSpacing: '-0.025em' }}>
          Skema kompetensi — grid view
        </h2>
      </div>
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 18 }}>
        {window.LSP_SCHEMES.slice(0, 6).map(s => <window.SkemaCardB key={s.no} scheme={s} />)}
      </div>
    </div>
  );
}

// ============================================================
// HOME PAGE composition — full
// ============================================================
function PageHome({ variant = 'a' }) {
  const Hero = variant === 'a' ? window.HeroHomeA : window.HeroHomeB;
  const Alur = variant === 'a' ? window.AlurA : window.AlurB;
  const Kegiatan = variant === 'a' ? window.KegiatanA : window.KegiatanB;
  return (
    <div style={{ background: T5.cream, fontFamily: '"Plus Jakarta Sans", sans-serif', color: T5.ink }}>
      <window.Header active="home" variant={variant} />
      <Hero />
      <Alur />
      <window.SkemaSection variant={variant} sample={6} />
      <Kegiatan />
      <window.CtaBlock />
      <window.Footer />
    </div>
  );
}

// ============================================================
// SKEMA KOMPETENSI PAGE — full
// ============================================================
function PageSkema({ variant = 'a' }) {
  return (
    <div style={{ background: T5.cream, fontFamily: '"Plus Jakarta Sans", sans-serif', color: T5.ink }}>
      <window.Header active="skema" variant={variant} />
      <window.PageHero
        variant={variant} image="assets/hero-skema.jpg"
        badge="DP.AK.05 Rev. 02 · 26 Skema"
        title="Skema Kompetensi"
        italicWord="Kompetensi"
        lead="Rincian unit kompetensi lengkap pada seluruh 26 skema sertifikasi LSP Edukasi Global Cendekia — 7 kategori bidang keahlian."
      />
      <window.SkemaSection
        variant={variant}
        sample={6}
        eyebrow="Daftar Skema"
        title="Pilih bidang keahlian Anda"
        sub="Filter berdasarkan kategori untuk menemukan skema yang relevan dengan profesi atau industri Anda."
        bg={T5.cream}
      />
      <window.CtaBlock />
      <window.Footer />
    </div>
  );
}

// ============================================================
// TENTANG KAMI PAGE
// ============================================================
function PageTentang({ variant = 'a' }) {
  const Komitmen = variant === 'a' ? window.KomitmenA : window.KomitmenB;
  return (
    <div style={{ background: T5.cream, fontFamily: '"Plus Jakarta Sans", sans-serif', color: T5.ink }}>
      <window.Header active="tentang" variant={variant} />
      <window.PageHero
        variant={variant} image="assets/hero-tentang.jpg"
        badge="PM.SM.01 Rev. 3 · Panduan Mutu"
        title="Tentang Kami"
        italicWord="Kami"
        lead="Profil, visi, misi, komitmen manajemen, struktur organisasi, dan acuan normatif LSP Edukasi Global Cendekia."
      />
      <ProfilSection variant={variant} />
      <Komitmen />
      {variant === 'b' && window.StrukturOrganisasiSection && <window.StrukturOrganisasiSection />}
      <window.CtaBlock />
      <window.Footer />
    </div>
  );
}

// Profil — quick section under page hero
function ProfilSection({ variant }) {
  if (variant === 'a') {
    return (
      <section style={{ padding: '96px 0', background: T5.cream }}>
        <window.Wrap>
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1.4fr', gap: 80, alignItems: 'flex-start' }}>
            <div>
              <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.2em', textTransform: 'uppercase',
                            color: T5.orangeDeep, marginBottom: 16, fontFamily: 'ui-monospace, monospace' }}>
                § 01 · Profil Lembaga
              </div>
              <h2 style={{ fontSize: 'clamp(34px, 4vw, 48px)', lineHeight: 1.05, letterSpacing: '-0.03em',
                           fontWeight: 800, color: T5.ink, margin: 0, textWrap: 'balance' }}>
                Mengakreditasi kompetensi, meningkatkan <em style={{
                  fontFamily: '"Fraunces", serif', fontStyle: 'italic', fontWeight: 400, color: T5.orange,
                }}>daya saing</em> SDM Indonesia.
              </h2>
            </div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
              {[
                'Lembaga Sertifikasi Person merupakan lembaga yang bertanggung jawab melaksanakan sertifikasi kompetensi person yang memperoleh lisensi dari lembaga penjaminan mutu. LSP Edukasi Global Cendekia memperoleh lisensi dari Komite Akreditasi Nasional (KAN).',
                'Pelaksanaan sertifikasi kompetensi dilakukan oleh tim asesor yang terseleksi dari praktisi industri sektor jasa di bidang pendidikan dan pendidikan tinggi.',
                'Dalam melaksanakan tugas dan fungsinya, LSP Edukasi Global Cendekia mengacu pada Pedoman yang dikeluarkan KAN dan ISO 17024.',
              ].map((p, i) => (
                <p key={i} style={{ fontSize: 16, color: T5.ink2, lineHeight: 1.75, margin: 0,
                                    paddingBottom: 18, borderBottom: i < 2 ? `1px solid ${T5.line}` : 'none' }}>
                  {p}
                </p>
              ))}
            </div>
          </div>
        </window.Wrap>
      </section>
    );
  }
  // Variant B
  return (
    <section style={{ padding: '96px 0', background: T5.cream }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Profil Lembaga"
          title="LSP Edukasi Global Cendekia"
          sub="Lembaga Sertifikasi Person berlisensi KAN untuk bidang pendidikan tinggi, laboratorium, lifting engineering, dan industri."
        />
        <div style={{
          background: `linear-gradient(135deg, ${T5.navy800} 0%, ${T5.navy700} 60%, ${T5.navy900})`,
          borderRadius: 24, padding: 48, color: '#fff', position: 'relative', overflow: 'hidden',
        }}>
          <div style={{ position: 'absolute', right: -80, top: -80, width: 300, height: 300, borderRadius: '50%',
                        background: 'radial-gradient(circle, rgba(68,159,229,.25), transparent 70%)' }} />
          <div style={{ position: 'absolute', left: -60, bottom: -60, width: 240, height: 240, borderRadius: '50%',
                        background: 'radial-gradient(circle, rgba(244,137,31,.2), transparent 70%)' }} />
          <div style={{ position: 'relative', zIndex: 1, maxWidth: '76ch' }}>
            <h3 style={{ color: T5.orange, fontSize: 13, fontWeight: 700, letterSpacing: '0.14em',
                         textTransform: 'uppercase', margin: '0 0 14px' }}>
              LSP Edukasi Global Cendekia
            </h3>
            <h2 style={{ color: '#fff', fontSize: 28, lineHeight: 1.2, margin: '0 0 28px', fontWeight: 700 }}>
              Mengakreditasi Kompetensi, Meningkatkan Daya Saing SDM Indonesia
            </h2>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
              <p style={{ color: 'rgba(255,255,255,.82)', fontSize: 15, lineHeight: 1.75, margin: 0 }}>
                Lembaga Sertifikasi Person bertanggung jawab melaksanakan sertifikasi kompetensi person yang memperoleh lisensi dari lembaga penjaminan mutu.
                LSP Edukasi Global Cendekia memperoleh lisensi dari <strong style={{ color: '#fff' }}>Komite Akreditasi Nasional (KAN)</strong>.
              </p>
              <p style={{ color: 'rgba(255,255,255,.82)', fontSize: 15, lineHeight: 1.75, margin: 0 }}>
                Pelaksanaan sertifikasi dilakukan oleh tim asesor yang terseleksi dari praktisi industri sektor jasa di bidang pendidikan dan pendidikan tinggi, mengacu pada Pedoman KAN dan ISO 17024.
              </p>
            </div>
          </div>
        </div>
      </window.Wrap>
    </section>
  );
}

// ============================================================
// SERTIFIKAT page (full)
// ============================================================
function PageSertifikat({ variant = 'a' }) {
  const Body = variant === 'a' ? window.SertifikatA : window.SertifikatB;
  return (
    <div style={{ background: T5.cream, fontFamily: '"Plus Jakarta Sans", sans-serif', color: T5.ink }}>
      <window.Header active="sertifikat" variant={variant} />
      <window.PageHero
        variant={variant} image="assets/hero-sertifikat.jpg"
        badge="Transparansi & Akuntabilitas"
        title="Daftar Penerima Sertifikat"
        lead="Informasi pemegang sertifikat kompetensi yang diterbitkan oleh LSP Edukasi Global Cendekia."
      />
      <Body />
      <window.CtaBlock />
      <window.Footer />
    </div>
  );
}

// ============================================================
// BLOG page (full)
// ============================================================
function PageBlog({ variant = 'a' }) {
  const Body = variant === 'a' ? window.BlogA : window.BlogB;
  return (
    <div style={{ background: T5.cream, fontFamily: '"Plus Jakarta Sans", sans-serif', color: T5.ink }}>
      <window.Header active="blog" variant={variant} />
      <window.PageHero
        variant={variant} image="assets/hero-informasi.jpg"
        badge="Blog & Artikel"
        title="Artikel & informasi sertifikasi"
        italicWord="sertifikasi"
        lead="Tips sertifikasi, info skema terbaru, dan berita dari LSP Edukasi Global Cendekia."
      />
      <Body />
      <window.CtaBlock />
      <window.Footer />
    </div>
  );
}

Object.assign(window, {
  Foundations, SkemaCardCompare, SkemaCardsGridA, SkemaCardsGridB,
  PageHome, PageSkema, PageTentang, PageSertifikat, PageBlog,
});
