<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

class UpdateEventAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(Event $event, array $data): Event
    {
        $userId = app('auth')->id();

        /** @var Event $event */
        return app('db')->transaction(function () use ($event, $data, $userId) {
            $event->fill($data);
            if ($userId !== null) {
                $event->updated_by = (string) $userId;
            }
            $event->save();

            return $event;
        });
    }
}
