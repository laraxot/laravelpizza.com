<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\ModelClass;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\InformationSchemaTable;
use Spatie\QueueableAction\QueueableAction;

/**
 * Counts records for a given model class using optimized table information.
 */
class CountAction
{
    use QueueableAction;

    /**
     * Execute the count action for the given model class.
     *
     * @param  class-string<Model>  $modelClass  The fully qualified model class name
     * @return int The total count of records
     *
     * @throws \InvalidArgumentException If model class is invalid or not found
     */
    public function execute(string $modelClass): int
    {
        return InformationSchemaTable::getModelCount($modelClass);
    }
}
