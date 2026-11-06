<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Cast;

use Spatie\QueueableAction\QueueableAction;

final class CastScalarToNullableStringAction
{
    use QueueableAction;

    public function execute(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return is_scalar($value) ? (string) $value : null;
    }
}
