<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

class ProposeMeetupAction
{
    use QueueableAction;

    /**
     * Create a new event proposal with status=pending.
     * Visible only to the proposer until approved.
     *
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data, string $proposerId): Event
    {
        return app('db')->transaction(function () use ($data, $proposerId): Event {
            $event = new Event;
            $event->fill($data);
            $event->status = 'pending';
            $event->user_id = (int) $proposerId;
            $event->organizer_id = (int) $proposerId;
            $event->created_by = $proposerId;
            $event->attendees_count = 0;
            $event->save();

            return $event;
        });
    }
}
