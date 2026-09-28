/* global React */
const T11 = window.LSP_TOKENS;

// ============================================================
// STRUKTUR ORGANISASI — SVG-based org chart
// Variant B styling: navy hierarchy + dashed orange for independent oversight
// ============================================================

// SVG box helper (uses foreignObject for clean multi-line text wrapping)
function ChartBox({ x, y, w, h, label, variant = 'manager' }) {
  const styles = {
    primary:     { bg: T11.navy800, color: '#fff',     stroke: 'none',      strokeWidth: 0,   dash: 0, fw: 700, fs: 18, shadow: true },
    dashed:      { bg: '#fff',      color: T11.ink,    stroke: T11.orange,  strokeWidth: 2,   dash: '6 4', fw: 600, fs: 14 },
    manager:     { bg: '#fff',      color: T11.navy800, stroke: T11.navy800, strokeWidth: 1.5, dash: 0, fw: 600, fs: 14, accent: true },
    sub:         { bg: T11.navy50,  color: T11.navy700, stroke: T11.navy700, strokeWidth: 1,   dash: 0, fw: 600, fs: 13 },
    operational: { bg: T11.cream,   color: T11.navy800, stroke: T11.line2,   strokeWidth: 1.5, dash: 0, fw: 700, fs: 15 },
  };
  const s = styles[variant];

  return (
    <g>
      {/* Soft shadow for primary */}
      {s.shadow && (
        <rect x={x + 2} y={y + 4} width={w} height={h} rx={8} fill={T11.navy900} opacity={0.18} />
      )}
      {/* Box */}
      <rect
        x={x} y={y} width={w} height={h} rx={8}
        fill={s.bg}
        stroke={s.stroke} strokeWidth={s.strokeWidth}
        strokeDasharray={s.dash || undefined}
      />
      {/* Left accent strip for managers */}
      {s.accent && (
        <rect x={x} y={y} width={4} height={h} rx={2} fill={T11.orange} />
      )}
      {/* Label */}
      <foreignObject x={x} y={y} width={w} height={h}>
        <div xmlns="http://www.w3.org/1999/xhtml" style={{
          width: '100%', height: '100%',
          display: 'flex', alignItems: 'center', justifyContent: 'center',
          padding: s.accent ? '0 14px 0 18px' : '0 14px',
          color: s.color, fontWeight: s.fw, fontSize: s.fs,
          textAlign: 'center', lineHeight: 1.3, textWrap: 'balance',
          fontFamily: '"Plus Jakarta Sans", sans-serif',
          letterSpacing: variant === 'primary' ? '-0.01em' : 0,
        }}>{label}</div>
      </foreignObject>
    </g>
  );
}

function OrgChart() {
  const W = 1240, H = 680;
  // Connector stroke (subtle navy)
  const conn = T11.muted;
  return (
    <svg viewBox={`0 0 ${W} ${H}`} xmlns="http://www.w3.org/2000/svg"
         style={{ width: '100%', height: 'auto', maxWidth: '100%', display: 'block' }}>

      {/* ----- CONNECTOR LINES ----- */}
      <g stroke={conn} strokeWidth={1.5} fill="none">
        {/* Central spine */}
        <line x1={620} y1={90}  x2={620} y2={530} />

        {/* Bus at y=150 → Manajer Teknis & Mutu */}
        <line x1={370} y1={150} x2={840} y2={150} />
        <line x1={370} y1={150} x2={370} y2={220} />
        <line x1={840} y1={150} x2={840} y2={220} />

        {/* Manajer Mutu → Tim Audit Internal */}
        <line x1={840} y1={280} x2={840} y2={320} />

        {/* Wide bus at y=385 → 4 Manajer */}
        <line x1={120}  y1={385} x2={1120} y2={385} />
        <line x1={120}  y1={385} x2={120}  y2={420} />
        <line x1={400}  y1={385} x2={400}  y2={420} />
        <line x1={720}  y1={385} x2={720}  y2={420} />
        <line x1={1120} y1={385} x2={1120} y2={420} />

        {/* Bus at y=530 → TUK / Asesor / Pengawas */}
        <line x1={370} y1={530} x2={860} y2={530} />
        <line x1={370} y1={530} x2={370} y2={560} />
        <line x1={620} y1={530} x2={620} y2={560} />
        <line x1={860} y1={530} x2={860} y2={560} />
      </g>

      {/* Dashed advisory line — Ketua LSP ↔ Komite Ketidakberpihakan */}
      <line x1={770} y1={60} x2={960} y2={60}
            stroke={T11.orange} strokeWidth={2} strokeDasharray="6 5" />

      {/* ----- BOXES ----- */}
      <ChartBox x={470}  y={30}  w={300} h={60} label="Ketua LSP" variant="primary" />
      <ChartBox x={960}  y={30}  w={260} h={60} label="Komite Ketidakberpihakan" variant="dashed" />

      <ChartBox x={240}  y={220} w={260} h={60} label="Manajer Teknis" variant="manager" />
      <ChartBox x={680}  y={220} w={320} h={60} label="Manajer Mutu dan Administrasi" variant="manager" />

      <ChartBox x={720}  y={320} w={240} h={50} label="Tim Audit Internal" variant="sub" />

      <ChartBox x={20}   y={420} w={200} h={90} label="Manajer Skema" variant="manager" />
      <ChartBox x={240}  y={420} w={320} h={90} label="Manajer Ketidakberpihakan, Kerahasiaan dan Keamanan MUK" variant="manager" />
      <ChartBox x={580}  y={420} w={280} h={90} label="Manajer HR, Keuangan dan Sales" variant="manager" />
      <ChartBox x={1020} y={420} w={200} h={90} label="Manajer Sertifikasi" variant="manager" />

      <ChartBox x={250}  y={560} w={240} h={50} label="TUK" variant="operational" />
      <ChartBox x={500}  y={560} w={240} h={50} label="Asesor" variant="operational" />
      <ChartBox x={740}  y={560} w={240} h={50} label="Pengawas" variant="operational" />
    </svg>
  );
}

