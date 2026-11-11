<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Query;

use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Get activities by event type.
 */
class GetActivitiesByTypeAction
{
    use QueueableAction;

    /**
     * @return Collection<int, Activity>
     */
    public function execute(string $type, int $limit = 50): Collection
    {
        if ($type === '') {
            throw new InvalidArgumentException('Type cannot be empty');
        }
        if ($limit <= 0) {
            throw new InvalidArgumentException('Limit must be positive');
        }

        $query = Activity::typedQuery()
            ->with(['causer', 'subject'])
            ->where('event', $type)
            ->latest()
            ->limit($limit);

        return Activity::typedGet($query);
    }
}
