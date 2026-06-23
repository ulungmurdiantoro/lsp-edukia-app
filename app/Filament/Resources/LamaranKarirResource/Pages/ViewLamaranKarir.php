<?php

namespace App\Filament\Resources\LamaranKarirResource\Pages;

use App\Filament\Resources\LamaranKarirResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLamaranKarir extends ViewRecord
{
    protected static string $resource = LamaranKarirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Update Status'),
            Actions\DeleteAction::make(),
        ];
    }
}
