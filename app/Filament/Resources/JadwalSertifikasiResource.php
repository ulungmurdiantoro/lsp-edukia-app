<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalSertifikasiResource\Pages;
use App\Models\JadwalSertifikasi;
use App\Support\Skemas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JadwalSertifikasiResource extends Resource
{
    protected static ?string $model = JadwalSertifikasi::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Jadwal Sertifikasi';
    protected static ?string $modelLabel = 'Jadwal Sertifikasi';
    protected static ?string $pluralModelLabel = 'Jadwal Sertifikasi';
    protected static ?int $navigationSort = 4;

    private static function bidangOptions(): array
    {
        return collect(Skemas::bidangs())->map(fn ($b) => $b['label'])->all();
    }

    private static function skemaOptionsGrouped(): array
    {
        return Skemas::all()
            ->groupBy('bidang')
            ->mapWithKeys(fn ($group, $bidang) => [
                Skemas::bidangs()[$bidang]['label'] => $group->pluck('nama', 'nama')->all(),
            ])
            ->all();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('skema')
                ->label('Skema Sertifikasi')
                ->required()
                ->searchable()
                ->live()
                ->afterStateUpdated(function (Set $set, ?string $state): void {
                    $skema = Skemas::all()->firstWhere('nama', $state);
                    $set('bidang', $skema['bidang'] ?? null);
                })
                ->options(self::skemaOptionsGrouped())
                ->columnSpanFull(),

            Forms\Components\Select::make('bidang')
                ->label('Sektor')
                ->required()
                ->disabled()
                ->dehydrated()
                ->hint('Terisi otomatis saat skema dipilih')
                ->options(self::bidangOptions()),

            Forms\Components\DatePicker::make('tanggal_sertifikasi')
                ->label('Tanggal Sertifikasi')
                ->required(),

            Forms\Components\Toggle::make('tampil')
                ->label('Tampilkan di Website')
                ->default(true)
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('skema')
                ->label('Skema')
                ->searchable()
                ->sortable()
                ->wrap(),

            Tables\Columns\TextColumn::make('bidang')
                ->label('Sektor')
                ->badge()
                ->formatStateUsing(fn (string $state): string => Skemas::bidangs()[$state]['label'] ?? $state),

            Tables\Columns\TextColumn::make('tanggal_sertifikasi')
                ->label('Tanggal Sertifikasi')
                ->date('d M Y')
                ->sortable(),

            Tables\Columns\IconColumn::make('tampil')
                ->label('Tampil')
                ->boolean(),
        ])
        ->defaultSort('tanggal_sertifikasi', 'asc')
        ->filters([
            Tables\Filters\SelectFilter::make('bidang')
                ->label('Sektor')
                ->options(fn () => self::bidangOptions()),

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
            'index' => Pages\ListJadwalSertifikasis::route('/'),
            'create' => Pages\CreateJadwalSertifikasi::route('/create'),
            'edit' => Pages\EditJadwalSertifikasi::route('/{record}/edit'),
        ];
    }
}
