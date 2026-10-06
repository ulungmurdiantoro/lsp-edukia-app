<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookletResource\Pages;
use App\Models\Booklet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BookletResource extends Resource
{
    protected static ?string $model = Booklet::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Booklet';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Booklet';
    protected static ?string $pluralModelLabel = 'Booklet';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Forms\Components\Textarea::make('deskripsi')
                ->rows(3)
                ->maxLength(500)
                ->helperText('Ringkasan singkat isi booklet, tampil di bawah judul.')
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('cover')
                ->label('Sampul')
                ->image()
                ->disk('public')
                ->directory('booklet/cover')
                ->maxSize(2048)
                ->helperText('Opsional. Gambar potret (mis. halaman depan booklet), maks. 2 MB.')
                ->columnSpanFull(),

            Forms\Components\Section::make('File Booklet')
                ->description('Isi salah satu: unggah PDF atau tempel tautan (Google Drive, Canva, flipbook, dll.). Bila keduanya diisi, PDF yang dipakai.')
                ->schema([
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
                        ->helperText('Maks. 10 MB. Booklet yang lebih besar: unggah ke Google Drive lalu isi tautannya.'),

                    Forms\Components\TextInput::make('link')
                        ->label('Tautan Eksternal')
                        ->url()
                        ->maxLength(2048)
                        ->placeholder('https://')
                        ->requiredWithout('file'),
                ]),

            Forms\Components\TextInput::make('urutan')
                ->numeric()
                ->default(0)
                ->helperText('Angka kecil tampil lebih dulu.'),

            Forms\Components\Toggle::make('tampil')
                ->label('Tampilkan di Website')
                ->helperText('Menu "Booklet" di nav bar hanya muncul bila ada minimal satu booklet yang ditampilkan.')
                ->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('cover')
                ->label('Sampul')
                ->disk('public')
                ->height(64),

            Tables\Columns\TextColumn::make('judul')
                ->searchable()
                ->wrap(),

            Tables\Columns\TextColumn::make('sumber')
                ->state(fn (Booklet $record): string => $record->file ? 'PDF' : 'Tautan')
                ->badge()
                ->color(fn (string $state): string => $state === 'PDF' ? 'info' : 'gray'),

            Tables\Columns\IconColumn::make('tampil')
                ->label('Tampil')
                ->boolean(),

            Tables\Columns\TextColumn::make('urutan')
                ->sortable(),
        ])
        ->defaultSort('urutan')
        ->reorderable('urutan')
        ->filters([
            Tables\Filters\TernaryFilter::make('tampil')->label('Ditampilkan'),
        ])
        ->actions([
            Tables\Actions\Action::make('buka')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (Booklet $record): ?string => $record->url())
                ->openUrlInNewTab(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooklets::route('/'),
            'create' => Pages\CreateBooklet::route('/create'),
            'edit' => Pages\EditBooklet::route('/{record}/edit'),
        ];
    }
}
