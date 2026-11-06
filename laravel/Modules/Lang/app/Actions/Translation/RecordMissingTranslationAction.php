<?php

declare(strict_types=1);

namespace Modules\Lang\Actions\Translation;

use Modules\Lang\Models\Translation;
use Spatie\QueueableAction\QueueableAction;

/**
 * Records a missing translation key in the database (translation-manager pattern).
 *
 * This is the domain business logic previously inlined in the translator adapter's
 * notifyMissingKey(). The translator adapter (Modules\Lang\Adapters\TranslatorAdapter)
 * delegates to it so the framework-bound singleton stays thin.
 */
class RecordMissingTranslationAction
{
    use QueueableAction;

    public function execute(string $key, string $locale): void
    {
        [$namespace, $group, $item] = $this->parseKey($key);

        Translation::firstOrCreate([
            'lang' => $locale,
            'namespace' => $namespace,
            'group' => $group,
            'item' => $item,
        ]);
    }

    /**
     * @return array{0: string, 1: string|null, 2: string|null}
     */
    private function parseKey(string $key): array
    {
        if (str_contains($key, '::')) {
            [$namespace, $key] = explode('::', $key, 2);
            [$group, $item] = str_contains($key, '.')
                ? explode('.', $key, 2)
                : [$key, null];
        } else {
            [$group, $item] = str_contains($key, '.')
                ? explode('.', $key, 2)
                : [$key, null];
            $namespace = '*';
        }

        return [$namespace, $group, $item];
    }
}
