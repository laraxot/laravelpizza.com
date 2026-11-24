<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/store-has-many-through-action.md
<<<<<<< .merge_file_DHXYrj
 *
=======
>>>>>>> .merge_file_oz4cQf
 * @contract docs/contracts/store-has-many-through-action.md
 */
class HasManyThroughAction
{
    use QueueableAction;

    public function execute(Model $_model, RelationDTO $_relationDTO): void
    {
        // Assert::isInstanceOf($rows = $relationDTO->rows, BelongsToMany::class);
        throw new \LogicException('Store\HasManyThroughAction not implemented');
    }
}
