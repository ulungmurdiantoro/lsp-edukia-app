<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Sertifikat;

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
        return view('index', compact('schemes', 'kegiatan'))->with('activeNav', 'home');
    }

    public function informasi()
    {
        return view('informasi-publik')->with('activeNav', 'informasi');
    }

    public function tentang()
    {
        return view('tantang-kami')->with('activeNav', 'tentang');
    }

    public function skema()
    {
        return view('skema-sertifikasi')->with('activeNav', 'skema');
    }

    public function sertifikat()
    {
        $sertifikats = Sertifikat::tampil()->orderByDesc('tanggal_terbit')->get();
        $stats = [
            'total'      => $sertifikats->count(),
            'aktif'      => $sertifikats->where('status', 'aktif')->count(),
            'expiring'   => $sertifikats->where('status', 'expiring')->count(),
            'kadaluarsa' => $sertifikats->where('status', 'kadaluarsa')->count(),
        ];
        return view('sertifikat', compact('sertifikats', 'stats'))->with('activeNav', 'sertifikat');
    }

    public function kegiatan()
    {
        $kegiatan = Kegiatan::aktif()->paginate(12);
        return view('kegiatan.index', compact('kegiatan'))->with('activeNav', '');
    }
}
