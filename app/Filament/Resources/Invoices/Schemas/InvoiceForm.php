<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(3)
                    ->schema([
                        Select::make('contact_id')
                            ->label('Cliente')
                            ->searchable()
                            ->relationship(
                                name: 'contact',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->orderBy('name')
                            )
                            ->columnSpan(2)
                            ->default(request()->get('contact_id')),
                        TextInput::make('number')
                            ->label('Número')
                            ->default('000000'),
                        DatePicker::make('date')
                            ->label('Fecha')
                            ->default(now()),
                        // TextInput::make('discount_rate')
                        //     ->numeric(),
                        // TextInput::make('discount_amount')
                        //     ->numeric(),
                        TextInput::make('tax_rate')
                            ->label('IVA')
                            ->default(0)
                            ->numeric(),
                        // TextInput::make('name'),
                        // TextInput::make('identifier'),
                        // TextInput::make('address'),
                    ]),
            ]);
    }
}
