<?php

namespace App\Filament\Resources\LamaranKarirResource\Pages;

use App\Filament\Resources\LamaranKarirResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLamaranKarir extends EditRecord
{
    protected static string $resource = LamaranKarirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
