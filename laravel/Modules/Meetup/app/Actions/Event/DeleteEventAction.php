<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

class DeleteEventAction
{
    use QueueableAction;

    public function execute(Event $event): bool
    {
        $userId = Auth::id();
        
        return DB::transaction(function () use ($event, $userId) {
            $event->updated_by = (string) $userId;
            return $event->delete();
        });
    }
}