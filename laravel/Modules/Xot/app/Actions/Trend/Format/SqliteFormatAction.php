<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Trend\Format;

/**
 * @see docs/contracts/sqlite-format-action.md
<<<<<<< .merge_file_0jQdH7
 *
=======
>>>>>>> .merge_file_jxln6U
 * @contract docs/contracts/sqlite-format-action.md
 */
class SqliteFormatAction extends BaseFormatAction
{
    #[\Override]
    public function execute(string $column, string $interval): string
    {
        $format = match ($interval) {
            'minute' => '%Y-%m-%d %H:%M:00',
            'hour' => '%Y-%m-%d %H:00',
            'day' => '%Y-%m-%d',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => throw new \InvalidArgumentException('Invalid interval.'),
        };

        return sprintf("strftime('%s', %s)", $format, $column);
    }
}
