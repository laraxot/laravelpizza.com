<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/store-morph-many-action.md
<<<<<<< .merge_file_459zvf
 *
=======
>>>>>>> .merge_file_h5JeKj
 * @contract docs/contracts/store-morph-many-action.md
 */
class MorphManyAction
{
    use QueueableAction;

    public function execute(Model $_model, RelationDTO $_relationDTO): void
    {
        // Assert::isInstanceOf($rows = $relationDTO->rows, HasOne::class);
        throw new \LogicException('Store\MorphManyAction not implemented');
    }
}
