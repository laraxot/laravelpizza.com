<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Console;

use Spatie\QueueableAction\QueueableAction;

final class GetScheduleStatusCommandsAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(): array
    {
        return [
            'job:schedule-list',
            'schedule:clear-cache',
            'schedule:list',
            'schedule:run',
            'schedule:test',
            'schedule:work',
            'schedule-monitor:sync',
            'schedule-monitor:list',
        ];
    }
}
