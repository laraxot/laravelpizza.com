<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/update-has-many-deep-action.md
<<<<<<< .merge_file_TPB2Ih
 *
=======
>>>>>>> .merge_file_E0SZEP
 * @contract docs/contracts/update-has-many-deep-action.md
 */
class HasManyDeepAction
{
    use QueueableAction;

    public function execute(Model $_model, RelationDTO $_relationDTO): void
    {
        // Assert::isInstanceOf($relation = $relationDTO->rows, HasMany::class);
        throw new \LogicException('Update\HasManyDeepAction not implemented');
    }
}
