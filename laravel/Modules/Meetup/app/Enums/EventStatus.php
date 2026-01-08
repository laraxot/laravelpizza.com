<?php

declare(strict_types=1);

namespace Modules\Meetup\Enums;

/**
 * Schema.org EventStatusType enumeration.
 *
 * Represents the status of an event according to Schema.org standards.
 *
 * @see https://schema.org/EventStatusType
 */
enum EventStatus: string
{
    case SCHEDULED = 'EventScheduled';
    case CANCELLED = 'EventCancelled';
    case POSTPONED = 'EventPostponed';
    case RESCHEDULED = 'EventRescheduled';
    case MOVED_ONLINE = 'EventMovedOnline';

    /**
     * Get human-readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Scheduled',
            self::CANCELLED => 'Cancelled',
            self::POSTPONED => 'Postponed',
            self::RESCHEDULED => 'Rescheduled',
            self::MOVED_ONLINE => 'Moved Online',
        };
    }

    /**
     * Get translated label for the status.
     */
    public function trans(): string
    {
        return trans('meetup::event.event_status.'.$this->value);
    }

    /**
     * Get full Schema.org URI for the status.
     */
    public function toSchemaOrgUri(): string
    {
        return 'https://schema.org/'.$this->value;
    }

    /**
     * Get CSS color class for UI display.
     */
    public function color(): string
    {
        return match ($this) {
            self::SCHEDULED => 'success',
            self::CANCELLED => 'danger',
            self::POSTPONED => 'warning',
            self::RESCHEDULED => 'info',
            self::MOVED_ONLINE => 'primary',
        };
    }
}
