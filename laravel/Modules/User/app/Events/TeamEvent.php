<?php

declare(strict_types=1);

namespace Modules\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Contracts\TeamContract;

abstract class TeamEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        /**
         * The team instance.
         */
        public TeamContract $teamContract,
    ) {
    }
}
