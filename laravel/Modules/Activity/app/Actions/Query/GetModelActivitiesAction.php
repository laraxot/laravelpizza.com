<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Query;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Activity;
use Spatie\QueueableAction\QueueableAction;

/**
 * Get activities for a given subject model.
 */
class GetModelActivitiesAction
{
    use QueueableAction;

    /**
     * @return Collection<int, Activity>
     */
    public function execute(Model $model, int $limit = 50): Collection
    {
        $query = Activity::typedQuery()
            ->with('causer')
            ->where('subject_type', $model::class)
            ->where('subject_id', $model->getKey())
            ->latest()
            ->limit($limit);

        return Activity::typedGet($query);
    }
}
