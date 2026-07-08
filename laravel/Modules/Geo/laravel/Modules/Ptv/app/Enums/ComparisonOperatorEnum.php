<?php

declare(strict_types=1);

namespace Modules\Ptv\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Operatori di confronto riutilizzabili (criteri esclusione/valutazione, filtri dinamici, regole campo+valore).
 */
enum ComparisonOperatorEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case Equal = '=';

    case NotEqual = '!=';

    case GreaterThan = '>';

    case LessThan = '<';

    case GreaterThanOrEqual = '>=';

    case LessThanOrEqual = '<=';

    case Like = 'LIKE';

    case NotLike = 'NOT LIKE';
}
