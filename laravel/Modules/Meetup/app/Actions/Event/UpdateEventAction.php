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

    public function execute(Event $event, array $data): Event
    {
        $userId = Auth::id();
        
        $event = DB::transaction(function () use ($event, $data, $userId) {
            $event->fill($data);
            $event->updated_by = (string) $userId;
            $event->save();

            return $event;
        });

        return $event;
    }
}