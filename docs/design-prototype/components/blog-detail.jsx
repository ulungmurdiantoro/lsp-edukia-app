/* global React */
const T9 = window.LSP_TOKENS;

// ============================================================
// BLOG DETAIL — Article reader page
// ============================================================
function PageBlogDetail() {
  return (
    <div style={{ background: T9.cream, fontFamily: '"Plus Jakarta Sans", sans-serif', color: T9.ink }}>
      <window.Header active="blog" variant="b" />

      {/* Article hero */}
      <article>
        <header style={{ background: '#fff', borderBottom: `1px solid ${T9.line}`, padding: '40px 0 56px' }}>
          <window.Wrap>
            {/* Breadcrumb */}
            <div style={{ fontSize: 13, color: T9.muted, marginBottom: 28, display: 'flex', alignItems: 'center', gap: 6 }}>
              <a href="#" style={{ color: T9.muted, textDecoration: 'none' }}>Blog</a>
              <window.Icon name="chev-r" size={12} color={T9.muted} />
              <a href="#" style={{ color: T9.muted, textDecoration: 'none' }}>Tips Sertifikasi</a>
            </div>

            <div style={{ maxWidth: 820 }}>
              {/* Category */}
              <span style={{
                display: 'inline-flex', alignItems: 'center', gap: 6,
                padding: '5px 11px', borderRadius: 999, fontSize: 11.5, fontWeight: 700,
                background: T9.orange50, color: T9.orangeDeep, letterSpacing: '0.04em',
                textTransform: 'uppercase', marginBottom: 22,
              }}>
                <window.Icon name="dot" size={6} color={T9.orange} />
                Tips Sertifikasi
              </span>

              <h1 style={{
                fontSize: 'clamp(34px, 4.5vw, 56px)', lineHeight: 1.08, letterSpacing: '-0.03em',
                fontWeight: 800, color: T9.ink, margin: '0 0 24px', textWrap: 'balance',
              }}>
                Persiapan asesmen ISO/IEC 17025: 5 dokumen krusial yang sering terlewat
              </h1>
              <p style={{ fontSize: 19, color: T9.ink2, lineHeight: 1.55, margin: 0, maxWidth: '64ch' }}>
                Panduan praktis menyiapkan pra-asesmen laboratorium berbasis ISO/IEC 17025:2017,
                berdasarkan pengalaman 200+ asesmen yang dilakukan tim LSP Edukia sejak 2024.
              </p>

              {/* Meta */}
              <div style={{
                display: 'flex', alignItems: 'center', gap: 20, marginTop: 32, paddingTop: 22,
                borderTop: `1px solid ${T9.line}`, fontSize: 13.5, color: T9.muted,
              }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: 10 }}>
                  <div style={{
                    width: 36, height: 36, borderRadius: '50%',
                    background: `linear-gradient(135deg, ${T9.navy800}, ${T9.navy600})`,
                    color: '#fff', display: 'grid', placeItems: 'center', fontWeight: 800, fontSize: 14,
                  }}>TL</div>
                  <div>
                    <div style={{ color: T9.ink, fontWeight: 700, fontSize: 14 }}>Tim LSP Edukia</div>
                    <div style={{ fontSize: 12.5 }}>Editorial Team</div>
                  </div>
                </div>
                <span style={{ width: 1, height: 24, background: T9.line2 }} />
                <span>15 Mei 2026</span>
                <span style={{ width: 1, height: 24, background: T9.line2 }} />
                <span>8 menit baca</span>
                <span style={{ flex: 1 }} />
                <button style={{
                  background: '#fff', border: `1px solid ${T9.line2}`, height: 38, padding: '0 16px',
                  borderRadius: 999, fontWeight: 600, fontSize: 13, color: T9.ink2, cursor: 'pointer',
                  display: 'inline-flex', alignItems: 'center', gap: 6, fontFamily: 'inherit',
                }}>
                  <window.Icon name="check-list" size={14} /> Simpan
                </button>
                <button style={{
                  background: T9.navy800, color: '#fff', border: 0, height: 38, padding: '0 18px',
                  borderRadius: 999, fontWeight: 700, fontSize: 13, cursor: 'pointer',
                  display: 'inline-flex', alignItems: 'center', gap: 6, fontFamily: 'inherit',
                }}>
                  Bagikan <window.Icon name="arrow-r" size={12} />
                </button>
              </div>
            </div>
          </window.Wrap>
        </header>

        {/* Hero image */}
        <window.Wrap style={{ padding: '0 32px' }}>
          <div style={{
            marginTop: -28, aspectRatio: '21/9', overflow: 'hidden',
            borderRadius: 18, border: `1px solid ${T9.line}`,
          }}>
            <img src="assets/kegiatan-3.jpg" alt="ISO 17025 asesmen"
                 style={{ width: '100%', height: '100%', objectFit: 'cover', display: 'block' }} />
          </div>
        </window.Wrap>

        {/* Article body */}
        <window.Wrap style={{ padding: '64px 32px' }}>
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 220px', gap: 64, alignItems: 'flex-start' }}>
            <div style={{ maxWidth: 720, fontSize: 17, lineHeight: 1.75, color: T9.ink2 }}>
              <p style={{ margin: '0 0 22px', fontSize: 19, lineHeight: 1.7, fontWeight: 500, color: T9.ink }}>
                Banyak laboratorium yang sudah lama beroperasi tetap kesulitan ketika pertama kali menghadapi asesmen ISO/IEC 17025. Bukan karena standar yang berubah — tapi karena lima jenis dokumen ini sering luput dari perhatian.
              </p>

              <h2 style={{ fontSize: 28, fontWeight: 700, color: T9.ink, margin: '40px 0 16px',
                          letterSpacing: '-0.02em', lineHeight: 1.2 }}>
                1. Bukti kompetensi personil — lebih dari sekadar CV
              </h2>
              <p style={{ margin: '0 0 18px' }}>
                Klausul 6.2 ISO/IEC 17025:2017 mensyaratkan rekaman kompetensi personil yang mencakup
                pendidikan, pelatihan, pengalaman, dan keterampilan teknis. Banyak laboratorium hanya
                menyiapkan CV — padahal asesor mencari <em>bukti</em> yang dapat diverifikasi.
              </p>
              <p style={{ margin: '0 0 18px' }}>
                Yang sering terlewat: rekaman observasi kerja periodik, hasil uji banding antar
                analis, dan dokumentasi otorisasi resmi yang menyatakan personil tertentu boleh
                melakukan pengujian spesifik.
              </p>

              <blockquote style={{
                margin: '28px 0', padding: '20px 24px', background: T9.cream,
                borderLeft: `4px solid ${T9.orange}`, borderRadius: '0 12px 12px 0',
                fontSize: 18, fontStyle: 'italic', color: T9.navy800, fontFamily: '"Fraunces", serif',
                fontWeight: 400, lineHeight: 1.5,
              }}>
                "Asesor tidak hanya melihat sertifikat pelatihan — mereka mencari bukti bahwa
                pelatihan itu diterapkan dan dievaluasi secara berkala."
              </blockquote>

              <h2 style={{ fontSize: 28, fontWeight: 700, color: T9.ink, margin: '40px 0 16px',
                          letterSpacing: '-0.02em', lineHeight: 1.2 }}>
                2. Catatan kondisi lingkungan (klausul 6.3)
              </h2>
              <p style={{ margin: '0 0 18px' }}>
                Rekaman suhu, kelembapan, dan kondisi lingkungan ruang uji harus tersedia secara
                kontinyu — bukan hanya snapshot saat akreditasi. Laboratorium yang mencatat secara
                manual sering kehilangan data ketika pencatatan harian terputus.
              </p>

              <h2 style={{ fontSize: 28, fontWeight: 700, color: T9.ink, margin: '40px 0 16px',
                          letterSpacing: '-0.02em', lineHeight: 1.2 }}>
                3. Verifikasi peralatan vs kalibrasi — dua hal berbeda
              </h2>
              <p style={{ margin: '0 0 18px' }}>
                Banyak laboratorium yang hanya menyiapkan sertifikat kalibrasi eksternal. Padahal
                klausul 6.4 mensyaratkan dua hal: kalibrasi (dari lembaga terakreditasi) dan
                verifikasi (dilakukan internal sebelum penggunaan). Keduanya harus terdokumentasi.
              </p>

              <h2 style={{ fontSize: 28, fontWeight: 700, color: T9.ink, margin: '40px 0 16px',
                          letterSpacing: '-0.02em', lineHeight: 1.2 }}>
                4. Estimasi ketidakpastian pengukuran
              </h2>
              <p style={{ margin: '0 0 18px' }}>
                Dokumen estimasi ketidakpastian (uncertainty budget) harus tersedia untuk
                setiap metode pengujian — lengkap dengan sumber ketidakpastian dan kontribusinya.
                Ini area dengan tingkat kegagalan tertinggi pada asesmen pertama.
              </p>

              <h2 style={{ fontSize: 28, fontWeight: 700, color: T9.ink, margin: '40px 0 16px',
                          letterSpacing: '-0.02em', lineHeight: 1.2 }}>
                5. Catatan tindakan korektif dan analisis akar masalah
              </h2>
              <p style={{ margin: '0 0 18px' }}>
                Klausul 8.7 mensyaratkan tindakan korektif yang efektif. Banyak laboratorium hanya
                mendokumentasikan "perbaikan langsung" tanpa analisis akar masalah yang menyeluruh.
                Asesor mencari pola: apakah masalah yang sama berulang? Apa tindakan pencegahan?
              </p>

              {/* Callout box */}
              <div style={{
                margin: '32px 0', padding: 28, background: '#fff', border: `1px solid ${T9.line}`,
                borderRadius: 16, display: 'flex', gap: 18, alignItems: 'flex-start',
              }}>
                <div style={{
                  width: 48, height: 48, borderRadius: 12, background: T9.navy50, color: T9.navy700,
                  display: 'grid', placeItems: 'center', flex: '0 0 auto',
                }}>
                  <window.Icon name="award" size={24} />
                </div>
                <div>
                  <h4 style={{ fontSize: 17, fontWeight: 700, color: T9.ink, margin: '0 0 8px' }}>
                    Butuh asesmen ISO/IEC 17025?
                  </h4>
                  <p style={{ fontSize: 14, color: T9.muted, margin: '0 0 14px', lineHeight: 1.6 }}>
                    LSP Edukia menyediakan skema sertifikasi Auditor Internal Laboratorium ISO/IEC 17025
                    dan Lead Implementer untuk Anda yang ingin menyiapkan asesmen.
                  </p>
                  <window.Btn variant="navy" size="sm" iconR="arrow-r">Lihat skema Lab</window.Btn>
                </div>
              </div>

              <p style={{ margin: '0 0 18px' }}>
                Lima area ini bukan satu-satunya — tetapi merupakan lima yang paling sering
                dijumpai sebagai ketidaksesuaian pada asesmen pertama. Menyiapkan dokumen ini
                <strong style={{ color: T9.ink, fontWeight: 700 }}> 3-6 bulan sebelum asesmen </strong>
                memberikan ruang untuk perbaikan tanpa tekanan waktu.
              </p>

              {/* Tags */}
              <div style={{
                marginTop: 40, paddingTop: 28, borderTop: `1px solid ${T9.line}`,
                display: 'flex', flexWrap: 'wrap', gap: 8, alignItems: 'center',
              }}>
                <span style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.14em',
                              textTransform: 'uppercase', color: T9.muted, marginRight: 6 }}>Tags</span>
                {['ISO 17025', 'Laboratorium', 'Audit Internal', 'Asesmen', 'Tips Sertifikasi'].map(t => (
                  <span key={t} style={{
                    background: '#fff', border: `1px solid ${T9.line2}`, padding: '6px 12px',
                    borderRadius: 999, fontSize: 12.5, color: T9.ink2, fontWeight: 500,
                  }}>{t}</span>
                ))}
              </div>
            </div>

            {/* Sidebar — table of contents */}
            <aside style={{ position: 'sticky', top: 100 }}>
              <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.14em',
                            textTransform: 'uppercase', color: T9.muted, marginBottom: 14 }}>
                Daftar isi
              </div>
              <ol style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                           flexDirection: 'column', gap: 12, borderLeft: `2px solid ${T9.line}` }}>
                {[
                  ['1. Bukti kompetensi personil', true],
                  ['2. Catatan kondisi lingkungan', false],
                  ['3. Verifikasi peralatan vs kalibrasi', false],
                  ['4. Estimasi ketidakpastian', false],
                  ['5. Tindakan korektif & akar masalah', false],
                ].map(([t, active], i) => (
                  <li key={i} style={{
                    paddingLeft: 14, marginLeft: -2,
                    borderLeft: `2px solid ${active ? T9.orange : 'transparent'}`,
                  }}>
                    <a href="#" style={{
                      fontSize: 13, color: active ? T9.navy800 : T9.muted,
                      fontWeight: active ? 700 : 500, textDecoration: 'none', lineHeight: 1.4,
                    }}>{t}</a>
                  </li>
                ))}
              </ol>
            </aside>
          </div>
        </window.Wrap>

        {/* Related */}
        <section style={{ padding: '64px 0 96px', background: T9.paperOff, borderTop: `1px solid ${T9.line}` }}>
          <window.Wrap>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline', marginBottom: 28 }}>
              <h3 style={{ fontSize: 28, fontWeight: 700, color: T9.ink, margin: 0, letterSpacing: '-0.02em' }}>
                Artikel terkait
              </h3>
              <a href="#" style={{ fontSize: 13.5, color: T9.navy800, fontWeight: 700,
                                   textDecoration: 'none', display: 'inline-flex', alignItems: 'center', gap: 4 }}>
                Semua artikel <window.Icon name="arrow-r" size={14} />
              </a>
            </div>
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 24 }}>
              {[
                { img: 'assets/kegiatan-1.jpg', cat: 'Info Skema', title: '7 skema baru LSP Edukia 2026' },
                { img: 'assets/kegiatan-2.jpg', cat: 'Industri',   title: 'Lifting Engineer wajib bersertifikat?' },
                { img: 'assets/kegiatan-4.jpg', cat: 'Pelatihan',  title: 'Persiapan asesor kompetensi pemula' },
              ].map((p, i) => (
                <a key={i} href="#" style={{
                  background: '#fff', border: `1px solid ${T9.line}`, borderRadius: 16, overflow: 'hidden',
                  textDecoration: 'none', color: 'inherit',
                }}>
                  <div style={{ aspectRatio: '16/9', overflow: 'hidden' }}>
                    <img src={p.img} alt={p.title} style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                  </div>
                  <div style={{ padding: 22 }}>
                    <div style={{ fontSize: 11, fontWeight: 700, color: T9.blueDeep, letterSpacing: '0.1em',
                                  textTransform: 'uppercase', marginBottom: 8 }}>{p.cat}</div>
                    <h4 style={{ fontSize: 16, fontWeight: 700, color: T9.ink, margin: 0, lineHeight: 1.35 }}>
                      {p.title}
                    </h4>
                  </div>
                </a>
              ))}
            </div>
          </window.Wrap>
        </section>
      </article>

      <window.CtaBlock />
      <window.Footer />
    </div>
  );
}

Object.assign(window, { PageBlogDetail });
