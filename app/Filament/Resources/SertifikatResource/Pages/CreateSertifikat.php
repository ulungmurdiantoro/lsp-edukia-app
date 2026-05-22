<?php

namespace App\Filament\Resources\SertifikatResource\Pages;

use App\Filament\Resources\SertifikatResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSertifikat extends CreateRecord
{
    protected static string $resource = SertifikatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
