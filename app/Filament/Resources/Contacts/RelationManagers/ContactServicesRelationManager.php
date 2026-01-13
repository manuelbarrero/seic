<?php

namespace App\Filament\Resources\Contacts\RelationManagers;

use App\Filament\Resources\ContactServices\ContactServiceResource;
use App\Models\ContactService;
use App\Models\Service;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\FusedGroup;
use Filament\Support\Enums\Width;
use Filament\Tables\Table;

class ContactServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'contactServices';

    protected static ?string $relatedResource = ContactServiceResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                // CreateAction::make(),
                Action::make('create')
                    ->label('Agregar Servicio')
                    ->modalWidth(Width::Small)
                    ->schema([
                        Checkbox::make('domainWithClient')
                            ->label('Dominio con cliente')
                            ->live(),
                        FusedGroup::make([
                            TextInput::make('domain')
                                ->label('Dominio')
                                ->columnSpan(2)
                                ->autofocus(),
                            Select::make('extension')
                                ->options(Service::query()
                                    ->where('type', 'REG')
                                    ->orderBy('position')
                                    ->pluck('extension', 'id')
                                )
                                ->default(11)
                                ->disablePlaceholderSelection(),
                        ])
                            ->label('Dominio')
                            ->columns(3)
                            ->visible(fn ($get): bool => ! $get('domainWithClient')),
                        TextInput::make('domain')
                            ->label('Dominio')
                            ->visible(fn ($get): bool => $get('domainWithClient'))
                            ->required(fn ($get): bool => $get('domainWithClient')),
                        Select::make('HostingServiceId')
                            ->label('Servicio')
                            ->options(Service::query()
                                ->where('type', 'HOST')
                                ->pluck('name', 'id')
                            )
                            ->required(),
                    ])
                    ->action(function (array $data, $livewire): void {
                        // domain
                        if ($data['domainWithClient']) {
                            $domain = $data['domain'];
                        } else {
                            $domainService = Service::find($data['extension']);
                            $domain = $data['domain'].$domainService->extension;
                            ContactService::create([
                                'contact_id' => $livewire->getOwnerRecord()->id,
                                'service_id' => $domainService->id,
                                'domain' => $domain,
                                'type' => 'D',
                                'status' => 1,
                            ]);
                        }

                        // hosting
                        if ($data['HostingServiceId']) {
                            $hostingService = Service::find($data['HostingServiceId']);
                            ContactService::create([
                                'contact_id' => $livewire->getOwnerRecord()->id,
                                'service_id' => $data['HostingServiceId'],
                                'domain' => $domain,
                                'type' => 'H',
                                'status' => 1,
                            ]);
                        }

                    }),
            ]);
    }
}
