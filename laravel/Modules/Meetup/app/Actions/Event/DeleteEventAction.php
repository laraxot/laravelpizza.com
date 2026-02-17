<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

class DeleteEventAction
{
    use QueueableAction;

    public function execute(Event $event): bool
    {
        $userId = app('auth')->id();

        return app('db')->transaction(function () use ($event, $userId): bool {
            if ($userId !== null) {
                $event->updated_by = (string) $userId;
            }
            $deleted = $event->delete();

            return $deleted ?? false;
        });
    }
}
