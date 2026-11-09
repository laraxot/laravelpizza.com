<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Database\Eloquent\Collection;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Spatie\QueueableAction\QueueableAction;

/**
 * Eventi pubblicati a cui un utente è iscritto, dal più vicino nel tempo.
 * Usata dalla pagina "I miei eventi" (events/my.json, events_source = user_subscribed).
 */
class GetUserRegisteredEventsAction
{
    use QueueableAction;

    /**
     * @return Collection<int, Event>
     */
    public function execute(string $userId): Collection
    {
        $eventIds = EventUser::query()
            ->where('user_id', $userId)
            ->pluck('event_id');

        return Event::query()
            ->published()
            ->whereIn('id', $eventIds)
            ->orderBy('start_date')
            ->get();
    }
}
