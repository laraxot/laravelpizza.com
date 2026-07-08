<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Modules\Ptv\Actions\CriteriEsclusione\Check;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class TrovaEsclusiByModelClassYearAction
{
    use QueueableAction;

    /**
     * @param  class-string<SchedaContract>  $modelClass
     */
    public function execute(string $modelClass, string $fieldName, int $year): void
    {
        if (! class_exists($modelClass) || ! is_subclass_of($modelClass, SchedaContract::class)) {
            return;
        }

        $rows = $modelClass::query()
            ->where($fieldName, $year)
            ->inRandomOrder()
            ->get();

        if (! ($rows instanceof EloquentCollection)) {
            return;
        }

        $criteriEsclusione = $modelClass::getCriteriEsclusioneByYear($year, $fieldName);
        $criteriOption = $modelClass::getCriteriOptionsParsedByYear($year, $fieldName);

        if ($criteriEsclusione === null || $criteriOption === null) {
            return;
        }

        /** @var \Illuminate\Support\Collection<int, CriteriEsclusioneContract> $validatedCriteriEsclusione */
        $validatedCriteriEsclusione = $criteriEsclusione
            ->filter(static fn (mixed $criterio): bool => $criterio instanceof CriteriEsclusioneContract)
            ->values()
            ->toBase();

        foreach ($rows as $row) {
            if (! $row instanceof SchedaContract) {
                continue;
            }
            app(Check::class)->execute($row, $validatedCriteriEsclusione, $criteriOption);
        }
    }
}
