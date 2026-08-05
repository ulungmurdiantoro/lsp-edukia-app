<?php

namespace App\Filament\Resources\JadwalSertifikasiResource\Pages;

use App\Filament\Resources\JadwalSertifikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJadwalSertifikasis extends ListRecords
{
    protected static string $resource = JadwalSertifikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
