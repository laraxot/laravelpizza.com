<?php

declare(strict_types=1);

namespace Modules\Rating\Actions\HasRating;

use Modules\Rating\Models\Contracts\HasRatingContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-count-by-model-rating-id-action.md
 *
 * @contract docs/contracts/get-count-by-model-rating-id-action.md
 */
class GetCountByModelRatingIdAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(HasRatingContract $model, ?string $rating_id = null): float
    {
        $opts = $model->ratings()
            ->wherePivot('user_id', '!=', null);
        if ($rating_id !== null) {
            $opts = $opts->wherePivot('rating_id', $rating_id);
        }

        return $opts->count('rating_morph.value');
    }
}
