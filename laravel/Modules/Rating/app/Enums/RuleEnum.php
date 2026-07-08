<?php

declare(strict_types=1);

namespace Modules\Rating\Enums;

use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum RuleEnum: string implements HasLabel
{
    use EnumTrait;

    case Null = '';
    case ZeroFive = 'numeric|min:0|max:5';
    case ZeroOrMin4Max25 = 'min:0|max:25|not_in:1,2,3';
    case NullableNumericMin0Max25 = 'nullable|numeric|min:0|max:25';
}
