<?php

namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ContactMethod: string implements HasIcon, HasLabel
{
    case Cel = 'cel';
    case Tel = 'tel';
    case Fax = 'fax';
    case Email = 'email';
    case Web = 'web';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Cel => 'Celular',
            self::Tel => 'Teléfono',
            self::Fax => 'Fax',
            self::Email => 'Email',
            self::Web => 'Web',
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Cel => 'heroicon-m-phone',
            self::Tel => 'heroicon-m-phone',
            self::Fax => 'heroicon-m-printer',
            self::Email => 'heroicon-m-envelope',
            self::Web => 'heroicon-m-globe-alt',
        };
    }
}
