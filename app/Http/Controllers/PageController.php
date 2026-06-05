<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Sertifikat;
use App\Support\Skemas;
use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Schema\BreadcrumbListSchema;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class PageController extends Controller
{
    private function schemes(): array
    {
        return [
            // ── SPMI ISO 21001 ──────────────────────────────────────────────
            [
                'nomor' => '01', 'kode' => 'EDUKIA-AIL-2024-001',
                'judul' => 'Auditor Internal SPMI Terintegrasi ISO 21001:2018',
                'kategori' => 'spmi', 'jumlah_unit' => 7,
                'reqs' => [
                    'Pendidikan minimal S2',
                    'Pengalaman kerja di bidang Perguruan Tinggi',
                    'Memiliki Sertifikat Pelatihan Auditor Internal',
                ],
            ],
            [
                'nomor' => '02', 'kode' => 'EDUKIA-LAD-2024-002',
                'judul' => 'Lead Auditor Internal SPMI Terintegrasi ISO 21001:2018',
                'kategori' => 'spmi', 'jumlah_unit' => 8,
                'reqs' => [
                    'Pendidikan minimal S2',
                    'Pengalaman kerja di bidang Perguruan Tinggi',
                    'Memiliki Sertifikat Pelatihan Auditor Internal',
                    'Pengalaman sebagai Ketua Auditor',
                ],
            ],
            [
                'nomor' => '03', 'kode' => 'EDUKIA-IMR-2024-003',
                'judul' => 'Lead Implementer SPMI Terintegrasi ISO 21001:2018',
                'kategori' => 'spmi', 'jumlah_unit' => 7,
                'reqs' => [
                    'Pendidikan minimal S2',
                    'Pengalaman kerja di bidang Perguruan Tinggi',
                    'Memiliki Sertifikat Pelatihan SPMI / ISO 21001:2018',
                ],
            ],
            // ── Perguruan Tinggi ────────────────────────────────────────────
            [
                'nomor' => '04', 'kode' => 'EDUKIA-ToT-2024-004',
                'judul' => 'Training of Trainer (ToT) Outcome Based Education (OBE)',
                'kategori' => 'pt', 'jumlah_unit' => 6, 'popular' => true,
                'reqs' => [
                    'Pendidikan minimal S2',
                    'Pengalaman kerja di bidang Perguruan Tinggi',
                    'Memiliki Sertifikat Pelatihan Kurikulum OBE / Pelatihan yang relevan',
                ],
            ],
            [
                'nomor' => '05', 'kode' => 'EDUKIA-TKO-2024-005',
                'judul' => 'Implementer Tata Kelola Organisasi Perguruan Tinggi',
                'kategori' => 'pt', 'jumlah_unit' => 6,
                'reqs' => [
                    'Pendidikan minimal S2',
                    'Pengalaman kerja di bidang Perguruan Tinggi',
                    'Memiliki Sertifikat Pelatihan relevan dengan Tata Kelola PT',
                ],
            ],
            // ── Lab ISO 17025 ───────────────────────────────────────────────
            [
                'nomor' => '06', 'kode' => 'EDUKIA-AUI-2024-006',
                'judul' => 'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017',
                'kategori' => 'lab17025', 'jumlah_unit' => 8,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan Auditor Internal & ISO 17025:2017',
                ],
            ],
            [
                'nomor' => '07', 'kode' => 'EDUKIA-LIM-2024-007',
                'judul' => 'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017',
                'kategori' => 'lab17025', 'jumlah_unit' => 7, 'popular' => true,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan Auditor Internal & ISO 17025:2017',
                ],
            ],
            // ── Lifting Engineering ─────────────────────────────────────────
            [
                'nomor' => '08', 'kode' => 'EDUKIA-LFM-2024-008',
                'judul' => 'Lifting Engineer for Medium Lifting',
                'kategori' => 'lifting', 'jumlah_unit' => 6,
                'reqs' => [
                    'Pendidikan minimal D3 Teknik',
                    'Fresh graduated atau pengalaman kerja di bidang Lifting',
                    'Memiliki Sertifikat Pelatihan Lifting Engineer for Medium Lifting',
                ],
            ],
            [
                'nomor' => '09', 'kode' => 'EDUKIA-LFH-2024-009',
                'judul' => 'Lifting Engineer for Heavy & Critical Lifting Operation',
                'kategori' => 'lifting', 'jumlah_unit' => 6,
                'reqs' => [
                    'Pendidikan minimal D3 Teknik',
                    'Fresh graduated atau pengalaman kerja di bidang Lifting',
                    'Memiliki Sertifikat Competent Person for Medium Lifting Operation',
                ],
            ],
            [
                'nomor' => '10', 'kode' => 'EDUKIA-LDT-2024-010',
                'judul' => '2D Lifting Designer',
                'kategori' => 'lifting', 'jumlah_unit' => 5,
                'reqs' => [
                    'Pendidikan minimal SMK/SMA',
                    'Fresh graduated atau pengalaman kerja di bidang CAD Drafter',
                    'Memiliki Sertifikat Pelatihan Lifting Drafter',
                ],
            ],
            [
                'nomor' => '11', 'kode' => 'EDUKIA-DLD-2024-011',
                'judul' => '3D Lifting Designer',
                'kategori' => 'lifting', 'jumlah_unit' => 5,
                'reqs' => [
                    'Pendidikan minimal SMK/SMA',
                    'Fresh graduated atau pengalaman kerja di bidang Lifting Drafter',
                    'Memiliki Sertifikat Lifting Drafter',
                ],
            ],
            // ── Lab & Pengujian ─────────────────────────────────────────────
            [
                'nomor' => '12', 'kode' => 'EDUKIA-LQO-2024-012',
                'judul' => 'Laboratory Quality System Officer ISO/IEC 17025',
                'kategori' => 'labtest', 'jumlah_unit' => 5,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017',
                ],
            ],
            [
                'nomor' => '13', 'kode' => 'EDUKIA-FMO-2024-013',
                'judul' => 'Food Safety Management Officer / Petugas Sistem Keamanan Pangan',
                'kategori' => 'labtest', 'jumlah_unit' => 6,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman produksi pangan 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan HACCP, ISO 22000, atau CPPOB/GMP',
                ],
            ],
            [
                'nomor' => '14', 'kode' => 'EDUKIA-PSP-2024-014',
                'judul' => 'Panelis Terlatih Pengujian Sensori Pangan',
                'kategori' => 'labtest', 'jumlah_unit' => 5,
                'reqs' => [
                    'Pendidikan minimal D3/S1 Teknologi Pangan, Gizi, Kimia, Biologi, atau Tek. Hasil Pertanian',
                    'Fresh graduated atau magang di laboratorium pangan minimal 3 bulan',
                    'Memiliki Sertifikat Pelatihan Pengujian Sensori Pangan',
                ],
            ],
            [
                'nomor' => '15', 'kode' => 'EDUKIA-GLP-2024-015',
                'judul' => 'GLP Laboratory Technician / Teknisi Laboratorium Berbasis GLP',
                'kategori' => 'labtest', 'jumlah_unit' => 4,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017',
                ],
            ],
            [
                'nomor' => '16', 'kode' => 'EDUKIA-K3L-2024-016',
                'judul' => 'Laboratory HSE Officer / Petugas K3L Laboratorium',
                'kategori' => 'labtest', 'jumlah_unit' => 5,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017, ISO 14001, ISO 45001',
                ],
            ],
            [
                'nomor' => '17', 'kode' => 'EDUKIA-LOP-2024-017',
                'judul' => 'Laboratory Operations Officer / Pranata Laboratorium',
                'kategori' => 'labtest', 'jumlah_unit' => 4,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017',
                ],
            ],
            // ── Sistem Manajemen ────────────────────────────────────────────
            [
                'nomor' => '18', 'kode' => 'EDUKIA-QMS-2024-018',
                'judul' => 'Quality Management System (ISO 9001) Officer',
                'kategori' => 'manajemen', 'jumlah_unit' => 5,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman industri 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan ISO/IEC 9001:2015',
                ],
            ],
            [
                'nomor' => '19', 'kode' => 'EDUKIA-QCA-2024-019',
                'judul' => 'QC Laboratory Analyst / Analis QC Laboratorium',
                'kategori' => 'labtest', 'jumlah_unit' => 9,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3/S1 fresh graduate',
                    'Memiliki Sertifikat Pelatihan QC / ISO 9001:2015 / ISO 17025:2017',
                ],
            ],
            [
                'nomor' => '20', 'kode' => 'EDUKIA-QAO-2024-020',
                'judul' => 'Quality Assurance Officer',
                'kategori' => 'manajemen', 'jumlah_unit' => 9,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman QA 2 tahun, atau D3/S1 fresh graduate',
                    'Memiliki Sertifikat Pelatihan QAQC / ISO 9001 / ISO 17025',
                ],
            ],
            [
                'nomor' => '21', 'kode' => 'EDUKIA-RDO-2024-021',
                'judul' => 'Research and Development Officer',
                'kategori' => 'manajemen', 'jumlah_unit' => 5,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab/industri 2 tahun, atau D3/S1 fresh graduate',
                    'Memiliki Sertifikat Pelatihan ISO 17025 / GMP (CPPOB, CPAKB, CPOIB)',
                ],
            ],
            [
                'nomor' => '22', 'kode' => 'EDUKIA-RAQ-2024-022',
                'judul' => 'Regulatory Affairs Officer',
                'kategori' => 'manajemen', 'jumlah_unit' => 6,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman QA industri 2 tahun, atau D3/S1 fresh graduate',
                    'Memiliki Sertifikat Pelatihan ISO 9001 / GMP (Good Manufacturing Practices)',
                ],
            ],
            [
                'nomor' => '23', 'kode' => 'EDUKIA-SBO-2024-023',
                'judul' => 'Sustainability Officer',
                'kategori' => 'manajemen', 'jumlah_unit' => 6,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab/industri 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko',
                ],
            ],
            [
                'nomor' => '24', 'kode' => 'EDUKIA-ESG-2024-024',
                'judul' => 'ESG Officer',
                'kategori' => 'manajemen', 'jumlah_unit' => 7,
                'reqs' => [
                    'Minimal SMA/SMK dengan pengalaman lab/industri 2 tahun, atau D3 fresh graduate',
                    'Memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko',
                ],
            ],
            [
                'nomor' => '25', 'kode' => 'EDUKIA-EMS-2024-025',
                'judul' => 'Environmental Management System (ISO 14001) Officer',
                'kategori' => 'manajemen', 'jumlah_unit' => 8,
                'reqs' => [
                    'Pendidikan minimal D3/S1 Teknik Lingkungan, Teknik Kimia, atau bidang terkait',
                    'Fresh graduated atau magang di bidang EMS minimal 3 bulan',
                    'Memiliki Sertifikat Pelatihan ISO 14001:2015 EMS atau pelatihan terkait',
                ],
            ],
            // ── Hukum Korporasi ─────────────────────────────────────────────
            [
                'nomor' => '26', 'kode' => 'EDUKIA-CLO-2024-026',
                'judul' => 'Corporate Legal Officer',
                'kategori' => 'hukum', 'jumlah_unit' => 9,
                'reqs' => [
                    'Pendidikan minimal D3/S1 Ilmu Hukum (terbuka untuk disiplin ilmu lain)',
                    'Fresh graduated dan/atau pengalaman kerja di perusahaan atau korporasi',
                    'Memiliki Sertifikat Pelatihan Corporate Legal Officer',
                ],
            ],
        ];
    }

    public function home()
    {
        $schemes = $this->schemes();
        $kegiatan = Kegiatan::aktif()->take(9)->get();

        $seo = new SEOData(
            schema: SchemaCollection::initialize()
                ->addFaqPage(fn ($faq) => $faq
                    ->addQuestion('Apakah LSP Edukia terakreditasi KAN?', 'Ya. LSP Edukia (LSP Edukasi Global Cendekia) adalah Lembaga Sertifikasi Person yang terakreditasi Komite Akreditasi Nasional (KAN).')
                    ->addQuestion('Berapa skema sertifikasi yang tersedia di LSP Edukia?', 'Tersedia 26 skema sertifikasi kompetensi pada 7 bidang: SPMI ISO 21001, Perguruan Tinggi, Laboratorium ISO/IEC 17025, Lifting Engineering, Laboratorium & Pengujian, Sistem Manajemen & Governance, serta Research & Innovation.')
                    ->addQuestion('Bagaimana cara mendaftar uji kompetensi di LSP Edukia?', 'Pilih skema sertifikasi yang sesuai di halaman Skema Sertifikasi, periksa persyaratan pemohon, lalu hubungi tim kami melalui WhatsApp untuk informasi jadwal dan biaya uji kompetensi.')
                    ->addQuestion('Apakah sertifikat LSP Edukia bisa diverifikasi?', 'Ya. Seluruh penerima sertifikat dapat ditelusuri pada halaman Daftar Penerima Sertifikat berdasarkan nama, nomor sertifikat, atau skema kompetensi.')),
        );

        return view('index', compact('schemes', 'kegiatan'))
            ->with('activeNav', 'home')
            ->with('SEOData', $seo);
    }

    public function informasi()
    {
        return view('informasi-publik')
            ->with('activeNav', 'informasi')
            ->with('SEOData', new SEOData(
                title: 'Informasi Publik',
                description: 'Informasi publik LSP Edukia: profil lembaga, legalitas, skema sertifikasi, biaya, serta hak dan kewajiban peserta sertifikasi kompetensi person terakreditasi KAN.',
                image: 'images/hero-informasi.jpg',
            ));
    }

    public function tentang()
    {
        return view('tantang-kami')
            ->with('activeNav', 'tentang')
            ->with('SEOData', new SEOData(
                title: 'Tentang Kami',
                description: 'Mengenal LSP Edukia (LSP Edukasi Global Cendekia) — lembaga sertifikasi person terakreditasi KAN yang berkomitmen mencetak SDM unggul dan tersertifikasi.',
                image: 'images/hero-tentang.jpg',
            ));
    }

    public function skema()
    {
        $bidangs = Skemas::bidangs();
        $skemas = Skemas::all()->groupBy('bidang');

        return view('skema-sertifikasi', compact('bidangs', 'skemas'))
            ->with('activeNav', 'skema')
            ->with('SEOData', new SEOData(
                title: 'Skema Sertifikasi Kompetensi Person',
                description: '26 skema sertifikasi kompetensi person terakreditasi KAN di LSP Edukia: SPMI ISO 21001, OBE, laboratorium ISO 17025, lifting engineering, sistem manajemen ISO 9001/14001, hingga hukum korporasi.',
                image: 'images/hero-skema.jpg',
            ));
    }

    public function sertifikat()
    {
        $now = now();
        $stats = [
            'total' => Sertifikat::tampil()->count(),
            'aktif' => Sertifikat::tampil()->where(fn ($q) => $q->whereNull('tanggal_kadaluarsa')->orWhere('tanggal_kadaluarsa', '>', $now->copy()->addDays(90)))->count(),
            'expiring' => Sertifikat::tampil()->whereBetween('tanggal_kadaluarsa', [$now, $now->copy()->addDays(90)])->count(),
            'kadaluarsa' => Sertifikat::tampil()->where('tanggal_kadaluarsa', '<', $now)->count(),
        ];
        $catCounts = Sertifikat::tampil()
            ->selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('sertifikat', compact('stats', 'catCounts'))
            ->with('activeNav', 'sertifikat')
            ->with('SEOData', new SEOData(
                title: 'Daftar Penerima Sertifikat',
                description: 'Verifikasi keaslian sertifikat kompetensi yang diterbitkan LSP Edukia. Cari berdasarkan nama, nomor sertifikat, atau skema sertifikasi kompetensi person.',
                image: 'images/hero-sertifikat.jpg',
            ));
    }

    public function sertifikatSearch(Request $request)
    {
        $now = now();
        $query = Sertifikat::tampil()->orderByDesc('tanggal_terbit');

        if ($q = trim($request->get('q', ''))) {
            $query->where(fn ($sq) => $sq
                ->where('nama', 'like', "%{$q}%")
                ->orWhere('nomor_sertifikat', 'like', "%{$q}%")
                ->orWhere('skema', 'like', "%{$q}%")
            );
        }

        if ($kat = $request->get('kategori')) {
            $query->where('kategori', $kat);
        }

        match ($request->get('status')) {
            'aktif' => $query->where(fn ($sq) => $sq->whereNull('tanggal_kadaluarsa')->orWhere('tanggal_kadaluarsa', '>', $now->copy()->addDays(90))),
            'expiring' => $query->whereBetween('tanggal_kadaluarsa', [$now, $now->copy()->addDays(90)]),
            'kadaluarsa' => $query->where('tanggal_kadaluarsa', '<', $now),
            default => null,
        };

        $paginator = $query->paginate(25);

        return response()->json([
            'data' => $paginator->getCollection()->map(fn ($c) => [
                'nama' => $c->nama,
                'gelar' => $c->gelar,
                'skema' => $c->skema,
                'kategori' => $c->kategori,
                'nomor_sertifikat' => $c->nomor_sertifikat,
                'tanggal_kadaluarsa' => $c->tanggal_kadaluarsa?->translatedFormat('d M Y'),
                'status' => $c->status,
            ]),
            'total' => $paginator->total(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
        ]);
    }

    public function kegiatan()
    {
        $kegiatan = Kegiatan::aktif()->paginate(12);

        return view('kegiatan.index', compact('kegiatan'))
            ->with('activeNav', '')
            ->with('SEOData', new SEOData(
                title: 'Kegiatan & Pelatihan',
                description: 'Dokumentasi kegiatan sertifikasi, pelatihan, dan asesmen kompetensi yang diselenggarakan LSP Edukia bersama mitra industri dan perguruan tinggi.',
                schema: SchemaCollection::initialize()
                    ->addBreadcrumbs(fn (BreadcrumbListSchema $b) => $b->prependBreadcrumbs([
                        'Beranda' => url('/'),
                    ])),
            ));
    }
}
