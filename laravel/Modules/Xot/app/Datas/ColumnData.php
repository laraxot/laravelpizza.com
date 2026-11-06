<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

class ColumnData extends Data
{
    public function __construct(
        public string $name,
        public string $type,
    ) {}
}
