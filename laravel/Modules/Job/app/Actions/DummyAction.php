<?php

declare(strict_types=1);

namespace Modules\Job\Actions;

use Spatie\QueueableAction\QueueableAction;

class DummyAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(): void
    {
        // The business logic goes here, this can be executed in an async job.
        echo 'hello'.PHP_EOL;
    }
}
