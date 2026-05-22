<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanResource\Pages;
use App\Models\Kegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KegiatanResource extends Resource
{
    protected static ?string $model = Kegiatan::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Kegiatan & Dokumentasi';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')->required()->columnSpanFull(),
            Forms\Components\FileUpload::make('foto')
                ->required()
                ->image()
                ->directory('kegiatan')
                ->columnSpanFull(),
            Forms\Components\Textarea::make('deskripsi')->rows(3)->columnSpanFull(),
            Forms\Components\DatePicker::make('tanggal')->required()->default(now()),
            Forms\Components\TextInput::make('urutan')->numeric()->default(0),
            Forms\Components\Toggle::make('tampilkan')->default(true)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('foto')->disk('public')->square(),
            Tables\Columns\TextColumn::make('judul')->searchable()->limit(50),
            Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable(),
            Tables\Columns\IconColumn::make('tampilkan')->boolean(),
            Tables\Columns\TextColumn::make('urutan')->sortable(),
        ])
        ->defaultSort('tanggal', 'desc')
        ->reorderable('urutan')
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKegiatans::route('/'),
            'create' => Pages\CreateKegiatan::route('/create'),
            'edit'   => Pages\EditKegiatan::route('/{record}/edit'),
        ];
    }
}
