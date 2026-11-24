<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Console;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-queue-subcommands-action.md
 *
 * @contract docs/contracts/get-queue-subcommands-action.md
 */
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
