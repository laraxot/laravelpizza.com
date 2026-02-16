<?php

declare(strict_types=1);

namespace Modules\Meetup\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Schema.org EventStatusType enumeration.
 *
 * Represents the status of an event according to Schema.org standards.
 *
 * @see https://schema.org/EventStatusType
 */
enum EventStatus: string implements HasColor, HasLabel
{
    use EnumTrait;

    case DRAFT = 'draft';
    case SCHEDULED = 'EventScheduled';
    case CONFIRMED = 'EventScheduled_confirmed'; // Alias or specific confirmed state if needed, often mapped to Scheduled
    case CANCELLED = 'EventCancelled';
    case POSTPONED = 'EventPostponed';
    case RESCHEDULED = 'EventRescheduled';
    case MOVED_ONLINE = 'EventMovedOnline';
    case COMPLETED = 'completed';

    /**
     * Get full Schema.org URI for the status.
     */
    public function toSchemaOrgUri(): string
    {
        if ($this === self::DRAFT) {
            return 'https://schema.org/EventScheduled'; // Draft is still scheduled but not public
        }

        $value = $this->value;
        if ($this === self::CONFIRMED) {
            $value = 'EventScheduled';
        }

        return 'https://schema.org/'.$value;
    }
}
