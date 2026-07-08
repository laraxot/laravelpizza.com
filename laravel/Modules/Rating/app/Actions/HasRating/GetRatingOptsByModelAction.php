<?php

declare(strict_types=1);

namespace Modules\Rating\Actions\HasRating;

use Modules\Rating\Models\Contracts\HasRatingContract;
use Spatie\QueueableAction\QueueableAction;

class GetRatingOptsByModelAction
{
    use QueueableAction;

    /**
     * @return array<int, string|null>
     */
    public function execute(HasRatingContract $model): array
    {
        $result = [];

        foreach (
            $model->ratings()
                ->wherePivot('user_id', null)
                ->pluck('title', 'ratings.id') as $ratingId => $title
        ) {
            $result[(int) $ratingId] = is_string($title) ? $title : null;
        }

        return $result;
    }
}
