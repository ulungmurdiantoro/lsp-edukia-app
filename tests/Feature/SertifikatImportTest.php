<?php

namespace Tests\Feature;

use App\Imports\SertifikatImport;
use App\Models\Sertifikat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class SertifikatImportTest extends TestCase
{
    use RefreshDatabase;

    private function templatePath(): string
    {
        return public_path('downloads/template-import-sertifikat.xlsx');
    }

    public function test_downloadable_template_imports_all_example_rows_with_correct_fields(): void
    {
        $this->assertFileExists($this->templatePath());

        Excel::import(new SertifikatImport(), $this->templatePath());

        $this->assertSame(8, Sertifikat::count());

        $r = Sertifikat::where('nomor_sertifikat', '001-001-01-2024-00001')->first();
        $this->assertSame('Budi Santoso', $r->nama);
        $this->assertSame('Auditor Internal SPMI Terintegrasi ISO 21001:2018', $r->skema);
        $this->assertSame('spmi', $r->kategori);
        $this->assertTrue((bool) $r->lisensi);
        $this->assertSame('2024-01-15', $r->tanggal_terbit->toDateString());
        $this->assertSame('2027-01-15', $r->tanggal_kadaluarsa->toDateString());
    }

    public function test_reimporting_same_template_updates_instead_of_duplicating(): void
    {
        Excel::import(new SertifikatImport(), $this->templatePath());
        Excel::import(new SertifikatImport(), $this->templatePath());

        $this->assertSame(8, Sertifikat::count());
    }

    public function test_blank_lisensi_column_preserves_existing_value_instead_of_resetting(): void
    {
        Sertifikat::create([
            'nama' => 'Lama Berlisensi', 'skema' => 'Corporate Legal Officer', 'kategori' => 'hukum',
            'lisensi' => true, 'nomor_sertifikat' => 'PRESERVE-001',
            'tanggal_terbit' => '2025-01-01', 'tanggal_kadaluarsa' => '2028-01-01', 'tampil' => true,
        ]);

        $csv = "No,Nama Lengkap,Skema,Batch,No Skema,No Sertifikat,No SK,Nama Gelar,Tanggal Rilis,Tanggal_Berakhir\n"
             . "1,Nama Diupdate,Corporate Legal Officer,1,EDUKIA-CLO-2024-026,PRESERVE-001,SK/1,S.H.,1 Januari 2026,1 Januari 2029\n";
        $path = sys_get_temp_dir() . '/preserve_lisensi_probe.csv';
        file_put_contents($path, $csv);

        Excel::import(new SertifikatImport(), $path);
        @unlink($path);

        $r = Sertifikat::where('nomor_sertifikat', 'PRESERVE-001')->first();
        $this->assertSame('Nama Diupdate', $r->nama);
        $this->assertTrue((bool) $r->lisensi, 'lisensi seharusnya tetap true, tidak ter-reset karena kolom kosong di file');
    }

    public function test_row_with_unresolvable_scheme_and_no_fallback_text_is_skipped(): void
    {
        $csv = "No,Nama Lengkap,Skema,Batch,No Skema,No Sertifikat,No SK,Nama Gelar,Tanggal Rilis,Tanggal_Berakhir\n"
             . "1,Orang Tanpa Skema,,1,KODE-TIDAK-DIKENAL,SKIP-001,SK/1,,1 Januari 2026,1 Januari 2029\n";
        $path = sys_get_temp_dir() . '/skip_probe.csv';
        file_put_contents($path, $csv);

        Excel::import(new SertifikatImport(), $path);
        @unlink($path);

        $this->assertSame(0, Sertifikat::count());
    }
}
