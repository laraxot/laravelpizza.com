<?php

declare(strict_types=1);

namespace Modules\Xot\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum YesNoEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case YES = 'yes';
    case NO = 'no';
}
