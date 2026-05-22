/* global React */
const T8 = window.LSP_TOKENS;

// ============================================================
// INFORMASI PUBLIK — Full page (Variant B styling)
// Hak/Kewajiban · Proses Sertifikasi · Pembekuan timeline ·
// Resertifikasi · Keluhan & Banding
// ============================================================

function HakKewajibanSection() {
  return (
    <section style={{ padding: '96px 0', borderTop: `1px solid ${T8.line}`, background: '#fff' }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Bagian 4"
          title="Hak Pemohon & Kewajiban Pemegang Sertifikat"
          sub="LSP EDUKIA menjamin transparansi, kerahasiaan, dan keadilan dalam setiap proses sertifikasi."
        />
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
          {/* Hak */}
          <div style={{ background: '#fff', border: `1px solid ${T8.line}`, borderRadius: 16,
                        padding: 28, position: 'relative', overflow: 'hidden' }}>
            <div style={{ position: 'absolute', top: 0, left: 0, right: 0, height: 4,
                          background: `linear-gradient(90deg, ${T8.blueDeep}, ${T8.blue})` }} />
            <div style={{ display: 'flex', alignItems: 'center', gap: 14, marginBottom: 20 }}>
              <div style={{ width: 48, height: 48, borderRadius: 12, background: T8.blue50,
                            color: T8.blueDeep, display: 'grid', placeItems: 'center' }}>
                <window.Icon name="shield" size={24} />
              </div>
              <div>
                <h3 style={{ fontSize: 19, fontWeight: 700, color: T8.ink, margin: 0 }}>Hak Pemohon Sertifikasi</h3>
                <div style={{ fontSize: 13, color: T8.muted, marginTop: 3 }}>
                  Apa yang Anda dapatkan dari LSP EDUKIA
                </div>
              </div>
            </div>
            <ol style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                         flexDirection: 'column', gap: 12 }}>
              {[
                'Berhak mengikuti pra-asesmen dan asesmen dengan asesor yang ditugaskan LSP Edukia.',
                'Memperoleh penjelasan tentang proses sertifikasi sesuai dengan skema.',
                'Hak bertanya berkaitan dengan kompetensi.',
                'Hak banding atas keputusan sertifikasi.',
                'Hak menyampaikan keluhan terkait pelaksanaan proses sertifikasi.',
                'Jaminan kerahasiaan atas proses sertifikasi.',
                'Peserta kompeten memperoleh sertifikat kompetensi.',
                'Sertifikat menjadi alat bukti keahlian sesuai jenis skema.',
              ].map((t, i) => (
                <li key={i} style={{ display: 'grid', gridTemplateColumns: '26px 1fr', gap: 12,
                                     alignItems: 'flex-start', fontSize: 14, color: T8.ink2, lineHeight: 1.55 }}>
                  <span style={{
                    width: 24, height: 24, borderRadius: '50%', background: T8.blueDeep, color: '#fff',
                    fontSize: 11, fontWeight: 800, display: 'grid', placeItems: 'center', marginTop: 1, flex: '0 0 auto',
                  }}>{i + 1}</span>
                  <span>{t}</span>
                </li>
              ))}
            </ol>
          </div>

          {/* Kewajiban */}
          <div style={{ background: '#fff', border: `1px solid ${T8.line}`, borderRadius: 16,
                        padding: 28, position: 'relative', overflow: 'hidden' }}>
            <div style={{ position: 'absolute', top: 0, left: 0, right: 0, height: 4,
                          background: `linear-gradient(90deg, ${T8.orangeDeep}, ${T8.orange})` }} />
            <div style={{ display: 'flex', alignItems: 'center', gap: 14, marginBottom: 20 }}>
              <div style={{ width: 48, height: 48, borderRadius: 12, background: T8.orange50,
                            color: T8.orangeDeep, display: 'grid', placeItems: 'center' }}>
                <window.Icon name="check-list" size={24} />
              </div>
              <div>
                <h3 style={{ fontSize: 19, fontWeight: 700, color: T8.ink, margin: 0 }}>Kewajiban Pemegang Sertifikat</h3>
                <div style={{ fontSize: 13, color: T8.muted, marginTop: 3 }}>
                  Tanggung jawab Anda sebagai profesional bersertifikat
                </div>
              </div>
            </div>
            <ol style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                         flexDirection: 'column', gap: 12 }}>
              {[
                'Menjamin sertifikasi kompetensi tidak disalahgunakan.',
                'Menjamin terpeliharanya kompetensi sesuai sertifikat.',
                'Menjamin pertanyaan dan informasi yang diberikan terbaru, benar, dan dapat dipertanggungjawabkan.',
                'Menjamin mentaati peraturan sertifikat.',
              ].map((t, i) => (
                <li key={i} style={{ display: 'grid', gridTemplateColumns: '26px 1fr', gap: 12,
                                     alignItems: 'flex-start', fontSize: 14, color: T8.ink2, lineHeight: 1.55 }}>
                  <span style={{
                    width: 24, height: 24, borderRadius: '50%', background: T8.orange, color: '#fff',
                    fontSize: 11, fontWeight: 800, display: 'grid', placeItems: 'center', marginTop: 1, flex: '0 0 auto',
                  }}>{i + 1}</span>
                  <span>{t}</span>
                </li>
              ))}
            </ol>
            <div style={{
              marginTop: 20, padding: 16, background: '#fdf3ec', border: '1px solid #f3d0b0',
              borderRadius: 10, fontSize: 13.5, color: '#7d3e10', lineHeight: 1.55,
            }}>
              <strong style={{ display: 'block', marginBottom: 4, color: '#5a2c0c' }}>
                Pembekuan & pencabutan sertifikat
              </strong>
              Pelanggaran kewajiban → surat peringatan → pembekuan 3 bulan → pencabutan sertifikat.
            </div>
          </div>
        </div>
      </window.Wrap>
    </section>
  );
}

