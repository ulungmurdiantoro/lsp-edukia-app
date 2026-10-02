<?php

namespace Tests\Feature;

use App\Models\Sertifikat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Tujuan QR code sertifikat/SK dari CBT: https://verifikasi-sertifikat.lspedukia.id/{nomor}. */
class VerifikasiSertifikatTest extends TestCase
{
    use RefreshDatabase;

    private function sertifikat(array $attrs = []): Sertifikat
    {
        return Sertifikat::create($attrs + [
            'nama'               => 'Budi Santoso',
            'gelar'              => 'S.T., M.T.',
            'skema'              => 'Auditor Internal SPMI',
            'kategori'           => 'spmi',
            'lisensi'            => true,
            'nomor_sertifikat'   => '004-013-09-2026-00128',
            'no_sk'              => '012/SK-SP/LSP-EDUKIA/IX/2026',
            'tanggal_terbit'     => '2026-09-20',
            'tanggal_kadaluarsa' => '2029-09-19',
            'tampil'             => true,
        ]);
    }

    private function mainUrl(string $path): string
    {
        return rtrim(config('app.url'), '/').$path;
    }

    public function test_certificate_number_shows_holder(): void
    {
        $this->sertifikat();

        $this->get('/verifikasi-sertifikat/004-013-09-2026-00128')
            ->assertOk()
            ->assertSee('Sertifikat')
            ->assertSee('Terverifikasi')
            ->assertSee('Budi Santoso')
            ->assertSee('Auditor Internal SPMI')
            ->assertSee('noindex', false);
    }

    public function test_sk_number_with_slashes_shows_holder(): void
    {
        $this->sertifikat();

        $this->get('/verifikasi-sertifikat/sk/012/SK-SP/LSP-EDUKIA/IX/2026')
            ->assertOk()
            ->assertSee('Budi Santoso');
    }

    public function test_unknown_or_hidden_certificate_is_not_found(): void
    {
        $this->sertifikat(['tampil' => false]);

        $this->get('/verifikasi-sertifikat/004-013-09-2026-00128')
            ->assertNotFound()
            ->assertSee('Data tidak ditemukan')
            ->assertDontSee('Budi Santoso');

        $this->get('/verifikasi-sertifikat/999-999')
            ->assertNotFound()
            ->assertSee('999-999');
    }

    public function test_verification_subdomain_redirects_to_main_domain(): void
    {
        $sub = 'http://'.config('app.verifikasi_domain');

        $this->get($sub.'/004-013-09-2026-00128')
            ->assertStatus(301)
            ->assertRedirect($this->mainUrl('/verifikasi-sertifikat/004-013-09-2026-00128'));

        $this->get($sub.'/sk/012/SK-SP/LSP-EDUKIA/IX/2026')
            ->assertRedirect($this->mainUrl('/verifikasi-sertifikat/sk/012/SK-SP/LSP-EDUKIA/IX/2026'));

        $this->get($sub.'/')
            ->assertRedirect($this->mainUrl('/daftar-penerima-sertifikat'));
    }

    public function test_bare_verification_path_goes_to_certificate_list(): void
    {
        $this->get('/verifikasi-sertifikat')->assertRedirect('/daftar-penerima-sertifikat');
    }
}
