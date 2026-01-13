<?php

namespace App\Filament\Resources\ContactServices;

use App\Filament\Resources\ContactServices\Pages\CreateContactService;
use App\Filament\Resources\ContactServices\Pages\EditContactService;
use App\Filament\Resources\ContactServices\Pages\ListContactServices;
use App\Filament\Resources\ContactServices\Schemas\ContactServiceForm;
use App\Filament\Resources\ContactServices\Tables\ContactServicesTable;
use App\Models\ContactService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactServiceResource extends Resource
{
    protected static ?string $model = ContactService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedServerStack;

    protected static ?string $modelLabel = 'Servicio';

    protected static ?string $navigationLabel = 'Servicios';

    protected static ?string $pluralModelLabel = 'Servicios';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ContactServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactServicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactServices::route('/'),
            'create' => CreateContactService::route('/create'),
            'edit' => EditContactService::route('/{record}/edit'),
        ];
    }
}
