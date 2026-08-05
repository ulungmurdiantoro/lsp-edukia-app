<?php

namespace App\Filament\Resources\JadwalSertifikasiResource\Pages;

use App\Filament\Resources\JadwalSertifikasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJadwalSertifikasi extends CreateRecord
{
    protected static string $resource = JadwalSertifikasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
