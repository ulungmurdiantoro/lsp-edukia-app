<?php

namespace App\Filament\Resources\LamaranKarirResource\Pages;

use App\Filament\Resources\LamaranKarirResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLamaranKarirs extends ListRecords
{
    protected static string $resource = LamaranKarirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