function ProsesSertifikasiSection() {
  const steps = [
    { alpha: 'a', title: 'Permohonan Sertifikasi', items: [
      'Calon peserta mengisi berkas FR.APL.01 dan FR.AK.01.',
      'Peserta menyatakan setuju memenuhi persyaratan & memberikan informasi yang diperlukan.',
      'LSP Edukia melakukan pengkajian terhadap permohonan asesmen.',
      'Peserta yang memenuhi syarat direkomendasikan untuk tindak lanjut asesmen.',
    ] },
    { alpha: 'b', title: 'Proses Pra Asesmen', items: [
      'Asesmen direncanakan untuk memastikan verifikasi objektif dan sistematis.',
      'LSP Edukia menugaskan asesor kompetensi.',
      'Asesor melakukan verifikasi perangkat & metode asesmen.',
      'Asesor menjelaskan dan menyepakati rencana asesmen dengan peserta.',
      'Pengkajian kecukupan bukti dari dokumen pendukung (APL 02).',
    ] },
    { alpha: 'c', title: 'Pelaksanaan Asesmen / Uji Kompetensi', items: [
      'Metode: ujian tertulis, lisan, keterampilan, atau metode lain yang andal.',
      'Bukti dievaluasi: Valid, Asli, Terkini, Memadai (VATM).',
      'Hasil: "Kompeten" atau "Belum Kompeten".',
      'Asesor menyampaikan rekaman hasil dan rekomendasi.',
    ] },
    { alpha: 'd', title: 'Keputusan Asesmen', items: [
      'LSP Edukia melakukan rapat verifikasi berkas dan menetapkan status kompetensi.',
      'Tim asesor membuat keputusan sertifikasi.',
      'Peserta tidak lulus dapat: menerima hasil · remedial · banding (FR.AK.04).',
      'Sertifikat disahkan Ketua LSP Edukia dengan masa berlaku 3 tahun.',
    ] },
  ];
  return (
    <section style={{ padding: '96px 0', borderTop: `1px solid ${T8.line}`, background: T8.cream }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Bagian 5"
          title="Proses Sertifikasi"
          sub="Empat tahap sertifikasi yang transparan, objektif, dan sesuai standar — dari permohonan hingga penerbitan sertifikat."
        />
        <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
          {steps.map((s, i) => (
            <article key={i} style={{
              background: '#fff', border: `1px solid ${T8.line}`, borderRadius: 16, overflow: 'hidden',
              display: 'grid', gridTemplateColumns: '280px 1fr', minHeight: 200,
            }}>
              <div style={{
                background: `linear-gradient(135deg, ${T8.navy800}, ${T8.navy700})`,
                padding: '28px 28px', color: '#fff', display: 'flex', flexDirection: 'column', justifyContent: 'space-between',
                position: 'relative', overflow: 'hidden',
              }}>
                <div style={{
                  position: 'absolute', bottom: -30, right: -30, width: 140, height: 140,
                  borderRadius: '50%', background: 'radial-gradient(circle, rgba(244,137,31,.18), transparent 70%)',
                }} />
                <div style={{ position: 'relative' }}>
                  <div style={{
                    width: 44, height: 44, borderRadius: '50%', background: T8.orange,
                    color: '#fff', fontSize: 20, fontWeight: 800, display: 'grid', placeItems: 'center',
                    textTransform: 'uppercase',
                  }}>{s.alpha}</div>
                </div>
                <div style={{ position: 'relative' }}>
                  <div style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.18em',
                                textTransform: 'uppercase', color: 'rgba(255,255,255,.55)', marginBottom: 6 }}>
                    Tahap {i + 1} dari 4
                  </div>
                  <h3 style={{ fontSize: 20, fontWeight: 700, color: '#fff', margin: 0, lineHeight: 1.25 }}>
                    {s.title}
                  </h3>
                </div>
              </div>
              <div style={{ padding: '28px 32px' }}>
                <ol style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                             flexDirection: 'column', gap: 10 }}>
                  {s.items.map((t, j) => (
                    <li key={j} style={{ display: 'grid', gridTemplateColumns: '22px 1fr', gap: 12,
                                         alignItems: 'flex-start', fontSize: 14.5, color: T8.ink2, lineHeight: 1.6 }}>
                      <span style={{
                        width: 20, height: 20, borderRadius: 6, background: T8.navy50, color: T8.navy700,
                        fontSize: 11, fontWeight: 700, display: 'grid', placeItems: 'center', marginTop: 2, flex: '0 0 auto',
                      }}>{j + 1}</span>
                      <span>{t}</span>
                    </li>
                  ))}
                </ol>
              </div>
            </article>
          ))}
        </div>
      </window.Wrap>
    </section>
  );
}

