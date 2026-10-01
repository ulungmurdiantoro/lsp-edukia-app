<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Sumber data tunggal 26 skema sertifikasi LSP Edukia (data referensi statis).
 * Dipakai oleh halaman daftar skema, halaman detail per-skema, hub bidang, dan sitemap.
 * Setiap skema punya URL terindeks sendiri: /skema-sertifikasi/{slug}.
 *
 * Isi tiap skema mengikuti dokumen skema resminya (folder "Skema Terakreditasi" untuk
 * skema 01–07 dan "Skema PRL" untuk 08–26, tanggal efektif 15 September 2026).
 * Bagian yang identik di semua dokumen — code of conduct poin a–i, standar kelulusan,
 * survailen, dan resertifikasi — disimpan sekali di konstanta/helper di bawah; tiap
 * skema hanya menyimpan bagian yang khusus miliknya.
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

    /** Aturan pelaksanaan (code of conduct) poin a–i — sama di semua dokumen skema. */
    public const KODE_ETIK_UMUM = [
        'Bekerja hanya dalam lingkup kompetensi dan kewenangan yang dimiliki.',
        'Memberikan informasi, data, hasil analisis, laporan, atau pernyataan profesional secara benar, objektif, dapat dipertanggungjawabkan, dan tidak menyesatkan.',
        'Menjaga kerahasiaan informasi yang diperoleh dalam pelaksanaan pekerjaan, kecuali pengungkapan diwajibkan oleh hukum atau telah mendapat kewenangan yang sah.',
        'Menghindari konflik kepentingan dan mengungkapkan potensi konflik kepentingan kepada pihak yang relevan.',
        'Mematuhi peraturan perundang-undangan, standar, prosedur, dan persyaratan profesional yang relevan.',
        'Tidak menyalahgunakan sertifikat, logo, tanda sertifikasi, atau status sertifikasi.',
        'Tidak melakukan tindakan yang dapat merusak integritas proses profesional maupun reputasi sertifikasi.',
        'Menjaga dan mengembangkan kompetensi sesuai perkembangan bidang profesinya.',
        'Bersedia memenuhi ketentuan LSP mengenai pemeliharaan, penggunaan, pembekuan, pencabutan, dan sertifikasi ulang sesuai skema yang berlaku.',
    ];

    public const SURVAILEN_TIDAK_DITERAPKAN = 'Survailen tidak diterapkan pada skema ini berdasarkan kajian risiko LSP Edukia. Selama masa berlaku sertifikat, pemegang sertifikat tetap wajib menjaga kompetensi, mematuhi aturan pelaksanaan (code of conduct), menggunakan sertifikat sesuai ketentuan, dan mengikuti perkembangan standar, regulasi, teknologi, dan praktik profesional yang relevan. Informasi atau keluhan atas dugaan pelanggaran tetap dapat ditindaklanjuti LSP sesuai prosedur.';

    public const SURVAILEN_DITERAPKAN = 'Survailen diterapkan pada skema ini berdasarkan kajian risiko LSP Edukia, untuk memastikan pemegang sertifikat tetap memelihara kompetensi selama masa berlaku sertifikat. Survailen dilaksanakan sekurang-kurangnya 1 (satu) kali pada bulan ke-18 sampai ke-24 masa sertifikasi melalui verifikasi bukti pemeliharaan kompetensi. Hasilnya dikategorikan Memenuhi, Perlu Klarifikasi/Verifikasi Tambahan, atau Tidak Memenuhi; bila bukti belum memadai, LSP dapat melakukan verifikasi tambahan.';

    public const RESERTIFIKASI = 'Permohonan sertifikasi ulang diajukan paling lambat 2 bulan sebelum masa berlaku sertifikat berakhir. Resertifikasi dilakukan dengan uji kompetensi kembali, melalui proses pendaftaran, asesmen, dan pengambilan keputusan yang sama dengan sertifikasi awal.';

    /** Metode penilaian yang dipakai sebagian besar skema (ujian tulis, lisan studi kasus, tugas keterampilan). */
    private const METODE_STANDAR = [
        'Ujian tulis (pilihan ganda dan esai) untuk menilai pemahaman dan penguasaan pengetahuan terhadap elemen kompetensi dan kriteria unjuk kerja.',
        'Ujian lisan berbasis studi kasus untuk menilai kemampuan menjelaskan, menginterpretasikan, memberikan argumentasi, mengidentifikasi ketidaksesuaian, dan menganalisis permasalahan.',
        'Tugas keterampilan untuk mengevaluasi pengetahuan, keterampilan, dan kemampuan peserta.',
    ];

    /** Metode penilaian skema Lifting Engineering (ujian tulis pilihan ganda + ujian praktek). */
    private const METODE_PRAKTEK = [
        'Ujian tulis pilihan ganda untuk mengukur pengetahuan dan pemahaman terhadap elemen kompetensi dan kriteria unjuk kerja.',
        'Ujian praktek untuk mengukur keterampilan, kreativitas, dan kompetensi peserta secara langsung (nyata) sesuai keahlian di bidang skema.',
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
            'spmi' => ['label' => 'SPMI ISO 21001',      'judul' => 'Personil Sistem Penjaminan Mutu Internal (SPMI) Terintegrasi ISO 21001:2025'],
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
            $s['kode_etik'] = [...self::KODE_ETIK_UMUM, $s['kode_etik_khusus']];

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

    /** Dokumen skema rujukan — semua dokumen saat ini efektif 15 September 2026. */
    private static function dok(int $revisi): array
    {
        return ['revisi' => $revisi, 'tgl_efektif' => '15 September 2026'];
    }

    private static function kelulusan(int $nilaiMinimal): array
    {
        return [
            "Asesi dinyatakan lulus uji kompetensi apabila memperoleh nilai minimal {$nilaiMinimal}. Asesi yang tidak lulus dapat mengikuti remedial.",
            'Asesi wajib mengerjakan ujian secara jujur dan mandiri, tanpa bekerja sama, alat bantu tambahan, atau perantara ujian. Pelanggaran atau perilaku tidak jujur membatalkan ujian, nilai dianggap 0, dan asesi dinyatakan tidak lulus.',
            'Jawaban yang terindikasi plagiarisme (kata, kalimat, data, atau informasi sama persis) diberi skor 0, asesi dinyatakan tidak lulus, dan tidak dapat mengikuti ujian ulang sampai batas waktu yang ditentukan LSP Edukia.',
        ];
    }

    /** Asesmen ujian tulis (pilihan ganda + esai) 70% dan ujian lisan + keterampilan 30%, lulus ≥ 60. */
    private static function asesmenTulis(array $metode = self::METODE_STANDAR, string $komponenLisan = 'Ujian Lisan + Keterampilan'): array
    {
        return [
            'metode' => $metode,
            'bobot_soal' => [
                ['metode' => 'Pilihan Ganda', 'soal' => '100', 'durasi' => '120 menit', 'bobot' => '65%'],
                ['metode' => 'Esai', 'soal' => '10', 'durasi' => '90 menit', 'bobot' => '35%'],
            ],
            'bobot_rekap' => [
                ['metode' => 'Ujian Tulis (Pilihan Ganda + Esai)', 'bobot' => '70%'],
                ['metode' => $komponenLisan, 'bobot' => '30%'],
            ],
            'kelulusan' => self::kelulusan(60),
        ];
    }

    /** Asesmen skema Lifting Engineering: pilihan ganda + ujian praktek, lulus ≥ 70. */
    private static function asesmenPraktek(array $bobotSoal): array
    {
        return [
            'metode' => self::METODE_PRAKTEK,
            'bobot_soal' => array_map(
                fn (array $r): array => ['metode' => $r[0], 'soal' => $r[1], 'durasi' => $r[2], 'bobot' => $r[3]],
                $bobotSoal
            ),
            'bobot_rekap' => [],
            'kelulusan' => self::kelulusan(70),
        ];
    }

    private static function survailen(string $metode, string $kriteria): array
    {
        return ['metode' => $metode, 'kriteria' => $kriteria];
    }

    private static function data(): array
    {
        return [
            [
                'slug' => 'auditor-internal-spmi-iso-21001', 'badge' => 'A', 'bidang' => 'spmi', 'popular' => false,
                'nama' => 'Auditor Internal SPMI Terintegrasi ISO 21001:2025',
                'kode' => 'EDUKIA-AIL-2024-001', 'jenis_kemasan' => 'Auditor Internal SPMI Terintegrasi ISO 21001:2025',
                'gelar' => 'CEA (Certified Educational Auditor)',
                'persyaratan' => [
                    'Pendidikan minimal S2',
                    'Memiliki pengalaman kerja di bidang Pendidikan Tinggi',
                    'Memiliki Sertifikat Pelatihan Auditor Internal',
                ],
                'units' => [
                    self::u('SP.AIL.001.01', 'Memahami Pengetahuan Dasar Terkait Audit'),
                    self::u('SP.AIL.002.01', 'Melaksanakan Kegiatan Audit Internal'),
                    self::u('SP.AIL.003.01', 'Memahami Konsep Integrasi SPMI dan ISO 21001:2025'),
                    self::u('SP.AIL.004.01', 'Mengevaluasi Penerapan Integrasi Siklus Plan ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.AIL.005.01', 'Mengevaluasi Penerapan Integrasi Siklus Do ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.AIL.006.01', 'Mengevaluasi Penerapan Integrasi Siklus Check ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.AIL.007.01', 'Mengevaluasi Penerapan Integrasi Siklus Act ISO 21001:2025 ke dalam SPMI'),
                ],
                'dokumen' => self::dok(4),
                'ruang_lingkup' => 'Standar kompetensi kerja dasar bagi personel organisasi pendidikan tinggi di bidang penjaminan mutu yang bertugas utama melakukan audit internal SPMI terintegrasi ISO 21001:2025.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga objektivitas dan ketidakberpihakan audit; tidak memanipulasi bukti/temuan; menjaga kerahasiaan informasi auditi; menyampaikan temuan berdasarkan bukti yang dapat diverifikasi; menghindari audit terhadap pekerjaan sendiri apabila dapat mengganggu objektivitas; serta berkomunikasi secara profesional dan tidak mengintimidasi auditi.',
                'survailen' => null,
            ],
            [
                'slug' => 'lead-auditor-spmi-iso-21001', 'badge' => 'B', 'bidang' => 'spmi', 'popular' => false,
                'nama' => 'Lead Auditor SPMI Terintegrasi ISO 21001:2025',
                'kode' => 'EDUKIA-LAD-2024-002', 'jenis_kemasan' => 'Lead Auditor SPMI Terintegrasi ISO 21001:2025',
                'gelar' => 'CELA (Certified Educational Lead Auditor)',
                'persyaratan' => [
                    'Pendidikan minimal S2',
                    'Memiliki pengalaman kerja di bidang Pendidikan Tinggi',
                    'Memiliki Sertifikat Pelatihan Auditor Internal',
                    'Memiliki pengalaman sebagai Auditor Internal',
                ],
                'units' => [
                    self::u('SP.LAD.001.01', 'Memahami Pengetahuan Dasar Terkait Audit'),
                    self::u('SP.LAD.002.01', 'Melaksanakan Kegiatan Audit Internal'),
                    self::u('SP.LAD.003.01', 'Memahami Konsep Integrasi SPMI dan ISO 21001:2025'),
                    self::u('SP.LAD.004.01', 'Mengevaluasi Penerapan Integrasi Siklus Plan ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.LAD.005.01', 'Mengevaluasi Penerapan Integrasi Siklus Do ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.LAD.006.01', 'Mengevaluasi Penerapan Integrasi Siklus Check ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.LAD.007.01', 'Mengevaluasi Penerapan Integrasi Siklus Act ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.LAD.008.01', 'Mengelola Program Audit Internal'),
                ],
                'dokumen' => self::dok(4),
                'ruang_lingkup' => 'Standar kompetensi kerja dasar bagi personel organisasi pendidikan tinggi di bidang penjaminan mutu yang bertugas utama menjadi ketua dalam audit internal SPMI terintegrasi ISO 21001:2025.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Memenuhi seluruh etika auditor serta menunjukkan kepemimpinan yang adil dan objektif terhadap tim audit; membagi tugas secara profesional; tidak menekan anggota tim untuk mengubah temuan tanpa dasar bukti; menyelesaikan perbedaan pendapat secara profesional; serta bertanggung jawab terhadap integritas kesimpulan audit.',
                'survailen' => null,
            ],
            [
                'slug' => 'lead-implementer-spmi-iso-21001', 'badge' => 'C', 'bidang' => 'spmi', 'popular' => false,
                'nama' => 'Lead Implementer SPMI Terintegrasi ISO 21001:2025',
                'kode' => 'EDUKIA-IMR-2024-003', 'jenis_kemasan' => 'Lead Implementer SPMI Terintegrasi ISO 21001:2025',
                'gelar' => 'CQAI (Certified Quality Assurance Implementer)',
                'persyaratan' => [
                    'Pendidikan minimal S2',
                    'Memiliki pengalaman kerja di bidang Pendidikan Tinggi',
                    'Memiliki Sertifikat Pelatihan SPMI / ISO 21001:2025',
                ],
                'units' => [
                    self::u('SP.IMR.001.01', 'Mengelola Implementasi Standar'),
                    self::u('SP.IMR.002.01', 'Memahami Konsep SPMI Terintegrasi ISO 21001:2025'),
                    self::u('SP.IMR.003.01', 'Menyiapkan Kebutuhan Dokumen SPMI'),
                    self::u('SP.IMR.004.01', 'Menerapkan Siklus Plan ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.IMR.005.01', 'Menerapkan Siklus Do ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.IMR.006.01', 'Menerapkan Siklus Check ISO 21001:2025 ke dalam SPMI'),
                    self::u('SP.IMR.007.01', 'Menerapkan Siklus Act ISO 21001:2025 ke dalam SPMI'),
                ],
                'dokumen' => self::dok(4),
                'ruang_lingkup' => 'Standar kompetensi kerja dasar bagi personel organisasi pendidikan tinggi di bidang penjaminan mutu yang bertugas utama menginisiasi pemenuhan standar mutu organisasi pendidikan tinggi dengan menerapkan sistem manajemen terintegrasi.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga integritas dalam penerapan sistem; tidak merekayasa dokumen/rekaman untuk menunjukkan kepatuhan semu; mempertimbangkan kebutuhan pemangku kepentingan secara objektif; mengomunikasikan kesenjangan implementasi secara transparan; serta tidak menyembunyikan ketidaksesuaian yang diketahui.',
                'survailen' => null,
            ],
            [
                'slug' => 'training-of-trainer-tot-obe', 'badge' => 'D', 'bidang' => 'pt', 'popular' => true,
                'nama' => 'Training of Trainer (ToT) Outcome Based Education (OBE)',
                'kode' => 'EDUKIA-ToT-2024-004', 'jenis_kemasan' => 'Training of Trainer (ToT) Outcome Based Education (OBE)',
                'gelar' => 'CLOT (Certified Learning Outcome Trainer)',
                'persyaratan' => [
                    'Pendidikan minimal S2',
                    'Memiliki pengalaman kerja di bidang Pendidikan Tinggi',
                    'Memiliki Sertifikat Pelatihan Kurikulum OBE / Pelatihan penyusunan kurikulum yang relevan',
                ],
                'units' => [
                    self::u('SP.ToT.001.01', 'Mendesain Program Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.002.01', 'Menyusun RPS dan Bahan Ajar Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.003.01', 'Merencanakan Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.004.01', 'Melaksanakan Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.005.01', 'Mengevaluasi Hasil Pembelajaran Outcome Based Education (OBE)'),
                    self::u('SP.ToT.006.01', 'Mengembangkan Program Pembelajaran Outcome Based Education (OBE)'),
                ],
                'dokumen' => self::dok(3),
                'ruang_lingkup' => 'Persyaratan dasar bagi trainer dalam pengembangan standar pembelajaran, pelaksanaan (delivery) pembelajaran, dan asesmen pembelajaran Outcome Based Education (OBE) di organisasi pendidikan tinggi.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menghormati peserta dan keberagaman kebutuhan belajar; tidak melakukan diskriminasi atau intimidasi; menyampaikan materi sesuai kompetensi dan bukti yang dapat dipertanggungjawabkan; memberikan penilaian secara adil; menjaga kerahasiaan informasi peserta; serta tidak menyalahgunakan hubungan fasilitator–peserta.',
                'survailen' => null,
            ],
            [
                'slug' => 'implementer-tata-kelola-perguruan-tinggi', 'badge' => 'E', 'bidang' => 'pt', 'popular' => false,
                'nama' => 'Implementer Tata Kelola Organisasi Perguruan Tinggi',
                'kode' => 'EDUKIA-TKO-2024-005', 'jenis_kemasan' => 'Implementer Tata Kelola Organisasi Perguruan Tinggi',
                'gelar' => 'CEGI (Certified Educational Governance Implementer)',
                'persyaratan' => [
                    'Pendidikan minimal S2',
                    'Memiliki pengalaman kerja di bidang Pendidikan Tinggi',
                    'Memiliki Sertifikat Pelatihan yang relevan dengan tata kelola organisasi Pendidikan Tinggi',
                ],
                'units' => [
                    self::u('SP.TKO.001.01', 'Menyusun Rencana Bisnis Organisasi Pendidikan Tinggi'),
                    self::u('SP.TKO.002.01', 'Merancang Design Organisasi Pendidikan Tinggi (Membangun proses bisnis)'),
                    self::u('SP.TKO.003.01', 'Mengelola Tata Pamong Organisasi Pendidikan Tinggi'),
                    self::u('SP.TKO.004.01', 'Mengembangkan Pola Kepemimpinan'),
                    self::u('SP.TKO.005.01', 'Mengelola Organisasi Pendidikan Tinggi'),
                    self::u('SP.TKO.006.01', 'Menerapkan Etika dan Integritas Organisasi Pendidikan Tinggi'),
                ],
                'dokumen' => self::dok(3),
                'ruang_lingkup' => 'Standar kompetensi kerja bagi personel organisasi pendidikan tinggi dalam mengelola organisasi serta mengatur pembagian tugas, fungsi, wewenang, tanggung jawab, dan hubungan kerja setiap unit kerja untuk pelaksanaan program kegiatan.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjunjung akuntabilitas, transparansi, dan integritas tata kelola; menghindari konflik kepentingan; tidak memanipulasi data kelembagaan; menjaga kerahasiaan informasi organisasi; serta memberikan rekomendasi berdasarkan data dan ketentuan yang berlaku.',
                'survailen' => null,
            ],
            [
                'slug' => 'auditor-internal-laboratorium-iso-17025', 'badge' => 'F', 'bidang' => 'lab17025', 'popular' => false,
                'nama' => 'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017',
                'kode' => 'EDUKIA-AUI-2024-006', 'jenis_kemasan' => 'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017',
                'gelar' => 'CLIA (Certified Laboratory Internal Auditor)',
                'persyaratan' => [
                    'Pendidikan minimal SMA/SMK dengan pengalaman kerja di bidang laboratorium minimal 2 tahun, atau minimal D3 dengan pengalaman kerja di bidang laboratorium',
                    'Memiliki Sertifikat Pelatihan Pemahaman ISO/IEC 17025:2017',
                    'Memiliki Sertifikat Pelatihan Audit Internal ISO/IEC 17025:2017',
                ],
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
                'dokumen' => self::dok(6),
                'ruang_lingkup' => 'Standar kompetensi kerja dasar bagi personel auditor internal laboratorium untuk melakukan audit internal terhadap persyaratan standar ISO/IEC 17025:2017, kepatuhan regulasi, dan peningkatan berkelanjutan.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga independensi dan objektivitas audit; menggunakan bukti objektif; menjaga kerahasiaan data laboratorium/pelanggan; tidak mengubah atau menghilangkan temuan; menghindari konflik kepentingan; serta menghormati ketentuan keselamatan saat berada di laboratorium.',
                'survailen' => null,
            ],
            [
                'slug' => 'lead-implementer-laboratorium-iso-17025', 'badge' => 'G', 'bidang' => 'lab17025', 'popular' => true,
                'nama' => 'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017',
                'kode' => 'EDUKIA-LIM-2024-007', 'jenis_kemasan' => 'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017',
                'gelar' => 'CLLI (Certified Laboratory Lead Implementer)',
                'persyaratan' => [
                    'Pendidikan minimal SMA/SMK dengan pengalaman kerja di bidang laboratorium minimal 2 tahun, atau minimal D3 dengan pengalaman kerja di bidang laboratorium',
                    'Memiliki Sertifikat Pelatihan Pemahaman ISO/IEC 17025:2017',
                ],
                'units' => [
                    self::u('SP.LIM.001.01', 'Memahami Implementasi dan Interpretasi Standar ISO/IEC 17025:2017'),
                    self::u('SP.LIM.002.01', 'Menyiapkan Kebutuhan Dokumen ISO/IEC 17025:2017'),
                    self::u('SP.LIM.003.01', 'Menerapkan Manajemen Laboratorium'),
                    self::u('SP.LIM.004.01', 'Menerapkan Siklus Plan ISO/IEC 17025:2017'),
                    self::u('SP.LIM.005.01', 'Menerapkan Siklus Do ISO/IEC 17025:2017'),
                    self::u('SP.LIM.006.01', 'Menerapkan Siklus Check ISO/IEC 17025:2017'),
                    self::u('SP.LIM.007.01', 'Menerapkan Siklus Act ISO/IEC 17025:2017'),
                ],
                'dokumen' => self::dok(5),
                'ruang_lingkup' => 'Standar kompetensi kerja dasar bagi Kepala Laboratorium (Lead Implementer) untuk menjaga kualitas, keandalan, dan efisiensi operasional laboratorium sehingga berjalan lancar dan sesuai standar yang ditetapkan.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga integritas sistem dan rekaman laboratorium; tidak membuat bukti kepatuhan fiktif; menjaga kerahasiaan hasil/data pelanggan; melaporkan kesenjangan implementasi secara objektif; serta mempertimbangkan ketidakberpihakan dan validitas kegiatan laboratorium.',
                'survailen' => null,
            ],
            [
                'slug' => 'lifting-engineer-medium-lifting', 'badge' => 'H', 'bidang' => 'lifting', 'popular' => false,
                'nama' => 'Lifting Engineer for Medium Lifting',
                'kode' => 'EDUKIA-LML-2025-008', 'jenis_kemasan' => 'Lifting Engineer for Medium Lifting',
                'persyaratan' => [
                    'Pendidikan minimal D3 Teknik dan memiliki Sertifikat Pelatihan terkait Lifting Engineer, atau',
                    'Pendidikan minimal D3 Teknik dan memiliki pengalaman kerja di bidang Lifting, atau',
                    'Mahasiswa D3/S1 Teknik yang memiliki Sertifikat Pelatihan terkait Lifting Engineer',
                ],
                'units' => [
                    self::u('SP.LML.001.01', 'Menetapkan Kategori Lifting Operation'),
                    self::u('SP.LML.001.02', 'Memahami Standar Operasi Lifting & Lifting Equipment Nasional dan Internasional'),
                    self::u('F.42LFE00.001.1', 'Menyusun pekerjaan persiapan perencanaan operasi pesawat angkat & angkut'),
                    self::u('F.42LFE00.002.1', 'Menyusun rencana operasi pengangkatan (lifting plan) untuk beban kurang dari 50 ton'),
                    self::u('F.42LFE00.003.1', 'Melakukan kajian risiko dan pengendaliannya'),
                    self::u('F.42LFE00.004.1', 'Mengawasi proses pengangkatan dan pemasangan beban sesuai Lifting Plan'),
                    self::u('F.42LFE00.005.1', 'Melakukan evaluasi kinerja pelaksanaan Lifting Plan'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Lingkup pekerjaan Lifting Engineer for Medium Lifting mencakup perencanaan pengangkatan dan pemasangan beban, serta evaluasi pengangkatan beban.',
                'asesmen' => self::asesmenPraktek([
                    ['Pilihan Ganda', '100', '60 menit', '20%'],
                    ['Praktek Calculation', '1 kasus', '300 menit', '50%'],
                    ['Praktek Gambar', '1 kasus', '180 menit', '30%'],
                ]),
                'kode_etik_khusus' => 'Mengutamakan keselamatan dibanding target waktu/biaya; tidak menyetujui lifting plan yang diketahui tidak memenuhi persyaratan; menggunakan data teknis yang valid; tidak mengubah parameter keselamatan tanpa justifikasi teknis; serta menghentikan atau merekomendasikan penghentian pekerjaan apabila ditemukan kondisi tidak aman sesuai kewenangannya.',
                'survailen' => self::survailen(
                    'Verifikasi bukti aktivitas profesional selama periode sertifikasi, berupa logbook/rekaman pekerjaan atau proyek lifting, surat keterangan pengalaman kerja, portofolio pekerjaan, bukti pelatihan/continuous professional development (CPD), dan/atau bukti lain yang dapat diverifikasi.',
                    'Pemegang sertifikat dapat menunjukkan bukti keterlibatan dalam aktivitas yang relevan dengan ruang lingkup sertifikasi dan bukti pemeliharaan/pembaruan kompetensi, serta tidak terdapat informasi terverifikasi mengenai pelanggaran serius terhadap persyaratan sertifikasi atau code of conduct.'
                ),
            ],
            [
                'slug' => 'lifting-engineer-heavy-critical-lifting', 'badge' => 'I', 'bidang' => 'lifting', 'popular' => false,
                'nama' => 'Lifting Engineer for Heavy & Critical Lifting',
                'kode' => 'EDUKIA-LHC-2025-009', 'jenis_kemasan' => 'Lifting Engineer for Heavy & Critical Lifting',
                'persyaratan' => [
                    'Pendidikan minimal D3 Teknik dan memiliki Sertifikat Pelatihan terkait Heavy & Critical Lifting, atau',
                    'Pendidikan minimal D3 Teknik dan memiliki pengalaman kerja di bidang Lifting, atau',
                    'Mahasiswa D3/S1 Teknik yang memiliki Sertifikat Pelatihan terkait Heavy & Critical Lifting',
                ],
                'units' => [
                    self::u('SP.LHC.001.01', 'Mengetahui Kategori Lifting Operation'),
                    self::u('SP.LHC.001.02', 'Memahami Standar Operasi Lifting & Lifting Equipment Nasional dan Internasional'),
                    self::u('F.42LFE00.001.1', 'Menyusun pekerjaan persiapan perencanaan operasi pesawat angkat & angkut untuk kategori Heavy & Critical Lifting'),
                    self::u('F.42LFE00.002.1', 'Menyusun rencana operasi pengangkatan (lifting plan) untuk kategori Heavy & Critical Lifting'),
                    self::u('F.42LFE00.003.1', 'Melakukan kajian risiko dan pengendaliannya'),
                    self::u('F.42LFE00.004.1', 'Mengawasi proses pengangkatan dan pemasangan beban sesuai Lifting Plan'),
                    self::u('F.42LFE00.005.1', 'Melakukan evaluasi kinerja pelaksanaan Lifting Plan'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Lingkup pekerjaan Lifting Engineer for Heavy & Critical Lifting mencakup perencanaan pengangkatan dan pemasangan beban, serta evaluasi pengangkatan beban.',
                'asesmen' => self::asesmenPraktek([
                    ['Pilihan Ganda', '100', '60 menit', '20%'],
                    ['Praktek Calculation', '1 kasus', '300 menit', '50%'],
                    ['Praktek Gambar', '1 kasus', '180 menit', '30%'],
                ]),
                'kode_etik_khusus' => 'Memiliki standar perilaku keselamatan yang lebih ketat: tidak berkompromi terhadap batas kapasitas, konfigurasi, ground condition, rigging arrangement, atau parameter kritis; memastikan analisis didasarkan pada data yang dapat diverifikasi; mengungkapkan asumsi/keterbatasan analisis; serta menolak tekanan untuk menyetujui rencana yang secara teknis tidak dapat dipertanggungjawabkan.',
                'survailen' => self::survailen(
                    'Verifikasi bukti aktivitas profesional selama periode sertifikasi, berupa logbook/rekaman pekerjaan atau proyek lifting, surat keterangan pengalaman kerja, portofolio pekerjaan, bukti pelatihan/continuous professional development (CPD), dan/atau bukti lain yang dapat diverifikasi.',
                    'Pemegang sertifikat dapat menunjukkan bukti keterlibatan dalam aktivitas yang relevan dengan ruang lingkup sertifikasi dan bukti pemeliharaan/pembaruan kompetensi, serta tidak terdapat informasi terverifikasi mengenai pelanggaran serius terhadap persyaratan sertifikasi atau code of conduct.'
                ),
            ],
            [
                'slug' => '2d-lifting-designer', 'badge' => 'J', 'bidang' => 'lifting', 'popular' => false,
                'nama' => '2D Lifting Designer', 'kode' => 'EDUKIA-LDT-2025-010', 'jenis_kemasan' => '2D Lifting Drafter',
                'persyaratan' => [
                    'Pendidikan minimal SMA/SMK dan memiliki Sertifikat Pelatihan 2D Lifting Drafter/Designer, atau',
                    'Pendidikan minimal SMA/SMK dan memiliki pengalaman kerja di bidang 2D Lifting Drafter/Designer',
                ],
                'units' => [
                    self::u('SP.LDT.001.01', 'Mengetahui Kategori Lifting Operation'),
                    self::u('SP.LDT.002.01', 'Memahami Kaidah Operasi Lifting yang Aman'),
                    self::u('SP.LDT.003.01', 'Memahami Spesifikasi Crane & Lifting Gear'),
                    self::u('SP.LDT.004.01', 'Memahami Lifting/Rigging Study'),
                    self::u('SP.LDT.005.01', 'Mampu membuat Lifting Plan Drawing 2D'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Lingkup pekerjaan 2D Lifting Designer mencakup tanggung jawab menghasilkan gambar Lifting Plan yang berkualitas, lengkap, dan mudah dipahami oleh pihak lain yang terlibat dalam operasi lifting.',
                'asesmen' => self::asesmenPraktek([
                    ['Pilihan Ganda', '100', '60 menit', '30%'],
                    ['Praktek', '1 kasus', '180 menit', '70%'],
                ]),
                'kode_etik_khusus' => 'Menjaga ketelitian dan keterlacakan desain; menggunakan data/dimensi yang tervalidasi; tidak menghilangkan informasi teknis penting; melakukan pengendalian revisi gambar; tidak menggunakan atau mengesahkan desain di luar kompetensi/kewenangannya; serta segera mengoreksi kesalahan desain yang diketahui.',
                'survailen' => self::survailen(
                    'Verifikasi portofolio/desain, bukti keterlibatan dalam pekerjaan perancangan lifting, rekaman pengalaman profesional, dan/atau bukti pengembangan kompetensi terkait perangkat lunak, metode desain, standar, atau persyaratan teknis yang relevan. Bukti yang memuat informasi rahasia pemberi kerja dapat disamarkan (redacted) sepanjang informasi yang diperlukan untuk verifikasi tetap tersedia.',
                    'Pemegang sertifikat dapat menunjukkan aktivitas profesional yang relevan dan pemeliharaan kompetensi desain selama periode sertifikasi, dengan bukti yang terkait ruang lingkup sertifikasi dan dapat diverifikasi LSP.'
                ),
            ],
            [
                'slug' => '3d-lifting-designer', 'badge' => 'K', 'bidang' => 'lifting', 'popular' => false,
                'nama' => '3D Lifting Designer', 'kode' => 'EDUKIA-DLD-2025-011', 'jenis_kemasan' => '3D Lifting Designer',
                'persyaratan' => [
                    'Pendidikan minimal SMA/SMK dan memiliki Sertifikat Pelatihan 3D Lifting Drafter/Designer, atau',
                    'Pendidikan minimal SMA/SMK dan memiliki pengalaman kerja di bidang 3D Lifting Drafter/Designer',
                ],
                'units' => [
                    self::u('SP.DLD.001.01', 'Mengetahui Kategori Lifting Operation'),
                    self::u('SP.DLD.002.01', 'Memahami Kaidah Operasi Lifting yang Aman'),
                    self::u('SP.DLD.003.01', 'Memahami Spesifikasi Crane & Lifting Gear'),
                    self::u('SP.DLD.004.01', 'Memahami Lifting/Rigging Study'),
                    self::u('SP.DLD.005.01', 'Mampu membuat Lifting Modelling 3D & Lifting Plan Drawing'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Lingkup pekerjaan 3D Lifting Designer mencakup tanggung jawab menghasilkan gambar Lifting Plan yang berkualitas, lengkap, dan mudah dipahami oleh pihak lain yang terlibat dalam operasi lifting.',
                'asesmen' => self::asesmenPraktek([
                    ['Pilihan Ganda', '100', '60 menit', '30%'],
                    ['Praktek', '1 kasus', '240 menit', '70%'],
                ]),
                'kode_etik_khusus' => 'Menjaga integritas model dan data teknis; memastikan perubahan model terdokumentasi; tidak memanipulasi visualisasi sehingga menyembunyikan risiko/interferensi; menggunakan input teknis yang dapat dipertanggungjawabkan; serta mengomunikasikan keterbatasan/asumsi model kepada pihak terkait.',
                'survailen' => self::survailen(
                    'Verifikasi portofolio/desain, bukti keterlibatan dalam pekerjaan perancangan lifting, rekaman pengalaman profesional, dan/atau bukti pengembangan kompetensi terkait perangkat lunak, metode desain, standar, atau persyaratan teknis yang relevan. Bukti yang memuat informasi rahasia pemberi kerja dapat disamarkan (redacted) sepanjang informasi yang diperlukan untuk verifikasi tetap tersedia.',
                    'Pemegang sertifikat dapat menunjukkan aktivitas profesional yang relevan dan pemeliharaan kompetensi desain selama periode sertifikasi, dengan bukti yang terkait ruang lingkup sertifikasi dan dapat diverifikasi LSP.'
                ),
            ],
            [
                'slug' => 'laboratory-quality-system-officer-iso-17025', 'badge' => 'L', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Laboratory Quality System Officer ISO/IEC 17025 / Petugas Sistem Mutu Laboratorium ISO/IEC 17025',
                'kode' => 'EDUKIA-LQO-2025-012', 'jenis_kemasan' => 'Laboratory Quality System Officer ISO/IEC 17025 / Petugas Sistem Mutu Laboratorium ISO/IEC 17025',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di laboratorium atau bagian laboratorium di industri, dan memiliki Sertifikat Pelatihan ISO/IEC 17025:2017',
                    'Persyaratan 2: Fresh graduate D3 bidang sains atau teknik dengan pengalaman magang minimal 3 bulan di laboratorium atau bagian laboratorium di industri, atau memiliki Sertifikat Pelatihan ISO/IEC 17025:2017',
                ],
                'units' => [
                    self::u('SP.LQO.001.01', 'Memahami Prinsip Ketidakberpihakan dan Kerahasiaan (Klausul 4 ISO 17025)'),
                    self::u('SP.LQO.002.01', 'Memahami Struktur Organisasi Laboratorium yang Sesuai (Klausul 5 ISO 17025)'),
                    self::u('SP.LQO.003.01', 'Memahami Pengelolaan Persyaratan Sumber Daya (Klausul 6 ISO 17025)'),
                    self::u('SP.LQO.004.01', 'Memahami dan Menganalisis Persyaratan Proses (Klausul 7 ISO 17025)'),
                    self::u('SP.LQO.005.01', 'Memahami Pengembangan Sistem Manajemen Laboratorium (Klausul 8 ISO 17025)'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Menilai dan mensertifikasi kompetensi individu dalam memahami dan menginterpretasikan seluruh persyaratan ISO/IEC 17025:2017, mulai dari persyaratan umum (klausul 4) hingga persyaratan sistem manajemen (klausul 8).',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga kerahasiaan data laboratorium/pelanggan; tidak memanipulasi dokumen atau rekaman sistem; menyampaikan ketidaksesuaian secara objektif; menjaga ketidakberpihakan; serta memastikan pengendalian dokumen/rekaman dilakukan secara benar dan dapat ditelusuri.',
                'survailen' => null,
            ],
            [
                'slug' => 'food-safety-management-officer', 'badge' => 'M', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Food Safety Management Officer / Petugas Sistem Keamanan Pangan',
                'kode' => 'EDUKIA-FMO-2026-013', 'jenis_kemasan' => 'Food Safety Management Officer / Petugas Sistem Keamanan Pangan',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di laboratorium atau bagian laboratorium di industri, dan memiliki Sertifikat Pelatihan Penerapan HACCP, ISO 22000, CPPOB/GMP',
                    'Persyaratan 2: Fresh graduate D3 bidang sains dengan pengalaman magang minimal 3 bulan di bidang produksi, penjaminan mutu, atau keamanan pangan di industri pangan, atau memiliki Sertifikat Pelatihan Penerapan HACCP, ISO 22000, CPPOB/GMP setara 24 jam pelatihan',
                ],
                'units' => [
                    self::u('SP.FMO.001.01', 'Menguasai Prinsip Dasar dan Regulasi Keamanan Pangan'),
                    self::u('SP.FMO.002.01', 'Mengimplementasikan Program Prasyarat (PRPs - Prerequisite Programs)'),
                    self::u('SP.FMO.003.01', 'Mengembangkan dan Menerapkan Rencana HACCP'),
                    self::u('SP.FMO.004.01', 'Mengelola Pengendalian Operasional Keamanan Pangan'),
                    self::u('SP.FMO.005.01', 'Melaksanakan Verifikasi dan Peningkatan Berkelanjutan FSMS'),
                    self::u('SP.FMO.006.01', 'Mengelola Komunikasi dan Pelatihan Keamanan Pangan'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Ditujukan bagi profesional yang bertanggung jawab langsung atas implementasi, pemeliharaan, dan pemantauan harian sistem manajemen keamanan pangan (SMKP) di berbagai sektor rantai pasok pangan.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Mengutamakan keamanan pangan dan perlindungan konsumen; tidak menyembunyikan bahaya atau ketidaksesuaian yang berpotensi memengaruhi keamanan pangan; menggunakan data yang valid; menjaga keterlacakan informasi; serta menghindari konflik kepentingan dalam evaluasi risiko keamanan pangan.',
                'survailen' => null,
            ],
            [
                'slug' => 'panelis-terlatih-pengujian-sensori-pangan', 'badge' => 'N', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Panelis Terlatih Pengujian Sensori Pangan', 'kode' => 'EDUKIA-PSP-2026-014', 'jenis_kemasan' => 'Panelis Terlatih Pengujian Sensori Pangan',
                'persyaratan' => [
                    'Pendidikan minimal D3 atau S1 Teknologi Pangan, Ilmu Gizi, Kimia, Biologi, atau Teknologi Hasil Pertanian',
                    'Fresh graduate dan/atau memiliki pengalaman magang di industri pangan atau laboratorium pangan minimal 3 bulan, atau',
                    'Memiliki Sertifikat Pelatihan Pengujian Sensori Pangan',
                ],
                'units' => [
                    self::u('SP.PSP.001.01', 'Menguasai Prinsip Fundamental Analisis Sensori dan Fisiologi Indrawi'),
                    self::u('SP.PSP.002.01', 'Melaksanakan Prosedur Uji Pembedaan (Discrimination Testing)'),
                    self::u('SP.PSP.003.01', 'Melaksanakan Prosedur Uji Deskriptif Kuantitatif (Quantitative Descriptive Analysis)'),
                    self::u('SP.PSP.004.01', 'Menerapkan Praktik Laboratorium Sensori yang Baik (Good Sensory Practices)'),
                    self::u('SP.PSP.005.01', 'Mengelola Kinerja dan Konsistensi Penilaian Sensori Pribadi'),
                    self::u('SP.PSP.006.01', 'Menguasai Prinsip Fundamental Analisis Sensori dan Fisiologi Indrawi'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Kompetensi individu sebagai pelaksana pengujian sensori, khususnya uji pembedaan (discrimination testing) dan uji deskriptif (descriptive testing). Skema ini tidak mencakup peran Pemimpin Panel (Panel Leader).',
                'asesmen' => self::asesmenTulis([
                    'Ujian tulis (pilihan ganda dan esai) untuk mengukur pengetahuan dan pemahaman terhadap prinsip, prosedur, dan persyaratan pengujian sensori pangan.',
                    'Ujian lisan untuk mengonfirmasi dan/atau memperdalam bukti kompetensi dari metode lain, khususnya pemahaman prinsip, prosedur, kondisi pengujian, serta penerapan pengujian sensori pangan.',
                    'Ujian praktik untuk mendemonstrasikan secara langsung kemampuan sebagai panelis terlatih — pengenalan atribut sensori, membedakan sampel, menilai karakteristik sensori, mencatat hasil, dan menerapkan prosedur pengujian — yang dinilai dengan lembar observasi LSP Edukia.',
                ], 'Ujian Lisan + Praktik'),
                'kode_etik_khusus' => 'Memberikan respons sensori secara mandiri, jujur, dan tidak dipengaruhi panelis lain; tidak mendiskusikan sampel sebelum penilaian selesai; mengikuti instruksi persiapan panel; menginformasikan kondisi yang dapat memengaruhi kemampuan sensori; serta tidak mengidentifikasi/mencari informasi sampel dengan cara yang dapat menimbulkan bias.',
                'survailen' => self::survailen(
                    'Verifikasi bukti keterlibatan dalam kegiatan pengujian sensori dan/atau pemeliharaan kemampuan sensori, berupa logbook kegiatan, surat tugas dari tempat kerja, atau surat keterangan dari atasan.',
                    'Pemegang sertifikat dapat menunjukkan bahwa selama periode sertifikasi masih melakukan kegiatan yang relevan dan kemampuan sensori yang dipersyaratkan masih terpelihara.'
                ),
            ],
            [
                'slug' => 'glp-laboratory-technician', 'badge' => 'O', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'GLP Laboratory Officer / Petugas Laboratorium Berbasis GLP',
                'kode' => 'EDUKIA-GLP-2026-015', 'jenis_kemasan' => 'GLP Laboratory Officer / Petugas Laboratorium Berbasis GLP',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di laboratorium atau bagian laboratorium di industri, dan memiliki Sertifikat Pelatihan ISO/IEC 17025:2017',
                    'Persyaratan 2: Fresh graduate D3 bidang sains atau teknik dengan pengalaman magang minimal 3 bulan di laboratorium atau bagian laboratorium di industri, atau memiliki Sertifikat Pelatihan ISO/IEC 17025:2017',
                ],
                'units' => [
                    self::u('SP.GLP.001.01', 'Melakukan Persiapan Penerapan GLP'),
                    self::u('SP.GLP.002.01', 'Menganalisis Penerapan Prinsip GLP dalam Kegiatan Pengujian'),
                    self::u('SP.GLP.003.01', 'Melakukan Pengendalian Mutu dan Data'),
                    self::u('SP.GLP.004.01', 'Mengelola Limbah dan Pasca Pengujian'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Berlaku bagi personel yang menjalankan fungsi pengelolaan dan penerapan prinsip Good Laboratory Practice (GLP) pada fasilitas pengujian nonklinis — sistem mutu, integritas dan ketertelusuran data, dokumentasi dan rekaman, serta pengendalian kegiatan pengujian. Skema ini tidak mencakup pelaksanaan teknis metode pengujian tertentu.',
                'asesmen' => self::asesmenTulis([
                    'Ujian tulis (pilihan ganda dan esai) untuk menilai pemahaman dan penguasaan pengetahuan mengenai prinsip GLP.',
                    'Ujian lisan berbasis studi kasus untuk menilai kemampuan menjelaskan, menginterpretasikan, memberikan argumentasi, mengidentifikasi ketidaksesuaian, dan menganalisis permasalahan penerapan prinsip GLP.',
                    'Tugas keterampilan berbasis studi kasus untuk menilai kemampuan menelaah dokumen, data, rekaman, dan informasi kegiatan pengujian; menganalisis kesesuaiannya terhadap rencana analisis, SOP, dan prinsip GLP; mengidentifikasi penyimpangan dan risiko; serta menentukan tindakan yang sesuai.',
                ], 'Ujian Lisan + Tugas Keterampilan'),
                'kode_etik_khusus' => 'Menjunjung integritas data; tidak membuat, mengubah, menghapus, atau merekonstruksi data secara tidak sah; menjaga keterlacakan data dan dokumentasi; melaporkan penyimpangan secara objektif; menjaga kerahasiaan data; serta menganalisis penerapan GLP berdasarkan bukti, bukan asumsi.',
                'survailen' => null,
            ],
            [
                'slug' => 'laboratory-hse-officer-k3l', 'badge' => 'P', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Laboratory HSE Officer / Petugas K3L Laboratorium', 'kode' => 'EDUKIA-K3L-2026-016', 'jenis_kemasan' => 'Laboratory HSE Officer / Petugas K3L Laboratorium',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di laboratorium atau bagian laboratorium di industri, dan memiliki Sertifikat Pelatihan ISO/IEC 17025:2017, ISO 14001, ISO 45001',
                    'Persyaratan 2: Fresh graduate D3 bidang sains atau teknik dengan pengalaman magang minimal 3 bulan di laboratorium atau bagian laboratorium di industri, atau memiliki Sertifikat Pelatihan ISO/IEC 17025:2017, ISO 14001, ISO 45001',
                ],
                'units' => [
                    self::u('SP.K3L.001.01', 'Melakukan Identifikasi Bahaya dan Penilaian Risiko (HIRADC) di Laboratorium'),
                    self::u('SP.K3L.002.01', 'Mengelola Penyimpanan dan Penanganan Bahan Kimia Berbahaya (B3)'),
                    self::u('SP.K3L.003.01', 'Melakukan Pengelolaan dan Penyimpanan Limbah B3 Laboratorium'),
                    self::u('SP.K3L.004.01', 'Mengelola Tindakan Tanggap Darurat di Laboratorium'),
                    self::u('SP.K3L.005.01', 'Melakukan Inspeksi K3 dan Lingkungan Kerja Laboratorium'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Menilai kompetensi individu yang memegang peran operasional dalam implementasi sistem manajemen K3 dan Lingkungan (K3L) di laboratorium, termasuk laboratorium pengujian kimia dan fisika, mikrobiologi dan biologi molekuler, lingkungan, pendidikan dan penelitian, serta kalibrasi.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Mengutamakan keselamatan manusia dan lingkungan; tidak mengabaikan atau menyembunyikan bahaya; melaporkan kondisi/tindakan tidak aman; menjaga objektivitas penilaian risiko; tidak mengurangi pengendalian K3L hanya karena tekanan operasional; serta bertindak sesuai kewenangan dalam kondisi darurat.',
                'survailen' => self::survailen(
                    'Verifikasi bukti aktivitas profesional di bidang K3L laboratorium, bukti pelatihan atau refreshment, pembaruan pengetahuan mengenai regulasi/persyaratan K3L, rekaman profesional lain yang relevan, atau surat keterangan dari atasan.',
                    'Pemegang sertifikat dapat menunjukkan aktivitas yang relevan dan pemeliharaan kompetensi K3L, serta tidak terdapat informasi terverifikasi mengenai pelanggaran serius terhadap keselamatan, integritas profesional, atau persyaratan sertifikasi.'
                ),
            ],
            [
                'slug' => 'laboratory-operations-officer', 'badge' => 'Q', 'bidang' => 'labtest', 'popular' => false,
                'nama' => 'Laboratory Operations Officer / Pranata Laboratorium', 'kode' => 'EDUKIA-LOP-2026-017', 'jenis_kemasan' => 'Laboratory Operations Officer / Pranata Laboratorium',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di laboratorium atau bagian laboratorium di industri, dan memiliki Sertifikat Pelatihan ISO/IEC 17025:2017',
                    'Persyaratan 2: Fresh graduate D3 bidang sains atau teknik dengan pengalaman magang minimal 3 bulan di laboratorium atau bagian laboratorium di industri, atau memiliki Sertifikat Pelatihan ISO/IEC 17025:2017',
                ],
                'units' => [
                    self::u('SP.LOP.001.01', 'Menetapkan Konteks Organisasi dan Perencanaan Mutu (Plan)'),
                    self::u('SP.LOP.002.01', 'Mengelola Sumber Daya dan Operasional (Do)'),
                    self::u('SP.LOP.003.01', 'Melakukan Evaluasi Kinerja (Check)'),
                    self::u('SP.LOP.004.01', 'Melakukan Peningkatan Berkelanjutan (Act)'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Menilai kompetensi individu dalam mengelola sistem manajemen mutu laboratorium, mulai dari perencanaan strategis hingga evaluasi dan perbaikan.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga integritas operasional laboratorium; mematuhi SOP; menjaga fasilitas/peralatan dan sampel; tidak menggunakan peralatan di luar kewenangan/kompetensi; mencatat kegiatan secara benar; serta segera melaporkan penyimpangan, kerusakan, atau kondisi tidak sesuai.',
                'survailen' => self::survailen(
                    'Verifikasi bukti aktivitas profesional di bidang operasional laboratorium, rekaman pengalaman kerja, bukti pelatihan/refreshment, dan/atau bukti pemeliharaan kompetensi lain yang relevan.',
                    'Pemegang sertifikat dapat menunjukkan aktivitas profesional yang relevan dengan ruang lingkup sertifikasi dan bukti bahwa kompetensi yang dipersyaratkan tetap dipelihara.'
                ),
            ],
            [
                'slug' => 'quality-management-system-iso-9001-officer', 'badge' => 'R', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Quality Management System (ISO 9001) Officer', 'kode' => 'EDUKIA-QMS-2026-018', 'jenis_kemasan' => 'Quality Management System (ISO 9001) Officer',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun, dan memiliki Sertifikat Pelatihan ISO 9001',
                    'Persyaratan 2: Fresh graduate D3 bidang sains atau teknik dengan pengalaman magang minimal 3 bulan, atau memiliki Sertifikat Pelatihan ISO 9001',
                ],
                'units' => [
                    self::u('SP.QMS.001.01', 'Menganalisis Konteks Organisasi dan Pihak Berkepentingan'),
                    self::u('SP.QMS.002.01', 'Menyusun Perencanaan Mutu dan Manajemen Risiko'),
                    self::u('SP.QMS.003.01', 'Mengelola Sumber Daya dan Informasi Terdokumentasi'),
                    self::u('SP.QMS.004.01', 'Memantau Operasional dan Penyedia Eksternal'),
                    self::u('SP.QMS.005.01', 'Melakukan Evaluasi Kinerja dan Peningkatan Berkelanjutan'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Menilai kompetensi individu yang berperan sebagai Koordinator ISO, Quality Assurance (QA), Management Representative, atau anggota tim implementasi ISO 9001 di berbagai jenis organisasi — manufaktur, jasa, perkantoran, pendidikan, pemerintahan, dan nirlaba.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga objektivitas analisis sistem; tidak merekayasa bukti kepatuhan; melaporkan ketidaksesuaian secara faktual; menjaga kerahasiaan informasi organisasi; menghindari konflik kepentingan; serta mendorong perbaikan berdasarkan data dan bukti.',
                'survailen' => null,
            ],
            [
                'slug' => 'qc-laboratory-analyst', 'badge' => 'S', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'QC Laboratory Officer / Petugas QC Laboratorium', 'kode' => 'EDUKIA-QCA-2026-019', 'jenis_kemasan' => 'QC Laboratory Officer / Petugas QC Laboratorium',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di laboratorium atau bagian laboratorium di industri, dan memiliki Sertifikat Pelatihan Quality Control / ISO 9001:2015 / ISO/IEC 17025:2017',
                    'Persyaratan 2: Pendidikan minimal D3 atau S1 semua jurusan Teknik, Ilmu Gizi, Kimia, Biologi, atau Farmasi (terbuka juga bagi lulusan disiplin ilmu lain yang berminat di bidang quality control), fresh graduate dan/atau berpengalaman kerja di industri atau laboratorium, dan memiliki Sertifikat Pelatihan Quality Control / ISO 9001:2015 / ISO/IEC 17025:2017',
                ],
                'units' => [
                    self::u('SP.QCA.001.01', 'Melakukan Kaji Ulang Permintaan, Tender, dan Kontrak Pengujian'),
                    self::u('SP.QCA.002.01', 'Memilih, Memverifikasi, dan Memvalidasi Metode Pengujian'),
                    self::u('SP.QCA.003.01', 'Menganalisis Proses Pengambilan Sampel Sesuai Prosedur'),
                    self::u('SP.QCA.004.01', 'Menganalisis Penanganan dan Persiapan Sampel untuk Analisis'),
                    self::u('SP.QCA.005.01', 'Membuat dan Mengelola Rekaman Teknis Pengujian'),
                    self::u('SP.QCA.006.01', 'Melaksanakan Penjaminan Mutu Hasil Pengujian'),
                    self::u('SP.QCA.007.01', 'Mengevaluasi Ketidakpastian Pengukuran'),
                    self::u('SP.QCA.008.01', 'Menyusun Laporan Hasil Uji'),
                    self::u('SP.QCA.009.01', 'Mengidentifikasi dan Mengendalikan Pekerjaan yang Tidak Sesuai'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Berlaku bagi personel yang menjalankan fungsi pengendalian mutu, penelaahan, analisis, evaluasi, dan pengelolaan kegiatan yang berkaitan dengan proses pengujian laboratorium — mulai dari kaji ulang permintaan pengujian hingga pengendalian pekerjaan yang tidak sesuai.',
                'asesmen' => self::asesmenTulis([
                    self::METODE_STANDAR[0],
                    self::METODE_STANDAR[1],
                    'Tugas keterampilan berbasis studi kasus untuk menilai kemampuan menelaah dokumen, data, rekaman, dan informasi kegiatan pengujian; menganalisis kesesuaiannya terhadap rencana analisis dan SOP; mengidentifikasi penyimpangan dan risiko; serta menentukan tindakan yang sesuai.',
                ]),
                'kode_etik_khusus' => 'Menjaga integritas data QC; tidak mengubah, memilih, atau menghilangkan hasil untuk memenuhi spesifikasi; menganalisis proses sampling/preparasi berdasarkan bukti; melaporkan out-of-specification, penyimpangan, atau pekerjaan tidak sesuai secara objektif; serta menjaga keterlacakan sampel dan data.',
                'survailen' => null,
            ],
            [
                'slug' => 'quality-assurance-officer', 'badge' => 'T', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Quality Assurance Officer', 'kode' => 'EDUKIA-QAO-2026-020', 'jenis_kemasan' => 'Quality Assurance Officer',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di bagian quality assurance di industri, dan memiliki Sertifikat Pelatihan QA/QC / ISO 9001 / ISO 17025',
                    'Persyaratan 2: Pendidikan minimal D3 atau S1 semua jurusan Teknik, Ilmu Gizi, Kimia, Biologi, atau Farmasi (terbuka juga bagi lulusan disiplin ilmu lain), fresh graduate dan/atau berpengalaman kerja di industri, dan memiliki Sertifikat Pelatihan QA/QC / ISO 9001 / ISO 17025',
                ],
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
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Lingkup pekerjaan QA Officer mencakup perencanaan, penerapan, pemantauan, dan evaluasi sistem manajemen mutu di organisasi, agar kegiatan penjaminan mutu berjalan sistematis, konsisten, efektif, dan mendukung perbaikan berkelanjutan.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga independensi fungsi QA sesuai kewenangan; tidak menutupi ketidaksesuaian; tidak menyetujui bukti kepatuhan yang tidak memadai; menjaga kerahasiaan; menghindari konflik kepentingan; serta melakukan evaluasi dan pelaporan secara objektif.',
                'survailen' => null,
            ],
            [
                'slug' => 'regulatory-affairs-officer', 'badge' => 'V', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Regulatory Affairs Officer', 'kode' => 'EDUKIA-RAQ-2026-022', 'jenis_kemasan' => 'Regulatory Affairs Officer',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di bagian quality assurance di industri, dan memiliki Sertifikat Pelatihan ISO 9001 / GMP (Good Manufacturing Practices)',
                    'Persyaratan 2: Pendidikan minimal D3 atau S1 semua jurusan Teknik, Ilmu Gizi, Kimia, Biologi, atau Farmasi (terbuka juga bagi lulusan disiplin ilmu lain), fresh graduate dan/atau berpengalaman kerja di industri, dan memiliki Sertifikat Pelatihan ISO 9001 / GMP (Good Manufacturing Practices)',
                ],
                'units' => [
                    self::u('SP.RAQ.001.01', 'Menerapkan Prinsip Kepatuhan Regulasi dan Etika Profesi'),
                    self::u('SP.RAQ.002.01', 'Menyusun dan Mengevaluasi Dokumen Registrasi dan Perizinan Produk'),
                    self::u('SP.RAQ.003.01', 'Melakukan Proses Pengajuan Registrasi dan Perizinan Produk kepada Otoritas Terkait'),
                    self::u('SP.RAQ.004.01', 'Melakukan Pemantauan Perubahan Regulasi dan Analisis Dampaknya terhadap Produk/Perusahaan'),
                    self::u('SP.RAQ.005.01', 'Mengelola Arsip dan Sistem Dokumentasi Regulatory Affairs'),
                    self::u('SP.RAQ.006.01', 'Melakukan Evaluasi Kepatuhan Produk dan Menyusun Tindak Lanjut Ketidaksesuaian (Compliance Management)'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Lingkup pekerjaan Regulatory Affairs Officer mencakup tanggung jawab strategis dan teknis dalam memastikan kepatuhan produk dan operasional perusahaan terhadap peraturan perundang-undangan, sehingga meminimalkan risiko ketidaksesuaian (non-compliance) dan hambatan perizinan.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Memberikan informasi regulatori secara akurat; tidak menyembunyikan informasi material dari otoritas/pihak terkait; menjaga kerahasiaan dokumen; memastikan informasi/submisi dapat ditelusuri; serta menghindari pernyataan menyesatkan mengenai kepatuhan atau status persetujuan.',
                'survailen' => null,
            ],
            [
                'slug' => 'sustainability-officer', 'badge' => 'W', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Sustainability Officer', 'kode' => 'EDUKIA-SBO-2026-023', 'jenis_kemasan' => 'Sustainability Officer',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di laboratorium atau bagian laboratorium di industri, dan memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko',
                    'Persyaratan 2: Fresh graduate D3 bidang sains atau teknik dengan pengalaman magang minimal 3 bulan di laboratorium atau bagian laboratorium di industri, atau memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko',
                ],
                'units' => [
                    self::u('SP.SBO.001.01', 'Mengidentifikasi aspek dan dampak keberlanjutan operasional'),
                    self::u('SP.SBO.002.01', 'Merencanakan program peningkatan kinerja lingkungan dan sosial'),
                    self::u('SP.SBO.003.01', 'Mengimplementasikan program keberlanjutan organisasi'),
                    self::u('SP.SBO.004.01', 'Memantau dan mengevaluasi capaian target keberlanjutan'),
                    self::u('SP.SBO.005.01', 'Mengomunikasikan kinerja keberlanjutan internal'),
                    self::u('SP.SBO.006.01', 'Mendukung pengelolaan data kinerja keberlanjutan'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Implementasi program keberlanjutan dan peningkatan kinerja lingkungan serta sosial organisasi; berlaku untuk organisasi sektor jasa, manufaktur, energi, keuangan, dan sektor lain yang menerapkan fungsi keberlanjutan dan ESG.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga integritas data lingkungan dan sosial; tidak melakukan greenwashing atau membuat klaim keberlanjutan yang tidak didukung bukti; menyampaikan capaian dan kesenjangan secara berimbang; mempertimbangkan dampak terhadap pemangku kepentingan; serta menjaga keterlacakan data.',
                'survailen' => null,
            ],
            [
                'slug' => 'esg-officer', 'badge' => 'X', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'ESG Officer', 'kode' => 'EDUKIA-ESG-2026-024', 'jenis_kemasan' => 'ESG Officer',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di laboratorium atau bagian laboratorium di industri, dan memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko',
                    'Persyaratan 2: Fresh graduate D3 bidang sains atau teknik dengan pengalaman magang minimal 3 bulan di laboratorium atau bagian laboratorium di industri, atau memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko',
                ],
                'units' => [
                    self::u('SP.ESG.001.01', 'Mengidentifikasi dan memetakan pemangku kepentingan'),
                    self::u('SP.ESG.002.01', 'Mengidentifikasi isu dan risiko ESG'),
                    self::u('SP.ESG.003.01', 'Melakukan penilaian dampak dan risiko ESG'),
                    self::u('SP.ESG.004.01', 'Menyusun matriks materialitas'),
                    self::u('SP.ESG.005.01', 'Mengintegrasikan risiko ESG ke dalam manajemen risiko organisasi'),
                    self::u('SP.ESG.006.01', 'Menyiapkan informasi pengungkapan ESG'),
                    self::u('SP.ESG.007.01', 'Mendukung tata kelola dan kebijakan ESG organisasi'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Pengelolaan risiko, tata kelola, materialitas, dan kesiapan pengungkapan ESG organisasi, termasuk inventarisasi emisi GRK; berlaku untuk organisasi sektor jasa, manufaktur, energi, keuangan, dan sektor lainnya.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga integritas informasi ESG; tidak menyembunyikan risiko material atau memanipulasi indikator; menghindari greenwashing; mengelola konflik kepentingan; menjaga kerahasiaan informasi; serta memastikan analisis materialitas, risiko, dan pengungkapan berdasarkan data yang dapat dipertanggungjawabkan.',
                'survailen' => null,
            ],
            [
                'slug' => 'environmental-management-system-iso-14001-officer', 'badge' => 'Y', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Environmental Management System (ISO 14001) Officer', 'kode' => 'EDUKIA-EMS-2026-025', 'jenis_kemasan' => 'Environmental Management System (ISO 14001) Officer',
                'persyaratan' => [
                    'Pendidikan minimal D3/S1 Teknik Lingkungan, Teknik Kimia, Kesehatan Lingkungan, atau bidang terkait',
                    'Fresh graduate atau memiliki pengalaman magang di bidang Environmental Management System / pengelolaan lingkungan minimal 3 bulan',
                    'Memiliki Sertifikat Pelatihan ISO 14001:2015 Environmental Management System atau pelatihan terkait pengelolaan lingkungan dan audit lingkungan',
                ],
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
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Lingkup pekerjaan Implementer Sistem Manajemen Lingkungan mencakup penerapan, pengendalian, dan pemeliharaan Sistem Manajemen Lingkungan dalam organisasi secara sistematis, terukur, dan selaras dengan prinsip peningkatan berkelanjutan.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga objektivitas identifikasi aspek/dampak; tidak menyembunyikan ketidakpatuhan lingkungan; menggunakan data lingkungan secara benar; tidak membuat klaim lingkungan yang menyesatkan; serta memperhatikan kewajiban kepatuhan dan pencegahan dampak lingkungan.',
                'survailen' => null,
            ],
            [
                'slug' => 'corporate-legal-officer', 'badge' => 'Z', 'bidang' => 'manajemen', 'popular' => false,
                'nama' => 'Corporate Legal Officer', 'kode' => 'EDUKIA-CLO-2026-026', 'jenis_kemasan' => 'Sertifikasi Corporate Legal Officer',
                'persyaratan' => [
                    'Pendidikan minimal D3 atau S1 Ilmu Hukum atau Hukum Islam (terbuka juga bagi lulusan disiplin ilmu lain yang berminat menjadi Corporate Legal Officer)',
                    'Fresh graduate dan/atau memiliki pengalaman kerja di perusahaan atau korporasi',
                    'Memiliki Sertifikat Pelatihan Corporate Legal Officer',
                ],
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
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Pengelolaan fungsi hukum internal perusahaan — identifikasi regulasi, penyusunan dan penelaahan dokumen hukum, pengelolaan risiko hukum, serta pengawasan kepatuhan terhadap peraturan perundang-undangan yang berlaku.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjaga kerahasiaan informasi hukum; menghindari konflik kepentingan; memberikan analisis berdasarkan hukum/regulasi yang berlaku; tidak memalsukan atau menyembunyikan dokumen/fakta material; membedakan fakta, interpretasi, dan pendapat profesional; serta tidak memberikan pernyataan mengenai kewenangan/kompetensi yang tidak dimiliki.',
                'survailen' => null,
            ],
            [
                'slug' => 'research-and-development-officer', 'badge' => 'U', 'bidang' => 'riset', 'popular' => false,
                'nama' => 'Research and Development Officer', 'kode' => 'EDUKIA-RDO-2026-021', 'jenis_kemasan' => 'Research and Development Officer',
                'persyaratan' => [
                    'Persyaratan 1: Pendidikan minimal SMA/SMK bidang sains atau teknik dengan pengalaman kerja minimal 2 tahun di laboratorium atau bagian laboratorium di industri, dan memiliki Sertifikat Pelatihan ISO 17025 / GMP (CPPOB, CPAKB, CPOIB)',
                    'Persyaratan 2: Pendidikan minimal D3 atau S1 semua jurusan Teknik, Ilmu Gizi, Kimia, Biologi, atau Farmasi (terbuka juga bagi lulusan disiplin ilmu lain), fresh graduate dan/atau berpengalaman kerja di industri atau laboratorium, dan memiliki Sertifikat Pelatihan ISO 17025 / GMP (CPPOB, CPAKB, CPOIB)',
                ],
                'units' => [
                    self::u('SP.RDO.001.01', 'Merencanakan Kegiatan Penelitian dan Pengembangan'),
                    self::u('SP.RDO.002.01', 'Melaksanakan Kegiatan Penelitian dan Pengembangan'),
                    self::u('SP.RDO.003.01', 'Melakukan Analisis dan Validasi Hasil Penelitian'),
                    self::u('SP.RDO.004.01', 'Mengelola Dokumentasi dan Pelaporan Kegiatan R&D'),
                    self::u('SP.RDO.005.01', 'Mengelola Implementasi dan Peningkatan Berkelanjutan Hasil Pengembangan'),
                ],
                'dokumen' => self::dok(1),
                'ruang_lingkup' => 'Lingkup pekerjaan R&D Officer mencakup perencanaan, pelaksanaan, koordinasi, dan evaluasi kegiatan penelitian dan pengembangan di perusahaan secara metodologis, berbasis data, serta sesuai standar mutu dan keselamatan kerja.',
                'asesmen' => self::asesmenTulis(),
                'kode_etik_khusus' => 'Menjunjung integritas penelitian; tidak melakukan fabrikasi, falsifikasi, atau manipulasi data; mendokumentasikan metode/perubahan secara benar; menghormati kerahasiaan dan kekayaan intelektual; menyampaikan keterbatasan hasil secara transparan; serta menghindari klaim yang tidak didukung bukti.',
                'survailen' => null,
            ],
        ];
    }
}