// ============================================================
// STRUKTUR ORGANISASI SECTION (with legend + org roster)
// ============================================================
function StrukturOrganisasiSection() {
  return (
    <section style={{ padding: '96px 0', background: T11.paperOff, borderTop: `1px solid ${T11.line}` }}>
      <window.Wrap>
        <window.SectionHead
          eyebrow="Tata Kelola"
          title="Struktur Organisasi"
          sub="Susunan pengurus dan personel LSP Edukasi Global Cendekia berdasarkan SK No: 001/SK-AK/LSP-EDUKIA/I/2026."
        />

        {/* Chart card */}
        <div style={{
          background: '#fff', border: `1px solid ${T11.line}`, borderRadius: 20,
          padding: '40px 36px', position: 'relative', overflow: 'hidden',
        }}>
          {/* Subtle bg pattern */}
          <div style={{
            position: 'absolute', inset: 0, pointerEvents: 'none',
            backgroundImage: `radial-gradient(${T11.line} 1px, transparent 1px)`,
            backgroundSize: '24px 24px', opacity: 0.3, maskImage: 'radial-gradient(60% 60% at 50% 50%, #000 30%, transparent)',
          }} />

          {/* Header strip */}
          <div style={{
            position: 'relative', display: 'flex', justifyContent: 'space-between',
            alignItems: 'flex-end', marginBottom: 28, paddingBottom: 18,
            borderBottom: `1px solid ${T11.line}`,
          }}>
            <div>
              <div style={{ fontSize: 11, fontWeight: 800, letterSpacing: '0.18em',
                            textTransform: 'uppercase', color: T11.orangeDeep,
                            fontFamily: 'ui-monospace, monospace', marginBottom: 6 }}>
                Bagan Tata Kelola · v2026
              </div>
              <h3 style={{ fontSize: 22, fontWeight: 700, color: T11.ink,
                           margin: 0, letterSpacing: '-0.015em' }}>
                Struktur Organisasi LSP Edukasi Global Cendekia
              </h3>
            </div>
            <div style={{ fontSize: 12.5, color: T11.muted, textAlign: 'right' }}>
              <div style={{ fontFamily: 'ui-monospace, monospace' }}>SK No. 001/SK-AK/LSP-EDUKIA/I/2026</div>
              <div style={{ marginTop: 2 }}>Efektif sejak Januari 2026</div>
            </div>
          </div>

          {/* The chart */}
          <div style={{ position: 'relative' }}>
            <OrgChart />
          </div>

          {/* Legend */}
          <div style={{
            position: 'relative', marginTop: 28, paddingTop: 20,
            borderTop: `1px solid ${T11.line}`,
            display: 'flex', flexWrap: 'wrap', gap: 24, alignItems: 'center',
            fontSize: 12.5, color: T11.muted,
          }}>
            <span style={{ fontSize: 11, fontWeight: 800, letterSpacing: '0.14em',
                          textTransform: 'uppercase', color: T11.ink }}>Legenda</span>
            <LegendItem swatch={<span style={{ width: 14, height: 14, borderRadius: 3, background: T11.navy800 }} />}>
              Posisi puncak
            </LegendItem>
            <LegendItem swatch={
              <span style={{ width: 14, height: 14, borderRadius: 3, background: '#fff',
                             border: `2px dashed ${T11.orange}` }} />
            }>
              Komite independen
            </LegendItem>
            <LegendItem swatch={
              <span style={{ width: 14, height: 14, borderRadius: 3, background: '#fff',
                             border: `1.5px solid ${T11.navy800}`, position: 'relative' }}>
                <span style={{ position: 'absolute', left: 0, top: 0, bottom: 0, width: 2, background: T11.orange }} />
              </span>
            }>
              Manajemen
            </LegendItem>
            <LegendItem swatch={
              <span style={{ width: 14, height: 14, borderRadius: 3, background: T11.navy50,
                             border: `1px solid ${T11.navy700}` }} />
            }>
              Tim pendukung
            </LegendItem>
            <LegendItem swatch={
              <span style={{ width: 14, height: 14, borderRadius: 3, background: T11.cream,
                             border: `1.5px solid ${T11.line2}` }} />
            }>
              Operasional
            </LegendItem>
            <span style={{ flex: 1 }} />
            <span style={{ display: 'inline-flex', alignItems: 'center', gap: 8, color: T11.muted }}>
              <svg width={28} height={10} viewBox="0 0 28 10">
                <line x1={0} y1={5} x2={28} y2={5} stroke={T11.orange} strokeWidth={2} strokeDasharray="6 4" />
              </svg>
              Hubungan independen / advisory
            </span>
          </div>
        </div>

        {/* Roster — list of all roles */}
        <div style={{ marginTop: 28, display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: 16 }}>
          <RosterGroup title="Pimpinan & Pengawasan" items={[
            { role: 'Ketua LSP', tone: 'primary' },
            { role: 'Komite Ketidakberpihakan', tone: 'dashed' },
            { role: 'Tim Audit Internal', tone: 'sub' },
          ]} />
          <RosterGroup title="Manajemen" items={[
            { role: 'Manajer Teknis' },
            { role: 'Manajer Mutu dan Administrasi' },
            { role: 'Manajer Skema' },
            { role: 'Manajer Ketidakberpihakan, Kerahasiaan & Keamanan MUK' },
            { role: 'Manajer HR, Keuangan dan Sales' },
            { role: 'Manajer Sertifikasi' },
          ]} />
          <RosterGroup title="Operasional" items={[
            { role: 'TUK (Tempat Uji Kompetensi)', tone: 'operational' },
            { role: 'Asesor Kompetensi', tone: 'operational' },
            { role: 'Pengawas', tone: 'operational' },
            { role: 'Anggota Teknis', tone: 'operational' },
            { role: 'Staff Administrasi', tone: 'operational' },
            { role: 'Staff Sales', tone: 'operational' },
          ]} />
        </div>
      </window.Wrap>
    </section>
  );
}

