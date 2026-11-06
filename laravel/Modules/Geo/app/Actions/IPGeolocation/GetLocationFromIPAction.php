<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\IPGeolocation;

use Modules\Geo\Datas\Location\IPLocationData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Classe per ottenere la posizione da un indirizzo IP.
 */
class GetLocationFromIPAction
{
    use QueueableAction;

    /**
     * Ottiene i dati di geolocalizzazione per un indirizzo IP.
     *
     * @param string $ip Indirizzo IP
     *
     * @return IPLocationData|null Dati di geolocalizzazione o null se non disponibili
     */
    public function execute(string $ip): ?IPLocationData
    {
        return app(FetchIPLocationAction::class)->execute($ip);
    }
}
