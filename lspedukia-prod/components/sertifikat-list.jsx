/* global React */
const T6 = window.LSP_TOKENS;
const CATS = window.LSP_CATS;

// ============================================================
// MOCK CERTIFICATE HOLDERS DATA
// ============================================================
window.LSP_CERTIFICATES = [
  { name: 'Dr. Ir. Bayu Setiawan, M.T.',    skema: 'Lead Auditor SPMI Terintegrasi ISO 21001:2018', cat: 'spmi',     no: 'EDUKIA-LAD-2026-018', date: '12 Mei 2026',   status: 'aktif' },
  { name: 'Sri Wahyuni Pratama, S.Si.',     skema: 'Laboratory Quality System Officer ISO/IEC 17025', cat: 'labtest', no: 'EDUKIA-LQO-2026-017', date: '08 Mei 2026',   status: 'aktif' },
  { name: 'Ahmad Fauzi Rahmadhan, S.T.',    skema: 'Lifting Engineer for Medium Lifting',           cat: 'lifting',  no: 'EDUKIA-LFE-2026-016', date: '02 Mei 2026',   status: 'aktif' },
  { name: 'Prof. Dr. Indira Permatasari',   skema: 'Auditor Internal SPMI Terintegrasi ISO 21001:2018', cat: 'spmi',  no: 'EDUKIA-AIL-2026-015', date: '28 April 2026', status: 'aktif' },
  { name: 'Rizki Hermawan, S.T., M.Eng.',   skema: '3D Lifting Designer',                           cat: 'lifting',  no: 'EDUKIA-DLD-2026-014', date: '24 April 2026', status: 'aktif' },
  { name: 'Maharani Aulia Putri, S.Si.',    skema: 'Food Safety Management Officer',                cat: 'labtest',  no: 'EDUKIA-FMO-2026-013', date: '20 April 2026', status: 'aktif' },
  { name: 'Hendra Wijaya, S.H., M.H.',      skema: 'Corporate Legal Officer',                       cat: 'hukum',    no: 'EDUKIA-CLO-2026-012', date: '15 April 2026', status: 'aktif' },
  { name: 'Dewi Lestari Anggraini, S.T.',   skema: 'Quality Management System (ISO 9001) Officer',  cat: 'manajemen',no: 'EDUKIA-QMS-2026-011', date: '10 April 2026', status: 'aktif' },
  { name: 'Bambang Sutrisno, S.Pd., M.M.',  skema: 'Training of Trainer (ToT) Outcome Based Education', cat: 'pt',   no: 'EDUKIA-TOT-2026-010', date: '05 April 2026', status: 'aktif' },
  { name: 'Yuni Kartika Sari, A.Md.',       skema: 'GLP Laboratory Technician',                     cat: 'labtest',  no: 'EDUKIA-GLP-2026-009', date: '30 Maret 2026', status: 'aktif' },
  { name: 'Drs. Joko Susilo, M.Si.',        skema: 'Auditor Internal Standar Laboratorium ISO/IEC 17025', cat: 'lab17025', no: 'EDUKIA-AUI-2026-008', date: '24 Maret 2026', status: 'aktif' },
  { name: 'Putri Maharani, S.Si., M.Si.',   skema: 'ESG Officer',                                   cat: 'manajemen',no: 'EDUKIA-ESG-2026-007', date: '20 Maret 2026', status: 'aktif' },
  { name: 'Anggi Permana, S.T.',            skema: 'Lifting Engineer for Heavy & Critical Lifting', cat: 'lifting',  no: 'EDUKIA-LFE-2026-006', date: '15 Maret 2026', status: 'aktif' },
  { name: 'Nurul Hidayah, S.Si.',           skema: 'QC Laboratory Analyst',                         cat: 'manajemen',no: 'EDUKIA-QCA-2026-005', date: '10 Maret 2026', status: 'aktif' },
  { name: 'Eko Prasetyo, S.T., M.T.',       skema: 'Environmental Management System (ISO 14001) Officer', cat: 'manajemen', no: 'EDUKIA-EMS-2026-004', date: '05 Maret 2026', status: 'aktif' },
  { name: 'Dr. Lukmanul Hakim, M.Pd.',      skema: 'Lead Implementer SPMI Terintegrasi ISO 21001:2018', cat: 'spmi',  no: 'EDUKIA-IMR-2025-098', date: '22 Februari 2026', status: 'aktif' },
  { name: 'Rina Marlina, S.Si.',            skema: 'Laboratory HSE Officer',                        cat: 'labtest',  no: 'EDUKIA-K3L-2025-097', date: '15 Februari 2026', status: 'aktif' },
  { name: 'Fajar Nugroho, S.T.',            skema: '2D Lifting Designer',                           cat: 'lifting',  no: 'EDUKIA-LDT-2025-096', date: '08 Februari 2026', status: 'aktif' },
  { name: 'Siti Aminah, S.Si., Apt.',       skema: 'Regulatory Affairs Officer',                    cat: 'manajemen',no: 'EDUKIA-RAQ-2024-085', date: '12 November 2024', status: 'expiring' },
  { name: 'Agus Salim, S.T.',               skema: 'Quality Assurance Officer',                     cat: 'manajemen',no: 'EDUKIA-QAO-2024-076', date: '20 September 2024', status: 'expiring' },
];

