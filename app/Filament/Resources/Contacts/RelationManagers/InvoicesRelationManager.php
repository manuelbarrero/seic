<?php

namespace App\Filament\Resources\Contacts\RelationManagers;

use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';

    protected static ?string $relatedResource = InvoiceResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                // CreateAction::make(),
                Action::make('create')
                    ->label('Agregar Factura')
                    ->url(fn ($livewire) => InvoiceResource::getUrl('create', [
                        'contact_id' => $livewire->getOwnerRecord()->id,
                    ])),
            ]);
    }
}
