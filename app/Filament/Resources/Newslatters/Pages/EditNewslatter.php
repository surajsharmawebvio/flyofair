<?php

namespace App\Filament\Resources\Newslatters\Pages;

use App\Filament\Resources\Newslatters\NewslatterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNewslatter extends EditRecord
{
    protected static string $resource = NewslatterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
