<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable(),
                TextColumn::make('extension')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Precio')
                    ->width(150),
                TextColumn::make('base_price')
                    ->label('Precio Base')
                    ->width(150),
                TextColumn::make('contactServices_count')
                    ->label('Servicios')
                    ->counts('contactServices'),
                // TextColumn::make('period')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('space_mb')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('transfer_gb')
                //     ->numeric()
                //     ->sortable(),

                // TextInputColumn::make('description')
                //     ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginated(false);
    }
}
