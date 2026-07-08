<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Scheda;
use Spatie\QueueableAction\QueueableAction;

/**
 * Materializza `gg_presenza_dalal` sulle schede organizzative ancora vuote.
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
     */
    public function execute(string $year, string $type): void
    {
        foreach (Scheda::query()
            ->where('anno', $year)
            ->where('type', $type)
            // ->where('ha_diritto', '>', 0)
            ->whereNull('gg_presenza_dalal')
            ->lazyById(self::BATCH_SIZE) as $scheda) {
            $scheda->getAttribute('gg_presenza_dalal');
        }
    }
}
