<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class MorphToManyAction
{
    use QueueableAction;

    public function execute(Model $model, RelationDTO $relationDTO): void
    {
        Assert::isInstanceOf($rows = $relationDTO->rows, MorphToMany::class);

        $data = $relationDTO->data;
        if (\in_array('to', array_keys($data), false) || \in_array('from', array_keys($data), false)) {
            if (! isset($data['to'])) {
                $data['to'] = [];
            }

            $data = $data['to'];
        }
        Assert::isArray($data);
        // dddx(['row' => $row, 'relation' => $relation, 't1' => Arr::isAssoc($data)]);

        if (! Arr::isAssoc($data)) {
            $relationDTO->rows->sync($data);

            return;
        }

        dddx([
            'message' => 'wip',
            'row' => $model,
            'relation' => $relationDTO,
            'relation_rows' => $relationDTO->rows->exists(),
            't' => $model->{$relationDTO->name},
        ]);

        dddx('wip');

        /*
         * foreach ($data as $k => $v) {
         * if (\is_array($v)) {
         * if (! isset($v['pivot'])) {
         * $v['pivot'] = [];
         * }
         * if (! isset($v['pivot']['user_id']) && isset($model->user_id)) {
         * $v['pivot']['user_id'] = $model->user_id;
         * }
         * if (! isset($v['pivot']['user_id']) && \Auth::check()) {
         * $v['pivot']['user_id'] = \Auth::id();
         * }
         * $model->$name()->syncWithoutDetaching([$k => $v['pivot']]);
         * } else {
         * $res = $model->$name()->syncWithoutDetaching([$v]);
         * }
         * }
         */
    }
}
