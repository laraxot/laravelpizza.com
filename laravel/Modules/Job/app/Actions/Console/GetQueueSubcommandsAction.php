<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Console;

use Spatie\QueueableAction\QueueableAction;

final class GetQueueSubcommandsAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(): array
    {
        return [
            'clear',
            'failed',
            'flush',
            'prune-batches',
            'prune-failed',
            'restart',
            'retry',
        ];
    }
}
