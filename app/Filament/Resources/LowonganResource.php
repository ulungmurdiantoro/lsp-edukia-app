<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LowonganResource\Pages;
use App\Models\LamaranKarir;
use App\Models\Lowongan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LowonganResource extends Resource
{
    protected static ?string $model = Lowongan::class;
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Lowongan';
    protected static ?string $navigationGroup = 'Karir';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Lowongan';
    protected static ?string $pluralModelLabel = 'Lowongan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')
                ->label('Judul Posisi')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Set $set, ?string $state, string $operation): void {
                    if ($operation === 'create') {
                        $set('slug', Str::slug($state));
                    }
                })
                ->columnSpanFull(),

            Forms\Components\TextInput::make('slug')
                ->label('Slug URL')
                ->required()
                ->unique(ignoreRecord: true)
                ->alphaDash()
                // Slug tersimpan di lamaran_karirs.posisi — mengubahnya memutus kaitan ke lamaran lama.
                ->disabledOn('edit')
                ->helperText('Tidak bisa diubah setelah dibuat (dipakai untuk mengaitkan lamaran).'),

            Forms\Components\TextInput::make('kategori')
                ->required()
                ->maxLength(100),

            Forms\Components\TextInput::make('lokasi')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('tipe')
                ->required()
                ->options([
                    'Full-time' => 'Full-time',
                    'Part-time' => 'Part-time',
                    'Kontrak' => 'Kontrak',
                    'Magang' => 'Magang',
                    'Freelance' => 'Freelance',
                ])
                ->native(false),

            Forms\Components\Textarea::make('deskripsi')
                ->required()
                ->rows(3)
                ->columnSpanFull(),

            Forms\Components\Repeater::make('requirements')
                ->label('Persyaratan')
                ->simple(Forms\Components\TextInput::make('item')->required())
                ->required()
                ->reorderable()
                ->columnSpanFull(),

            Forms\Components\Repeater::make('responsibilities')
                ->label('Tanggung Jawab')
                ->simple(Forms\Components\TextInput::make('item')->required())
                ->required()
                ->reorderable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('urutan')
                ->numeric()
                ->default(0)
                ->helperText('Angka kecil tampil lebih dulu.'),

            Forms\Components\Toggle::make('tampil')
                ->label('Tampilkan di Website')
                ->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('judul')
                ->searchable()
                ->sortable()
                ->wrap(),

            Tables\Columns\TextColumn::make('kategori')
                ->badge()
                ->color('gray'),

            Tables\Columns\TextColumn::make('tipe')
                ->badge()
                ->color('info'),

            Tables\Columns\TextColumn::make('lamaran_count')
                ->label('Lamaran')
                ->state(fn (Lowongan $record) => LamaranKarir::where('posisi', $record->slug)->count()),

            Tables\Columns\IconColumn::make('tampil')
                ->label('Tampil')
                ->boolean(),
        ])
        ->defaultSort('urutan')
        ->filters([
            Tables\Filters\TernaryFilter::make('tampil')->label('Ditampilkan'),
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
            'index' => Pages\ListLowongans::route('/'),
            'create' => Pages\CreateLowongan::route('/create'),
            'edit' => Pages\EditLowongan::route('/{record}/edit'),
        ];
    }
}
