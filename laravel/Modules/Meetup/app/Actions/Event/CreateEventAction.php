<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

class CreateEventAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): Event
    {
        $userId = app('auth')->id();

        return app('db')->transaction(function () use ($data, $userId): Event {
            $event = new Event;
            $event->fill($data);
            if ($userId !== null) {
                $event->user_id = (int) $userId;
                $event->created_by = (string) $userId;
            }
            $event->save();

            return $event;
        });
    }
}
