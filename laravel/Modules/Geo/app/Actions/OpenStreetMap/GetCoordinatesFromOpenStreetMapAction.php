<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\OpenStreetMap;

use Modules\Geo\Actions\Nominatim\FetchCoordinatesAction;
use Modules\Geo\Datas\LocationData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Classe per ottenere le coordinate da OpenStreetMap.
 */
class GetCoordinatesFromOpenStreetMapAction
{
    use QueueableAction;

    /**
     * Ottiene le coordinate geografiche da un indirizzo usando OpenStreetMap.
     *
     * @param string $address Indirizzo da geocodificare
     *
     * @return LocationData|null Dati della posizione o null se non trovata
     */
    public function execute(string $address): ?LocationData
    {
        if (empty($address)) {
            return null;
        }

        return app(FetchCoordinatesAction::class)->execute($address);
    }
}
