<?php

namespace App\Filament\Resources\ContactServices\Schemas;

use App\Enums\ServiceStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class ContactServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->columnSpan(2)
                    ->columns(3)
                    ->schema([
                        Select::make('contact_id')
                            ->label('Cliente')
                            ->relationship(
                                name: 'contact',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->orderBy('name')
                            ),
                        Select::make('service_id')
                            ->label('Servicio')
                            ->relationship(name: 'service', titleAttribute: 'name')
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} {$record->extension}"),
                        Radio::make('type')
                            ->label('Tipo')
                            ->inline()
                            ->options([
                                'D' => 'Dominio',
                                'H' => 'Hosting',
                            ]),
                        TextInput::make('domain')
                            ->label('Dominio'),
                        TextInput::make('username')
                            ->label('Usuario'),
                        TextInput::make('password')
                            ->label('Contraseña'),
                        DatePicker::make('date_from')
                            ->label('Fecha de Inicio'),
                        DatePicker::make('due_date')
                            ->label('Vencimiento'),
                        Select::make('status')
                            ->label('Estatus')
                            ->options(ServiceStatus::class),
                    ]),
            ]);
    }
}
