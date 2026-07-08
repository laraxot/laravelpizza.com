<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

/**
 * Materializza `gg_anno` sulle schede ancora vuote o con valore 0.
 *
 * Questa action non contiene la formula di calcolo. Il valore resta delegato
 * al modello, che tramite il mutator calcola `gg_anno`
 * interrogando i dati di presenza per l'intero anno e lo persiste
 * automaticamente al primo accesso.
 *
 * In questo modo la business logic vive in un solo punto e la action si limita
 * a orchestrare la materializzazione batch dei record necessari.
 */
class UpdateGgAnnoAction
{
    use QueueableAction;

    private const BATCH_SIZE = 100;

    /**
     * Materializza il valore per i record con `gg_anno` NULL o 0.
     *
     * @param  class-string<Model>  $class  Classe model da aggiornare
     * @param  string  $year  Anno di riferimento (es: '2024')
     * @param  string  $type  Tipo dipendente ('dip' per dipendenti, 'po', etc.)
     */
    public function execute(string $class, string $year, string $type): void
    {
        foreach ($class::query()
            ->where('anno', $year)
            ->where('type', $type)
            ->where(static function ($query): void {
                $query->whereNull('gg_anno')
                    ->orWhere('gg_anno', 0)
                    ->orWhere('gg_anno', 0.0);
            })
            ->lazyById(self::BATCH_SIZE) as $scheda) {
            $scheda->getAttribute('gg_anno');
        }
    }
}
