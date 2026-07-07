<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Sumber data tunggal 26 skema sertifikasi LSP Edukia (data referensi statis).
 * Dipakai oleh halaman daftar skema, halaman detail per-skema, hub bidang, dan sitemap.
 * Setiap skema punya URL terindeks sendiri: /skema-sertifikasi/{slug}.
 */
class Skemas
{
    /**
     * Slug skema yang telah berlisensi KAN (7 dari 26 skema).
     * Skema di luar daftar ini ditandai "Belum Berlisensi KAN".
     */
    public const LISENSI_KAN = [
        'auditor-internal-spmi-iso-21001',
        'lead-auditor-spmi-iso-21001',
        'lead-implementer-spmi-iso-21001',
        'training-of-trainer-tot-obe',
        'implementer-tata-kelola-perguruan-tinggi',
        'auditor-internal-laboratorium-iso-17025',
        'lead-implementer-laboratorium-iso-17025',
    ];

    /** Jumlah skema yang sudah berlisensi KAN. */
    public static function lisensiCount(): int
    {
        return count(self::LISENSI_KAN);
    }

    /** Definisi bidang (kategori tampilan) + judul kelompok. */
    public static function bidangs(): array
    {
        return [
            'spmi' => ['label' => 'SPMI ISO 21001',      'judul' => 'Personil Sistem Penjaminan Mutu Internal (SPMI) Terintegrasi ISO 21001:2018'],
            'pt' => ['label' => 'Perguruan Tinggi',    'judul' => 'Personil Organisasi Perguruan Tinggi'],
            'lab17025' => ['label' => 'Lab ISO 17025',       'judul' => 'Personil Manajemen Laboratorium Standar ISO/IEC 17025:2017'],
            'lifting' => ['label' => 'Lifting Engineering', 'judul' => 'Industrial Engineering & Lifting'],
            'labtest' => ['label' => 'Lab & Pengujian',     'judul' => 'Laboratorium & Pengujian / Laboratory & Testing'],
            'manajemen' => ['label' => 'Sistem Manajemen',    'judul' => 'Sistem Manajemen & Governance'],
            'riset' => ['label' => 'Research & Innovation', 'judul' => 'Research & Innovation'],
        ];
    }

    public static function all(): Collection
    {
        return collect(self::data())->map(function (array $s): array {
            $bidang = self::bidangs()[$s['bidang']];
            $s['bidang_label'] = $bidang['label'];
            $s['bidang_judul'] = $bidang['judul'];
            $s['jumlah_unit'] = count($s['units']);
            $s['lisensi_kan'] = in_array($s['slug'], self::LISENSI_KAN, true);

            return $s;
        });
    }

    public static function find(string $slug): ?array
    {
        return self::all()->firstWhere('slug', $slug);
    }

    public static function byBidang(string $bidang): Collection
    {
        return self::all()->where('bidang', $bidang)->values();
    }

    /** Skema lain dalam bidang yang sama (untuk internal linking). */
    public static function related(array $skema, int $limit = 4): Collection
    {
        return self::all()
            ->where('bidang', $skema['bidang'])
            ->where('slug', '!=', $skema['slug'])
            ->take($limit)
            ->values();
    }

    private static function u(string $kode, string $judul): array
    {
        return ['kode' => $kode, 'judul' => $judul];
    }

