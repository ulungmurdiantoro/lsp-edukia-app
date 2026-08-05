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
            ->assertSee('Sektor SPMI ISO 21001')
            ->assertSee('Auditor Internal SPMI Terintegrasi ISO 21001:2018');
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
