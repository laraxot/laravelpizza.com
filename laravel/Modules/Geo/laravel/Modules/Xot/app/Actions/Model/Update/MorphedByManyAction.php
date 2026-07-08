<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;

class MorphedByManyAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(Model $_model, RelationDTO $_relationDTO): void
    {
        // Assert::isInstanceOf($relation = $relationDTO->rows, HasMany::class);
        dddx('wip');

        /*
         * foreach ($data as $k => $v) {
         * if (! \is_array($v)) {
         * $v = [];
         * }
         * if (! isset($v['pivot'])) {
         * $v['pivot'] = [];
         * }
         * // Call to undefined method Illuminate\Database\Eloquent\Relations\MorphMany::syncWithoutDetaching()
         * // $res = $model->$name()->syncWithoutDetaching([$k => $v['pivot']]);
         * $model->$name()->touch();
         * }
         */
    }
}
