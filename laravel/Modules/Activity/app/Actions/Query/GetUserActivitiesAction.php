<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Query;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Activity\Models\Activity;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * Get activities caused by a user.
 */
class GetUserActivitiesAction
{
    use QueueableAction;

    /**
     * @return Collection<int, Activity>
     */
    public function execute(UserContract $user, int $limit = 50): Collection
    {
        if (! $user instanceof Model) {
            throw new InvalidArgumentException('User must be an Eloquent model');
        }
        if ($limit <= 0) {
            throw new InvalidArgumentException('Limit must be positive');
        }

        $query = Activity::typedQuery()
            ->with('subject')
            ->whereIn('causer_id', [$user->getKey()])
            ->where('causer_type', $user::class)
            ->latest()
            ->limit($limit)
            ;

        return Activity::typedGet($query);
    }
}
