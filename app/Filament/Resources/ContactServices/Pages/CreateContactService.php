<?php

namespace App\Filament\Resources\ContactServices\Pages;

use App\Filament\Resources\ContactServices\ContactServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactService extends CreateRecord
{
    protected static string $resource = ContactServiceResource::class;
}
