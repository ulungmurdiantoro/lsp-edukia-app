<?php

namespace Tests\Feature;

use App\Filament\Resources\BookletResource\Pages\CreateBooklet;
use App\Filament\Resources\BookletResource\Pages\EditBooklet;
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

    public function test_nav_hides_booklet_until_a_visible_booklet_exists(): void
    {
        Booklet::create(['judul' => 'Draf', 'link' => 'https://example.com/draf', 'tampil' => false]);

        $navLink = 'href="'.route('booklet').'" class="menu-booklet"';

        $this->get(route('home'))->assertOk()->assertDontSee($navLink, false);

        Booklet::create(['judul' => 'Company Profile', 'link' => 'https://example.com/cp', 'tampil' => true]);

        $this->get(route('home'))->assertOk()->assertSee($navLink, false);
    }

    public function test_booklet_page_shows_empty_state_without_booklets(): void
    {
        $this->get(route('booklet'))->assertOk()->assertSee('Belum ada booklet yang dipublikasikan.');
    }

    public function test_booklet_page_lists_visible_booklets_with_read_and_download_links(): void
    {
        Storage::disk('public')->put('booklet/profil-lsp-edukia-abc123.pdf', '%PDF-1.4 test');

        Booklet::create(['judul' => 'Profil LSP Edukia', 'file' => 'booklet/profil-lsp-edukia-abc123.pdf', 'urutan' => 1]);
        Booklet::create(['judul' => 'Katalog Skema', 'link' => 'https://example.com/flipbook', 'urutan' => 2]);
        Booklet::create(['judul' => 'Booklet Tersembunyi', 'link' => 'https://example.com/x', 'tampil' => false]);

        $this->get(route('booklet'))
            ->assertOk()
            ->assertSeeInOrder(['Profil LSP Edukia', 'Katalog Skema'])
            ->assertSee(Storage::disk('public')->url('booklet/profil-lsp-edukia-abc123.pdf'), false)
            ->assertSee('download="profil-lsp-edukia.pdf"', false)
            ->assertSee('https://example.com/flipbook', false)
            ->assertDontSee('Booklet Tersembunyi');
    }

    public function test_admin_can_view_booklet_pages(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get('/admin/booklets')->assertOk();
        $this->get('/admin/booklets/create')->assertOk();
    }

    public function test_admin_can_create_booklet_from_external_link(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(CreateBooklet::class)
            ->fillForm([
                'judul' => 'Company Profile',
                'link' => 'https://drive.google.com/file/d/abc/view',
                'tampil' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('booklets', ['judul' => 'Company Profile', 'file' => null]);
    }

    public function test_admin_can_create_booklet_by_uploading_pdf(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(CreateBooklet::class)
            ->fillForm([
                'judul' => 'Company Profile',
                'file' => UploadedFile::fake()->create('Company Profile 2026.pdf', 500, 'application/pdf'),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $booklet = Booklet::firstOrFail();
        $this->assertMatchesRegularExpression('#^booklet/company-profile-2026-[a-z0-9]{6}\.pdf$#', $booklet->file);
        Storage::disk('public')->assertExists($booklet->file);
    }

    public function test_booklet_requires_pdf_or_link(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(CreateBooklet::class)
            ->fillForm(['judul' => 'Tanpa File'])
            ->call('create')
            ->assertHasFormErrors(['file' => 'required', 'link' => 'required_without']);

        $this->assertDatabaseCount('booklets', 0);
    }

    public function test_replacing_and_deleting_booklet_removes_old_files(): void
    {
        Storage::disk('public')->put('booklet/lama.pdf', '%PDF-1.4 lama');
        Storage::disk('public')->put('booklet/baru.pdf', '%PDF-1.4 baru');
        $booklet = Booklet::create(['judul' => 'Profil', 'file' => 'booklet/lama.pdf']);

        $booklet->update(['file' => 'booklet/baru.pdf']);
        Storage::disk('public')->assertMissing('booklet/lama.pdf');
        Storage::disk('public')->assertExists('booklet/baru.pdf');

        $booklet->delete();
        Storage::disk('public')->assertMissing('booklet/baru.pdf');
    }

    public function test_admin_edit_page_loads_existing_booklet(): void
    {
        $this->actingAs(User::factory()->admin()->create());
        $booklet = Booklet::create(['judul' => 'Profil', 'link' => 'https://example.com/profil']);

        Livewire::test(EditBooklet::class, ['record' => $booklet->getRouteKey()])
            ->assertFormSet(['judul' => 'Profil', 'link' => 'https://example.com/profil']);
    }
}
