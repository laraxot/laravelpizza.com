<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Console;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-job-status-commands-action.md
 * @contract docs/contracts/get-job-status-commands-action.md
 */
final class GetJobStatusCommandsAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(): array
    {
        return [
            'queue:clear',
            'queue:failed',
            'queue:flush',
            'queue:prune-batches',
            'queue:prune-failed',
            'queue:restart',
            'queue:retry',
            'worker:check',
            'route:list',
        ];
    }
}
