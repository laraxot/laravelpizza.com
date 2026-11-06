<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Record activity for a subject identified by class and id (no Model instance required).
 */
class RecordSubjectActivityAction
{
    use QueueableAction;

    /**
     * @param  class-string  $subjectType
     * @param  array<string, mixed>|null  $properties
     */
    public function execute(
        string $subjectType,
        int|string $subjectId,
        string $event,
        ?array $properties = null,
        ?string $description = null,
    ): Activity {
        /** @var Activity */
        return Activity::typedQuery()->create([
            'log_name' => 'default',
            'description' => $description ?? sprintf('%s %s', class_basename($subjectType), $event),
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'event' => $event,
            'properties' => $properties,
        ]);
    }
}
