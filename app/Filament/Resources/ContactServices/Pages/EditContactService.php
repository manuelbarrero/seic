<?php

namespace App\Filament\Resources\ContactServices\Pages;

use App\Filament\Resources\ContactServices\ContactServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactService extends EditRecord
{
    protected static string $resource = ContactServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
