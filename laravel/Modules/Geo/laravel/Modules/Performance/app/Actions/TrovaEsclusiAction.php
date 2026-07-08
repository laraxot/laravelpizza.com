<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Modules\Performance\Models\BaseIndividualeModel;
use Spatie\QueueableAction\QueueableAction;

class TrovaEsclusiAction
{
    use QueueableAction;

    public int $year;

    /**
     * @param BaseIndividualeModel<object> $model
     */
    public function check(string $name, string $value, BaseIndividualeModel $model): string
    {
        $action = new GetHaDirittoMotivoAction;
        $action->year = $this->year;

        $criteri_esclusione = [$name => $value];
        $criteri_option = [];

        [, $motivo] = $action->execute($model, $criteri_esclusione, $criteri_option);

        return $motivo;
    }

    public function execute(): void
    {
        dddx('wip');
    }
}
