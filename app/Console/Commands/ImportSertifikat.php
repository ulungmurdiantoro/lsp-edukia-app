<?php

namespace App\Console\Commands;

use App\Models\Sertifikat;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImportSertifikat extends Command
{
    protected $signature = 'sertifikat:import {--fresh : Kosongkan tabel sertifikats sebelum import}';
    protected $description = 'Import daftar penerima sertifikat dari file Excel (Terlisensi KAN & Tidak Terlisensi)';

    private const BULAN = [
        'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
        'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
        'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12,
    ];

    // kode-tengah (mis. AIL, ToT) & nomor urut skema → [skema, kategori], sinkron dengan
    // Select options di App\Filament\Resources\SertifikatResource agar hasil import valid di admin.
    private array $skemaByMiddle = [];
    private array $skemaByNomor = [];

    public function __construct()
    {
        parent::__construct();

        $schemes = [
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

        foreach ($schemes as [$nomor, $middle, $skema, $kategori]) {
            $entry = ['skema' => $skema, 'kategori' => $kategori];
            $this->skemaByMiddle[$middle] = $entry;
            $this->skemaByNomor[$nomor] = $entry;
        }
    }

    public function handle(): void
    {
        $files = [
            ['path' => database_path('Daftar Penerima Sertifikat LSP Edukia - Terlisensi KAN.xlsx'), 'lisensi' => true],
            ['path' => database_path('Daftar Penerima Sertifikat LSP Edukia - Tidak Terlisensi.xlsx'), 'lisensi' => false],
        ];

        foreach ($files as $file) {
            if (! is_file($file['path'])) {
                $this->error('File tidak ditemukan: ' . $file['path']);
                return;
            }
        }

        if ($this->option('fresh')) {
            Sertifikat::query()->delete();
            $this->info('Tabel sertifikats dikosongkan.');
        }

        $totalImported = 0;
        $totalSkipped = 0;

        foreach ($files as $file) {
            $this->info('Membaca: ' . basename($file['path']));
            $sheet = IOFactory::load($file['path'])->getActiveSheet();
            [$imported, $skipped] = $this->importSheet($sheet, $file['lisensi']);
            $this->line("  → {$imported} diimport, {$skipped} dilewati.");
            $totalImported += $imported;
            $totalSkipped += $skipped;
        }

        $this->newLine();
        $this->info("Selesai! {$totalImported} sertifikat berhasil diimport, {$totalSkipped} dilewati.");
    }

    private function importSheet(Worksheet $sheet, bool $lisensi): array
    {
        $highestRow = $sheet->getHighestRow();
        $imported = 0;
        $skipped = 0;

        for ($r = 4; $r <= $highestRow; $r++) {
            $no = trim((string) $sheet->getCell("A{$r}")->getValue());
            if ($no === '') {
                continue;
            }

            $nama = $this->clean($sheet->getCell("B{$r}")->getValue());
            $noSkemaRaw = $this->clean($sheet->getCell("E{$r}")->getValue());
            $nomorSertifikat = $this->clean($sheet->getCell("F{$r}")->getValue());
            $noSk = $this->clean($sheet->getCell("G{$r}")->getValue());
            $gelar = $this->clean($sheet->getCell("H{$r}")->getValue());
            $tanggalTerbit = $this->parseTanggal($sheet->getCell("I{$r}")->getValue());
            $tanggalKadaluarsa = $this->parseTanggal($sheet->getCell("J{$r}")->getValue());

            $scheme = $this->resolveScheme($noSkemaRaw);

            if (! $nama || ! $nomorSertifikat || ! $tanggalTerbit || ! $scheme) {
                $this->warn("  Baris {$r} dilewati (data tidak lengkap/skema tidak dikenali): {$nama} | {$noSkemaRaw}");
                $skipped++;
                continue;
            }

            Sertifikat::create([
                'nama' => $nama,
                'gelar' => $gelar ?: null,
                'skema' => $scheme['skema'],
                'kategori' => $scheme['kategori'],
                'lisensi' => $lisensi,
                'nomor_sertifikat' => $nomorSertifikat,
                'no_sk' => ($noSk && $noSk !== '-') ? $noSk : null,
                'no_skema' => $noSkemaRaw ?: null,
                'tanggal_terbit' => $tanggalTerbit,
                'tanggal_kadaluarsa' => $tanggalKadaluarsa,
                'tampil' => true,
            ]);
            $imported++;
        }

        return [$imported, $skipped];
    }

    private function resolveScheme(string $noSkemaRaw): ?array
    {
        if (! preg_match('/^[A-Za-z]+-([A-Za-z0-9]+)-\d{4}-(\d+)$/', $noSkemaRaw, $m)) {
            return null;
        }

        $middle = strtoupper($m[1]);
        if (isset($this->skemaByMiddle[$middle])) {
            return $this->skemaByMiddle[$middle];
        }

        $nomor = str_pad((string) ((int) $m[2]), 2, '0', STR_PAD_LEFT);

        return $this->skemaByNomor[$nomor] ?? null;
    }

    private function clean(mixed $value): string
    {
        $value = str_replace(['_x000D_', "\r", "\n"], ' ', (string) $value);

        return trim(preg_replace('/\s+/', ' ', $value));
    }

    private function parseTanggal(mixed $value): ?Carbon
    {
        $raw = $this->clean($value);
        if ($raw === '' || $raw === '-') {
            return null;
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