function PembekuanSection() {
  const tl = [
    { dot: T8.blue,    body: <><strong>Pembekuan dan pencabutan sertifikat</strong> dilakukan jika pemegang sertifikat melanggar kewajiban.</> },
    { dot: T8.blue,    body: <>LSP Edukia melakukan pembekuan dan pencabutan melalui <strong>tahap peringatan terlebih dahulu</strong>.</> },
    { dot: T8.greenOk, body: <>LSP Edukia menerbitkan <strong>surat pengaktifan kembali</strong> setelah tindakan perbaikan dalam <strong>1 bulan</strong>.</> },
    { dot: T8.orange,  body: <>LSP Edukia menerbitkan <strong>surat pembekuan</strong> jika tidak ada perbaikan. Periode: <strong>3 bulan</strong> — sertifikat tidak boleh digunakan.</> },
    { dot: T8.warn,    body: <>LSP Edukia menerbitkan <strong>surat pencabutan sertifikat</strong> jika perbaikan tidak sesuai. Pemegang harus mengembalikan sertifikat.</> },
  ];
  return (
    <section style={{ padding: '96px 0', borderTop: `1px solid ${T8.line}`, background: '#fff' }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Bagian 6"
          title="Pembekuan dan Pencabutan Sertifikat"
          sub="Mekanisme sanksi bertahap yang diterapkan apabila pemegang sertifikat melanggar kewajiban."
        />
        <div style={{ background: T8.cream, border: `1px solid ${T8.line}`, borderRadius: 16,
                      padding: '36px 40px' }}>
          <div style={{ display: 'flex', flexDirection: 'column', position: 'relative', paddingLeft: 36 }}>
            <div style={{ position: 'absolute', left: 10, top: 14, bottom: 14, width: 2, background: T8.line2 }} />
            {tl.map((t, i) => (
              <div key={i} style={{ position: 'relative', paddingBottom: i < tl.length - 1 ? 26 : 0 }}>
                <div style={{
                  position: 'absolute', left: -30, top: 4, width: 14, height: 14, borderRadius: '50%',
                  background: t.dot, border: `2px solid ${T8.cream}`,
                  boxShadow: `0 0 0 2px ${t.dot}`,
                }} />
                <p style={{ fontSize: 15, color: T8.ink2, lineHeight: 1.65, margin: 0 }}>{t.body}</p>
              </div>
            ))}
          </div>
        </div>
      </window.Wrap>
    </section>
  );
}

function ResertifikasiSection() {
  return (
    <section style={{ padding: '96px 0', borderTop: `1px solid ${T8.line}`, background: T8.cream }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Bagian 7"
          title="Proses Resertifikasi"
          sub="Pemegang sertifikat wajib mengajukan permohonan sertifikasi ulang minimal 2 bulan sebelum masa berlaku berakhir."
        />
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
          {[
            {
              title: 'Perpanjangan Sertifikat', icon: 'refresh', color: T8.blueDeep, colorBg: T8.blue50,
              forSchemes: ['Auditor Internal SPMI Terintegrasi ISO 21001:2018', 'Lead Auditor SPMI Terintegrasi ISO 21001:2018', 'Auditor Internal Standar Laboratorium ISO/IEC 17025'],
              note: { strong: 'Persyaratan Portofolio:', body: 'Auditor Internal — pengalaman audit min. 2 kali dalam 3 tahun. Lead Auditor — pengalaman sebagai Lead minimal 1 kali dalam 3 tahun. Jika tidak memenuhi, akan diberikan uji kompetensi kembali.' },
            },
            {
              title: 'Uji Kompetensi Kembali', icon: 'doc', color: T8.orangeDeep, colorBg: T8.orange50,
              forSchemes: ['Lead Implementer SPMI ISO 21001', 'ToT OBE', 'Implementer Tata Kelola PT', 'Lab ISO 17025', 'Lifting Engineer Medium/Heavy', '2D/3D Lifting Designer', 'Lab Quality / Food Safety / GLP / HSE / Operations', 'QMS ISO 9001 / QC / QA / R&D / Regulatory', 'Sustainability / ESG / EMS ISO 14001', 'Corporate Legal Officer'],
              note: { strong: 'Catatan:', body: 'Proses resertifikasi mengikuti prosedur yang sama dengan sertifikasi awal (klausul 5a–5d).' },
            },
          ].map((c, i) => (
            <article key={i} style={{
              background: '#fff', border: `1px solid ${T8.line}`, borderRadius: 16, padding: 28,
              display: 'flex', flexDirection: 'column',
            }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: 12, marginBottom: 18 }}>
                <div style={{ width: 44, height: 44, borderRadius: 12, background: c.colorBg,
                              color: c.color, display: 'grid', placeItems: 'center' }}>
                  <window.Icon name={c.icon} size={22} />
                </div>
                <h3 style={{ fontSize: 19, fontWeight: 700, color: T8.ink, margin: 0 }}>{c.title}</h3>
              </div>
              <div style={{ fontSize: 11.5, fontWeight: 700, letterSpacing: '0.12em',
                            textTransform: 'uppercase', color: T8.muted, marginBottom: 10 }}>
                Berlaku untuk
              </div>
              <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                           flexDirection: 'column', gap: 6, flex: 1 }}>
                {c.forSchemes.map((s, j) => (
                  <li key={j} style={{ display: 'flex', gap: 10, alignItems: 'flex-start',
                                       fontSize: 13.5, color: T8.ink2, lineHeight: 1.5 }}>
                    <span style={{ width: 5, height: 5, borderRadius: '50%', background: c.color,
                                   flex: '0 0 auto', marginTop: 8 }} />
                    <span>{s}</span>
                  </li>
                ))}
              </ul>
              <div style={{
                marginTop: 18, padding: 14, background: c.colorBg, borderRadius: 10,
                fontSize: 13, color: c.color, lineHeight: 1.55,
              }}>
                <strong style={{ display: 'block', marginBottom: 4 }}>{c.note.strong}</strong>
                {c.note.body}
              </div>
            </article>
          ))}
        </div>
      </window.Wrap>
    </section>
  );
}

