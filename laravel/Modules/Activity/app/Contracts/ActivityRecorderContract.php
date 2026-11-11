<?php

declare(strict_types=1);

namespace Modules\Activity\Contracts;

/**
 * Contract for activity recording across modules.
 * Modules should dispatch ActivityRecorded events instead of calling this directly.
 */
interface ActivityRecorderContract
{
    /**
     * Record a model action for audit trail.
     *
     * @param  class-string  $modelClass
     * @param  string  $action  create|update|delete|restore
     * @param  array<string, mixed>  $changes
     */
    public function record(
        string $modelClass,
        int|string $modelId,
        string $action,
        array $changes = []
    ): void;

    /**
     * Get activity log for a model.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getLog(string $modelClass, int|string $modelId): array;
}
