<?php

declare(strict_types=1);
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

namespace Modules\Xot\Actions\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-model-fields-by-model-action.md
<<<<<<< .merge_file_8nZYrP
 *
=======
>>>>>>> .merge_file_dv38AQ
 * @contract docs/contracts/get-model-fields-by-model-action.md
 */
class GetModelFieldsByModelAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(Model $model): array
    {
        return $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
    }
}
