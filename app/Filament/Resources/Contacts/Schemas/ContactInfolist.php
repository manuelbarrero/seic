<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(6)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre')
                            ->columnSpan(3),
                        TextEntry::make('identifier')
                            ->label(fn ($record): string => $record->contact_type?->value === 'P' ? 'Cédula' : 'RIF')
                            ->placeholder('-'),
                        TextEntry::make('contact')
                            ->label('Contacto')
                            ->columnSpan(2)
                            ->visible(fn ($record): bool => $record->contact_type?->value === 'O'),
                        TextEntry::make('address')
                            ->label('Dirección')
                            ->placeholder('-')
                            ->columnSpan(2),
                        TextEntry::make('city')
                            ->label('Ciudad')
                            ->placeholder('-'),
                        TextEntry::make('state')
                            ->label('Estado')
                            ->placeholder('-'),
                        TextEntry::make('country')
                            ->label('País')
                            ->placeholder('-'),
                        TextEntry::make('zipcode')
                            ->label('Código Postal')
                            ->placeholder('-'),
                        TextEntry::make('notes')
                            ->label('Notas')
                            ->columnSpanFull(),
                        // TextEntry::make('created_by')
                        //     ->numeric()
                        //     ->placeholder('-'),
                        // TextEntry::make('created_at')
                        //     ->dateTime()
                        //     ->placeholder('-'),
                        // TextEntry::make('updated_at')
                        //     ->dateTime()
                        //     ->placeholder('-'),
                        // TextEntry::make('referred_by')
                        //     ->numeric()
                        //     ->placeholder('-'),
                        // TextEntry::make('contact_type')
                        //     ->placeholder('-'),
                        // TextEntry::make('referred_id')
                        //     ->numeric()
                        //     ->placeholder('-'),
                    ]),

                Section::make()
                    ->schema([
                        // Contact Methods
                        RepeatableEntry::make('contactMethods')
                            ->table([
                                TableColumn::make('Tipo'),
                                TableColumn::make('Numero o dirección'),
                                TableColumn::make('Descripción'),
                            ])
                            ->schema([
                                TextEntry::make('method'),
                                TextEntry::make('value'),
                                TextEntry::make('description'),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}
