<?php

declare(strict_types=1);

namespace Modules\Xot\Services\Trend\Adapters;

use Error;
use Override;

class SqliteAdapter extends AbstractAdapter
{
    #[Override]
    public function format(string $column, string $interval): string
    {
        $format = match ($interval) {
            'minute' => '%Y-%m-%d %H:%M:00',
            'hour' => '%Y-%m-%d %H:00',
            'day' => '%Y-%m-%d',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => throw new Error('Invalid interval.'),
        };

        return sprintf("strftime('%s', %s)", $format, $column);
    }
}
