<?php

declare(strict_types=1);

namespace Modules\Activity\Adapters;

use Modules\Activity\Actions\Query\GetSubjectActivityLogAction;
use Modules\Activity\Actions\RecordSubjectActivityAction;
use Modules\Activity\Models\Contracts\ActivityRecorderContract;

/**
 * Adapter for ActivityRecorderContract — not a QueueableAction (multi-operation contract).
 */
class ActivityRecorder implements ActivityRecorderContract
{
    /**
     * @param  array<string, mixed>  $changes
     */
    public function record(
        string $modelClass,
        int|string $modelId,
        string $action,
        array $changes = []
    ): void {
        app(RecordSubjectActivityAction::class)->execute(
            $modelClass,
            $modelId,
            $action,
            $changes,
            null,
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getLog(string $modelClass, int|string $modelId): array
    {
        return app(GetSubjectActivityLogAction::class)->execute($modelClass, $modelId);
    }
}
