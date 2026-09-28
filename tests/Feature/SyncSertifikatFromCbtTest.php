<?php

namespace Tests\Feature;

use App\Models\Sertifikat;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SyncSertifikatFromCbtTest extends TestCase
{
    use RefreshDatabase;

    private const SKEMA = 'Auditor Internal SPMI Terintegrasi ISO 21001:2018';

    protected function setUp(): void
    {
        parent::setUp();

        // Koneksi 'cbt' diarahkan ke SQLite in-memory, dengan tabel tiruan view CBT.
        config(['database.connections.cbt' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]]);
        DB::purge('cbt');

        Schema::connection('cbt')->create('v_sertifikasi_kelulusan', function (Blueprint $table) {
            $table->string('nama_peserta')->nullable();
            $table->string('kode_skema')->nullable();
            $table->string('classroom_title')->nullable();
            $table->string('sk_number')->nullable();
            $table->string('sertifikat_number')->nullable();
            $table->date('finalized_at')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('with_kan')->default(true);
        });
    }

    private function cbtRow(array $override = []): void
    {
        DB::connection('cbt')->table('v_sertifikasi_kelulusan')->insert(array_merge([
            'nama_peserta' => 'Budi Santoso',
            'kode_skema' => 'EDUKIA-AIL-2024-001',
            'classroom_title' => 'Kelas AIL',
            'sk_number' => 'SK-001',
            'sertifikat_number' => 'CBT-0001',
            'finalized_at' => '2026-01-10',
            'valid_until' => '2029-01-10',
            'with_kan' => true,
        ], $override));
    }

    private function sertifikat(array $override = []): Sertifikat
    {
        return Sertifikat::create(array_merge([
            'nama' => 'Budi Santoso',
            'skema' => self::SKEMA,
            'kategori' => 'spmi',
            'lisensi' => true,
            'nomor_sertifikat' => 'XLS-0001',
            'tanggal_terbit' => '2025-01-10',
            'tanggal_kadaluarsa' => '2028-01-10',
            'tampil' => true,
        ], $override));
    }

    public function test_new_certificate_is_created_and_shown(): void
    {
        $this->cbtRow();

        $this->artisan('sertifikat:sync-cbt')->assertSuccessful();

        $s = Sertifikat::where('nomor_sertifikat', 'CBT-0001')->firstOrFail();
        $this->assertTrue($s->tampil);
        $this->assertSame(self::SKEMA, $s->skema);
        $this->assertSame('2029-01-10', $s->tanggal_kadaluarsa->toDateString());
    }

    public function test_rows_without_certificate_number_are_ignored_instead_of_crashing_sync(): void
    {
        $this->cbtRow(['sertifikat_number' => null, 'nama_peserta' => 'Tanpa Nomor']);
        $this->cbtRow(['sertifikat_number' => '', 'nama_peserta' => 'Nomor Kosong']);
        $this->cbtRow();

        $this->artisan('sertifikat:sync-cbt')->assertSuccessful();

        $this->assertSame(1, Sertifikat::count());
    }

    public function test_certificate_hidden_by_admin_stays_hidden_after_sync(): void
    {
        $this->sertifikat(['nomor_sertifikat' => 'CBT-0001', 'tampil' => false]);
        $this->cbtRow();

        $this->artisan('sertifikat:sync-cbt')->assertSuccessful();

        $this->assertFalse(Sertifikat::where('nomor_sertifikat', 'CBT-0001')->first()->tampil);
    }

    public function test_older_excel_duplicate_of_same_person_is_hidden(): void
    {
        $lama = $this->sertifikat(['nama' => 'BUDI  SANTOSO.']);
        $this->cbtRow();

        $this->artisan('sertifikat:sync-cbt')->assertSuccessful();

        $this->assertFalse($lama->fresh()->tampil);
        $this->assertTrue(Sertifikat::where('nomor_sertifikat', 'CBT-0001')->first()->tampil);
    }

    public function test_recertification_keeps_newest_certificate_visible_across_repeated_syncs(): void
    {
        $this->cbtRow(['sertifikat_number' => 'CBT-LAMA', 'finalized_at' => '2023-01-10', 'valid_until' => '2026-01-10']);
        $this->cbtRow(['sertifikat_number' => 'CBT-BARU', 'finalized_at' => '2026-01-10', 'valid_until' => '2029-01-10']);

        $this->artisan('sertifikat:sync-cbt')->assertSuccessful();
        $this->artisan('sertifikat:sync-cbt')->assertSuccessful();

        $this->assertFalse(Sertifikat::where('nomor_sertifikat', 'CBT-LAMA')->first()->tampil);
        $this->assertTrue(Sertifikat::where('nomor_sertifikat', 'CBT-BARU')->first()->tampil);
    }

    public function test_different_person_with_same_scheme_is_not_hidden(): void
    {
        $lain = $this->sertifikat(['nama' => 'Siti Aminah']);
        $this->cbtRow();

        $this->artisan('sertifikat:sync-cbt')->assertSuccessful();

        $this->assertTrue($lain->fresh()->tampil);
    }
}
