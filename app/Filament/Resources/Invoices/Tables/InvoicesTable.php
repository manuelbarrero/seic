<?php

namespace App\Filament\Resources\Invoices\Tables;

use App\Filament\Resources\Contacts\RelationManagers\InvoicesRelationManager;
use App\Models\Invoice;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Número')
                    ->searchable(),
                TextColumn::make('contact.name')
                    ->label('Cliente')
                    ->searchable()
                    ->hiddenOn(InvoicesRelationManager::class),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('tax_rate')
                    ->label('IVA')
                    ->numeric()
                    ->sortable(),
                // TextColumn::make('tax_amount')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('sub_total')
                //     ->numeric()
                //     ->sortable(),
                TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payments_count')->counts('payments')
                    ->label('Pagos'),
                IconColumn::make('cancel')
                    ->boolean(),
                // TextColumn::make('name')
                //     ->searchable(),
                // TextColumn::make('identifier')
                //     ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('print')
                    ->label('Imprimir')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn (Invoice $record): string => route('invoices.print', $record))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
