<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Map;

use Spatie\LaravelData\Data;

/**
 * @property array<string, mixed>             $geoJson
 * @property array<string, mixed>             $initialState
 * @property array<int, array<string, mixed>> $layerConfig
 */
class GeoMapWidgetData extends Data
{
    /**
     * @param array<string, mixed>             $geoJson
     * @param array<string, mixed>             $initialState
     * @param array<int, array<string, mixed>> $layerConfig
     * @param array<string, mixed>             $meta
     */
    public function __construct(
        public array $geoJson,
        public array $initialState,
        public array $layerConfig,
        public array $meta = [],
    ) {
    }
}
