<?php

declare(strict_types=1);

namespace Modules\Job\Actions;

use Spatie\QueueableAction\QueueableAction;

class ExecuteTaskAction
{
    use QueueableAction;

    public function execute(string $_task_id): string
    {
        /*
         * $task = Task::findOrFail($task_id);
         * $start = microtime(true);
         * try {
         * Artisan::call($task->command, $task->compileParameters());
         * $output = Artisan::output();
         * } catch (\Exception $e) {
         * $output = $e->getMessage();
         * }
         * Executed::dispatch($task, $start, $output);
         *
         * return $output;
         */
        dddx('wip');

        return 'WIP';
    }
}
