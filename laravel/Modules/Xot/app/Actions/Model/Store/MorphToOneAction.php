<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Modules\Xot\Actions\Model\CreateMorphToOneRelatedModelAction;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;

class MorphToOneAction
{
    use QueueableAction;

    public function execute(Model $_model, RelationDTO $relationDTO): void
    {
        // if ($relationDTO === null) {
        //    return;
        // }

        $rows = $relationDTO->rows;

        if (! isset($relationDTO->data['lang'])) {
            $relationDTO->data['lang'] = App::getLocale();
        }

        app(CreateMorphToOneRelatedModelAction::class)->execute($rows, $relationDTO->data);

        // }
        // } else {
        //    $rows->sync($relation->data);
        // }
        /*
         * dddx([
         * 'message' => 'wip',
         * 'row' => $row,
         * 'relation' => $relation,
         * 'relation_rows' => $relation->rows->exists(),
         * 't' => $row->{$relation->name},
         * ]);
         *
         * dddx('wip');
         */
    }
}
