<?php

namespace App\Filament\Resources\ContactServices\Tables;

use App\Enums\ServiceStatus;
use App\Enums\ServiceType;
use App\Filament\Resources\Contacts\ContactResource;
use App\Filament\Resources\Contacts\RelationManagers\ContactServicesRelationManager;
use App\Models\Service;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ContactServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Tipo')
                    ->formatStateUsing(fn ($state) => '')
                    ->width('50px'),
                TextColumn::make('contact.name')
                    ->label('Cliente')
                    ->searchable()
                    ->hiddenOn(ContactServicesRelationManager::class)
                    ->url(fn ($record) => ContactResource::getUrl('view', ['record' => $record->contact_id]))
                    ->color('primary'),
                TextColumn::make('service.name')
                    ->label('Servicio'),
                // SelectColumn::make('service_id')
                //     ->options(Service::where('type', 'HOST')->pluck('name', 'id')->toArray() ?? []),
                TextColumn::make('quota')
                    ->label('Cuota'),
                TextColumn::make('disk')
                    ->label('Disco'),

                TextColumn::make('domain')
                    ->label('Dominio')
                    ->searchable()
                    ->url(fn ($record) => 'https://'.$record->domain, true)
                    ->color('primary')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->iconPosition('after')
                    ->iconColor('primary'),
                // TextColumn::make('date_from')
                //     ->label('Fecha de Inicio')
                //     ->date()
                //     ->sortable(),
                TextColumn::make('due_date')
                    ->label('Vencimiento')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Estatus')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estatus')
                    ->options(ServiceStatus::class)
                    ->default(ServiceStatus::Active->value),
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options(ServiceType::class),
            ], layout: FiltersLayout::AboveContent)
            ->groups([
                // Group::make('due_date')
                //     ->date()
                //     ->groupQueryUsing(fn ($query, $group) => $query->whereMonth('due_date', $group->getValue())),
                Group::make('domain')
                    ->label('Dominio'),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    Action::make('register_domain')
                        ->label('Registrar Dominio')
                        ->icon('heroicon-o-globe-alt')
                        ->color('success')
                        ->modalWidth(Width::Small)
                        ->visible(fn ($record): bool => $record->status === ServiceStatus::Pending and $record->type === 'D')
                        ->schema([
                            DatePicker::make('date_from')
                                ->label('Fecha de registro'),
                        ])
                        ->action(function (array $data, $record): void {
                            // cambiar el servicio reg/ren
                            $record->date_from = $data['date_from'];
                            $record->status = ServiceStatus::Active;
                            $record->save();
                        }),
                    Action::make('renew_domain')
                        ->label('Renovar Dominio')
                        ->icon('heroicon-o-globe-alt')
                        ->color('success')
                        ->modalWidth(Width::Small)
                        ->visible(fn ($record): bool => $record->status === ServiceStatus::Active and $record->type === 'D')
                        ->schema([
                            DatePicker::make('date_from')
                                ->label('Fecha de renovación'),
                        ])
                        ->action(function (array $data, $record): void {
                            $newDueDate = $record->due_date->addYear();
                            $record->due_date = $newDueDate;
                            $record->status = ServiceStatus::Active;
                            $record->save();
                        }),
                    Action::make('activate_service')
                        ->label('Activar Servicio')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->modalWidth(Width::Small)
                        ->visible(fn ($record): bool => $record->status === ServiceStatus::Pending and $record->type === 'H')
                        ->schema([
                            TextInput::make('username')
                                ->label('Usuario'),
                            TextInput::make('password')
                                ->label('Contraseña'),
                            DatePicker::make('date_from')
                                ->label('Fecha de inicio'),
                        ])
                        ->action(function (array $data, $record): void {
                            $record->username = $data['username'];
                            $record->password = $data['password'];
                            $record->date_from = $data['date_from'];
                            $record->status = ServiceStatus::Active;
                            $record->save();
                        }),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                    BulkAction::make('eliminate_services')
                        ->label('Eliminar Servicios')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each(
                            fn ($record) => $record->update(['status' => 6]))
                        ),
                ]),
            ])
            ->defaultSort('domain', 'asc');
    }
}
