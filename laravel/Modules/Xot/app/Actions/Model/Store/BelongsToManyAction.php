<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Session;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class BelongsToManyAction
{
    use QueueableAction;

    public function execute(Model $_model, RelationDTO $relationDTO): void
    {
        Assert::isInstanceOf($rows = $relationDTO->rows, BelongsToMany::class);
        /*
         * dddx(['message' => 'wip',
         * 'row' => $row,
         * 'relation' => $relation, ]);
         */
        if (
            \in_array('to', array_keys($relationDTO->data), false)
                || \in_array('from', array_keys($relationDTO->data), false)
        ) {
            // $this->saveMultiselectTwoSides($row, $relation->name, $relation->data);
            Assert::isArray($to = $relationDTO->data['to'] ?? []);
            $rows->sync($to);
            $toLabels = array_values(array_filter(
                $to,
                static fn (mixed $item): bool => is_scalar($item),
            ));
            $status = 'collegati ['.implode(', ', array_map(
                static fn (int|float|string|bool $item): string => (string) $item,
                $toLabels,
            )).'] ';
            Session::flash('status', $status);

            return;
        }

        $rows->sync($relationDTO->data);
    }
}
