<?php

declare(strict_types=1);

namespace Modules\Meetup\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum RepeatFrequency: string implements HasColor, HasLabel
{
    use EnumTrait;

    case DAILY = 'P1D';
    case WEEKLY = 'P1W';
    case BIWEEKLY = 'P2W';
    case MONTHLY = 'P1M';
    case YEARLY = 'P1Y';

    public function toSchemaOrg(): string
    {
        return $this->value;
    }
}
