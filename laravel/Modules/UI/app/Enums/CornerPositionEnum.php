<?php

declare(strict_types=1);

namespace Modules\UI\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum CornerPositionEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case TOP_LEFT = 'top-left';
    case TOP_RIGHT = 'top-right';
    case BOTTOM_LEFT = 'bottom-left';
    case BOTTOM_RIGHT = 'bottom-right';

    public function getCssClass(): string
    {
        return match ($this) {
            self::TOP_LEFT => 'top-0 left-0',
            self::TOP_RIGHT => 'top-0 right-0',
            self::BOTTOM_LEFT => 'bottom-0 left-0',
            self::BOTTOM_RIGHT => 'bottom-0 right-0',
        };
    }
}
