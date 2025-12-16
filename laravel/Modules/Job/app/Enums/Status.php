<?php

declare(strict_types=1);

namespace Modules\Job\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasIcon, HasLabel
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Trashed = 'trashed';
    case One = '1';

    public function getColor(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'warning',
            self::Trashed => 'danger',
            self::One => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Active => 'heroicon-o-check-circle',
            self::Inactive => 'heroicon-o-document',
            self::Trashed => 'heroicon-o-x-circle',
            self::One => 'heroicon-o-x-circle',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Active => __('job::schedule.status.active'),
            self::Inactive => __('job::schedule.status.inactive'),
            self::Trashed => __('job::schedule.status.trashed'),
            self::One => __('job::schedule.status.one'),
        };
    }
}
