<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Cast;

use Spatie\QueueableAction\QueueableAction;

final class CastScalarToStringListAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter(array_map(
            static fn (mixed $tag): string => is_scalar($tag) ? (string) $tag : '',
            $value
        ), static fn (string $tag): bool => $tag !== ''));
    }
}
