<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Widgets;

use Modules\Meetup\Models\Event;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->where('start_date', '>=', $fetchInfo['start'])
            ->where('end_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Event $event) => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date,
                    'end' => $event->end_date,
                    'url' => '#', // TODO: Link to event view/edit
                    'shouldOpenInNewTab' => false,
                ]
            )
            ->all();
    }
}
