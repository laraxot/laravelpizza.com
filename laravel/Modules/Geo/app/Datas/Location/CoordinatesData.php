<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Location;

use Spatie\LaravelData\Data;

class CoordinatesData extends Data
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
