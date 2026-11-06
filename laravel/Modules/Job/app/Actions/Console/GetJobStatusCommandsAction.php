<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Console;

use Spatie\QueueableAction\QueueableAction;

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
