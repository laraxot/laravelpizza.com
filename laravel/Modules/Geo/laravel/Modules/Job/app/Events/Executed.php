<?php

declare(strict_types=1);

namespace Modules\Job\Events;

use Modules\Job\Models\Task;
use Modules\Job\Notifications\TaskCompleted;

class Executed extends BroadcastingEvent
{
    /**
     * Executed constructor.
     *
     * @return void
     */
    public function __construct(Task $task, float $started, string $output)
    {
        parent::__construct($task);

        $time_elapsed_secs = microtime(true) - $started;

        $task->results()->create([
            'duration' => $time_elapsed_secs * 1000,
            'result' => $output,
        ]);

        $task->notify(new TaskCompleted($output));
        $task->autoCleanup();
    }
}
