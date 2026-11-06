<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Illuminate\Contracts\Database\Query\Expression;
use Modules\Geo\Database\Query\GeoDistanceExpression;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per generare l'espressione SQL per il calcolo della distanza.
 *
 * Questa action centralizza la logica di generazione dell'espressione SQL
 * per il calcolo della distanza tra due punti geografici.
 */
class GetDistanceExpressionAction
{
    use QueueableAction;

    /**
     * Genera l'espressione SQL per calcolare la distanza tra due punti.
     *
     * @param float       $latitude  Latitudine del punto di riferimento
     * @param float       $longitude Longitudine del punto di riferimento
     * @param string|null $alias     Alias per l'espressione (opzionale)
     *
     * @return Expression Espressione SQL per il calcolo della distanza
     */
    public function execute(
        float $latitude,
        float $longitude,
        ?string $alias = null,
    ): Expression {
        return new GeoDistanceExpression($latitude, $longitude, $alias);
    }
}
