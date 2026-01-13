<?php

namespace App\Filament\Resources\DomainPayments\Pages;

use App\Filament\Resources\DomainPayments\DomainPaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDomainPayments extends ListRecords
{
    protected static string $resource = DomainPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
