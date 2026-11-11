<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

readonly class ElevationResultDTO
{
    public function __construct(
        public float $elevation,
        public float $latitude,
        public float $longitude,
    ) {}
}
