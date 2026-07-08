<?php

declare(strict_types=1);

namespace Modules\Ptv\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Tipo del valore letterale in una regola (stringa, intero, data, lista).
 * Riutilizzabile ovunque si componga campo + operatore + valore tipizzato.
 */
enum RuleValueTypeEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case String = 'string';

    case Int = 'int';

    case Date = 'date';

    case List = 'list';
}
