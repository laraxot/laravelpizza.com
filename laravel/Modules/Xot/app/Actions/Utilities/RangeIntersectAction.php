<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Utilities;

use Spatie\QueueableAction\QueueableAction;

class RangeIntersectAction
{
    use QueueableAction;

    /**
     * Find intersection of two numeric ranges.
     *
     * @return array{0: int, 1: int}|false
     */
    public function execute(int $a, int $b, int $c, int $d): array|bool
    {
        $maxStart = max($a, $c);
        $minEnd = min($b, $d);

        if ($maxStart <= $minEnd) {
            return [$maxStart, $minEnd];
        }

        return false;
    }
}
