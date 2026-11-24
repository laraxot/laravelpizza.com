<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/store-morphed-by-many-action.md
 * @contract docs/contracts/store-morphed-by-many-action.md
 */
class MorphedByManyAction
{
    use QueueableAction;

    public function execute(Model $_model, RelationDTO $_relationDTO): void
    {
        // Assert::isInstanceOf($rows = $relationDTO->rows, HasOne::class);
        throw new \LogicException('Store\MorphedByManyAction not implemented');
    }
}
