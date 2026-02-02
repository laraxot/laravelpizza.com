<?php

declare(strict_types=1);

namespace Modules\Meetup\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RepeatFrequency: string implements HasColor, HasLabel
{
    case DAILY = 'P1D';
    case WEEKLY = 'P1W';
    case BIWEEKLY = 'P2W';
    case MONTHLY = 'P1M';
    case YEARLY = 'P1Y';

    public function getLabel(): string
    {
        return match ($this) {
            self::DAILY => 'Daily',
            self::WEEKLY => 'Weekly',
            self::BIWEEKLY => 'Every 2 Weeks',
            self::MONTHLY => 'Monthly',
            self::YEARLY => 'Yearly',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::DAILY => 'info',
            self::WEEKLY => 'success',
            self::BIWEEKLY => 'warning',
            self::MONTHLY => 'primary',
            self::YEARLY => 'gray',
        };
    }

    public function toSchemaOrg(): string
    {
        return $this->value;
    }
}
