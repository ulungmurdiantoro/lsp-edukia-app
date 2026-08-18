<?php

namespace App\Support;

use Illuminate\Support\Carbon;

/**
 * Logika bersama untuk membaca data sertifikat dari file Excel institusi (format
 * register resmi FR.AK.09: No, Nama Lengkap, Skema, Batch, No Skema, No Sertifikat,
 * No SK, Nama Gelar, Tanggal Rilis, Tanggal_Berakhir). Dipakai oleh:
 * - App\Console\Commands\ImportSertifikat (import massal sekali jalan dari 2 file resmi)
 * - App\Imports\SertifikatImport (tombol "Import Excel" berulang di panel admin)
 * agar hasil resolusi skema/kategori/tanggal konsisten di kedua jalur import.
 */
class SertifikatExcelHelper
{
    private const BULAN = [
        'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
        'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
        'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12,
    ];

    // nomor urut, kode-tengah (mis. AIL, ToT), nama skema, kategori — sinkron dengan
    // Select options di App\Filament\Resources\SertifikatResource agar hasil import valid di admin.
    private const SKEMAS = [
        ['01', 'AIL', 'Auditor Internal SPMI Terintegrasi ISO 21001:2018', 'spmi'],
        ['02', 'LAD', 'Lead Auditor Internal SPMI Terintegrasi ISO 21001:2018', 'spmi'],
        ['03', 'IMR', 'Lead Implementer SPMI Terintegrasi ISO 21001:2018', 'spmi'],
        ['04', 'ToT', 'Training of Trainer (ToT) Outcome Based Education (OBE)', 'pt'],
        ['05', 'TKO', 'Implementer Tata Kelola Organisasi Perguruan Tinggi', 'pt'],
        ['06', 'AUI', 'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017', 'lab17025'],
        ['07', 'LIM', 'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017', 'lab17025'],
        ['08', 'LFM', 'Lifting Engineer for Medium Lifting', 'lifting'],
        ['09', 'LFH', 'Lifting Engineer for Heavy & Critical Lifting Operation', 'lifting'],
        ['10', 'LDT', '2D Lifting Designer', 'lifting'],
        ['11', 'DLD', '3D Lifting Designer', 'lifting'],
        ['12', 'LQO', 'Laboratory Quality System Officer ISO/IEC 17025', 'labtest'],
        ['13', 'FMO', 'Food Safety Management Officer', 'labtest'],
        ['14', 'PSP', 'Panelis Terlatih Pengujian Sensori Pangan', 'labtest'],
        ['15', 'GLP', 'GLP Laboratory Technician', 'labtest'],
        ['16', 'K3L', 'Laboratory HSE Officer', 'labtest'],
        ['17', 'LOP', 'Laboratory Operations Officer', 'labtest'],
        ['18', 'QMS', 'Quality Management System (ISO 9001) Officer', 'manajemen'],
        ['19', 'QCA', 'QC Laboratory Analyst', 'labtest'],
        ['20', 'QAO', 'Quality Assurance Officer', 'manajemen'],
        ['21', 'RDO', 'Research and Development Officer', 'manajemen'],
        ['22', 'RAQ', 'Regulatory Affairs Officer', 'manajemen'],
        ['23', 'SBO', 'Sustainability Officer', 'manajemen'],
        ['24', 'ESG', 'ESG Officer', 'manajemen'],
        ['25', 'EMS', 'Environmental Management System (ISO 14001) Officer', 'manajemen'],
        ['26', 'CLO', 'Corporate Legal Officer', 'hukum'],
    ];

    private static ?array $byMiddle = null;
    private static ?array $byNomor = null;

    private static function byMiddle(): array
    {
        return self::$byMiddle ??= collect(self::SKEMAS)
            ->mapWithKeys(fn ($s) => [$s[1] => ['skema' => $s[2], 'kategori' => $s[3]]])
            ->all();
    }

    private static function byNomor(): array
    {
        return self::$byNomor ??= collect(self::SKEMAS)
            ->mapWithKeys(fn ($s) => [$s[0] => ['skema' => $s[2], 'kategori' => $s[3]]])
            ->all();
    }

    /**
     * Bersihkan artefak baris-baru xlsx ("_x000D_"), rapikan spasi ganda, trim.
     */
    public static function clean(mixed $value): string
    {
        $value = str_replace(['_x000D_', "\r", "\n"], ' ', (string) $value);

        return trim(preg_replace('/\s+/', ' ', $value));
    }

    /**
     * Tentukan skema & kategori dari kode "No Skema" (mis. EDUKIA-AIL-2024-001), toleran
     * terhadap typo prefix/tahun/nomor urut. Kalau kode tidak cocok, coba cocokkan dari
     * teks nama skema bebas sebagai fallback.
     */
    public static function resolveScheme(?string $noSkemaRaw, ?string $skemaTextRaw = null): ?array
    {
        $noSkemaRaw = self::clean((string) $noSkemaRaw);

        if (preg_match('/^[A-Za-z]+-([A-Za-z0-9]+)-\d{4}-(\d+)$/', $noSkemaRaw, $m)) {
            $middle = strtoupper($m[1]);
            if (isset(self::byMiddle()[$middle])) {
                return self::byMiddle()[$middle];
            }

            $nomor = str_pad((string) ((int) $m[2]), 2, '0', STR_PAD_LEFT);
            if (isset(self::byNomor()[$nomor])) {
                return self::byNomor()[$nomor];
            }
        }

        $skemaText = self::clean((string) $skemaTextRaw);
        if ($skemaText === '') {
            return null;
        }

        foreach (self::SKEMAS as [, , $skemaCanonical, $kategori]) {
            if (strcasecmp($skemaText, $skemaCanonical) === 0) {
                return ['skema' => $skemaCanonical, 'kategori' => $kategori];
            }
        }

        $skemaLower = mb_strtolower($skemaText);
        foreach (self::SKEMAS as [, , $skemaCanonical, $kategori]) {
            if (str_contains($skemaLower, mb_strtolower(substr($skemaCanonical, 0, 20)))) {
                return ['skema' => $skemaCanonical, 'kategori' => $kategori];
            }
        }

        return null;
    }

    /**
     * Parser tanggal fleksibel: mendukung "4 Mei 2026", "April 2024" (tanpa tanggal,
     * dianggap tanggal 1), dan format ISO "YYYY-MM-DD".
     */
    public static function parseTanggal(mixed $value): ?Carbon
    {
        $raw = self::clean($value);
        if ($raw === '' || $raw === '-') {
            return null;
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) {
            return Carbon::parse($raw)->startOfDay();
        }

        if (preg_match('/^(\d{1,2})\s+([A-Za-z]+)\s+(\d{4})$/', $raw, $m)) {
            $bulan = self::BULAN[strtolower($m[2])] ?? null;
            if ($bulan) {
                return Carbon::createFromDate((int) $m[3], $bulan, (int) $m[1])->startOfDay();
            }
        }

        if (preg_match('/^([A-Za-z]+)\s+(\d{4})$/', $raw, $m)) {
            $bulan = self::BULAN[strtolower($m[1])] ?? null;
            if ($bulan) {
                return Carbon::createFromDate((int) $m[2], $bulan, 1)->startOfDay();
            }
        }

        return null;
    }
}
