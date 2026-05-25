<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SertifikatResource\Pages;
use App\Models\Sertifikat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SertifikatResource extends Resource
{
    protected static ?string $model = Sertifikat::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Penerima Sertifikat';
    protected static ?string $modelLabel = 'Penerima Sertifikat';
    protected static ?string $pluralModelLabel = 'Daftar Penerima Sertifikat';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required(),

            Forms\Components\TextInput::make('gelar')
                ->label('Gelar')
                ->placeholder('S.T., M.T., dr., dll')
                ->nullable(),

            Forms\Components\Select::make('skema')
                ->label('Skema Sertifikasi')
                ->required()
                ->searchable()
                ->options([
                    'Auditor Internal SPMI Terintegrasi ISO 21001:2018'               => 'Auditor Internal SPMI Terintegrasi ISO 21001:2018',
                    'Lead Auditor Internal SPMI Terintegrasi ISO 21001:2018'          => 'Lead Auditor Internal SPMI Terintegrasi ISO 21001:2018',
                    'Lead Implementer SPMI Terintegrasi ISO 21001:2018'               => 'Lead Implementer SPMI Terintegrasi ISO 21001:2018',
                    'Training of Trainer (ToT) Outcome Based Education (OBE)'         => 'Training of Trainer (ToT) Outcome Based Education (OBE)',
                    'Implementer Tata Kelola Organisasi Perguruan Tinggi'             => 'Implementer Tata Kelola Organisasi Perguruan Tinggi',
                    'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017'        => 'Auditor Internal Standar Laboratorium ISO/IEC 17025:2017',
                    'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017'        => 'Lead Implementer Standar Laboratorium ISO/IEC 17025:2017',
                    'Lifting Engineer for Medium Lifting'                              => 'Lifting Engineer for Medium Lifting',
                    'Lifting Engineer for Heavy & Critical Lifting Operation'          => 'Lifting Engineer for Heavy & Critical Lifting Operation',
                    '2D Lifting Designer'                                             => '2D Lifting Designer',
                    '3D Lifting Designer'                                             => '3D Lifting Designer',
                    'Laboratory Quality System Officer ISO/IEC 17025'                 => 'Laboratory Quality System Officer ISO/IEC 17025',
                    'Food Safety Management Officer'                                   => 'Food Safety Management Officer',
                    'Panelis Terlatih Pengujian Sensori Pangan'                       => 'Panelis Terlatih Pengujian Sensori Pangan',
                    'GLP Laboratory Technician'                                        => 'GLP Laboratory Technician',
                    'Laboratory HSE Officer'                                           => 'Laboratory HSE Officer',
                    'Laboratory Operations Officer'                                    => 'Laboratory Operations Officer',
                    'Quality Management System (ISO 9001) Officer'                    => 'Quality Management System (ISO 9001) Officer',
                    'QC Laboratory Analyst'                                            => 'QC Laboratory Analyst',
                    'Quality Assurance Officer'                                        => 'Quality Assurance Officer',
                    'Research and Development Officer'                                 => 'Research and Development Officer',
                    'Regulatory Affairs Officer'                                       => 'Regulatory Affairs Officer',
                    'Sustainability Officer'                                           => 'Sustainability Officer',
                    'ESG Officer'                                                      => 'ESG Officer',
                    'Environmental Management System (ISO 14001) Officer'             => 'Environmental Management System (ISO 14001) Officer',
                    'Corporate Legal Officer'                                          => 'Corporate Legal Officer',
                ])
                ->columnSpanFull(),

            Forms\Components\Select::make('kategori')
                ->label('Kategori / Bidang')
                ->required()
                ->options([
                    'spmi'      => 'SPMI ISO 21001',
                    'pt'        => 'Perguruan Tinggi',
                    'lab17025'  => 'Lab ISO 17025',
                    'labtest'   => 'Lab & Pengujian',
                    'lifting'   => 'Lifting Engineering',
                    'manajemen' => 'Sistem Manajemen',
                    'hukum'     => 'Hukum Korporasi',
                ]),

            Forms\Components\TextInput::make('nomor_sertifikat')
                ->label('Nomor Sertifikat')
                ->required()
                ->unique(ignoreRecord: true)
                ->placeholder('EDUKIA-XXX-2026-001'),

            Forms\Components\TextInput::make('no_sk')
                ->label('No. SK')
                ->placeholder('SK/LSP-EGC/XXX/2026')
                ->nullable(),

            Forms\Components\TextInput::make('no_skema')
                ->label('No. Skema')
                ->placeholder('SKKNI No. XXX Tahun 2024')
                ->nullable(),

            Forms\Components\DatePicker::make('tanggal_terbit')
                ->label('Tanggal Terbit')
                ->required()
                ->default(now()),

            Forms\Components\DatePicker::make('tanggal_kadaluarsa')
                ->label('Tanggal Kadaluarsa')
                ->required()
                ->hint('Status aktif / akan kadaluarsa / kadaluarsa dihitung otomatis dari tanggal ini')
                ->after('tanggal_terbit'),

            Forms\Components\Toggle::make('tampil')
                ->label('Tampilkan di Website')
                ->default(true)
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nomor_sertifikat')
                ->label('Nomor Sertifikat')
                ->searchable()
                ->fontFamily('mono')
                ->copyable(),

            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Lengkap')
                ->description(fn ($record) => $record->gelar)
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('no_sk')
                ->label('No. SK')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('no_skema')
                ->label('No. Skema')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('skema')
                ->label('Skema')
                ->searchable()
                ->limit(40)
                ->tooltip(fn ($record) => $record->skema),

            Tables\Columns\TextColumn::make('kategori')
                ->label('Bidang')
                ->badge()
                ->color(fn (string $state): string => match($state) {
                    'spmi'      => 'primary',
                    'pt'        => 'gray',
                    'lab17025'  => 'success',
                    'labtest'   => 'success',
                    'lifting'   => 'warning',
                    'manajemen' => 'danger',
                    'hukum'     => 'gray',
                    default     => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => match($state) {
                    'spmi'      => 'SPMI ISO 21001',
                    'pt'        => 'Perguruan Tinggi',
                    'lab17025'  => 'Lab ISO 17025',
                    'labtest'   => 'Lab & Pengujian',
                    'lifting'   => 'Lifting',
                    'manajemen' => 'Sistem Manajemen',
                    'hukum'     => 'Hukum Korporasi',
                    default     => $state,
                }),

            Tables\Columns\TextColumn::make('tanggal_terbit')
                ->label('Tanggal Terbit')
                ->date('d M Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('tanggal_kadaluarsa')
                ->label('Kadaluarsa')
                ->date('d M Y')
                ->sortable()
                ->color(fn ($record): string => match($record->status) {
                    'kadaluarsa' => 'danger',
                    'expiring'   => 'warning',
                    default      => 'success',
                }),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match($state) {
                    'aktif'      => 'success',
                    'expiring'   => 'warning',
                    'kadaluarsa' => 'danger',
                    default      => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => match($state) {
                    'aktif'      => 'Aktif',
                    'expiring'   => 'Akan Kadaluarsa',
                    'kadaluarsa' => 'Kadaluarsa',
                    default      => $state,
                }),

            Tables\Columns\IconColumn::make('tampil')
                ->label('Tampil')
                ->boolean(),
        ])
        ->defaultSort('tanggal_kadaluarsa', 'asc')
        ->filters([
            Tables\Filters\SelectFilter::make('kategori')
                ->label('Bidang')
                ->options([
                    'spmi'      => 'SPMI ISO 21001',
                    'pt'        => 'Perguruan Tinggi',
                    'lab17025'  => 'Lab ISO 17025',
                    'labtest'   => 'Lab & Pengujian',
                    'lifting'   => 'Lifting Engineering',
                    'manajemen' => 'Sistem Manajemen',
                    'hukum'     => 'Hukum Korporasi',
                ]),

            Tables\Filters\Filter::make('status')
                ->form([
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->placeholder('Semua status')
                        ->options([
                            'aktif'      => 'Aktif',
                            'expiring'   => 'Akan Kadaluarsa (≤ 90 hari)',
                            'kadaluarsa' => 'Kadaluarsa',
                        ]),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return match($data['status'] ?? null) {
                        'aktif'      => $query->where(fn ($q) => $q
                            ->whereNull('tanggal_kadaluarsa')
                            ->orWhere('tanggal_kadaluarsa', '>', now()->addDays(90))),
                        'expiring'   => $query->whereBetween('tanggal_kadaluarsa', [now(), now()->addDays(90)]),
                        'kadaluarsa' => $query->where('tanggal_kadaluarsa', '<', now()),
                        default      => $query,
                    };
                })
                ->indicateUsing(function (array $data): ?string {
                    return match($data['status'] ?? null) {
                        'aktif'      => 'Status: Aktif',
                        'expiring'   => 'Status: Akan Kadaluarsa',
                        'kadaluarsa' => 'Status: Kadaluarsa',
                        default      => null,
                    };
                }),

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
            'index'  => Pages\ListSertifikats::route('/'),
            'create' => Pages\CreateSertifikat::route('/create'),
            'edit'   => Pages\EditSertifikat::route('/{record}/edit'),
        ];
    }
}
