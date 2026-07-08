<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

/**
 * Materializza `perc_parttimepond_dalal` sulle schede ancora vuote.
 *
 * La formula reale non vive in questa action: viene delegata al mutator Sigma
 * che combina `perc_parttime_dalal`, `gg_parttimevert_dalal` e
 * `gg_presenza_dalal`, persiste il risultato al primo accesso e lo rende
 * riutilizzabile nelle action economiche successive.
 */
class UpdatePercParttimepondDalalAction
{
    use QueueableAction;

    private const BATCH_SIZE = 100;

    /**
     * Materializza il valore solo per i record ancora privi di `perc_parttimepond_dalal`.
     *
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
        foreach ($class::query()
            ->where('anno', $year)
            ->where('type', $type)
            ->whereNull('perc_parttimepond_dalal')
            ->lazyById(self::BATCH_SIZE) as $scheda) {
            $scheda->getAttribute('perc_parttimepond_dalal');
        }
    }
}
