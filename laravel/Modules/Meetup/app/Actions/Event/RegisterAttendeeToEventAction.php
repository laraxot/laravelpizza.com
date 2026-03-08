<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Spatie\QueueableAction\QueueableAction;

class RegisterAttendeeToEventAction
{
    use QueueableAction;

    public function execute(Event $event, string $userId): EventUser
    {
        /** @var EventUser $registration */
        $registration = app('db')->transaction(function () use ($event, $userId): EventUser {
            if ($event->isFull()) {
                throw new \DomainException('Event is full');
            }

            if ($event->isUserRegistered($userId)) {
                throw new \DomainException('User already registered for this event');
            }

            $registration = EventUser::query()->create([
                'event_id' => (int) $event->getKey(),
                'user_id' => $userId,
            ]);

            $event->increment('attendees_count');
            $event->refresh();

            return $registration;
        });

        return $registration;
    }
}
