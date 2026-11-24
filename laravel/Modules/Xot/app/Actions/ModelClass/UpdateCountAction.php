<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\ModelClass;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\InformationSchemaTable;
use Spatie\QueueableAction\QueueableAction;

/**
 * Counts records for a given model class using optimized table information.
 *
 * @see docs/contracts/update-count-action.md
 *
 * @contract docs/contracts/update-count-action.md
 */
class UpdateCountAction
{
    use QueueableAction;

    /**
     * Execute the count action for the given model class.
     *
     * @param  class-string<Model>  $modelClass  The fully qualified model class name
     */
    public function execute(string $modelClass, int $total): void
    {
        InformationSchemaTable::updateModelCount($modelClass, $total); // Method not implemented
    }
}
