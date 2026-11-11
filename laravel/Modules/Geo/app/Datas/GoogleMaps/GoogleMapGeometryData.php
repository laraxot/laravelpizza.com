<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\GoogleMaps;

use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per i dati geometrici dell'API di Google Maps.
 */
class GoogleMapGeometryData extends Data
{
    /**
     * @param  GoogleMapLocationData  $location  Posizione geografica
     */
    public function __construct(
        public readonly GoogleMapLocationData $location,
    ) {}
}
