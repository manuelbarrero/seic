<?php

namespace App\Filament\Resources\DomainPayments\Pages;

use App\Filament\Resources\DomainPayments\DomainPaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDomainPayment extends EditRecord
{
    protected static string $resource = DomainPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
