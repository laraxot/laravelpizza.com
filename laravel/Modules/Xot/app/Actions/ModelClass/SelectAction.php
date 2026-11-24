<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\ModelClass;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/select-action.md
 * @contract docs/contracts/select-action.md
 */
class SelectAction
{
    use QueueableAction;

    /**
     * Execute a select query.
     *
     * @param  class-string<Model>  $modelClass
     * @return array<mixed>
     */
    public function execute(string $modelClass, string $sql): array
    {
        /** @var Model $model */
        $model = app($modelClass);

        /** @var ConnectionInterface $connection */
        $connection = $model->getConnection();

        return $connection->select($sql);
    }
}
