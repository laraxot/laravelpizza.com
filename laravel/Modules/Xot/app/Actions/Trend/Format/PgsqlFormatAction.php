<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Trend\Format;

class PgsqlFormatAction extends BaseFormatAction
{
    #[\Override]
    public function execute(string $column, string $interval): string
    {
        $format = match ($interval) {
            'minute' => 'YYYY-MM-DD HH24:MI:00',
            'hour' => 'YYYY-MM-DD HH24:00:00',
            'day' => 'YYYY-MM-DD',
            'month' => 'YYYY-MM',
            'year' => 'YYYY',
            default => throw new \InvalidArgumentException('Invalid interval.'),
        };

        return sprintf("to_char(%s, '%s')", $column, $format);
    }
}
