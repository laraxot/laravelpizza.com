<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Array;

use Spatie\QueueableAction\QueueableAction;

/**
 * ---.
 */
class RangeIntersectAction
{
    use QueueableAction;

    /**
     * ---.
     */
    public function execute(int $a0, int $b0, int $a1, int $b1): array|bool
    {
        if ($a1 >= $a0 && $a1 <= $b0 && $b0 <= $b1) {
            return [$a1, $b0];
        }

        if ($a0 >= $a1 && $a0 <= $b0 && $b0 <= $b1) {
            return [$a0, $b0];
        }

        if ($a1 >= $a0 && $a1 <= $b1 && $b1 <= $b0) {
            return [$a1, $b1];
        }

        if ($a0 < $a1) {
            return false;
        }

        if ($a0 > $b1) {
            return false;
        }

        if ($b1 > $b0) {
            return false;
        }

        return [$a0, $b1];
    }
}
