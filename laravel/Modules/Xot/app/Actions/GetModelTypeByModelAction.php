<?php

declare(strict_types=1);
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

namespace Modules\Xot\Actions;

use Illuminate\Support\Str;
use Modules\Xot\Contracts\ModelContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-model-type-by-model-action.md
<<<<<<< .merge_file_ObW9iV
 *
=======
>>>>>>> .merge_file_qxnM4N
 * @contract docs/contracts/get-model-type-by-model-action.md
 */
class GetModelTypeByModelAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(ModelContract $modelContract): string
    {
        return Str::snake(class_basename($modelContract));
    }
}
