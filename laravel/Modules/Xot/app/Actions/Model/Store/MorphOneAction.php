<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class MorphOneAction
{
    use QueueableAction;

    public function execute(Model $_model, RelationDTO $relationDTO): void
    {
        Assert::isInstanceOf($rows = $relationDTO->rows, MorphOne::class);
        // if (is_string($relation->data) && isJson($relation->data)) {
        //    $relation->data = json_decode($relation->data, true);
        // }

        if ($rows->exists()) {
            $rows->update($relationDTO->data);
        } else {
            $rows->create($relationDTO->data);
        }
    }
}
