<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Maintenance operations (cleanup) for the activity log.
 *
 * Extracted from ActivityLogger to separate write and maintenance responsibilities.
 */
class ActivityMaintenanceAction
{
    use QueueableAction;

    /**
     * Clean old activities, chunked to avoid long table locks.
     */
    public function execute(int $days = 90): int
    {
        if ($days <= 0) {
            throw new InvalidArgumentException('Days must be positive');
        }

        $deleted = 0;
        Activity::typedQuery()->where('created_at', '<', now()->subDays($days))
            ->chunkById(1000, function (Collection $chunk) use (&$deleted): void {
                $deleted += $chunk->count();
                Activity::typedQuery()->whereIn('id', $chunk->pluck('id')->all())->delete();
            });

        Log::debug('Old activities cleaned', [
            'deleted_count' => $deleted,
            'older_than_days' => $days,
        ]);

        return $deleted;
    }
}
