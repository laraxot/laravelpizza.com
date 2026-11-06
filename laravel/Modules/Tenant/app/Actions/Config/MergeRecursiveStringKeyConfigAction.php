<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Spatie\QueueableAction\QueueableAction;

final class MergeRecursiveStringKeyConfigAction
{
    use QueueableAction;

    /**
     * Accetta array con chiavi di qualunque tipo: scartare quelle non stringa è
     * il compito dell'action, non una precondizione del chiamante.
     *
     * @param  array<array-key, mixed>  ...$configs
     * @return array<string, mixed>
     */
    public function execute(array ...$configs): array
    {
        /** @var array<string, mixed> $merged */
        $merged = [];

        foreach ($configs as $config) {
            /** @var array<string, mixed> $merged */
            $merged = array_replace_recursive(
                $merged,
                app(FilterConfigStringKeysAction::class)->execute($config),
            );
        }

        /** @var array<string, mixed> $filtered */
        $filtered = app(FilterConfigStringKeysAction::class)->execute($merged);

        return $filtered;
    }
}
