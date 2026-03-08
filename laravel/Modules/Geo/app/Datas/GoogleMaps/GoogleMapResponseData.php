<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\GoogleMaps;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Data Transfer Object per le risposte dell'API di Google Maps.
 */
class GoogleMapResponseData extends Data
{
    /**
     * @param DataCollection<GoogleMapResultData> $results Risultati della geocodifica
     * @param string                              $status  Stato della risposta
     */
    public function __construct(
        public readonly DataCollection $results,
<<<<<<< HEAD
        public readonly string $status,
||||||| 6161e129d
        public readonly string $status,
    ) {}
=======
        public readonly string $status = 'OK',
>>>>>>> feature/ralph-loop-implementation
    ) {
    }
}
