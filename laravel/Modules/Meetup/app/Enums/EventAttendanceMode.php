<?php

declare(strict_types=1);

namespace Modules\Meetup\Enums;

/**
 * Schema.org EventAttendanceModeEnumeration.
 *
 * Represents the attendance mode of an event according to Schema.org standards.
 *
 * @see https://schema.org/EventAttendanceModeEnumeration
 */
enum EventAttendanceMode: string
{
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
     * Get translated label for the attendance mode.
     */
    public function trans(): string
    {
        return trans('meetup::event.event_attendance_mode.'.$this->value);
    }

    /**
     * Get full Schema.org URI for the attendance mode.
     */
    public function toSchemaOrgUri(): string
    {
        return 'https://schema.org/'.$this->value;
    }

    /**
     * Get icon for UI display.
     */
    public function icon(): string
    {
        return match ($this) {
            self::OFFLINE => 'heroicon-o-map-pin',
            self::ONLINE => 'heroicon-o-computer-desktop',
            self::MIXED => 'heroicon-o-arrows-right-left',
        };
    }

    /**
     * Get CSS color class for UI display.
     */
    public function color(): string
    {
        return match ($this) {
            self::OFFLINE => 'primary',
            self::ONLINE => 'success',
            self::MIXED => 'warning',
        };
    }
}
