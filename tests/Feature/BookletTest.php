<?php

namespace Tests\Feature;

use App\Filament\Pages\KelolaBooklet;
use App\Models\Booklet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class BookletTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_nav_hides_booklet_until_admin_shows_it(): void
    {
        $navLink = 'href="'.route('booklet').'" class="menu-booklet"';
        $booklet = Booklet::create(['judul' => 'Booklet', 'file' => 'booklet/a.pdf', 'tampil' => false]);

        $this->get(route('home'))->assertOk()->assertDontSee($navLink, false);
        $this->get(route('booklet'))->assertNotFound();

        $booklet->update(['tampil' => true]);

        $this->get(route('home'))->assertOk()->assertSee($navLink, false);
    }

    public function test_booklet_page_opens_pdf_in_reading_mode(): void
    {
        Storage::disk('public')->put('booklet/profil-lsp-edukia-abc123.pdf', '%PDF-1.4 test');
        Booklet::create(['judul' => 'Profil LSP Edukia', 'file' => 'booklet/profil-lsp-edukia-abc123.pdf']);

        $this->get(route('booklet'))
            ->assertOk()
            ->assertSee('Profil LSP Edukia')
            ->assertSee(json_encode(Storage::disk('public')->url('booklet/profil-lsp-edukia-abc123.pdf')), false)
            ->assertSee('download="profil-lsp-edukia.pdf"', false)
            ->assertSee(json_encode(asset('vendor/pdfjs/pdf.min.js')), false);
    }

    public function test_external_link_booklet_redirects_and_opens_in_new_tab(): void
    {
        Booklet::create(['judul' => 'Flipbook', 'link' => 'https://example.com/flipbook']);

        $this->get(route('booklet'))->assertRedirect('https://example.com/flipbook');
        $this->assertMatchesRegularExpression(
            '#class="menu-booklet"\s+target="_blank"#',
            $this->get(route('home'))->getContent()
        );
    }

    public function test_pdfjs_assets_exist(): void
    {
        $this->assertFileExists(public_path('vendor/pdfjs/pdf.min.js'));
        $this->assertFileExists(public_path('vendor/pdfjs/pdf.worker.min.js'));
    }

    public function test_admin_can_view_booklet_page(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get('/admin/booklet')->assertOk();
    }

    public function test_admin_saving_twice_keeps_a_single_booklet(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(KelolaBooklet::class)
            ->fillForm(['judul' => 'Booklet 2025', 'link' => 'https://example.com/2025', 'tampil' => true])
            ->call('save')
            ->assertHasNoFormErrors();

        Livewire::test(KelolaBooklet::class)
            ->assertFormSet(['judul' => 'Booklet 2025', 'link' => 'https://example.com/2025'])
            ->fillForm(['judul' => 'Booklet 2026'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(1, Booklet::count());
        $this->assertSame('Booklet 2026', Booklet::first()->judul);
    }

    public function test_admin_can_upload_pdf(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(KelolaBooklet::class)
            ->fillForm([
                'judul' => 'Company Profile',
                'file' => UploadedFile::fake()->create('Company Profile 2026.pdf', 500, 'application/pdf'),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $booklet = Booklet::firstOrFail();
        $this->assertMatchesRegularExpression('#^booklet/company-profile-2026-[a-z0-9]{6}\.pdf$#', $booklet->file);
        Storage::disk('public')->assertExists($booklet->file);
    }

    public function test_booklet_requires_pdf_or_link(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(KelolaBooklet::class)
            ->fillForm(['judul' => 'Tanpa File'])
            ->call('save')
            ->assertHasFormErrors(['file' => 'required', 'link' => 'required_without']);

        $this->assertDatabaseCount('booklets', 0);
    }

    public function test_replacing_pdf_removes_old_file(): void
    {
        Storage::disk('public')->put('booklet/lama.pdf', '%PDF-1.4 lama');
        Storage::disk('public')->put('booklet/baru.pdf', '%PDF-1.4 baru');
        $booklet = Booklet::create(['judul' => 'Profil', 'file' => 'booklet/lama.pdf']);

        $booklet->update(['file' => 'booklet/baru.pdf']);

        Storage::disk('public')->assertMissing('booklet/lama.pdf');
        Storage::disk('public')->assertExists('booklet/baru.pdf');
    }
}
