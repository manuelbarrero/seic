<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use App\Models\Service;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('rate')
                ->label('Set Rate')
                ->modalWidth(Width::Small)
                ->schema([
                    TextInput::make('rate_bcv')
                        ->label('Tasa BCV')
                        ->numeric()
                        ->required()
                        ->default(1.0),
                    TextInput::make('rate_binance')
                        ->label('Tasa Binance')
                        ->numeric()
                        ->required()
                        ->default(1.0),
                ])
                ->action(function (array $data): void {
                    foreach (Service::all() as $service) {
                        $rate = $data['rate_bcv'] / $service->base_price;
                        $service->price = ceil($data['rate_binance'] / $rate);
                        $service->save();
                    }
                }),
        ];
    }
}
