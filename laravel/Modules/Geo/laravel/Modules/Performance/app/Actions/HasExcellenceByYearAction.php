<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Modules\Performance\Models\Individuale;
use Modules\Progressioni\Models\Progressioni;
use Spatie\QueueableAction\QueueableAction;

class HasExcellenceByYearAction
{
    use QueueableAction;

    /**
     * @param  Individuale|Progressioni  $model
     */
    public function execute($model, int $year): bool
    {
        /*
        $model->performanceIndividuale()
            ->whereBetween('anno', [$this->anno - 4, $this->anno - 1])

            ->where('excellence', 1)
            ->get()
        */
        $where = [
            'ente' => $model->ente,
            'matr' => $model->matr,
            'anno' => $year,
            'excellence' => 1,
        ];

        $rows = Individuale::where($where)->get();

        return $rows->count() > 0;
    }
}
