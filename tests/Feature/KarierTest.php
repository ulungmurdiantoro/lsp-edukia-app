<?php

namespace Tests\Feature;

use App\Models\LamaranKarir;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KarierTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        Storage::fake('public');
    }

    private function payload(array $override = []): array
    {
        return array_merge([
            'posisi' => 'management-representative',
            'nama_lengkap' => 'Andi Wijaya',
            'tempat_tanggal_lahir' => 'Semarang, 1 Januari 1990',
            'nomor_whatsapp' => '081234567890',
            'domisili' => 'Semarang',
            'pendidikan_terakhir' => 'S1',
            'jurusan' => 'Teknik Industri',
            'pengalaman_kerja' => '1-3 tahun',
            'sertifikat_iso' => 'YA',
            'pengalaman_audit' => 'Audit internal ISO 9001',
            'cv' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
            'ijazah' => UploadedFile::fake()->create('ijazah.pdf', 100, 'application/pdf'),
            'sertifikat_pelatihan' => UploadedFile::fake()->create('sertifikat.pdf', 100, 'application/pdf'),
            'bersedia_fulltime' => '1',
        ], $override);
    }

    private function lamaran(): LamaranKarir
    {
        Storage::disk('local')->put('lamaran-karir/cv/andi.pdf', '%PDF-1.4 test');

        return LamaranKarir::create([
            'posisi' => 'management-representative',
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
    }

    public function test_openings_are_read_from_database_and_hidden_ones_are_not_listed(): void
    {
        Lowongan::create([
            'slug' => 'staf-tersembunyi',
            'judul' => 'Staf Tersembunyi',
            'deskripsi' => '-',
            'kategori' => 'Admin',
            'lokasi' => 'Semarang',
            'tipe' => 'Full-time',
            'requirements' => ['A'],
            'responsibilities' => ['B'],
            'tampil' => false,
        ]);

        $this->get(route('karier.index'))
            ->assertOk()
            ->assertSee('Management Representative (MR) - LSP Edukia')
            ->assertDontSee('Staf Tersembunyi');

        $this->get(route('karier.show', 'management-representative'))
            ->assertOk()
            ->assertSee('Pendidikan minimal S1');

        $this->get(route('karier.show', 'staf-tersembunyi'))->assertNotFound();
    }

    public function test_application_documents_are_stored_on_private_disk(): void
    {
        $this->post(route('karier.apply'), $this->payload())
            ->assertRedirect(route('karier.index'))
            ->assertSessionHasNoErrors();

        $lamaran = LamaranKarir::sole();
        Storage::disk('local')->assertExists($lamaran->cv);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_application_for_unknown_or_hidden_opening_is_rejected(): void
    {
        $this->post(route('karier.apply'), $this->payload(['posisi' => 'tidak-ada']))->assertSessionHasErrors('posisi');

        Lowongan::where('slug', 'management-representative')->update(['tampil' => false]);
        $this->post(route('karier.apply'), $this->payload())->assertSessionHasErrors('posisi');

        $this->assertSame(0, LamaranKarir::count());
    }

    public function test_filled_honeypot_is_silently_discarded(): void
    {
        $this->post(route('karier.apply'), $this->payload(['website' => 'http://spam.example']))
            ->assertRedirect(route('karier.index'))
            ->assertSessionHas('success');

        $this->assertSame(0, LamaranKarir::count());
        $this->assertSame([], Storage::disk('local')->allFiles());
    }

    public function test_application_endpoint_is_rate_limited(): void
    {
        foreach (range(1, 5) as $_) {
            $this->post(route('karier.apply'), ['website' => 'bot']);
        }

        $this->post(route('karier.apply'), ['website' => 'bot'])->assertStatus(429);
    }

    public function test_application_is_saved_even_when_sheets_webhook_fails(): void
    {
        config(['google-sheets.webhook_url' => 'https://script.google.test/exec']);
        Http::fake(['*' => Http::response(['status' => 'error', 'message' => 'Token tidak valid.'])]);

        $this->post(route('karier.apply'), $this->payload())->assertRedirect(route('karier.index'));

        $this->assertSame(1, LamaranKarir::count());
    }

    public function test_sheets_webhook_receives_row_with_admin_only_document_links(): void
    {
        config(['google-sheets.webhook_url' => 'https://script.google.test/exec', 'google-sheets.webhook_token' => 'rahasia']);
        Http::fake(['*' => Http::response(['status' => 'ok'])]);

        $this->post(route('karier.apply'), $this->payload());

        $lamaran = LamaranKarir::sole();
        Http::assertSent(fn ($request) => $request['token'] === 'rahasia'
            && in_array(route('lamaran.dokumen', [$lamaran, 'cv']), $request['values'], true)
            && ! collect($request['values'])->contains(fn ($v) => str_contains((string) $v, '/storage/')));
    }

    public function test_no_sheets_request_without_webhook_url(): void
    {
        config(['google-sheets.webhook_url' => '']);
        Http::fake();

        $this->post(route('karier.apply'), $this->payload());

        Http::assertNothingSent();
    }

    public function test_guest_is_redirected_to_login_when_opening_document(): void
    {
        $lamaran = $this->lamaran();

        $this->get(route('lamaran.dokumen', [$lamaran, 'cv']))->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_open_document(): void
    {
        $lamaran = $this->lamaran();

        $this->actingAs(User::factory()->create())
            ->get(route('lamaran.dokumen', [$lamaran, 'cv']))
            ->assertForbidden();
    }

    public function test_admin_can_open_document_but_not_arbitrary_columns(): void
    {
        $lamaran = $this->lamaran();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('lamaran.dokumen', [$lamaran, 'cv']))->assertOk();
        $this->actingAs($admin)->get(route('lamaran.dokumen', [$lamaran, 'nomor_whatsapp']))->assertNotFound();
        // Kolom valid tapi filenya tidak ada di disk.
        $this->actingAs($admin)->get(route('lamaran.dokumen', [$lamaran, 'ijazah']))->assertNotFound();
    }
}
