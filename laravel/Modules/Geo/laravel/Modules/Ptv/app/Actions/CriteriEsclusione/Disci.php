<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class Disci
{
    use QueueableAction;

    /**
     * Verifica se la scheda ha diritto in base al criterio di disciplina.
     *
     * @param  SchedaContract  $scheda  La scheda da verificare
     * @param  string  $value  Valore del criterio (lista separata da virgole)
     * @return string Motivo di esclusione o stringa vuota se ha diritto
     */
    public function execute(SchedaContract $scheda, string $value): string
    {
        if (\in_array($scheda->disci1, explode(',', $value), false)) {
            return 'no disci';
        }

        return '';
    }
}
