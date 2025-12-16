<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

class CreateEventAction
{
    use QueueableAction;

    public function execute(array $data): Event
    {
        $userId = Auth::id();
        
        $event = DB::transaction(function () use ($data, $userId) {
            $event = new Event();
            $event->fill($data);
            $event->user_id = $userId;
            $event->created_by = (string) $userId;
            $event->save();

            return $event;
        });

        return $event;
    }
}