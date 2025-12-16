<?php

declare(strict_types=1);

namespace Modules\Job\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastingEvent extends TaskEvent implements ShouldBroadcast
{
    use InteractsWithSockets;

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): PrivateChannel
    {
        // return new PrivateChannel(config('totem.broadcasting.channel'));
        return new PrivateChannel('task.events');
    }

    /**
     * Toggles event broadcasting on/off based on config value.
     */
    public function broadcastWhen(): bool
    {
        // return config('totem.broadcasting.enabled');
        return true;
    }
}
