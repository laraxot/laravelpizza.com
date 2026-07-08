<?php

declare(strict_types=1);

namespace Modules\Job\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Job\Models\Task;

class TaskEvent extends Event
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Constructor.
     */
    public function __construct(
        public Task $task,
    ) {}
}
