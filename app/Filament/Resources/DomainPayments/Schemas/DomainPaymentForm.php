<?php

namespace App\Filament\Resources\DomainPayments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DomainPaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('domain'),
                TextInput::make('reference'),
                DatePicker::make('payment_date'),
                TextInput::make('provider'),
                TextInput::make('provider_account'),
                TextInput::make('fail'),
                DatePicker::make('date_from'),
                DatePicker::make('date_to'),
                TextInput::make('invoice_id')
                    ->numeric(),
                TextInput::make('type'),
            ]);
    }
}
