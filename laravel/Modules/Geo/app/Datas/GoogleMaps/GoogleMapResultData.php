<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\GoogleMaps;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Data Transfer Object per i risultati dell'API di Google Maps.
 */
class GoogleMapResultData extends Data
{
    /**
     * @param  DataCollection<GoogleMapAddressComponentData>  $address_components  Componenti dell'indirizzo
     * @param  GoogleMapGeometryData  $geometry  Dati geometrici
     * @param  string  $formatted_address  Indirizzo formattato
     * @param  array<string>  $types  Tipi di indirizzo
     */
    public function __construct(
        public readonly DataCollection $address_components,
        public readonly GoogleMapGeometryData $geometry,
        public readonly string $formatted_address,
        public readonly array $types,
    ) {}
}
