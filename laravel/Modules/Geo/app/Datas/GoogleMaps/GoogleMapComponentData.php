<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\GoogleMaps;

use Spatie\LaravelData\Data;

class GoogleMapComponentData extends Data
{
    /**
     * @param array<int, string> $types
     */
    public function __construct(
        public string $long_name,
        public string $short_name,
        public array $types,
    ) {
    }
}
