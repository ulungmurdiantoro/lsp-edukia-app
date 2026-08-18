<?php

namespace App\Filament\Resources\SertifikatResource\Pages;

use App\Filament\Resources\SertifikatResource;
use App\Imports\SertifikatImport;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListSertifikats extends ListRecords
{
    protected static string $resource = SertifikatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('import')
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->modalHeading('Import Data Sertifikat')
                ->modalDescription(new \Illuminate\Support\HtmlString(
                    'Upload file Excel (.xlsx) sesuai format register resmi (FR.AK.09).<br><br>' .
                    '<strong>Kolom wajib:</strong> No, Nama Lengkap, No Skema, No Sertifikat, Tanggal Rilis<br>' .
                    '<strong>Kolom opsional:</strong> Skema, Batch (diabaikan), No SK, Nama Gelar, Tanggal_Berakhir, Lisensi (1/0)<br>' .
                    'Kolom <strong>Skema</strong> &amp; kategori terisi otomatis dari kode di kolom <strong>No Skema</strong> (mis. EDUKIA-AIL-2024-001).<br>' .
                    'Kolom <strong>Lisensi</strong> (Berlisensi KAN) yang dikosongkan TIDAK diubah — nilai yang sudah tersimpan di database tetap dipertahankan.<br>' .
                    'Format tanggal: <code>4 Mei 2026</code>, <code>April 2024</code>, atau <code>YYYY-MM-DD</code>.<br>' .
                    'Baris dengan <strong>No Sertifikat</strong> yang sudah ada akan diperbarui otomatis.<br><br>' .
                    '<a href="/downloads/template-import-sertifikat.xlsx" download style="color:#f59e0b;font-weight:600;">⬇ Unduh template Excel</a>'
                ))
                ->modalSubmitActionLabel('Import')
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel')
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->required(),
                ])
                ->action(function (array $data): void {
                    try {
                        Excel::import(new SertifikatImport(), $data['file'], 'local');
                        Notification::make()
                            ->title('Import berhasil')
                            ->body('Data sertifikat telah diimport / diperbarui.')
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Import gagal')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    } finally {
                        Storage::disk('local')->delete($data['file']);
                    }
                }),
        ];
    }
}
