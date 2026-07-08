<?php

declare(strict_types=1);

namespace Modules\UI\Enums;

use Modules\Xot\Traits\EnumTrait;

enum TableLayout: string
{
    use EnumTrait;

    case LIST = 'list';
    case GRID = 'grid';

    public function toggle(): self
    {
        return match ($this) {
            self::LIST => self::GRID,
            self::GRID => self::LIST,
        };
    }
}
