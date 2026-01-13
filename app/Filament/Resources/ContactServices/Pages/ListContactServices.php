<?php

namespace App\Filament\Resources\ContactServices\Pages;

use App\Filament\Resources\ContactServices\ContactServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactServices extends ListRecords
{
    protected static string $resource = ContactServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
