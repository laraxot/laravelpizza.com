<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\GoogleMaps;

use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per i componenti degli indirizzi dell'API di Google Maps.
 */
class GoogleMapAddressComponentData extends Data
{
    /**
     * @param  string  $long_name  Nome completo del componente
     * @param  string  $short_name  Nome abbreviato del componente
     * @param  array<string>  $types  Tipi del componente
     */
    public function __construct(
        public readonly string $long_name,
        public readonly string $short_name,
        public readonly array $types,
    ) {}
}
