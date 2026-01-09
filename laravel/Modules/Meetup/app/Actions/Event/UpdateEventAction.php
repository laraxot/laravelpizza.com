<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $userId = Auth::id();

        /** @var Event $event */
        return DB::transaction(function () use ($event, $data, $userId) {
            $event->fill($data);
            if ($userId !== null) {
                $event->updated_by = (string) $userId;
            }
            $event->save();

            return $event;
        });
    }
}
