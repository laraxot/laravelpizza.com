<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Query;

use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Get activity log entries for a subject identified by class and id.
 *
 * @see docs/contracts/get-subject-activity-log-action.md
 *
 * @contract docs/contracts/get-subject-activity-log-action.md
 */
class GetSubjectActivityLogAction
{
    use QueueableAction;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function execute(string $modelClass, int|string $modelId, int $limit = 500): array
    {
        $activities = Activity::typedGet(Activity::typedQuery()
            ->where('subject_type', $modelClass)
            ->where('subject_id', $modelId)
            ->latest()
            ->limit($limit)
        );

        return $activities
            ->map(function (Activity $activity): array {
                $result = [];
                foreach ($activity->toArray() as $key => $value) {
                    if (is_string($key)) {
                        $result[$key] = $value;
                    }
                }

                return $result;
            })
            ->values()
            ->all();
    }
}
