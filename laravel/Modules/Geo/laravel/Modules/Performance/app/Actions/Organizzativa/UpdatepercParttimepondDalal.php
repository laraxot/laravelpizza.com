<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Scheda;
use Spatie\QueueableAction\QueueableAction;

/**
 * Materializza `perc_parttimepond_dalal` sulle schede organizzative ancora vuote.
 *
 * La formula reale non vive in questa action: viene delegata al mutator Sigma
 * che combina `perc_parttime_dalal`, `gg_parttimevert_dalal` e
 * `gg_presenza_dalal`, persiste il risultato al primo accesso e lo rende
 * riutilizzabile nelle action economiche successive.
 */
class UpdatepercParttimepondDalal
{
    use QueueableAction;

    private const BATCH_SIZE = 100;

    /**
     * Materializza il valore solo per i record ancora privi di `perc_parttimepond_dalal`.
     */
    public function execute(string $year, string $type): void
    {
        foreach (Scheda::query()
            ->where('anno', $year)
            ->where('type', $type)
            ->whereNull('perc_parttimepond_dalal')
            ->lazyById(self::BATCH_SIZE) as $scheda) {
            $scheda->getAttribute('perc_parttimepond_dalal');
        }
    }
}
