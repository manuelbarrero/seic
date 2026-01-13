<?php

namespace App\Filament\Resources\Contacts\Schemas;

use App\Enums\ContactMethod;
use App\Enums\ContactType;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(4)
                    ->schema([
                        ToggleButtons::make('contact_type')
                            ->label('Tipo de Contacto')
                            ->options(ContactType::class)
                            ->default(ContactType::Company)
                            ->inline()
                            ->live()
                            ->columnSpanFull()
                            ->id('contact-type-select'),
                        TextInput::make('name')
                            // ->label('Nombre')
                            ->label(fn (Get $get) => $get('contact_type')?->value === 'O' ? 'Nombre o razón social' : 'Nombre')
                            ->columnSpan(3),
                        TextInput::make('identifier')
                            ->label(fn (Get $get) => $get('contact_type')?->value === 'O' ? 'RIF' : 'Cédula o RIF')
                            ->columnSpan(1),
                        TextInput::make('contact')
                            ->label('Nombre del contacto')
                            ->visibleJs(<<<'JS'
                                $get('contact_type') === 'O'
                                JS)
                            ->columnSpanFull(),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->columnSpanFull(),
                        TextInput::make('city')
                            ->label('Ciudad'),
                        TextInput::make('state')
                            ->label('Estado'),
                        TextInput::make('country')
                            ->label('País'),
                        TextInput::make('zipcode')
                            ->label('Código Postal'),
                        Textarea::make('notes')
                            ->label('Notas')
                            ->columnSpanFull(),
                        Select::make('referred_by')
                            ->label('Referido por')
                            ->relationship('referred', 'name')
                            ->searchable()
                            ->columnSpan(2),
                    ]),
                Section::make()
                    ->schema([
                        Repeater::make('contactMethods')
                            ->label('Métodos de Contacto')
                            ->relationship()
                            ->compact()
                            ->table([
                                TableColumn::make('Tipo')->width('110px'),
                                TableColumn::make('Numero o dirección')->width('200px'),
                                TableColumn::make('Descripción')->width('200px'),
                            ])
                            ->schema([
                                Select::make('method')
                                    ->options(ContactMethod::class)
                                    ->selectablePlaceholder(false)
                                    ->required(),
                                TextInput::make('value')
                                    ->label('Numero o dirección')
                                    ->required(),
                                TextInput::make('description')
                                    ->label('Descripción'),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}
