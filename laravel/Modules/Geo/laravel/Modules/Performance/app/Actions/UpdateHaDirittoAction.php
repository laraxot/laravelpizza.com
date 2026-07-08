<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use Modules\Performance\Models\BaseIndividualeModel;
use Modules\Performance\Models\CriteriEsclusione;
use Modules\Performance\Models\CriteriOption;
use Spatie\QueueableAction\QueueableAction;

class UpdateHaDirittoAction
{
    use QueueableAction;

    /**
     * @template TModel of BaseIndividualeModel
     *
     * @param  class-string<TModel>  $modelClass
     */
    public function execute(string $modelClass, int|string $year, string $type = 'dip'): void
    {
        if (! is_subclass_of($modelClass, BaseIndividualeModel::class)) {
            throw new InvalidArgumentException(sprintf('Class %s must extend %s', $modelClass, BaseIndividualeModel::class));
        }

        $yearInt = is_int($year) ? $year : (int) $year;

        /** @var array<string, mixed> $criteriEsclusione */
        $criteriEsclusione = CriteriEsclusione::query()
            ->where('anno', $yearInt)
            ->pluck('value', 'name')
            ->all();

        /** @var array<string, mixed> $criteriOption */
        $criteriOption = CriteriOption::query()
            ->where('anno', $yearInt)
            ->pluck('value', 'name')
            ->all();

        /** @var Collection<int, TModel> $schede */
        $schede = $modelClass::query()
            ->where('type', $type)
            ->where('anno', $yearInt)
            ->get();

        $motivoAction = app(GetHaDirittoMotivoAction::class);

        foreach ($schede as $scheda) {
            [$haDiritto, $motivo] = $motivoAction->execute($scheda, $criteriEsclusione, $criteriOption);

            $scheda->motivo = $motivo;
            $scheda->ha_diritto = $haDiritto;
            $scheda->save();
        }
    }
}
