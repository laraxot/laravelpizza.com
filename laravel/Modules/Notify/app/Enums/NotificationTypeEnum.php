<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Enum for notification types.
 *
 * Uses EnumTrait for getLabel(), getIcon(), getColor(), getDescription().
 * Configure values in: Modules/Notify/lang/{locale}/enums.php
 */
enum NotificationTypeEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case EMAIL = 'email';
    case SMS = 'sms';
    case PUSH = 'push';
}
