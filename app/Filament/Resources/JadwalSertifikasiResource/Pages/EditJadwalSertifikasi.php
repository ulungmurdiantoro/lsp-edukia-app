<?php

namespace App\Filament\Resources\JadwalSertifikasiResource\Pages;

use App\Filament\Resources\JadwalSertifikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalSertifikasi extends EditRecord
{
    protected static string $resource = JadwalSertifikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
