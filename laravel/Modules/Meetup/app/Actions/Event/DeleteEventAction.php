<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventPerformer;
use Modules\Meetup\Models\EventSponsor;
use Modules\Meetup\Models\EventUser;
use Spatie\QueueableAction\QueueableAction;

class DeleteEventAction
{
    use QueueableAction;

    public function execute(Event $event): bool
    {
        $userId = app('auth')->id();

        return $event->getConnection()->transaction(function () use ($event, $userId): bool {
            if ($userId !== null) {
                $event->updated_by = (string) $userId;
            }
            // Le tabelle pivot non hanno foreign key con cascade: le righe collegate vanno rimosse qui,
            // altrimenti restano iscrizioni e associazioni orfane.
            EventUser::query()->where('event_id', $event->getKey())->delete();
            EventPerformer::query()->where('event_id', $event->getKey())->delete();
            EventSponsor::query()->where('event_id', $event->getKey())->delete();

            $deleted = $event->delete();

            return $deleted ?? false;
        });
    }
}
