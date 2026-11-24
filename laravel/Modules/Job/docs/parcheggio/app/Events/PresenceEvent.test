<?php

declare(strict_types=1);

namespace Modules\Job\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PresenceEvent implements ShouldBroadcast {
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     
     */
    public function broadcastOn(): Channel {
        return new PresenceChannel('presence.'.auth()->user()->group_id);
    }
}
