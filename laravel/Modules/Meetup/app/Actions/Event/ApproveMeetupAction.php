<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use DomainException;
use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

class ApproveMeetupAction
{
    use QueueableAction;

    /**
     * Approve a pending event proposal: status → published.
     * After approval the event is visible to all users.
     */
    public function execute(Event $event, string $approvedBy): Event
    {
        if (! $event->isPending()) {
            throw new DomainException('Only pending events can be approved.');
        }

        return app('db')->transaction(function () use ($event, $approvedBy): Event {
            $event->status = 'published';
            $event->updated_by = $approvedBy;
            $event->save();

            return $event->fresh();
        });
    }
}
