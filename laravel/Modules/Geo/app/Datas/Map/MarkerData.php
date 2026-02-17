<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Map;

use Spatie\LaravelData\Data;

class MarkerData extends Data
{
    public function __construct(
        public PositionData $position,
        public ?string $title = null,
        public ?IconData $icon = null,
    ) {}
}
