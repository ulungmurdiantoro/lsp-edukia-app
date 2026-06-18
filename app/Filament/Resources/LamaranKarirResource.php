<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LamaranKarirResource\Pages;
use App\Filament\Resources\LamaranKarirResource\RelationManagers;
use App\Models\LamaranKarir;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LamaranKarirResource extends Resource
{
    protected static ?string $model = LamaranKarir::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Lamaran Karir';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Posisi')
                    ->schema([
                        Forms\Components\TextInput::make('posisi')
                            ->label('Posisi')
                            ->required()
                            ->readOnly(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'submitted' => 'Diterima',
                                'reviewed' => 'Ditinjau',
                                'rejected' => 'Ditolak',
                                'accepted' => 'Diterima',
                            ])
                            ->default('submitted'),
                    ])->columns(2),

                Forms\Components\Section::make('Data Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->required()
                            ->readOnly(),
                        Forms\Components\TextInput::make('tempat_tanggal_lahir')
                            ->label('Tempat, Tanggal Lahir')
                            ->required()
                            ->readOnly(),
                        Forms\Components\TextInput::make('nomor_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->required()
                            ->readOnly(),
                        Forms\Components\TextInput::make('domisili')
                            ->label('Domisili')
                            ->required()
                            ->readOnly(),
                    ])->columns(2),

                Forms\Components\Section::make('Pendidikan & Pengalaman')
                    ->schema([
                        Forms\Components\TextInput::make('pendidikan_terakhir')
                            ->label('Pendidikan Terakhir')
                            ->readOnly(),
                        Forms\Components\TextInput::make('jurusan')
                            ->label('Jurusan')
                            ->readOnly(),
                        Forms\Components\TextInput::make('pengalaman_kerja')
                            ->label('Pengalaman Kerja')
                            ->readOnly(),
                        Forms\Components\TextInput::make('sertifikat_iso')
                            ->label('Sertifikat ISO')
                            ->readOnly(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Pengalaman')
                    ->schema([
                        Forms\Components\Textarea::make('sertifikat_list')
                            ->label('Daftar Sertifikat')
                            ->readOnly(),
                        Forms\Components\Textarea::make('pengalaman_audit')
                            ->label('Pengalaman Audit Internal/Sistem Mutu')
                            ->readOnly(),
                    ])->columnSpanFull(),

                Forms\Components\Section::make('Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('cv')
                            ->label('CV')
                            ->readOnly()
                            ->helperText('File disimpan di storage'),
                        Forms\Components\TextInput::make('portofolio')
                            ->label('Portofolio')
                            ->readOnly()
                            ->helperText('File disimpan di storage'),
                        Forms\Components\TextInput::make('ijazah')
                            ->label('Ijazah')
                            ->readOnly()
                            ->helperText('File disimpan di storage'),
                        Forms\Components\TextInput::make('sertifikat_pelatihan')
                            ->label('Sertifikat Pelatihan')
                            ->readOnly()
                            ->helperText('File disimpan di storage'),
                    ])->columns(2),

                Forms\Components\Section::make('Tambahan')
                    ->schema([
                        Forms\Components\Toggle::make('bersedia_fulltime')
                            ->label('Bersedia Full-time')
                            ->readOnly(),
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Admin')
                            ->rows(3),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('posisi')
                    ->label('Posisi')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('nomor_whatsapp')
                    ->label('WhatsApp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir')
                    ->label('Pendidikan'),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'submitted' => 'Diterima',
                        'reviewed' => 'Ditinjau',
                        'rejected' => 'Ditolak',
                        'accepted' => 'Diterima',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Diterima',
                        'reviewed' => 'Ditinjau',
                        'rejected' => 'Ditolak',
                        'accepted' => 'Diterima',
                    ]),
                Tables\Filters\SelectFilter::make('posisi'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLamaranKarirs::route('/'),
            'create' => Pages\CreateLamaranKarir::route('/create'),
            'edit' => Pages\EditLamaranKarir::route('/{record}/edit'),
        ];
    }
}
