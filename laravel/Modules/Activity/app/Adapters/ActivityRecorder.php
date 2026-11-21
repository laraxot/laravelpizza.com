<?php

declare(strict_types=1);

namespace Modules\Activity\Adapters;

use Modules\Activity\Actions\Query\GetSubjectActivityLogAction;
use Modules\Activity\Actions\RecordSubjectActivityAction;
use Modules\Activity\Contracts\ActivityRecorderContract;

/**
 * Adapter for ActivityRecorderContract — not a QueueableAction (multi-operation contract).
 */
class ActivityRecorder implements ActivityRecorderContract
{
    public function record(
        string $modelClass,
        int|string $modelId,
        string $action,
        array $changes = []
    ): void {
        app(RecordSubjectActivityAction::class)->execute($modelClass, $modelId, $action, $changes);
    }

    public function getLog(string $modelClass, int|string $modelId): array
    {
        return app(GetSubjectActivityLogAction::class)->execute($modelClass, $modelId);
    }
}
