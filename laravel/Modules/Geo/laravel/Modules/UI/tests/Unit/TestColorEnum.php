<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TestColorEnum: string implements HasIcon, HasLabel
{
    case RED = 'red';
    case GREEN = 'green';
    case BLUE = 'blue';

    public function getLabel(): string
    {
        return match ($this) {
            self::RED => 'Rosso',
            self::GREEN => 'Verde',
            self::BLUE => 'Blu',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::RED => 'heroicon-o-exclamation',
            self::GREEN => 'heroicon-o-check',
            self::BLUE => 'heroicon-o-info',
        };
    }
}
