<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Enum for notification log statuses.
 *
 * Uses EnumTrait for getLabel(), getIcon(), getColor().
 * Configure values in: Modules/Notify/lang/{locale}/enums.php
 */
enum NotificationLogStatusEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case PENDING = 'pending';
    case SENT = 'sent';
    case DELIVERED = 'delivered';
    case FAILED = 'failed';
    case OPENED = 'opened';
    case CLICKED = 'clicked';

    public function isCompleted(): bool
    {
        return match ($this) {
            self::DELIVERED, self::OPENED, self::CLICKED => true,
            default => false,
        };
    }

    public function isFailed(): bool
    {
        return $this === self::FAILED;
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }
}
