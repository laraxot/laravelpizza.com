<?php

declare(strict_types=1);

namespace Modules\UI\Enums;

enum TableLayout: string
{
    case LIST = 'list';
    case GRID = 'grid';

    public function getLabel(): string
    {
        return match ($this) {
            self::LIST => 'List View',
            self::GRID => 'Grid View',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::LIST => 'primary',
            self::GRID => 'secondary',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::LIST => 'heroicon-o-list-bullet',
            self::GRID => 'heroicon-o-squares-2x2',
        };
    }

    public function toggle(): self
    {
        return match ($this) {
            self::LIST => self::GRID,
            self::GRID => self::LIST,
        };
    }
}
