<?php

declare(strict_types=1);
/**
 * --- usata ricorsivamente.
 */

namespace Modules\Xot\Actions\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/has-column-action.md
<<<<<<< .merge_file_PTkPhz
 *
=======
>>>>>>> .merge_file_NToxCH
 * @contract docs/contracts/has-column-action.md
 */
class HasColumnAction
{
    use QueueableAction;

    public function execute(Model $model, string $column): bool
    {
        $conn = Schema::connection($model->getConnectionName());

        return $conn->hasColumn($model->getTable(), $column);
    }
}