// ============================================================
// CERTIFICATE LIST — full table with search, filter, status
// (Variant B styling: navy headers, colored category chips, modern table)
// ============================================================
function SertifikatList({ compact = false }) {
  const [query, setQuery] = React.useState('');
  const [catFilter, setCatFilter] = React.useState('all');
  const [statusFilter, setStatusFilter] = React.useState('all');

  const filtered = window.LSP_CERTIFICATES.filter(c => {
    if (catFilter !== 'all' && c.cat !== catFilter) return false;
    if (statusFilter !== 'all' && c.status !== statusFilter) return false;
    if (query) {
      const q = query.toLowerCase();
      return c.name.toLowerCase().includes(q) ||
             c.skema.toLowerCase().includes(q) ||
             c.no.toLowerCase().includes(q);
    }
    return true;
  });

  // Stats
  const totalActive = window.LSP_CERTIFICATES.filter(c => c.status === 'aktif').length;
  const totalExp = window.LSP_CERTIFICATES.filter(c => c.status === 'expiring').length;

  return (
    <section style={{ padding: '60px 0 96px', background: T6.cream }}>
      <window.Wrap>
        {/* Stat strip */}
        <div style={{
          display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: 14, marginBottom: 32,
        }}>
          {[
            { v: window.LSP_CERTIFICATES.length, l: 'Total sertifikat diterbitkan', accent: T6.navy800 },
            { v: totalActive, l: 'Sertifikat aktif', accent: T6.greenOk },
            { v: totalExp, l: 'Mendekati kadaluarsa', accent: T6.orange },
            { v: '26', l: 'Skema sertifikasi tersedia', accent: T6.blueDeep },
          ].map((s, i) => (
            <div key={i} style={{
              background: '#fff', border: `1px solid ${T6.line}`, borderRadius: 14,
              padding: '20px 22px', position: 'relative', overflow: 'hidden',
            }}>
              <div style={{ position: 'absolute', left: 0, top: 14, bottom: 14, width: 3, borderRadius: 0, background: s.accent }} />
              <div style={{ display: 'flex', alignItems: 'baseline', gap: 8 }}>
                <span style={{ fontSize: 36, fontWeight: 800, color: T6.ink, letterSpacing: '-0.025em', lineHeight: 1 }}>{s.v}</span>
              </div>
              <div style={{ fontSize: 13, color: T6.muted, marginTop: 8 }}>{s.l}</div>
            </div>
          ))}
        </div>

        {/* Search + filters card */}
        <div style={{ background: '#fff', border: `1px solid ${T6.line}`, borderRadius: 16, overflow: 'hidden' }}>
          <div style={{ padding: '24px 24px 0' }}>
            {/* Search bar */}
            <div style={{
              display: 'flex', alignItems: 'center', gap: 12,
              background: T6.cream, border: `1px solid ${T6.line2}`, borderRadius: 12,
              padding: '4px 4px 4px 16px',
            }}>
              <span style={{ color: T6.muted, display: 'flex' }}>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round">
                  <circle cx="11" cy="11" r="7" /><path d="M21 21l-4.35-4.35" />
                </svg>
              </span>
              <input
                value={query}
                onChange={e => setQuery(e.target.value)}
                placeholder="Cari nama, nomor sertifikat, atau skema sertifikasi…"
                style={{
                  flex: 1, height: 44, border: 0, outline: 0, background: 'transparent',
                  fontSize: 15, color: T6.ink, fontFamily: 'inherit',
                }}
              />
              <button style={{
                height: 40, padding: '0 22px', borderRadius: 999, border: 0,
                background: T6.navy800, color: '#fff', fontWeight: 700, fontSize: 13.5,
                cursor: 'pointer', display: 'inline-flex', alignItems: 'center', gap: 6,
              }}>
                Cari
              </button>
            </div>

            {/* Filter chips */}
            <div style={{ display: 'flex', flexWrap: 'wrap', gap: 8, padding: '18px 0 4px',
                          alignItems: 'center', borderBottom: `1px solid ${T6.line}` }}>
              <span style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.14em',
                            textTransform: 'uppercase', color: T6.muted, marginRight: 8 }}>Filter bidang</span>
              {[
                { id: 'all',        label: 'Semua', count: window.LSP_CERTIFICATES.length },
                { id: 'spmi',       label: 'SPMI', count: 3 },
                { id: 'pt',         label: 'Perguruan Tinggi', count: 1 },
                { id: 'lab17025',   label: 'Lab ISO 17025', count: 1 },
                { id: 'labtest',    label: 'Lab & Pengujian', count: 3 },
                { id: 'lifting',    label: 'Lifting', count: 4 },
                { id: 'manajemen',  label: 'Sistem Manajemen', count: 7 },
                { id: 'hukum',      label: 'Hukum', count: 1 },
              ].map(c => {
                const active = c.id === catFilter;
                return (
                  <button key={c.id} onClick={() => setCatFilter(c.id)} style={{
                    height: 32, padding: '0 12px', borderRadius: 999,
                    border: `1px solid ${active ? T6.navy800 : T6.line2}`,
                    background: active ? T6.navy800 : '#fff',
                    color: active ? '#fff' : T6.ink2,
                    fontSize: 12.5, fontWeight: 600, cursor: 'pointer',
                    display: 'inline-flex', alignItems: 'center', gap: 6, fontFamily: 'inherit',
                  }}>
                    {c.label}
                    <span style={{ fontSize: 11, opacity: 0.6 }}>{c.count}</span>
                  </button>
                );
              })}
              <span style={{ flex: 1 }} />
              <span style={{ fontSize: 11, fontWeight: 700, letterSpacing: '0.14em',
                            textTransform: 'uppercase', color: T6.muted, marginRight: 4 }}>Status</span>
              {[
                { id: 'all', label: 'Semua' },
                { id: 'aktif', label: 'Aktif' },
                { id: 'expiring', label: 'Akan kadaluarsa' },
              ].map(s => {
                const active = s.id === statusFilter;
                return (
                  <button key={s.id} onClick={() => setStatusFilter(s.id)} style={{
                    height: 32, padding: '0 12px', borderRadius: 999,
                    border: `1px solid ${active ? T6.navy800 : T6.line2}`,
                    background: active ? T6.navy800 : '#fff',
                    color: active ? '#fff' : T6.ink2,
                    fontSize: 12.5, fontWeight: 600, cursor: 'pointer', fontFamily: 'inherit',
                  }}>
                    {s.label}
                  </button>
                );
              })}
            </div>
          </div>

          {/* Table */}
          <div style={{ padding: '4px 0 0' }}>
            <div style={{
              display: 'grid', gridTemplateColumns: '56px 2fr 2.4fr 1.4fr 1fr 110px',
              padding: '14px 24px', borderBottom: `1px solid ${T6.line}`,
              fontSize: 10.5, fontWeight: 800, letterSpacing: '0.14em',
              textTransform: 'uppercase', color: T6.muted, fontFamily: 'ui-monospace, monospace',
            }}>
              <div>#</div>
              <div>Nama Lengkap</div>
              <div>Skema Sertifikasi</div>
              <div>Nomor Sertifikat</div>
              <div>Certification Date</div>
              <div style={{ textAlign: 'center' }}>Status</div>
            </div>
            {filtered.length === 0 ? (
              <div style={{ padding: '60px 24px', textAlign: 'center', color: T6.muted, fontSize: 14 }}>
                Tidak ditemukan sertifikat yang cocok. Coba kata kunci atau filter lain.
              </div>
            ) : (
              filtered.slice(0, compact ? 6 : 14).map((c, idx) => {
                const cat = CATS[c.cat];
                const isExp = c.status === 'expiring';
                return (
                  <div key={c.no} style={{
                    display: 'grid', gridTemplateColumns: '56px 2fr 2.4fr 1.4fr 1fr 110px',
                    padding: '16px 24px', borderBottom: `1px solid ${T6.line}`,
                    alignItems: 'center', fontSize: 13.5, color: T6.ink2,
                    transition: 'background .12s',
                  }}>
                    <div style={{ fontSize: 12, fontWeight: 700, color: T6.muted,
                                  fontFamily: 'ui-monospace, monospace' }}>
                      {String(idx + 1).padStart(2, '0')}
                    </div>
                    <div>
                      <div style={{ fontSize: 14.5, fontWeight: 700, color: T6.ink, lineHeight: 1.3 }}>
                        {c.name}
                      </div>
                    </div>
                    <div>
                      <div style={{ fontSize: 13.5, color: T6.ink2, lineHeight: 1.4, marginBottom: 4 }}>
                        {c.skema}
                      </div>
                      <span style={{
                        display: 'inline-flex', alignItems: 'center', gap: 6,
                        fontSize: 10.5, fontWeight: 700,
                        padding: '3px 8px', borderRadius: 5,
                        background: cat.bg, color: cat.color, letterSpacing: '0.02em',
                      }}>
                        <window.Icon name="dot" size={6} color={cat.color} />
                        {cat.label}
                      </span>
                    </div>
                    <div style={{ fontSize: 12.5, color: T6.navy800,
                                  fontFamily: 'ui-monospace, monospace', fontWeight: 600 }}>
                      {c.no}
                    </div>
                    <div style={{ fontSize: 13, color: T6.ink2 }}>{c.date}</div>
                    <div style={{ textAlign: 'center' }}>
                      <span style={{
                        display: 'inline-flex', alignItems: 'center', gap: 6,
                        padding: '5px 11px', borderRadius: 999, fontSize: 11.5, fontWeight: 700,
                        background: isExp ? '#fef3c7' : '#dcfce7',
                        color: isExp ? '#92400e' : '#15803d',
                      }}>
                        <span style={{
                          width: 6, height: 6, borderRadius: '50%',
                          background: isExp ? '#d97706' : '#16a34a',
                        }} />
                        {isExp ? 'Akan kadaluarsa' : 'Aktif'}
                      </span>
                    </div>
                  </div>
                );
              })
            )}
          </div>

          {/* Pagination */}
          {filtered.length > 0 && (
            <div style={{
              padding: '20px 24px', display: 'flex', justifyContent: 'space-between',
              alignItems: 'center', background: T6.paperOff,
              borderTop: `1px solid ${T6.line}`,
            }}>
              <span style={{ fontSize: 13, color: T6.muted }}>
                Menampilkan <strong style={{ color: T6.ink, fontWeight: 700 }}>
                  {Math.min(compact ? 6 : 14, filtered.length)}
                </strong> dari <strong style={{ color: T6.ink, fontWeight: 700 }}>{filtered.length}</strong> sertifikat
              </span>
              <div style={{ display: 'flex', gap: 6, alignItems: 'center' }}>
                <button disabled style={{
                  width: 34, height: 34, borderRadius: 8, border: `1px solid ${T6.line2}`,
                  background: '#fff', display: 'inline-flex', alignItems: 'center', justifyContent: 'center',
                  cursor: 'not-allowed', color: T6.muted, opacity: 0.4, fontFamily: 'inherit',
                }}>
                  <window.Icon name="arrow-l" size={14} />
                </button>
                {[1, 2].map(n => (
                  <button key={n} style={{
                    width: 34, height: 34, borderRadius: 8,
                    border: `1px solid ${n === 1 ? T6.navy800 : T6.line2}`,
                    background: n === 1 ? T6.navy800 : '#fff',
                    color: n === 1 ? '#fff' : T6.ink2,
                    fontSize: 13, fontWeight: 700, cursor: 'pointer', fontFamily: 'inherit',
                  }}>{n}</button>
                ))}
                <button style={{
                  width: 34, height: 34, borderRadius: 8, border: `1px solid ${T6.line2}`,
                  background: '#fff', display: 'inline-flex', alignItems: 'center', justifyContent: 'center',
                  cursor: 'pointer', color: T6.ink2, fontFamily: 'inherit',
                }}>
                  <window.Icon name="arrow-r" size={14} />
                </button>
              </div>
            </div>
          )}
        </div>

        {/* Disclaimer */}
        <div style={{
          marginTop: 28, padding: '18px 22px', background: T6.blue50,
          border: `1px solid #bfdbfe`, borderRadius: 12,
          display: 'flex', gap: 14, alignItems: 'flex-start', fontSize: 13.5, color: '#1e40af', lineHeight: 1.55,
        }}>
          <span style={{ flex: '0 0 auto', marginTop: 2, color: '#1e40af' }}>
            <window.Icon name="shield" size={20} />
          </span>
          <div>
            <strong style={{ color: '#1e3a8a', fontWeight: 700 }}>Verifikasi sertifikat:</strong> Untuk memvalidasi keaslian
            sertifikat, masukkan nomor sertifikat pada kolom pencarian atau hubungi tim LSP Edukia
            via WhatsApp di +62 851-7547-9385. Data dimutakhirkan setiap bulan.
          </div>
        </div>
      </window.Wrap>
    </section>
  );
}

// New full-page replacement (overrides the prior PageSertifikat B body)
function PageSertifikatList() {
  return (
    <div style={{ background: T6.cream, fontFamily: '"Plus Jakarta Sans", sans-serif', color: T6.ink }}>
      <window.Header active="sertifikat" variant="b" />
      <window.PageHero
        variant="b" image="assets/hero-sertifikat.jpg"
        badge="Transparansi & Akuntabilitas · 20 Penerima"
        title="Daftar Penerima Sertifikat"
        lead="Pemegang sertifikat kompetensi yang diterbitkan LSP Edukasi Global Cendekia. Gunakan pencarian untuk verifikasi sertifikat berdasarkan nama, nomor, atau skema."
      />
      <SertifikatList />
      <window.CtaBlock />
      <window.Footer />
    </div>
  );
}

Object.assign(window, { SertifikatList, PageSertifikatList });
