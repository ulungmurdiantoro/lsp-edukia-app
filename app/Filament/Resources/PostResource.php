<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Blog & Artikel';
    protected static ?string $modelLabel = 'Artikel';
    protected static ?string $pluralModelLabel = 'Blog & Artikel';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Konten Utama')->schema([
                Forms\Components\TextInput::make('judul')
                    ->label('Judul Artikel')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $state, Set $set) => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->hint('Auto-dibuat dari judul — dapat diedit manual')
                    ->prefix('/')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('ringkasan')
                    ->label('Ringkasan / Excerpt')
                    ->required()
                    ->rows(3)
                    ->maxLength(300)
                    ->hint('Tampil di kartu artikel dan meta description')
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('konten')
                    ->label('Konten Artikel')
                    ->required()
                    ->toolbarButtons([
                        'bold', 'italic', 'underline',
                        'h2', 'h3',
                        'bulletList', 'orderedList', 'blockquote',
                        'link', 'strike',
                        'undo', 'redo',
                    ])
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Metadata & Publikasi')->schema([
                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Gambar Utama')
                    ->image()
                    ->directory('posts')
                    ->imageCropAspectRatio('16:9')
                    ->hint('Rasio 16:9 direkomendasikan'),

                Forms\Components\Select::make('kategori')
                    ->label('Kategori')
                    ->required()
                    ->options([
                        'Tips Sertifikasi' => 'Tips Sertifikasi',
                        'Info Skema'       => 'Info Skema',
                        'Industri'         => 'Industri',
                        'Pelatihan'        => 'Pelatihan',
                        'Kegiatan'         => 'Kegiatan',
                    ]),

                Forms\Components\TextInput::make('penulis')
                    ->label('Penulis')
                    ->default('Tim LSP Edukia'),

                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Waktu Publikasi')
                    ->default(now()),

                Forms\Components\Toggle::make('published')
                    ->label('Publikasikan Artikel')
                    ->default(false)
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('thumbnail')
                ->label('Gambar')
                ->disk('public')
                ->width(80)
                ->height(50),

            Tables\Columns\TextColumn::make('judul')
                ->label('Judul')
                ->searchable()
                ->sortable()
                ->limit(55)
                ->tooltip(fn ($record) => $record->judul),

            Tables\Columns\TextColumn::make('kategori')
                ->label('Kategori')
                ->badge()
                ->color(fn (string $state): string => match($state) {
                    'Tips Sertifikasi' => 'success',
                    'Info Skema'       => 'primary',
                    'Industri'         => 'warning',
                    'Pelatihan'        => 'info',
                    'Kegiatan'         => 'gray',
                    default            => 'gray',
                }),

            Tables\Columns\TextColumn::make('penulis')
                ->label('Penulis')
                ->sortable(),

            Tables\Columns\TextColumn::make('published_at')
                ->label('Publikasi')
                ->dateTime('d M Y, H:i')
                ->sortable(),

            Tables\Columns\IconColumn::make('published')
                ->label('Live')
                ->boolean(),
        ])
        ->defaultSort('published_at', 'desc')
        ->filters([
            Tables\Filters\SelectFilter::make('kategori')
                ->options([
                    'Tips Sertifikasi' => 'Tips Sertifikasi',
                    'Info Skema'       => 'Info Skema',
                    'Industri'         => 'Industri',
                    'Pelatihan'        => 'Pelatihan',
                    'Kegiatan'         => 'Kegiatan',
                ]),
            Tables\Filters\TernaryFilter::make('published')->label('Status Publikasi'),
        ])
        ->actions([
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
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
