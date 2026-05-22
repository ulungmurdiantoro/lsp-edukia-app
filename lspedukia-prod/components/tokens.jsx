/* global window */
// ---------- LSP EDUKIA — DESIGN TOKENS (from production app) ----------
window.LSP_TOKENS = {
  // Navy scale (primary brand)
  navy900: '#06172e', navy800: '#0a2547', navy700: '#102d57',
  navy600: '#173a6b', navy500: '#21528f', navy50:  '#eef3fb',

  // Orange (CTA/accent)
  orange:      '#f4891f',
  orangeDeep:  '#d77110',
  orange50:    '#fdf0e1',

  // Blue (link/info accent)
  blue:      '#449fe5',
  blueDeep:  '#2a7fc4',
  blue50:    '#eaf4fd',

  // Ink (text)
  ink:    '#0f1d35',
  ink2:   '#2a3a55',
  muted:  '#5a6a85',

  // Surface
  cream:   '#f5f1e8',
  cream2:  '#efeadc',
  line:    '#e6e9f0',
  line2:   '#dfe3ec',
  paper:   '#ffffff',
  paperOff:'#fbf9f3',

  // Status
  greenOk:'#2f8a55',
  warn:   '#c0532e',
};

// Curated palettes user can switch (Tweaks panel)
window.LSP_PALETTES = {
  brand: { name: 'Brand (Navy + Orange)', primary: '#0a2547', accent: '#f4891f', tint: '#449fe5' },
  formal:{ name: 'Formal Maroon',         primary: '#102d57', accent: '#a83232', tint: '#449fe5' },
  growth:{ name: 'Edukasi Hijau',         primary: '#0a2547', accent: '#127f4d', tint: '#449fe5' },
  mono:  { name: 'Monokrom + Aksen',      primary: '#101820', accent: '#d77110', tint: '#404040' },
};

// Category color mapping for the 7 scheme groups (used on cards)
window.LSP_CATS = {
  spmi:       { label: 'SPMI ISO 21001',         color: '#1a4a8a', bg: '#e0ebff', count: 3, abbr: 'SPMI' },
  pt:         { label: 'Perguruan Tinggi',       color: '#102d57', bg: '#eef3fb', count: 2, abbr: 'PT'   },
  lab17025:   { label: 'Lab ISO 17025',          color: '#1a5c35', bg: '#e3f5ea', count: 2, abbr: 'LAB' },
  lifting:    { label: 'Lifting Engineering',    color: '#d77110', bg: '#fdf0e1', count: 4, abbr: 'LFT' },
  labtest:    { label: 'Lab & Pengujian',        color: '#1a5c35', bg: '#e3f5ea', count: 6, abbr: 'LAB' },
  manajemen:  { label: 'Sistem Manajemen',       color: '#922b2b', bg: '#fde8e8', count: 8, abbr: 'MGT' },
  hukum:      { label: 'Hukum Korporasi',        color: '#5a3aa6', bg: '#f0ecfa', count: 1, abbr: 'LGL' },
};

// Real scheme data (subset, taken from the Blade file)
window.LSP_SCHEMES = [
  { no: '01', cat: 'spmi', code: 'EDUKIA-AIL-2024-001',
    title: 'Auditor Internal SPMI Terintegrasi ISO 21001:2018',
    short: 'Auditor Internal SPMI',
    units: 7, reqs: ['Pendidikan minimal S2', 'Pengalaman kerja di bidang Perguruan Tinggi', 'Sertifikat Pelatihan Auditor Internal'] },
  { no: '02', cat: 'spmi', code: 'EDUKIA-LAD-2024-002',
    title: 'Lead Auditor SPMI Terintegrasi ISO 21001:2018',
    short: 'Lead Auditor SPMI',
    units: 8, reqs: ['Pendidikan minimal S2', 'Pengalaman kerja di bidang Perguruan Tinggi', 'Sertifikat Pelatihan Auditor Internal', 'Pengalaman sebagai Ketua Auditor'] },
  { no: '03', cat: 'spmi', code: 'EDUKIA-IMR-2024-003',
    title: 'Lead Implementer SPMI Terintegrasi ISO 21001:2018',
    short: 'Lead Implementer SPMI',
    units: 7, reqs: ['Pendidikan minimal S2', 'Pengalaman kerja di bidang Perguruan Tinggi', 'Sertifikat Pelatihan SPMI / ISO 21001:2018'] },
  { no: '04', cat: 'pt', code: 'EDUKIA-ToT-2024-004',
    title: 'Training of Trainer (ToT) Outcome Based Education',
    short: 'ToT — OBE',
    units: 6, reqs: ['Pendidikan minimal S2', 'Pengalaman kerja di bidang Perguruan Tinggi', 'Sertifikat Pelatihan Kurikulum OBE'] },
  { no: '06', cat: 'lab17025', code: 'EDUKIA-AUI-2024-006',
    title: 'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017',
    short: 'Auditor Internal Lab',
    units: 8, reqs: ['Min. SMA/SMK · pengalaman 2 thn di laboratorium', 'Sertifikat Pelatihan Auditor Internal & ISO 17025:2017'] },
  { no: '08', cat: 'lifting', code: 'EDUKIA-LFE-2024-008',
    title: 'Lifting Engineer for Medium Lifting',
    short: 'Lifting Engineer · Medium',
    units: 6, reqs: ['Pendidikan minimal D3 Teknik', 'Fresh-graduated atau pengalaman di Lifting', 'Sertifikat Pelatihan Lifting Engineer'] },
  { no: '18', cat: 'manajemen', code: 'EDUKIA-QMS-2024-018',
    title: 'Quality Management System (ISO 9001) Officer',
    short: 'QMS ISO 9001 Officer',
    units: 5, reqs: ['Min. SMA/SMK pengalaman 2 thn industri', 'Atau D3 fresh + magang 3 bulan', 'Sertifikat Pelatihan ISO 9001:2015'] },
  { no: '26', cat: 'hukum', code: 'EDUKIA-CLO-2024-026',
    title: 'Corporate Legal Officer',
    short: 'Corporate Legal Officer',
    units: 6, reqs: ['Min. D3/S1 Ilmu Hukum', 'Fresh-graduated atau pengalaman korporasi', 'Sertifikat Pelatihan Corporate Legal Officer'] },
];

Object.assign(window, {
  T: window.LSP_TOKENS,
  CATS: window.LSP_CATS,
  SCHEMES: window.LSP_SCHEMES,
  PALETTES: window.LSP_PALETTES,
});
