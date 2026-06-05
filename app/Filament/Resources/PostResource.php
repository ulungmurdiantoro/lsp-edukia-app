<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Support\SeoAnalyzer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
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

                Forms\Components\TextInput::make('short_code')
                    ->label('Short Link')
                    ->unique(ignoreRecord: true)
                    ->prefix(url('/b').'/')
                    ->placeholder('mis. auditor-2026')
                    ->hint('Link pendek untuk dibagikan — kosongkan untuk dibuat otomatis')
                    ->dehydrateStateUsing(fn (?string $state) => $state ? Str::slug($state) : null)
                    ->helperText('Hanya huruf, angka, dan tanda hubung. Akan diarahkan ke artikel ini.')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('ringkasan')
                    ->label('Ringkasan / Excerpt')
                    ->required()
                    ->rows(3)
                    ->maxLength(300)
                    ->live(onBlur: true)
                    ->hint('Tampil di kartu artikel dan meta description')
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('konten')
                    ->label('Konten Artikel')
                    ->required()
                    ->live(onBlur: true)
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
                    ->live()
                    ->hint('Rasio 16:9 direkomendasikan'),

                Forms\Components\Select::make('kategori')
                    ->label('Kategori')
                    ->required()
                    ->options([
                        'Tips Sertifikasi' => 'Tips Sertifikasi',
                        'Info Skema' => 'Info Skema',
                        'Industri' => 'Industri',
                        'Pelatihan' => 'Pelatihan',
                        'Kegiatan' => 'Kegiatan',
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

            Forms\Components\Section::make('SEO (Mesin Pencari)')
                ->description('Override opsional ala Yoast. Kosongkan untuk memakai judul, ringkasan, dan gambar artikel secara otomatis.')
                ->icon('heroicon-o-magnifying-glass')
                ->relationship('seo')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Meta Title')
                        ->maxLength(70)
                        ->live(debounce: 400)
                        ->placeholder('Default: judul artikel + " — LSP Edukia"')
                        ->helperText(fn (?string $state): string => 'Ideal ≤ 60 karakter. Saat ini: '.mb_strlen($state ?? '').' karakter.')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('description')
                        ->label('Meta Description')
                        ->rows(3)
                        ->maxLength(180)
                        ->live(debounce: 400)
                        ->placeholder('Default: ringkasan artikel')
                        ->helperText(fn (?string $state): string => 'Ideal 140–155 karakter. Saat ini: '.mb_strlen($state ?? '').' karakter.')
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar Social Share (OG Image)')
                        ->image()
                        ->disk('public')
                        ->directory('seo')
                        ->imageCropAspectRatio('1200:630')
                        ->helperText('Rasio 1200×630 px optimal untuk WhatsApp, Facebook, X/Twitter. Kosongkan untuk memakai thumbnail artikel.'),

                    Forms\Components\TextInput::make('canonical_url')
                        ->label('Canonical URL')
                        ->url()
                        ->placeholder('Otomatis ke URL artikel ini')
                        ->helperText('Isi hanya bila konten ini menduplikasi/menggabungkan halaman lain.'),

                    Forms\Components\Select::make('robots')
                        ->label('Indexing (robots)')
                        ->options([
                            'index,follow' => 'Index, Follow (default — tampil di Google)',
                            'noindex,follow' => 'Noindex, Follow (sembunyikan dari hasil pencarian)',
                            'noindex,nofollow' => 'Noindex, Nofollow',
                        ])
                        ->placeholder('Default (index, follow)')
                        ->helperText('Kosongkan untuk pengaturan default situs.'),
                ])
                ->columns(2)
                ->collapsed()
                ->collapsible(),

            Forms\Components\Section::make('Analisis SEO')
                ->description('Skor & checklist SEO real-time (ala Yoast). Perbarui saat Anda mengetik.')
                ->icon('heroicon-o-chart-bar')
                ->schema([
                    Forms\Components\TextInput::make('focus_keyword')
                        ->label('Keyword Fokus')
                        ->live(debounce: 500)
                        ->placeholder('mis. sertifikasi auditor SPMI')
                        ->helperText('Kata kunci utama yang ingin Anda targetkan untuk artikel ini.')
                        ->columnSpanFull(),

                    Forms\Components\Placeholder::make('seo_analysis')
                        ->hiddenLabel()
                        ->content(fn (Get $get) => view('filament.seo-analysis', [
                            'analysis' => SeoAnalyzer::analyze([
                                'judul' => $get('judul'),
                                'ringkasan' => $get('ringkasan'),
                                'konten' => $get('konten'),
                                'slug' => $get('slug'),
                                'thumbnail' => $get('thumbnail'),
                                'focus_keyword' => $get('focus_keyword'),
                            ]),
                        ]))
                        ->columnSpanFull(),
                ])
                ->collapsible(),
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
                ->color(fn (string $state): string => match ($state) {
                    'Tips Sertifikasi' => 'success',
                    'Info Skema' => 'primary',
                    'Industri' => 'warning',
                    'Pelatihan' => 'info',
                    'Kegiatan' => 'gray',
                    default => 'gray',
                }),

            Tables\Columns\TextColumn::make('short_code')
                ->label('Short Link')
                ->formatStateUsing(fn (?string $state) => $state ? '/b/'.$state : '—')
                ->copyable()
                ->copyableState(fn ($record) => $record->short_url)
                ->copyMessage('Short link disalin')
                ->tooltip('Klik untuk salin link lengkap')
                ->toggleable(),

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
                        'Info Skema' => 'Info Skema',
                        'Industri' => 'Industri',
                        'Pelatihan' => 'Pelatihan',
                        'Kegiatan' => 'Kegiatan',
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
