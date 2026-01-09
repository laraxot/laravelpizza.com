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

    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): Event
    {
        $userId = Auth::id();

        /** @var Event $event */
        return DB::transaction(function () use ($data, $userId) {
            $event = new Event();
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
