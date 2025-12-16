<?php

declare(strict_types=1);

namespace Modules\Activity\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    // public array $data = [];

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        // $this->data = ['aaa' => 'bbb'];
    }
}
