<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date'),
                TextInput::make('amount')
                    ->numeric(),
                TextInput::make('created_by')
                    ->numeric(),
            ]);
    }
}
