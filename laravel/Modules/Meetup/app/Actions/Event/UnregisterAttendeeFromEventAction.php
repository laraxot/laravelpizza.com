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
        $result = $event->getConnection()->transaction(function () use ($event, $userId): bool {
            /** @var Event $locked */
            $locked = Event::query()
                ->whereKey($event->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $registration = EventUser::query()
                ->where('event_id', $event->getKey())
                ->where('user_id', $userId)
                ->first();

            if ($registration === null) {
                throw new \DomainException('User is not registered for this event');
            }

            $registration->delete();

            if ($locked->attendees_count > 0) {
                $locked->decrement('attendees_count');
            }

            return true;
        });

        $event->refresh();

        return $result;
    }
}
