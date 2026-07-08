<?php

declare(strict_types=1);

namespace Modules\Xot\Services\Trend\Adapters;

abstract class AbstractAdapter
{
    abstract public function format(string $column, string $interval): string;
}
