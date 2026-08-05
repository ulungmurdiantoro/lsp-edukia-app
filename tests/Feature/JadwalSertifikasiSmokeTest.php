<?php

namespace Tests\Feature;

use App\Filament\Resources\JadwalSertifikasiResource\Pages\CreateJadwalSertifikasi;
use App\Models\JadwalSertifikasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JadwalSertifikasiSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_jadwal_sertifikasi_page_renders(): void
    {
        JadwalSertifikasi::create([
            'skema' => 'Auditor Internal SPMI Terintegrasi ISO 21001:2018',
            'bidang' => 'spmi',
            'tanggal_sertifikasi' => '2026-06-30',
            'tampil' => true,
        ]);

        $this->get(route('jadwal-sertifikasi'))
            ->assertOk()
            ->assertSee('Juni 2026')
            ->assertSee('Auditor Internal SPMI Terintegrasi ISO 21001:2018');
    }

    public function test_active_jadwal_links_to_matching_skema_page_but_past_one_does_not(): void
    {
        JadwalSertifikasi::create([
            'skema' => 'Corporate Legal Officer',
            'bidang' => 'manajemen',
            'tanggal_sertifikasi' => now()->addMonth()->toDateString(),
            'tampil' => true,
        ]);
        JadwalSertifikasi::create([
            'skema' => 'Quality Assurance Officer',
            'bidang' => 'manajemen',
            'tanggal_sertifikasi' => now()->subMonth()->toDateString(),
            'tampil' => true,
        ]);

        $this->get(route('jadwal-sertifikasi'))
            ->assertOk()
            ->assertSee(route('skema.show', 'corporate-legal-officer'))
            ->assertDontSee(route('skema.show', 'quality-assurance-officer'))
            ->assertSee('Selesai');
    }

    public function test_admin_can_view_jadwal_sertifikasi_list(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/admin/jadwal-sertifikasis')->assertOk();
    }

    public function test_admin_can_view_jadwal_sertifikasi_create_form(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/admin/jadwal-sertifikasis/create')->assertOk();
    }

    public function test_admin_can_create_jadwal_sertifikasi_via_livewire_form(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateJadwalSertifikasi::class)
            ->fillForm([
                'skema' => 'Corporate Legal Officer',
                'tanggal_sertifikasi' => '2026-09-01',
                'tampil' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $record = JadwalSertifikasi::where('skema', 'Corporate Legal Officer')->first();
        $this->assertNotNull($record);
        $this->assertSame('manajemen', $record->bidang);
    }
}
