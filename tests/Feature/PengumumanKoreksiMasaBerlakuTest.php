<?php

namespace Tests\Feature;

use App\Models\Sertifikat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/** Pemberitahuan No. 553/SPT/EDUKIA/X/2026 dan aturan tanggal berakhir masa berlaku 3 tahun. */
class PengumumanKoreksiMasaBerlakuTest extends TestCase
{
    use RefreshDatabase;

    private function sertifikat(array $attrs = []): Sertifikat
    {
        return Sertifikat::create($attrs + [
            'nama' => 'Budi Santoso',
            'skema' => 'Auditor Internal SPMI',
            'kategori' => 'spmi',
            'lisensi' => true,
            'nomor_sertifikat' => '004-013-06-2026-00001',
            'tanggal_terbit' => '2026-06-18',
            'tanggal_kadaluarsa' => '2029-06-17',
            'tampil' => true,
        ]);
    }

    public function test_end_date_is_one_day_before_third_anniversary(): void
    {
        $this->assertSame('2029-06-17', Sertifikat::tanggalBerakhir(Carbon::parse('2026-06-18'))->toDateString());
        // Register lama yang hanya mencatat bulan ("April 2024") dibaca sebagai tanggal 1.
        $this->assertSame('2027-03-31', Sertifikat::tanggalBerakhir(Carbon::parse('2024-04-01'))->toDateString());
    }

    public function test_only_old_pattern_end_dates_are_corrected(): void
    {
        $terbit = Carbon::parse('2026-06-18');

        $this->assertSame('2029-06-17', Sertifikat::koreksiTanggalBerakhir($terbit, Carbon::parse('2029-06-18'))->toDateString());
        $this->assertSame('2029-06-17', Sertifikat::koreksiTanggalBerakhir($terbit, Carbon::parse('2029-06-17'))->toDateString());
        $this->assertSame('2028-01-01', Sertifikat::koreksiTanggalBerakhir($terbit, Carbon::parse('2028-01-01'))->toDateString());
        $this->assertNull(Sertifikat::koreksiTanggalBerakhir($terbit, null));
    }

    public function test_dry_run_lists_corrections_without_saving(): void
    {
        $this->sertifikat(['tanggal_kadaluarsa' => '2029-06-18']);

        $this->artisan('sertifikat:koreksi-masa-berlaku', ['--dry-run' => true])
            ->expectsOutputToContain('1 sertifikat akan dikoreksi')
            ->assertSuccessful();

        $this->assertSame('2029-06-18', Sertifikat::first()->tanggal_kadaluarsa->toDateString());
    }

    public function test_command_corrects_only_old_pattern_and_writes_audit_log(): void
    {
        Storage::fake('local');
        $this->sertifikat(['nomor_sertifikat' => 'LAMA-1', 'tanggal_kadaluarsa' => '2029-06-18']);
        $this->sertifikat(['nomor_sertifikat' => 'LAMA-2', 'tanggal_terbit' => '2024-04-01', 'tanggal_kadaluarsa' => '2027-04-01', 'tampil' => false]);
        $this->sertifikat(['nomor_sertifikat' => 'BENAR', 'tanggal_kadaluarsa' => '2029-06-17']);
        $this->sertifikat(['nomor_sertifikat' => 'LAIN', 'tanggal_kadaluarsa' => '2028-01-01']);
        $this->sertifikat(['nomor_sertifikat' => 'KOSONG', 'tanggal_kadaluarsa' => null]);

        $this->artisan('sertifikat:koreksi-masa-berlaku')->assertSuccessful();

        $berakhir = Sertifikat::pluck('tanggal_kadaluarsa', 'nomor_sertifikat')->map(fn ($d) => $d?->toDateString());
        $this->assertSame('2029-06-17', $berakhir['LAMA-1']);
        $this->assertSame('2027-03-31', $berakhir['LAMA-2']);
        $this->assertSame('2029-06-17', $berakhir['BENAR']);
        $this->assertSame('2028-01-01', $berakhir['LAIN']);
        $this->assertNull($berakhir['KOSONG']);

        $log = Storage::disk('local')->files('koreksi-masa-berlaku');
        $this->assertCount(1, $log);
        $isi = Storage::disk('local')->get($log[0]);
        $this->assertStringContainsString('"LAMA-1","Budi Santoso","2026-06-18","2029-06-18","2029-06-17"', $isi);
        $this->assertStringNotContainsString('BENAR', $isi);

        // Dijalankan ulang: tidak ada lagi yang berpola lama.
        $this->artisan('sertifikat:koreksi-masa-berlaku')
            ->expectsOutput('Tidak ada sertifikat yang perlu dikoreksi.')
            ->assertSuccessful();
    }

    public function test_announcement_page_shows_letter(): void
    {
        $this->get('/pengumuman/koreksi-masa-berlaku-sertifikat')
            ->assertOk()
            ->assertSee('553/SPT/EDUKIA/X/2026')
            ->assertSee('April 2024 – Agustus 2026')
            ->assertSee('17 Juni 2029');
    }

    public function test_banner_links_to_announcement_from_home_and_certificate_list(): void
    {
        $url = route('pengumuman.koreksi-masa-berlaku');

        $this->get('/')->assertOk()->assertSee($url, false);
        $this->get('/daftar-penerima-sertifikat')->assertOk()->assertSee($url, false);
    }

    public function test_verification_page_notes_correction_only_for_certificates_in_period(): void
    {
        $url = route('pengumuman.koreksi-masa-berlaku');
        $this->sertifikat();
        $this->sertifikat([
            'nomor_sertifikat' => '004-013-09-2026-00128',
            'tanggal_terbit' => '2026-09-20',
            'tanggal_kadaluarsa' => '2029-09-19',
        ]);

        $this->get('/verifikasi-sertifikat/004-013-06-2026-00001')->assertOk()->assertSee($url, false);
        $this->get('/verifikasi-sertifikat/004-013-09-2026-00128')->assertOk()->assertDontSee($url, false);
    }
}
