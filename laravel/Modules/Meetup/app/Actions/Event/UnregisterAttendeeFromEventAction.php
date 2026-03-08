<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Spatie\QueueableAction\QueueableAction;

class UnregisterAttendeeFromEventAction
{
    use QueueableAction;

    public function execute(Event $event, string $userId): bool
    {
        return app('db')->transaction(function () use ($event, $userId): bool {
            $registration = EventUser::query()
                ->where('event_id', $event->getKey())
                ->where('user_id', $userId)
                ->first();

            if ($registration === null) {
                throw new \DomainException('User is not registered for this event');
            }

            $registration->delete();

            if ($event->attendees_count > 0) {
                $event->decrement('attendees_count');
            }
            $event->refresh();

            return true;
        });
    }
}
