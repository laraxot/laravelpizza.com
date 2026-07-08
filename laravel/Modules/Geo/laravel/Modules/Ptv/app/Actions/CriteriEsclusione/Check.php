<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Modules\Ptv\Contracts\CheckCriterioEsclusioneContract;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class Check
{
    use QueueableAction;

    /**
     * @param  Collection<int, \Modules\Ptv\Models\Contracts\CriteriEsclusioneContract>  $criteriEsclusione
     * @param  Collection<string, mixed>  $criteriOption
     */
    public function execute(SchedaContract $scheda, Collection $criteriEsclusione, Collection $criteriOption): void
    {
        foreach ($criteriEsclusione as $criterio) {
            $criterioName = $criterio->getAttribute('name');
            if (! is_string($criterioName)) {
                continue;
            }
            $action = '\Modules\Ptv\Actions\CriteriEsclusione\\'.Str::studly($criterioName);
            if (! class_exists($action)) {
                throw new InvalidArgumentException('Action criterio esclusione non trovata');
            }

            $critero_value = $criterio->getAttribute('value');
            $criterioValue = is_scalar($critero_value) ? (string) $critero_value : '';

            $actionInstance = app($action);
            if (! $actionInstance instanceof CheckCriterioEsclusioneContract) {
                continue;
            }

            $motivo = $actionInstance->execute($scheda, $criterioValue, $criteriOption);
            if ($motivo !== '') {
                $motivo_arr = explode(',', $motivo);
                $motivo_arr[] = $motivo;
                $motivo_arr = array_unique($motivo_arr);
                $motivo_arr = array_filter($motivo_arr);
                $scheda->ha_diritto = 0;
                $scheda->motivo = implode(',', $motivo_arr);
                $scheda->save();
            }
        }
    }
}
