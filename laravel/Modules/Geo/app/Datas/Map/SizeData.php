<?php

declare(strict_types=1);

namespace Modules\Geo\Datas\Map;

use Spatie\LaravelData\Data;

class SizeData extends Data
{
    public function __construct(
        public int $width,
        public int $height,
    ) {}
}
