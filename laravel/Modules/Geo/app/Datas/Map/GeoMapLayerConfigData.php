<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Map;

use Spatie\LaravelData\Data;

class GeoMapLayerConfigData extends Data
{
    public function __construct(
        public string $key,
        public string $label,
        public bool $enabled = false,
    ) {
    }
}
