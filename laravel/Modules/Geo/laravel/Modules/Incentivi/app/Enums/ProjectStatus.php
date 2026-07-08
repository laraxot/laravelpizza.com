<?php

declare(strict_types=1);

namespace Modules\Incentivi\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ProjectStatus: string implements HasColor, HasIcon, HasLabel
{
    case Compilazione = 'compilazione';
    case Aggiudicazione = 'aggiudicazione';
    case Concluso = 'concluso';
    case Cancellato = 'cancellato';

    public function getLabel(): string
    {
        return match ($this) {
            self::Compilazione => 'Compilazione',
            self::Aggiudicazione => 'Aggiudicazione',
            self::Concluso => 'Concluso',
            self::Cancellato => 'Cancellato',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Compilazione => 'info',
            self::Aggiudicazione => 'warning',
            self::Concluso => 'success',
            self::Cancellato => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Compilazione => 'heroicon-m-pencil-square',
            self::Aggiudicazione => 'heroicon-m-star',
            self::Concluso => 'heroicon-m-check-badge',
            self::Cancellato => 'heroicon-m-x-circle',
        };
    }
}
