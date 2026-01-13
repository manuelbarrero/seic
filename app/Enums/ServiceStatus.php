<?php

namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ServiceStatus: int implements HasColor, HasIcon, HasLabel
{
    case Pending = 1;
    case Active = 2;
    case Suspending = 3;
    case Suspended = 4;
    case Deleting = 5;
    case Deleted = 6;

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Pending => 'Por activar',
            self::Active => 'Activo',
            self::Suspending => 'Por suspender',
            self::Suspended => 'Suspendido',
            self::Deleting => 'Por eliminar',
            self::Deleted => 'Eliminado',
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Pending => 'heroicon-m-clock',
            self::Active => 'heroicon-m-check-circle',
            self::Suspending => 'heroicon-m-exclamation-triangle',
            self::Suspended => 'heroicon-m-x-circle',
            self::Deleting => 'heroicon-m-trash',
            self::Deleted => 'heroicon-m-trash',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'primary',
            self::Active => 'success',
            self::Suspending => 'warning',
            self::Suspended => 'warning',
            self::Deleting => 'danger',
            self::Deleted => 'danger',
        };
    }
}
