<?php

namespace App\Filament\Resources\DomainPayments;

use App\Filament\Resources\DomainPayments\Pages\CreateDomainPayment;
use App\Filament\Resources\DomainPayments\Pages\EditDomainPayment;
use App\Filament\Resources\DomainPayments\Pages\ListDomainPayments;
use App\Filament\Resources\DomainPayments\Schemas\DomainPaymentForm;
use App\Filament\Resources\DomainPayments\Tables\DomainPaymentsTable;
use App\Models\DomainPayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DomainPaymentResource extends Resource
{
    protected static ?string $model = DomainPayment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $modelLabel = 'Pagos de dominio';

    protected static ?string $navigationLabel = 'Pagos de dominios';

    protected static ?string $pluralModelLabel = 'Pagos de dominios';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return DomainPaymentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DomainPaymentsTable::configure($table);
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
            'index' => ListDomainPayments::route('/'),
            'create' => CreateDomainPayment::route('/create'),
            'edit' => EditDomainPayment::route('/{record}/edit'),
        ];
    }
}
