<?php

namespace App\Console\Commands;

use App\Models\Sertifikat;
use App\Support\SertifikatExcelHelper;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImportSertifikat extends Command
{
    protected $signature = 'sertifikat:import {--fresh : Kosongkan tabel sertifikats sebelum import}';
    protected $description = 'Import daftar penerima sertifikat dari file Excel (Terlisensi KAN & Tidak Terlisensi)';

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

            $nama = SertifikatExcelHelper::clean($sheet->getCell("B{$r}")->getValue());
            $skemaTextRaw = SertifikatExcelHelper::clean($sheet->getCell("C{$r}")->getValue());
            $noSkemaRaw = SertifikatExcelHelper::clean($sheet->getCell("E{$r}")->getValue());
            $nomorSertifikat = SertifikatExcelHelper::clean($sheet->getCell("F{$r}")->getValue());
            $noSk = SertifikatExcelHelper::clean($sheet->getCell("G{$r}")->getValue());
            $gelar = SertifikatExcelHelper::clean($sheet->getCell("H{$r}")->getValue());
            $tanggalTerbit = SertifikatExcelHelper::parseTanggal($sheet->getCell("I{$r}")->getValue());
            $tanggalKadaluarsa = SertifikatExcelHelper::parseTanggal($sheet->getCell("J{$r}")->getValue());

            $scheme = SertifikatExcelHelper::resolveScheme($noSkemaRaw, $skemaTextRaw);

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
}
