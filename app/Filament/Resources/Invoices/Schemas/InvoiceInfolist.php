<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Filament\Resources\Contacts\ContactResource;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(5)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('contact.name')
                            ->label('Cliente')
                            ->url(fn ($record) => ContactResource::getUrl('view', ['record' => $record->contact_id]))
                            ->color('primary'),
                        TextEntry::make('number')
                            ->label('Número')
                            ->placeholder('-'),
                        TextEntry::make('date')
                            ->date()
                            ->placeholder('-'),
                        // TextEntry::make('discount_rate')
                        //     ->numeric()
                        //     ->placeholder('-'),
                        // TextEntry::make('discount_amount')
                        //     ->numeric()
                        //     ->placeholder('-'),
                        TextEntry::make('tax_rate')
                            ->label('IVA')
                            ->numeric(),
                        TextEntry::make('tax_amount')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('sub_total')
                            ->label('Sub Total')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('total')
                            ->numeric()
                            ->money('USD')
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold),
                        IconEntry::make('paid')
                            ->boolean()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
