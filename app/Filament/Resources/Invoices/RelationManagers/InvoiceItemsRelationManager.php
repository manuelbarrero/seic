<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use App\Enums\ServiceStatus;
use App\Models\ContactService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoiceItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'invoiceItems';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date_from')
                    ->label('Desde'),
                DatePicker::make('date_to')
                    ->label('Hasta'),
                Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),
                TextInput::make('total')
                    ->numeric()
                    ->prefix('$'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->heading('Ítems')
            ->columns([
                TextColumn::make('date_from')
                    ->label('Desde')
                    ->date()
                    ->width('150px'),
                TextColumn::make('date_to')
                    ->label('Hasta')
                    ->date()
                    ->width('150px'),
                TextColumn::make('description')
                    ->label('Descripción'),
                // TextColumn::make('quantity')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('unit_price')
                //     ->money()
                //     ->sortable(),
                TextColumn::make('total')
                    ->label('Monto')
                    ->money('USD')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                Action::make('create_with_services')
                    ->label('Agregar Servicios')
                    ->modalWidth(Width::Small)
                    ->schema([
                        CheckboxList::make('services')
                            ->label('Servicios')
                            ->options(function ($livewire) {
                                return ContactService::where('contact_id', $livewire->getOwnerRecord()->contact_id)
                                    ->where('status', ServiceStatus::Active)
                                    ->with('service')
                                    ->get()
                                    ->map(function ($record) {
                                        $record->name = "{$record->service->name} {$record->domain}";

                                        return $record;
                                    })
                                    ->pluck('name', 'id');
                            }),
                    ])
                    ->action(function (array $data, $livewire): void {

                        foreach ($data['services'] as $serviceId) {
                            $contactService = ContactService::find($serviceId);

                            $newDueDate = $contactService->type->value === 'D' ?
                                    $contactService->due_date->addYear() :
                                    $contactService->due_date->addYear()->addMonthNoOverflow()->startOfMonth();

                            $livewire->getOwnerRecord()->invoiceItems()->create([
                                'contact_service_id' => $contactService->id,
                                'date_from' => $contactService->due_date,
                                'date_to' => $newDueDate,
                                'description' => "{$contactService->service->description} - {$contactService->domain}",
                                'quantity' => 1,
                                'unit_price' => $contactService->service->price,
                                'total' => $contactService->service->price,
                            ]);

                            // actualizar la fecha de vencimiento del servicio
                            $contactService->due_date = $contactService->due_date->addYear();
                            $contactService->save();

                            // recalcular total de factura
                            $livewire->getOwnerRecord()->calculateTotals();

                            // reload component
                            $livewire->dispatch('refreshInvoiceView');
                        }

                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth(Width::Medium)
                    ->after(function ($livewire) {
                        $livewire->getOwnerRecord()->calculateTotals();
                        $livewire->dispatch('refreshInvoiceView');
                    }),
                DeleteAction::make()
                    ->after(function ($livewire) {
                        $livewire->getOwnerRecord()->calculateTotals();
                        $livewire->dispatch('refreshInvoiceView');
                    }),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DissociateBulkAction::make(),
                //     DeleteBulkAction::make(),
                // ]),
            ])
            ->paginated(false);
    }
}
