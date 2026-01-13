<?php

namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ServiceType: string implements HasIcon, HasLabel
{
    case Hosting = 'H';
    case Domain = 'D';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Hosting => 'Hosting',
            self::Domain => 'Dominio',
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Hosting => 'heroicon-o-server-stack',
            self::Domain => 'heroicon-o-globe-alt',
        };
    }
}
