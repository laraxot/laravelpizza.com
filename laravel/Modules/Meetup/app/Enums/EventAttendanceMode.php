<?php

declare(strict_types=1);

namespace Modules\Meetup\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Schema.org EventAttendanceModeEnumeration.
 *
 * Represents the attendance mode of an event according to Schema.org standards.
 *
 * @see https://schema.org/EventAttendanceModeEnumeration
 */
enum EventAttendanceMode: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case OFFLINE = 'OfflineEventAttendanceMode';
    case ONLINE = 'OnlineEventAttendanceMode';
    case MIXED = 'MixedEventAttendanceMode';

    /**
     * Get human-readable label for the attendance mode.
     */
    public function label(): string
    {
        return match ($this) {
            self::OFFLINE => 'In Person',
            self::ONLINE => 'Online',
            self::MIXED => 'Hybrid',
        };
    }

    /**
     * Get full Schema.org URI for the attendance mode.
     */
    public function toSchemaOrgUri(): string
    {
        return 'https://schema.org/'.$this->value;
    }
}
