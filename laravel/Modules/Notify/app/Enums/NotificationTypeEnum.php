<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

enum NotificationTypeEnum: string
{
    case EMAIL = 'email';
    case SMS = 'sms';
    case PUSH = 'push';

    public function label(): string
    {
        return match ($this) {
            self::EMAIL => __('notify::enums.notification_type.email'),
            self::SMS => __('notify::enums.notification_type.sms'),
            self::PUSH => __('notify::enums.notification_type.push'),
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::EMAIL => 'heroicon-o-envelope',
            self::SMS => 'heroicon-o-device-phone-mobile',
            self::PUSH => 'heroicon-o-bell',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::EMAIL => 'success',
            self::SMS => 'warning',
            self::PUSH => 'info',
        };
    }
}