function LegendItem({ swatch, children }) {
  return (
    <span style={{ display: 'inline-flex', alignItems: 'center', gap: 8 }}>
      {swatch}
      <span style={{ color: T11.ink2 }}>{children}</span>
    </span>
  );
}

function RosterGroup({ title, items }) {
  const toneColors = {
    primary:     { bg: T11.navy800, color: '#fff', accent: T11.orange },
    dashed:      { bg: '#fff',      color: T11.ink, accent: T11.orange, dashed: true },
    sub:         { bg: T11.navy50,  color: T11.navy700, accent: T11.navy700 },
    operational: { bg: T11.cream,   color: T11.navy800, accent: T11.line2 },
    default:     { bg: '#fff',      color: T11.navy800, accent: T11.orange, bordered: true },
  };
  return (
    <div style={{ background: '#fff', border: `1px solid ${T11.line}`, borderRadius: 14, padding: 22 }}>
      <div style={{ fontSize: 11, fontWeight: 800, letterSpacing: '0.14em', textTransform: 'uppercase',
                    color: T11.orangeDeep, marginBottom: 14 }}>
        {title}
      </div>
      <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex',
                   flexDirection: 'column', gap: 6 }}>
        {items.map((it, i) => {
          const t = toneColors[it.tone || 'default'];
          return (
            <li key={i} style={{
              padding: '8px 12px', borderRadius: 8,
              background: t.bg, color: t.color, fontSize: 13.5, fontWeight: 600,
              border: t.dashed ? `1.5px dashed ${t.accent}`
                    : t.bordered ? `1px solid ${T11.line}`
                    : `1px solid ${t.bg === '#fff' ? T11.line : 'transparent'}`,
              position: 'relative', paddingLeft: it.tone === undefined || it.tone === 'default' ? 18 : 12,
            }}>
              {(it.tone === undefined || it.tone === 'default') && (
                <span style={{ position: 'absolute', left: 6, top: 6, bottom: 6, width: 2,
                              borderRadius: 1, background: T11.orange }} />
              )}
              {it.role}
            </li>
          );
        })}
      </ul>
    </div>
  );
}

Object.assign(window, { StrukturOrganisasiSection, OrgChart });
