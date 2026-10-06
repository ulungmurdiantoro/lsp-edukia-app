<?php

namespace App\Filament\Pages;

use App\Models\Booklet;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * Booklet hanya satu dokumen, jadi dikelola sebagai satu formulir (bukan tabel/resource).
 */
class KelolaBooklet extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Booklet';
    protected static ?string $title = 'Booklet';
    protected static ?string $slug = 'booklet';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.kelola-booklet';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            Booklet::first()?->only(['judul', 'file', 'link', 'tampil'])
                ?? ['judul' => 'Booklet LSP Edukia', 'tampil' => true]
        );
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')
                ->required()
                ->maxLength(255)
                ->helperText('Tampil di atas halaman baca dan menjadi nama file saat diunduh.'),

            Forms\Components\FileUpload::make('file')
                ->label('File PDF')
                ->disk('public')
                ->directory('booklet')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(10240)
                // Nama file terbaca (bukan ULID) karena URL PDF ikut dibagikan pengunjung.
                ->getUploadedFileNameForStorageUsing(fn (TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    .'-'.Str::lower(Str::random(6)).'.pdf')
                ->openable()
                ->downloadable()
                // Bukan requiredWithout(): aturan kustom FileUpload diterapkan per file, jadi tak jalan saat kosong.
                ->required(fn (Get $get): bool => blank($get('link')))
                ->helperText('Maks. 10 MB. Pengunjung langsung membacanya di halaman /booklet. File lama otomatis terhapus saat diganti.'),

            Forms\Components\TextInput::make('link')
                ->label('Atau Tautan Eksternal')
                ->url()
                ->maxLength(2048)
                ->placeholder('https://')
                ->requiredWithout('file')
                ->helperText('Untuk booklet di atas 10 MB (Google Drive, Canva, flipbook). Dipakai hanya bila File PDF kosong — menu Booklet akan langsung membuka tautan ini.'),

            Forms\Components\Toggle::make('tampil')
                ->label('Tampilkan menu Booklet di website'),
        ])->statePath('data');
    }

    /** @return array<Action> */
    protected function getFormActions(): array
    {
        return [
            Action::make('simpan')->label('Simpan')->submit('save'),
        ];
    }

    /** @return array<Action> */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('lihat')
                ->label('Lihat di Website')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(route('booklet'))
                ->openUrlInNewTab()
                ->visible(fn (): bool => Booklet::aktif() !== null),
        ];
    }

    public function save(): void
    {
        Booklet::firstOrNew()->fill($this->form->getState())->save();

        Notification::make()->success()->title('Booklet disimpan.')->send();
    }
}
