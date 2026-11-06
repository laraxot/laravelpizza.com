<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Query;

use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Get the most recent activities.
 */
class GetRecentActivitiesAction
{
    use QueueableAction;

    /**
     * @return Collection<int, Activity>
     */
    public function execute(int $limit = 50): Collection
    {
        if ($limit <= 0) {
            throw new InvalidArgumentException('Limit must be positive');
        }

        $query = Activity::typedQuery()
            ->with(['causer', 'subject'])
            ->latest()
            ->limit($limit)
            ;

        return Activity::typedGet($query);
    }
}
