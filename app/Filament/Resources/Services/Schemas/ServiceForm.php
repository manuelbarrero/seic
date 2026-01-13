<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('code'),
                        TextInput::make('name'),
                        TextInput::make('type'),
                        TextInput::make('extension'),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('period')
                            ->numeric(),
                        TextInput::make('space_mb')
                            ->numeric(),
                        TextInput::make('transfer_gb')
                            ->numeric(),
                        TextInput::make('position')
                            ->numeric(),
                        TextInput::make('description'),
                    ]),
            ]);
    }
}
