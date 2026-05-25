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
                    'Upload file Excel (.xlsx) atau CSV.<br><br>' .
                    '<strong>Kolom wajib:</strong> nama, skema, kategori, nomor_sertifikat, tanggal_terbit, tanggal_kadaluarsa<br>' .
                    '<strong>Kolom opsional:</strong> gelar, no_sk, no_skema, tampil (1/0)<br>' .
                    'Format tanggal: <code>YYYY-MM-DD</code> (contoh: 2024-01-15)<br>' .
                    'Baris dengan <strong>nomor_sertifikat</strong> yang sudah ada akan diperbarui otomatis.<br><br>' .
                    '<a href="/downloads/template-import-sertifikat.csv" download style="color:#f59e0b;font-weight:600;">⬇ Unduh template CSV</a>'
                ))
                ->modalSubmitActionLabel('Import')
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel / CSV')
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                            'text/plain',
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