function KeluhanBandingSection() {
  return (
    <section style={{ padding: '96px 0', borderTop: `1px solid ${T8.line}`, background: '#fff' }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Bagian 8"
          title="Penanganan Keluhan dan Banding"
          sub="LSP EDUKIA menjamin proses banding dilakukan secara objektif dan tidak memihak."
        />
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 18 }}>
          {[
            { num: 'i',   title: 'Hak Pengajuan Keluhan dan Banding',
              body: 'LSP Edukia memberikan kesempatan kepada asesi untuk mengajukan keluhan dan banding apabila proses sertifikasi dirasakan tidak sesuai SOP.',
              note: { warn: true, label: 'Batas waktu:', body: 'Maksimal 7 hari sejak keputusan sertifikasi ditetapkan.' } },
            { num: 'ii',  title: 'Formulir Keluhan dan Banding',
              body: 'Formulir yang digunakan:',
              list: ['Formulir keluhan asesmen: FR.AK.07', 'Formulir banding asesmen: FR.AK.04'],
              note: { info: true, label: 'Akses formulir:', body: 'Dapat diunduh melalui website LSP Edukia.' } },
            { num: 'iii', title: 'Proses Investigasi dan Keputusan',
              list: [
                'LSP Edukia membentuk tim investigasi dari personel yang tidak terlibat dengan subjek banding.',
                'Proses banding dilakukan secara objektif dan tidak memihak.',
                'Keputusan dituangkan dalam laporan selambat-lambatnya 14 hari kerja sejak permohonan.',
                'Keputusan banding bersifat mengikat kedua belah pihak.',
              ] },
          ].map((s, i) => (
            <article key={i} style={{
              background: '#fff', border: `1px solid ${T8.line}`, borderRadius: 16, overflow: 'hidden',
              display: 'flex', flexDirection: 'column',
            }}>
              <div style={{
                padding: '18px 22px', background: `linear-gradient(135deg, ${T8.navy800}, ${T8.navy700})`,
                display: 'flex', alignItems: 'center', gap: 12,
              }}>
                <div style={{
                  width: 32, height: 32, borderRadius: '50%', background: T8.blue, color: '#fff',
                  fontSize: 13, fontWeight: 800, display: 'grid', placeItems: 'center',
                  textTransform: 'uppercase', fontFamily: 'ui-monospace, monospace',
                }}>{s.num}</div>
                <h3 style={{ color: '#fff', fontSize: 15, fontWeight: 700, margin: 0, lineHeight: 1.3 }}>{s.title}</h3>
              </div>
              <div style={{ padding: '22px 24px', flex: 1, display: 'flex', flexDirection: 'column', gap: 14 }}>
                {s.body && <p style={{ fontSize: 14, color: T8.ink2, lineHeight: 1.6, margin: 0 }}>{s.body}</p>}
                {s.list && (
                  <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                               flexDirection: 'column', gap: 8 }}>
                    {s.list.map((t, j) => (
                      <li key={j} style={{ display: 'flex', gap: 10, alignItems: 'flex-start',
                                            fontSize: 13.5, color: T8.ink2, lineHeight: 1.55 }}>
                        <span style={{ color: T8.blueDeep, marginTop: 1, flex: '0 0 auto' }}>
                          <window.Icon name="check" size={14} stroke={2.5} />
                        </span>
                        <span>{t}</span>
                      </li>
                    ))}
                  </ul>
                )}
                {s.note && (
                  <div style={{
                    marginTop: 'auto', padding: 12,
                    background: s.note.warn ? '#fdf3ec' : T8.blue50,
                    border: `1px solid ${s.note.warn ? '#f3d0b0' : '#bfdbfe'}`, borderRadius: 8,
                    fontSize: 12.5, color: s.note.warn ? '#7d3e10' : '#1e40af', lineHeight: 1.5,
                  }}>
                    <strong style={{ display: 'block', marginBottom: 2 }}>{s.note.label}</strong>
                    {s.note.body}
                  </div>
                )}
              </div>
            </article>
          ))}
        </div>
      </window.Wrap>
    </section>
  );
}

// Full page composition
function PageInformasi() {
  return (
    <div style={{ background: T8.cream, fontFamily: '"Plus Jakarta Sans", sans-serif', color: T8.ink }}>
      <window.Header active="informasi" variant="b" />
      <window.PageHero
        variant="b" image="assets/hero-informasi.jpg"
        badge="DP.AK.05 Rev. 02 · Informasi Publik"
        title="Informasi Publik"
        italicWord="Publik"
        lead="Hak pemohon, kewajiban pemegang sertifikat, proses sertifikasi, pembekuan, resertifikasi, dan penanganan keluhan."
      />
      <HakKewajibanSection />
      <ProsesSertifikasiSection />
      <PembekuanSection />
      <ResertifikasiSection />
      <KeluhanBandingSection />
      <window.CtaBlock />
      <window.Footer />
    </div>
  );
}

Object.assign(window, { PageInformasi });
