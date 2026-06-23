<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LamaranKarirResource\Pages;
use App\Models\LamaranKarir;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class LamaranKarirResource extends Resource
{
    protected static ?string $model = LamaranKarir::class;

    protected static ?string $navigationIcon   = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel  = 'Lamaran Karir';
    protected static ?string $navigationGroup  = 'Karir';
    protected static ?int    $navigationSort   = 1;
    protected static ?string $modelLabel       = 'Lamaran';
    protected static ?string $pluralModelLabel = 'Lamaran Karir';

    protected static array $statusOptions = [
        'submitted' => 'Masuk',
        'reviewed'  => 'Ditinjau',
        'accepted'  => 'Diterima',
        'rejected'  => 'Ditolak',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Posisi & Status')
                    ->schema([
                        Forms\Components\TextInput::make('posisi')
                            ->label('Posisi Dilamar')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->label('Status Lamaran')
                            ->options(self::$statusOptions)
                            ->required()
                            ->native(false),
                    ])->columns(2),

                Forms\Components\Section::make('Data Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->disabled(),
                        Forms\Components\TextInput::make('tempat_tanggal_lahir')
                            ->label('Tempat, Tanggal Lahir')
                            ->disabled(),
                        Forms\Components\TextInput::make('nomor_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->disabled(),
                        Forms\Components\TextInput::make('domisili')
                            ->label('Domisili')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Pendidikan & Pengalaman')
                    ->schema([
                        Forms\Components\TextInput::make('pendidikan_terakhir')
                            ->label('Pendidikan Terakhir')
                            ->disabled(),
                        Forms\Components\TextInput::make('jurusan')
                            ->label('Jurusan')
                            ->disabled(),
                        Forms\Components\TextInput::make('pengalaman_kerja')
                            ->label('Pengalaman Bidang Penjaminan Mutu')
                            ->disabled(),
                        Forms\Components\TextInput::make('sertifikat_iso')
                            ->label('Memiliki Sertifikat ISO 21001/17024?')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Pengalaman')
                    ->schema([
                        Forms\Components\Textarea::make('sertifikat_list')
                            ->label('Daftar Sertifikat yang Dimiliki')
                            ->disabled()
                            ->rows(3),
                        Forms\Components\Textarea::make('pengalaman_audit')
                            ->label('Pengalaman Audit Internal / Sistem Mutu')
                            ->disabled()
                            ->rows(3),
                    ])->columnSpanFull(),

                Forms\Components\Section::make('Dokumen Pelamar')
                    ->description('Klik tautan untuk mengunduh dokumen.')
                    ->schema([
                        Forms\Components\Placeholder::make('cv_link')
                            ->label('CV')
                            ->content(fn ($record) => $record?->cv
                                ? new \Illuminate\Support\HtmlString(
                                    '<a href="'.Storage::disk('public')->url($record->cv).'" target="_blank" class="text-primary-600 underline">⬇ Unduh CV</a>'
                                )
                                : '—'),
                        Forms\Components\Placeholder::make('portofolio_link')
                            ->label('Portofolio')
                            ->content(fn ($record) => $record?->portofolio
                                ? new \Illuminate\Support\HtmlString(
                                    '<a href="'.Storage::disk('public')->url($record->portofolio).'" target="_blank" class="text-primary-600 underline">⬇ Unduh Portofolio</a>'
                                )
                                : '—'),
                        Forms\Components\Placeholder::make('ijazah_link')
                            ->label('Ijazah Terakhir')
                            ->content(fn ($record) => $record?->ijazah
                                ? new \Illuminate\Support\HtmlString(
                                    '<a href="'.Storage::disk('public')->url($record->ijazah).'" target="_blank" class="text-primary-600 underline">⬇ Unduh Ijazah</a>'
                                )
                                : '—'),
                        Forms\Components\Placeholder::make('sertifikat_link')
                            ->label('Sertifikat Pelatihan')
                            ->content(fn ($record) => $record?->sertifikat_pelatihan
                                ? new \Illuminate\Support\HtmlString(
                                    '<a href="'.Storage::disk('public')->url($record->sertifikat_pelatihan).'" target="_blank" class="text-primary-600 underline">⬇ Unduh Sertifikat</a>'
                                )
                                : '—'),
                    ])->columns(2),

                Forms\Components\Section::make('Lainnya & Catatan Admin')
                    ->schema([
                        Forms\Components\Toggle::make('bersedia_fulltime')
                            ->label('Bersedia Full-time di Mijen, Semarang Barat')
                            ->disabled(),
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Admin')
                            ->helperText('Hanya terlihat oleh admin.')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Pelamar')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('posisi')
                    ->label('Posisi')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn ($state) => str($state)->title()->replace('-', ' ')),
                Tables\Columns\TextColumn::make('pendidikan_terakhir')
                    ->label('Pendidikan')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('pengalaman_kerja')
                    ->label('Pengalaman Mutu')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('nomor_whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor disalin'),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options(self::$statusOptions)
                    ->sortable(),
                Tables\Columns\IconColumn::make('bersedia_fulltime')
                    ->label('Full-time?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::$statusOptions),
                Tables\Filters\SelectFilter::make('posisi')
                    ->label('Posisi')
                    ->options(fn () => LamaranKarir::query()
                        ->distinct()
                        ->pluck('posisi', 'posisi')
                        ->mapWithKeys(fn ($v) => [$v => str($v)->title()->replace('-', ' ')])
                        ->toArray()
                    ),
                Tables\Filters\SelectFilter::make('pendidikan_terakhir')
                    ->label('Pendidikan')
                    ->options(['S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3']),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->label('Update Status'),
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
            'index' => Pages\ListLamaranKarirs::route('/'),
            'view'  => Pages\ViewLamaranKarir::route('/{record}'),
            'edit'  => Pages\EditLamaranKarir::route('/{record}/edit'),
        ];
    }
}
