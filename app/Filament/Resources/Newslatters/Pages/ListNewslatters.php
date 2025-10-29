<?php

namespace App\Filament\Resources\Newslatters\Pages;

use App\Filament\Resources\Newslatters\NewslatterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNewslatters extends ListRecords
{
    protected static string $resource = NewslatterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
