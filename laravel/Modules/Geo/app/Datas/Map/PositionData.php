<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Map;

use Spatie\LaravelData\Data;

class PositionData extends Data
{
    public function __construct(
        public float $lat,
        public float $lng,
    ) {}
}
