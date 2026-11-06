<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Trend\Format;

class MySqlFormatAction extends BaseFormatAction
{
    #[\Override]
    public function execute(string $column, string $interval): string
    {
        $format = match ($interval) {
            'minute' => '%Y-%m-%d %H:%i:00',
            'hour' => '%Y-%m-%d %H:00',
            'day' => '%Y-%m-%d',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => throw new \InvalidArgumentException('Invalid interval.'),
        };

        return sprintf("date_format(%s, '%s')", $column, $format);
    }
}
