<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('type')
                    ->numeric(),
                TextInput::make('amount')
                    ->label('Monto')
                    ->numeric(),
                DatePicker::make('date')
                    ->label('Fecha'),
                TextInput::make('reference')
                    ->label('Referencia'),
                TextInput::make('account_number')
                    ->label('Número de Cuenta'),
                TextInput::make('bank_code')
                    ->label('Código del Banco'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('type')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Monto')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                TextColumn::make('reference')
                    ->label('Referencia'),
                TextColumn::make('account_number')
                    ->label('Número de Cuenta'),
                TextColumn::make('bank_code')
                    ->label('Código del Banco'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        $data['amount_applied'] = $data['amount'];

                        return $data;
                    })
                    ->label('Registrar Pago'),
            ])
            ->recordActions([
                EditAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        $data['amount_applied'] = $data['amount'];

                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DetachBulkAction::make(),
                //     DeleteBulkAction::make(),
                // ]),
            ])
            ->paginated(false);
    }
}
