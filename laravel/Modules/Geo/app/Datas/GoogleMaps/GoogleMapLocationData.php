<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\GoogleMaps;

use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per i dati di posizione dell'API di Google Maps.
 */
class GoogleMapLocationData extends Data
{
    /**
     * @param  float  $lat  Latitudine
     * @param  float  $lng  Longitudine
     */
    public function __construct(
        public readonly float $lat,
        public readonly float $lng,
    ) {}
}
