<?php

namespace Tests\Feature;

use App\Filament\Resources\LamaranKarirResource;
use App\Filament\Resources\LowonganResource;
use App\Models\LamaranKarir;
use App\Models\Lowongan;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_user_cannot_access_panel(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_user_can_access_panel(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get('/admin')
            ->assertOk();
    }

    public function test_admin_can_open_lowongan_and_lamaran_pages(): void
    {
        $this->actingAs(User::factory()->admin()->create());
        $lowongan = Lowongan::firstOrFail();
        $lamaran = LamaranKarir::create([
            'posisi' => $lowongan->slug,
            'nama_lengkap' => 'Andi Wijaya',
            'tempat_tanggal_lahir' => 'Semarang, 1 Januari 1990',
            'nomor_whatsapp' => '081234567890',
            'domisili' => 'Semarang',
            'pendidikan_terakhir' => 'S1',
            'jurusan' => 'Teknik Industri',
            'pengalaman_kerja' => '1-3 tahun',
            'sertifikat_iso' => 'YA',
            'pengalaman_audit' => '-',
            'cv' => 'lamaran-karir/cv/andi.pdf',
            'ijazah' => 'lamaran-karir/ijazah/andi.pdf',
            'sertifikat_pelatihan' => 'lamaran-karir/sertifikat/andi.pdf',
        ]);

        $this->get(LowonganResource::getUrl('index'))->assertOk()->assertSee($lowongan->judul);
        $this->get(LowonganResource::getUrl('create'))->assertOk();
        $this->get(LowonganResource::getUrl('edit', ['record' => $lowongan]))->assertOk();
        $this->get(LamaranKarirResource::getUrl('view', ['record' => $lamaran]))
            ->assertOk()
            ->assertSee(route('lamaran.dokumen', [$lamaran, 'cv']), false)
            ->assertDontSee('/storage/lamaran-karir', false);
    }

    public function test_admin_seeder_does_not_overwrite_existing_admin_password(): void
    {
        $admin = User::factory()->create(['email' => 'admin@lspedukia.com']);
        $hashLama = $admin->password;

        $this->seed(AdminSeeder::class);

        $admin->refresh();
        $this->assertSame($hashLama, $admin->password);
        $this->assertTrue($admin->is_admin);
    }
}
