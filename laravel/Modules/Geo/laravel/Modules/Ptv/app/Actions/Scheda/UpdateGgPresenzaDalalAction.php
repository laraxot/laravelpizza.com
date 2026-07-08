<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

/**
 * Materializza `gg_presenza_dalal` sulle schede ancora vuote.
 *
 * Questa action non contiene la formula di calcolo. Il valore resta delegato
 * al modello, che tramite il mutator Sigma calcola `gg_presenza_dalal`
 * interrogando la relazione `qua00f()` nel range `dal`/`al` e lo persiste
 * automaticamente al primo accesso.
 *
 * In questo modo la business logic vive in un solo punto e la action si limita
 * a orchestrare la materializzazione batch dei record necessari.
 */
class UpdateGgPresenzaDalalAction
{
    use QueueableAction;

    private const BATCH_SIZE = 100;

    /**
     * Materializza il valore solo per i record ancora privi di `gg_presenza_dalal`.
     *
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
        foreach ($class::query()
            ->where('anno', $year)
            ->where('type', $type)
            ->whereNull('gg_presenza_dalal')
            ->lazyById(self::BATCH_SIZE) as $scheda) {
            $scheda->getAttribute('gg_presenza_dalal');
        }
    }
}
