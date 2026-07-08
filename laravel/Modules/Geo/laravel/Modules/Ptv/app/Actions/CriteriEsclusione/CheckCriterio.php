<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;
use Spatie\QueueableAction\QueueableAction;

class CheckCriterio
{
    use QueueableAction;

    /**
     * Verifica un criterio di esclusione specifico per tutte le schede.
     *
     * @param  CriteriEsclusioneContract  $criterio  Il criterio di esclusione da verificare
     */
    public function execute(CriteriEsclusioneContract $criterio): void
    {
        $schede = $criterio->getSchedaCollection();

        $criterioName = $criterio->getAttribute('name');
        if (! is_string($criterioName)) {
            return;
        }

        $action = '\Modules\Ptv\Actions\CriteriEsclusione\\'.Str::studly($criterioName);

        if (! class_exists($action)) {
            return;
        }

        $criteriOption = $criterio->criteriOptionsCollection();
        $count = 0;
        foreach ($schede as $scheda) {
            // Type narrowing: scheda is already Model from Collection type
            // Removed redundant is_object() check - scheda is already Model

            $critero_value = $criterio->getAttribute('value');
            if ($critero_value == null) {
                $critero_value = '';
            }

            $actionInstance = app($action);
            if (! is_object($actionInstance) || ! method_exists($actionInstance, 'execute')) {
                continue;
            }

            $motivo = $actionInstance->execute($scheda, $critero_value, $criteriOption);
            // Type narrowing: motivo is already string from execute return type
            if (is_string($motivo) && $motivo !== '') {
                $motivo_arr = explode(',', $motivo);
                $motivo_arr[] = $motivo;

                $motivo_arr = array_unique($motivo_arr);
                $motivo_arr = array_filter($motivo_arr);

                // @phpstan-ignore-next-line property.notFound
                $scheda->ha_diritto = 0;
                // @phpstan-ignore-next-line property.notFound
                $scheda->motivo = implode(',', $motivo_arr);
                $scheda->save();
                $count++;
            }
        }

        Notification::make()
            ->title('Esclusi ['.$count.']')
            ->success()
            ->send();
    }
}
