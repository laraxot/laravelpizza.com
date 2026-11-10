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

        return (new Event)->getConnection()->transaction(function () use ($data, $userId): Event {
            $event = new Event;
            $event->fill($data);
            if ($userId !== null) {
                // users.id e' un UUID: il vecchio cast (int) salvava 0 e l'evento restava senza autore.
                $event->user_id = (string) $userId;
                $event->organizer_id ??= (string) $userId;
                $event->created_by = (string) $userId;
            }
            $event->save();

            return $event;
        });
    }
}
