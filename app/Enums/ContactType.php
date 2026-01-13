<?php

namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ContactType: string implements HasIcon, HasLabel
{
    case Company = 'O';
    case Individual = 'P';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Company => 'Compañía',
            self::Individual => 'Persona Natural',
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Company => 'heroicon-m-building-office',
            self::Individual => 'heroicon-m-user',
        };
    }
}
