<?php

declare(strict_types=1);

namespace Modules\Incentivi\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AmbitoIncentivo: string implements HasColor, HasIcon, HasLabel
{
    case Lavori = 'Lavori';
    case Servizi = 'Servizi';
    case Misti = 'Misti';

    public function getLabel(): string
    {
        return match ($this) {
            self::Lavori => 'Lavori',
            self::Servizi => 'Servizi',
            self::Misti => 'Misti',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Lavori => 'info',
            self::Servizi => 'warning',
            self::Misti => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Lavori => 'heroicon-m-pencil-square',
            self::Servizi => 'heroicon-m-star',
            self::Misti => 'heroicon-m-x-circle',
        };
    }
}