    private static function data(): array
    {
        return [
            [
                'slug' => 'auditor-internal-spmi-iso-21001', 'badge' => 'A', 'bidang' => 'spmi', 'popular' => false,
                'nama' => 'Auditor Internal SPMI Terintegrasi ISO 21001:2018',
                'kode' => 'EDUKIA-AIL-2024-001', 'jenis_kemasan' => 'Auditor Internal SPMI terintegrasi ISO 21001:2018',
                'gelar' => 'CEA (Certified Educational Auditor)',
                'persyaratan' => ['Pendidikan minimal S2', 'Pengalaman kerja di bidang Perguruan Tinggi', 'Memiliki Sertifikat Pelatihan Auditor Internal'],
                'units' => [
                    self::u('SP.AIL.001.01', 'Memahami Pengetahuan Dasar Terkait Audit'),
                    self::u('SP.AIL.002.01', 'Melaksanakan Kegiatan Audit Internal'),
                    self::u('SP.AIL.003.01', 'Memahami Konsep Integrasi SPMI dan ISO 21001:2018'),
                    self::u('SP.AIL.004.01', 'Mengevaluasi Penerapan Integrasi Siklus Plan ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.AIL.005.01', 'Mengevaluasi Penerapan Integrasi Siklus Do ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.AIL.006.01', 'Mengevaluasi Penerapan Integrasi Siklus Check ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.AIL.007.01', 'Mengevaluasi Penerapan Integrasi Siklus Act ISO 21001:2018 ke dalam SPMI'),
                ],
            ],
            [
                'slug' => 'lead-auditor-spmi-iso-21001', 'badge' => 'B', 'bidang' => 'spmi', 'popular' => false,
                'nama' => 'Lead Auditor SPMI Terintegrasi ISO 21001:2018',
                'kode' => 'EDUKIA-LAD-2024-002', 'jenis_kemasan' => 'Lead Auditor SPMI terintegrasi ISO 21001:2018',
                'gelar' => 'CELA (Certified Educational Lead Auditor)',
                'persyaratan' => ['Pendidikan minimal S2', 'Pengalaman kerja di bidang Perguruan Tinggi', 'Memiliki Sertifikat Pelatihan Auditor Internal', 'Pengalaman sebagai Ketua Auditor'],
                'units' => [
                    self::u('SP.LAD.001.01', 'Memahami Pengetahuan Dasar Terkait Audit'),
                    self::u('SP.LAD.002.01', 'Melaksanakan Kegiatan Audit Internal'),
                    self::u('SP.LAD.003.01', 'Memahami Konsep Integrasi SPMI dan ISO 21001:2018'),
                    self::u('SP.LAD.004.01', 'Mengevaluasi Penerapan Integrasi Siklus Plan ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.LAD.005.01', 'Mengevaluasi Penerapan Integrasi Siklus Do ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.LAD.006.01', 'Mengevaluasi Penerapan Integrasi Siklus Check ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.LAD.007.01', 'Mengevaluasi Penerapan Integrasi Siklus Act ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.LAD.008.01', 'Mengelola Program Audit Internal'),
                ],
            ],
            [
                'slug' => 'lead-implementer-spmi-iso-21001', 'badge' => 'C', 'bidang' => 'spmi', 'popular' => false,
                'nama' => 'Lead Implementer SPMI Terintegrasi ISO 21001:2018',
                'kode' => 'EDUKIA-IMR-2024-003', 'jenis_kemasan' => 'Lead Implementer SPMI Terintegrasi ISO 21001:2018',
                'gelar' => 'CQAI (Certified Quality Assurance Implementer)',
                'persyaratan' => ['Pendidikan minimal S2', 'Pengalaman kerja di bidang Perguruan Tinggi', 'Memiliki Sertifikat Pelatihan SPMI / ISO 21001:2018'],
                'units' => [
                    self::u('SP.IMR.001.01', 'Mengelola Implementasi Standar'),
                    self::u('SP.IMR.002.01', 'Memahami Konsep SPMI Terintegrasi ISO 21001:2018'),
                    self::u('SP.IMR.003.01', 'Menyiapkan Kebutuhan Dokumen SPMI'),
                    self::u('SP.IMR.004.01', 'Menerapkan Siklus Plan ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.IMR.005.01', 'Menerapkan Siklus Do ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.IMR.006.01', 'Menerapkan Siklus Check ISO 21001:2018 ke dalam SPMI'),
                    self::u('SP.IMR.007.01', 'Menerapkan Siklus Act ISO 21001:2018 ke dalam SPMI'),
                ],
            ],
            [
                'slug' => 'training-of-trainer-tot-obe', 'badge' => 'D', 'bidang' => 'pt', 'popular' => true,
                'nama' => 'Training of Trainer (ToT) Outcome Based Education (OBE)',
                'kode' => 'EDUKIA-ToT-2024-004', 'jenis_kemasan' => 'Training of Trainer (ToT) Outcome Based Education (OBE)',
                'gelar' => 'CLOT (Certified Learning Outcome Trainer)',
                'persyaratan' => ['Pendidikan minimal S2', 'Pengalaman kerja di bidang Perguruan Tinggi', 'Memiliki Sertifikat Pelatihan Kurikulum OBE / Pelatihan yang relevan'],
                'units' => [
                    self::u('SP.ToT.001.01', 'Mendesain Program Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.002.01', 'Menyusun RPS dan Bahan Ajar Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.003.01', 'Merencanakan Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.004.01', 'Melaksanakan Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.005.01', 'Mengevaluasi Hasil Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.006.01', 'Mengembangkan Program Pembelajaran Outcome Based Education (OBE)'),
                ],
            ],
            [
                'slug' => 'implementer-tata-kelola-perguruan-tinggi', 'badge' => 'E', 'bidang' => 'pt', 'popular' => false,
                'nama' => 'Implementer Tata Kelola Organisasi Perguruan Tinggi',
                'kode' => 'EDUKIA-TKO-2024-005', 'jenis_kemasan' => 'Implementer Tata Kelola Organisasi Perguruan Tinggi',
                'gelar' => 'CEGI (Certified Educational Governance Implementer)',
                'persyaratan' => ['Pendidikan minimal S2', 'Pengalaman kerja di bidang Perguruan Tinggi', 'Memiliki Sertifikat Pelatihan relevan dengan Tata Kelola PT'],
                'units' => [
                    self::u('SP.TKO.001.01', 'Menyusun Rencana Bisnis Organisasi Perguruan Tinggi'),
                    self::u('SP.TKO.002.01', 'Merancang Design Organisasi Perguruan Tinggi (Membangun proses bisnis)'),
                    self::u('SP.TKO.003.01', 'Mengelola Tata Pamong Organisasi Perguruan Tinggi'),
                    self::u('SP.TKO.004.01', 'Mengembangkan Pola Kepemimpinan'),
                    self::u('SP.TKO.005.01', 'Mengelola Organisasi Perguruan Tinggi'),
                    self::u('SP.TKO.006.01', 'Menerapkan Etika dan Integritas Organisasi Perguruan Tinggi'),
                ],
            ],
            [
                'slug' => 'auditor-internal-laboratorium-iso-17025', 'badge' => 'F', 'bidang' => 'lab17025', 'popular' => false,
                'nama' => 'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017',
                'kode' => 'EDUKIA-AUI-2024-006', 'jenis_kemasan' => 'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017',
                'gelar' => 'CLIA (Certified Laboratory Internal Auditor)',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan Auditor Internal & ISO 17025:2017'],
                'units' => [
                    self::u('SP.AUI.001.01', 'Memahami Pengetahuan Dasar terkait Audit Internal'),
                    self::u('SP.AUI.002.01', 'Melaksanakan Kegiatan Audit Internal'),
                    self::u('SP.AUI.003.01', 'Memahami Konsep Audit Internal ISO/IEC 17025:2017'),
                    self::u('SP.AUI.004.01', 'Mengevaluasi Penerapan Siklus Plan ISO/IEC 17025:2017'),
                    self::u('SP.AUI.005.01', 'Mengevaluasi Penerapan Siklus Do ISO/IEC 17025:2017'),
                    self::u('SP.AUI.006.01', 'Mengevaluasi Penerapan Siklus Check ISO/IEC 17025:2017'),
                    self::u('SP.AUI.007.01', 'Mengevaluasi Penerapan Siklus Act ISO/IEC 17025:2017'),
                    self::u('SP.AUI.008.01', 'Mengelola Program Audit Internal'),
                ],
            ],
            [
                'slug' => 'lead-implementer-laboratorium-iso-17025', 'badge' => 'G', 'bidang' => 'lab17025', 'popular' => true,
                'nama' => 'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017',
                'kode' => 'EDUKIA-LIM-2024-007', 'jenis_kemasan' => 'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017',
                'gelar' => 'CLLI (Certified Laboratory Lead Implementer)',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan Auditor Internal & ISO 17025:2017'],
                'units' => [
                    self::u('SP.LIM.001.01', 'Memahami Implementasi dan Interpretasi Standar ISO/IEC 17025:2017'),
                    self::u('SP.LIM.002.01', 'Menyiapkan Kebutuhan Dokumen ISO/IEC 17025:2017'),
                    self::u('SP.LIM.003.01', 'Menerapkan Manajemen Laboratorium'),
                    self::u('SP.LIM.004.01', 'Menerapkan Siklus Plan ISO/IEC 17025:2017'),
                    self::u('SP.LIM.005.01', 'Menerapkan Siklus Do ISO/IEC 17025:2017'),
                    self::u('SP.LIM.006.01', 'Menerapkan Siklus Check ISO/IEC 17025:2017'),
                    self::u('SP.LIM.007.01', 'Menerapkan Siklus Act ISO/IEC 17025:2017'),
                ],
            ],
            [
                'slug' => 'lifting-engineer-medium-lifting', 'badge' => 'H', 'bidang' => 'lifting', 'popular' => false,
                'nama' => 'Lifting Engineer for Medium Lifting',
                'kode' => 'EDUKIA-LFM-2024-008', 'jenis_kemasan' => 'Lifting Engineer for Medium Lifting',
                'persyaratan' => ['Pendidikan minimal D3 Teknik', 'Fresh graduated atau pengalaman kerja di bidang Lifting', 'Memiliki Sertifikat Pelatihan Lifting Engineer for Medium Lifting'],
                'units' => [
                    self::u('F.410140.001.01', 'Menerapkan Komunikasi di Tempat Kerja'),
                    self::u('F.42LFE00.001.1', 'Menyusun pekerjaan persiapan perencanaan operasi pesawat angkat & angkut'),
                    self::u('F.42LFE00.002.1', 'Menyusun rencana operasi pengangkatan (lifting plan) untuk beban kurang dari 50 ton'),
                    self::u('F.42LFE00.003.1', 'Melakukan kajian risiko dan pengendaliannya'),
                    self::u('F.42LFE00.004.1', 'Mengawasi proses pengangkatan dan pemasangan beban sesuai Lifting Plan'),
                    self::u('F.42LFE00.005.1', 'Melakukan evaluasi kinerja pelaksanaan Lifting Plan'),
                ],
            ],
            [
                'slug' => 'lifting-engineer-heavy-critical-lifting', 'badge' => 'I', 'bidang' => 'lifting', 'popular' => false,
                'nama' => 'Lifting Engineer for Heavy & Critical Lifting Operation',
                'kode' => 'EDUKIA-LFH-2024-009', 'jenis_kemasan' => 'Lifting Engineer for Heavy & Critical Lifting Operation',
                'persyaratan' => ['Pendidikan minimal D3 Teknik', 'Fresh graduated atau pengalaman kerja di bidang Lifting', 'Memiliki Sertifikat Competent Person for Medium Lifting Operation'],
                'units' => [
                    self::u('F.410140.001.01', 'Menerapkan Komunikasi di Tempat Kerja'),
                    self::u('F.42LFE00.001.1', 'Menyusun pekerjaan persiapan perencanaan operasi pesawat angkat & angkut'),
                    self::u('F.42LFE00.002.1', 'Menyusun rencana operasi pengangkatan (lifting plan) untuk beban lebih dari 50 ton atau berjenis critical lifting'),
                    self::u('F.42LFE00.003.1', 'Melakukan kajian risiko dan pengendaliannya'),
                    self::u('F.42LFE00.004.1', 'Mengawasi proses pengangkatan dan pemasangan beban sesuai Lifting Plan'),
                    self::u('F.42LFE00.005.1', 'Melakukan evaluasi kinerja pelaksanaan Lifting Plan'),
                ],
            ],
            [
                'slug' => '2d-lifting-designer', 'badge' => 'J', 'bidang' => 'lifting', 'popular' => false,
                'nama' => '2D Lifting Designer', 'kode' => 'EDUKIA-LDT-2024-010', 'jenis_kemasan' => 'Lifting Drafter',
                'persyaratan' => ['Pendidikan minimal SMK/SMA', 'Fresh graduated atau pengalaman kerja di bidang CAD Drafter', 'Memiliki Sertifikat Pelatihan Lifting Drafter'],
                'units' => [
                    self::u('SP.LDT.001.01', 'Menerapkan Komunikasi di Tempat Kerja'),
                    self::u('SP.LDT.002.01', 'Memahami Spesifikasi Crane & Lifting Gear'),
                    self::u('SP.LDT.003.01', 'Memahami Kaidah Operasi Lifting yang Aman'),
                    self::u('SP.LDT.004.01', 'Memahami Lifting/Rigging Study'),
                    self::u('SP.LDT.005.01', 'Mampu membuat Lifting Plan Drawing 2D'),
                ],
            ],
            [
                'slug' => '3d-lifting-designer', 'badge' => 'K', 'bidang' => 'lifting', 'popular' => false,
                'nama' => '3D Lifting Designer', 'kode' => 'EDUKIA-DLD-2024-011', 'jenis_kemasan' => '3D Lifting Designer',
                'persyaratan' => ['Pendidikan minimal SMK/SMA', 'Fresh graduated atau pengalaman kerja di bidang Lifting Drafter', 'Memiliki Sertifikat Lifting Drafter'],
                'units' => [
                    self::u('SP.DLD.001.01', 'Menerapkan Komunikasi di Tempat Kerja'),
                    self::u('SP.DLD.002.01', 'Memahami Spesifikasi Crane & Lifting Gear'),
                    self::u('SP.DLD.003.01', 'Memahami Kaidah Operasi Lifting yang Aman'),
                    self::u('SP.DLD.004.01', 'Memahami Lifting/Rigging Study'),
                    self::u('SP.DLD.005.01', 'Mampu membuat Lifting Modelling 3D & Lifting Plan Drawing'),
                ],
            ],
            [
                'slug' => 'laboratory-quality-system-officer-iso-17025', 'badge' => 'L', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Laboratory Quality System Officer ISO/IEC 17025', 'kode' => 'EDUKIA-LQO-2024-012', 'jenis_kemasan' => 'Laboratory Quality System Officer ISO/IEC 17025',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017'],
                'units' => [
                    self::u('SP.LQO.001.01', 'Memahami Prinsip Ketidakberpihakan dan Kerahasiaan (Klausul 4 ISO 17025)'),
                    self::u('SP.LQO.002.01', 'Memahami Struktur Organisasi Laboratorium yang Sesuai (Klausul 5 ISO 17025)'),
                    self::u('SP.LQO.003.01', 'Memahami Pengelolaan Persyaratan Sumber Daya (Klausul 6 ISO 17025)'),
                    self::u('SP.LQO.004.01', 'Memahami dan Menganalisis Persyaratan Proses (Klausul 7 ISO 17025)'),
                    self::u('SP.LQO.005.01', 'Memahami Pengembangan Sistem Manajemen Laboratorium (Klausul 8 ISO 17025)'),
                ],
            ],
            [
                'slug' => 'food-safety-management-officer', 'badge' => 'M', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Food Safety Management Officer / Petugas Sistem Keamanan Pangan', 'kode' => 'EDUKIA-FMO-2024-013', 'jenis_kemasan' => 'Food Safety Management Officer',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman produksi pangan 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan HACCP, ISO 22000, atau CPPOB/GMP'],
                'units' => [
                    self::u('SP.FMO.001.01', 'Menguasai Prinsip Dasar dan Regulasi Keamanan Pangan'),
                    self::u('SP.FMO.002.01', 'Mengimplementasikan Program Prasyarat (PRPs - Prerequisite Programs)'),
                    self::u('SP.IKP.003.01', 'Mengembangkan dan Menerapkan Rencana HACCP'),
                    self::u('SP.IKP.004.01', 'Mengelola Pengendalian Operasional Keamanan Pangan'),
                    self::u('SP.IKP.005.01', 'Melaksanakan Verifikasi dan Peningkatan Berkelanjutan FSMS'),
                    self::u('SP.IKP.006.01', 'Mengelola Komunikasi dan Pelatihan Keamanan Pangan'),
                ],
            ],
            [
                'slug' => 'panelis-terlatih-pengujian-sensori-pangan', 'badge' => 'N', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Panelis Terlatih Pengujian Sensori Pangan', 'kode' => 'EDUKIA-PSP-2024-014', 'jenis_kemasan' => 'Panelis Terlatih Pengujian Sensori Pangan',
                'persyaratan' => ['Pendidikan minimal D3/S1 Teknologi Pangan, Gizi, Kimia, Biologi, atau Tek. Hasil Pertanian', 'Fresh graduated atau magang di laboratorium pangan minimal 3 bulan', 'Memiliki Sertifikat Pelatihan Pengujian Sensori Pangan'],
                'units' => [
                    self::u('SP.PSP.001.01', 'Menguasai Prinsip Fundamental Analisis Sensori dan Fisiologi Indrawi'),
                    self::u('SP.PSP.002.01', 'Melaksanakan Prosedur Uji Pembedaan (Discrimination Testing)'),
                    self::u('SP.PSP.003.01', 'Melaksanakan Prosedur Uji Deskriptif Kuantitatif (Quantitative Descriptive Analysis)'),
                    self::u('SP.PSP.004.01', 'Menerapkan Praktik Laboratorium Sensori yang Baik (Good Sensory Practices)'),
                    self::u('SP.PSP.005.01', 'Mengelola Kinerja dan Konsistensi Penilaian Sensori Pribadi'),
                ],
            ],
            [
                'slug' => 'glp-laboratory-technician', 'badge' => 'O', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'GLP Laboratory Technician / Teknisi Laboratorium Berbasis GLP', 'kode' => 'EDUKIA-GLP-2024-015', 'jenis_kemasan' => 'GLP Laboratory Technician',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017'],
                'units' => [
                    self::u('SP.GLP.001.01', 'Melakukan Persiapan Penerapan GLP'),
                    self::u('SP.GLP.002.01', 'Melaksanakan Pengujian Sesuai Prinsip GLP'),
                    self::u('SP.GLP.003.01', 'Melakukan Pengendalian Mutu dan Data'),
                    self::u('SP.GLP.004.01', 'Mengelola Limbah dan Pasca Pengujian'),
                ],
            ],
            [
                'slug' => 'laboratory-hse-officer-k3l', 'badge' => 'P', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Laboratory HSE Officer / Petugas K3L Laboratorium', 'kode' => 'EDUKIA-K3L-2024-016', 'jenis_kemasan' => 'Laboratory HSE Officer / Petugas K3L Laboratorium',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017, ISO 14001, ISO 45001'],
                'units' => [
                    self::u('SP.K3L.001.01', 'Melakukan Identifikasi Bahaya dan Penilaian Risiko (HIRADC) di Laboratorium'),
                    self::u('SP.K3L.002.01', 'Mengelola Penyimpanan dan Penanganan Bahan Kimia Berbahaya (B3)'),
                    self::u('SP.K3L.003.01', 'Melakukan Pengelolaan dan Penyimpanan Limbah B3 Laboratorium'),
                    self::u('SP.K3L.004.01', 'Mengelola Tindakan Tanggap Darurat di Laboratorium'),
                    self::u('SP.K3L.005.01', 'Melakukan Inspeksi K3 dan Lingkungan Kerja Laboratorium'),
                ],
            ],
            [
                'slug' => 'laboratory-operations-officer', 'badge' => 'Q', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Laboratory Operations Officer / Pranata Laboratorium', 'kode' => 'EDUKIA-LOP-2024-017', 'jenis_kemasan' => 'Laboratory Operations Officer / Pranata Laboratorium',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017'],
                'units' => [
                    self::u('SP.LOP.001.01', 'Menetapkan Konteks Organisasi dan Perencanaan Mutu (Plan)'),
                    self::u('SP.LOP.002.01', 'Mengelola Sumber Daya dan Operasional (Do)'),
                    self::u('SP.LOP.003.01', 'Melakukan Evaluasi Kinerja (Check)'),
                    self::u('SP.LOP.004.01', 'Melakukan Peningkatan Berkelanjutan (Act)'),
                ],
            ],
            [
                'slug' => 'quality-management-system-iso-9001-officer', 'badge' => 'R', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Quality Management System (ISO 9001) Officer', 'kode' => 'EDUKIA-QMS-2024-018', 'jenis_kemasan' => 'Quality Management System (ISO 9001) Officer',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman industri 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan ISO/IEC 9001:2015'],
                'units' => [
                    self::u('SP.QMS.001.01', 'Menganalisis Konteks Organisasi dan Pihak Berkepentingan'),
                    self::u('SP.QMS.002.01', 'Menyusun Perencanaan Mutu dan Manajemen Risiko'),
                    self::u('SP.QMS.003.01', 'Mengelola Sumber Daya dan Informasi Terdokumentasi'),
                    self::u('SP.QMS.004.01', 'Mengendalikan Operasional dan Penyedia Eksternal'),
                    self::u('SP.QMS.005.01', 'Melakukan Evaluasi Kinerja dan Peningkatan Berkelanjutan'),
                ],
            ],
            [
                'slug' => 'qc-laboratory-analyst', 'badge' => 'S', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'QC Laboratory Analyst / Analis QC Laboratorium', 'kode' => 'EDUKIA-QCA-2024-019', 'jenis_kemasan' => 'QC Laboratory Analyst / Analis QC Laboratorium',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab 2 tahun, atau D3/S1 fresh graduate', 'Memiliki Sertifikat Pelatihan QC / ISO 9001:2015 / ISO 17025:2017'],
                'units' => [
                    self::u('SP.QCA.001.01', 'Melakukan Kaji Ulang Permintaan, Tender, dan Kontrak Pengujian'),
                    self::u('SP.QCA.002.01', 'Memilih, Memverifikasi, dan Memvalidasi Metode Pengujian'),
                    self::u('SP.QCA.003.01', 'Melaksanakan Pengambilan Sampel (Sampling)'),
                    self::u('SP.QCA.004.01', 'Menangani dan Menyiapkan Sampel untuk Analisis'),
                    self::u('SP.QCA.005.01', 'Membuat dan Mengelola Rekaman Teknis Pengujian'),
                    self::u('SP.QCA.006.01', 'Melaksanakan Penjaminan Mutu Hasil Pengujian'),
                    self::u('SP.QCA.007.01', 'Mengevaluasi Ketidakpastian Pengukuran'),
                    self::u('SP.QCA.008.01', 'Menyusun Laporan Hasil Uji'),
                    self::u('SP.QCA.009.01', 'Mengidentifikasi dan Mengendalikan Pekerjaan yang Tidak Sesuai'),
                ],
            ],
            [
                'slug' => 'quality-assurance-officer', 'badge' => 'T', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Quality Assurance Officer', 'kode' => 'EDUKIA-QAO-2024-020', 'jenis_kemasan' => 'Quality Assurance Officer',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman QA 2 tahun, atau D3/S1 fresh graduate', 'Memiliki Sertifikat Pelatihan QAQC / ISO 9001 / ISO 17025'],
                'units' => [
                    self::u('SP.QAO.001.01', 'Mengelola dan Mengendalikan Dokumen Sistem Manajemen Mutu'),
                    self::u('SP.QAO.002.01', 'Mengimplementasikan Sistem Manajemen Mutu Sesuai Standar yang Berlaku'),
                    self::u('SP.QAO.003.01', 'Melaksanakan Audit Internal Sistem Manajemen Mutu'),
                    self::u('SP.QAO.004.01', 'Mengidentifikasi dan Mengendalikan Ketidaksesuaian'),
                    self::u('SP.QAO.005.01', 'Melaksanakan Tindakan Korektif dan Tindakan Pencegahan'),
                    self::u('SP.QAO.006.01', 'Melakukan Analisis Risiko dan Peluang dalam Sistem Manajemen Mutu'),
                    self::u('SP.QAO.007.01', 'Melakukan Pemantauan, Pengukuran, dan Evaluasi Kinerja Mutu'),
                    self::u('SP.QAO.008.01', 'Melaksanakan Pengendalian Rekaman dan Pelaporan Kinerja Mutu'),
                    self::u('SP.QAO.009.01', 'Menerapkan Prinsip Perbaikan Berkelanjutan (Continuous Improvement)'),
                ],
            ],
            [
                'slug' => 'regulatory-affairs-officer', 'badge' => 'V', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Regulatory Affairs Officer', 'kode' => 'EDUKIA-RAQ-2024-022', 'jenis_kemasan' => 'Regulatory Affairs Officer',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman QA industri 2 tahun, atau D3/S1 fresh graduate', 'Memiliki Sertifikat Pelatihan ISO 9001 / GMP (Good Manufacturing Practices)'],
                'units' => [
                    self::u('SP.RAQ.001.01', 'Menerapkan Prinsip Kepatuhan Regulasi dan Etika Profesi'),
                    self::u('SP.RAQ.002.01', 'Menyusun dan Mengevaluasi Dokumen Registrasi dan Perizinan Produk'),
                    self::u('SP.RAQ.003.01', 'Melakukan Proses Pengajuan Registrasi dan Perizinan Produk kepada Otoritas Terkait'),
                    self::u('SP.RAQ.004.01', 'Melakukan Pemantauan Perubahan Regulasi dan Analisis Dampaknya'),
                    self::u('SP.RAQ.005.01', 'Mengelola Arsip dan Sistem Dokumentasi Regulatory Affairs'),
                    self::u('SP.RAQ.006.01', 'Melakukan Evaluasi Kepatuhan Produk dan Menyusun Tindak Lanjut Ketidaksesuaian'),
                ],
            ],
            [
                'slug' => 'sustainability-officer', 'badge' => 'W', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Sustainability Officer', 'kode' => 'EDUKIA-SBO-2024-023', 'jenis_kemasan' => 'Sustainability Officer',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab/industri 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko'],
                'units' => [
                    self::u('SP.SBO.001.01', 'Mengidentifikasi aspek dan dampak keberlanjutan operasional'),
                    self::u('SP.SBO.002.01', 'Merencanakan program peningkatan kinerja lingkungan dan sosial'),
                    self::u('SP.SBO.003.01', 'Mengimplementasikan program keberlanjutan organisasi'),
                    self::u('SP.SBO.004.01', 'Memantau dan mengevaluasi capaian target keberlanjutan'),
                    self::u('SP.SBO.005.01', 'Mengomunikasikan kinerja keberlanjutan internal'),
                    self::u('SP.SBO.006.01', 'Mendukung pengelolaan data kinerja keberlanjutan'),
                ],
            ],
            [
                'slug' => 'esg-officer', 'badge' => 'X', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'ESG Officer', 'kode' => 'EDUKIA-ESG-2024-024', 'jenis_kemasan' => 'ESG Officer',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab/industri 2 tahun, atau D3 fresh graduate', 'Memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko'],
                'units' => [
                    self::u('SP.ESG.001.01', 'Mengidentifikasi dan memetakan pemangku kepentingan'),
                    self::u('SP.ESG.002.01', 'Mengidentifikasi isu dan risiko ESG'),
                    self::u('SP.ESG.003.01', 'Melakukan penilaian dampak dan risiko ESG'),
                    self::u('SP.ESG.004.01', 'Menyusun matriks materialitas'),
                    self::u('SP.ESG.005.01', 'Mengintegrasikan risiko ESG ke dalam manajemen risiko organisasi'),
                    self::u('SP.ESG.006.01', 'Menyiapkan informasi pengungkapan ESG'),
                    self::u('SP.ESG.007.01', 'Mendukung tata kelola dan kebijakan ESG organisasi'),
                ],
            ],
            [
                'slug' => 'environmental-management-system-iso-14001-officer', 'badge' => 'Y', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Environmental Management System (ISO 14001) Officer', 'kode' => 'EDUKIA-EMS-2024-025', 'jenis_kemasan' => 'Implementer Sistem Manajemen Lingkungan',
                'persyaratan' => ['Pendidikan minimal D3/S1 Teknik Lingkungan, Teknik Kimia, atau bidang terkait', 'Fresh graduated atau magang di bidang EMS minimal 3 bulan', 'Memiliki Sertifikat Pelatihan ISO 14001:2015 EMS atau pelatihan terkait'],
                'units' => [
                    self::u('SP.EMS.001.01', 'Menerapkan Konteks Organisasi dalam SML'),
                    self::u('SP.EMS.002.01', 'Mengidentifikasi Aspek dan Dampak Lingkungan'),
                    self::u('SP.EMS.003.01', 'Mengidentifikasi dan Mengevaluasi Kewajiban Kepatuhan'),
                    self::u('SP.EMS.004.01', 'Menyusun Sasaran dan Program Lingkungan'),
                    self::u('SP.EMS.005.01', 'Mengendalikan Operasional dan Dokumen SML'),
                    self::u('SP.EMS.006.01', 'Melaksanakan Pemantauan dan Pengukuran Kinerja Lingkungan'),
                    self::u('SP.EMS.007.01', 'Melaksanakan Audit Internal SML'),
                    self::u('SP.EMS.008.01', 'Menindaklanjuti Ketidaksesuaian dan Tindakan Perbaikan'),
                ],
            ],
            [
                'slug' => 'corporate-legal-officer', 'badge' => 'Z', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Corporate Legal Officer', 'kode' => 'EDUKIA-CLO-2024-026', 'jenis_kemasan' => 'Sertifikasi Corporate Legal Officer',
                'persyaratan' => ['Pendidikan minimal D3/S1 Ilmu Hukum (terbuka untuk disiplin ilmu lain)', 'Fresh graduated dan/atau pengalaman kerja di perusahaan atau korporasi', 'Memiliki Sertifikat Pelatihan Corporate Legal Officer'],
                'units' => [
                    self::u('SP.CLO.001.01', 'Melakukan Pemenuhan Perizinan Usaha dan Legalitas Korporasi'),
                    self::u('SP.CLO.002.01', 'Menyusun dan Meninjau Dokumen Hukum Perusahaan'),
                    self::u('SP.CLO.003.01', 'Menyusun Legal Opinion dan Rekomendasi Hukum'),
                    self::u('SP.CLO.004.01', 'Mengelola Administrasi dan Arsip Hukum Korporasi'),
                    self::u('SP.CLO.005.01', 'Menyusun Laporan Legal dan Kepatuhan Secara Berkala'),
                    self::u('SP.CLO.006.01', 'Melakukan Monitoring dan Analisis Perubahan Regulasi'),
                    self::u('SP.CLO.007.01', 'Melakukan Legal Due Diligence & Audit Kepatuhan Hukum'),
                    self::u('SP.CLO.008.01', 'Mengelola Hubungan dengan Regulasi dan Stakeholder'),
                    self::u('SP.CLO.009.01', 'Menangani Pemeriksaan dan Investigasi oleh Regulator'),
                ],
            ],
            [
                'slug' => 'research-and-development-officer', 'badge' => 'U', 'bidang' => 'riset', 'popular' => false,
                'nama' => 'Research and Development Officer', 'kode' => 'EDUKIA-RDO-2024-021', 'jenis_kemasan' => 'Research and Development Officer',
                'persyaratan' => ['Minimal SMA/SMK dengan pengalaman lab/industri 2 tahun, atau D3/S1 fresh graduate', 'Memiliki Sertifikat Pelatihan ISO 17025 / GMP (CPPOB, CPAKB, CPOIB)'],
                'units' => [
                    self::u('SP.RDO.001.01', 'Merencanakan Kegiatan Penelitian dan Pengembangan'),
                    self::u('SP.RDO.002.01', 'Melaksanakan Kegiatan Penelitian dan Pengembangan'),
                    self::u('SP.RDO.003.01', 'Melakukan Analisis dan Validasi Hasil Penelitian'),
                    self::u('SP.RDO.004.01', 'Mengelola Dokumentasi dan Pelaporan Kegiatan R&D'),
                    self::u('SP.RDO.005.01', 'Mengelola Implementasi dan Peningkatan Berkelanjutan Hasil Pengembangan'),
                ],
            ],
        ];
    }
}
