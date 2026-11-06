<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Spatie\QueueableAction\QueueableAction;

/**
 * Action per fondere file di traduzione multipli in una singola struttura.
 * Utile per consolidare traduzioni da fonti diverse (es. override regionali).
 */
class MergeTranslationsAction
{
    use QueueableAction;

    /**
     * Fonde key/value pairs da file di traduzione multipli in una singola struttura.
     * Sovrascrive chiavi esistenti con valori da file successivi (principio LIFO).
     *
     * @param array<array<string, string>> $translationFiles Array di file di traduzione, dove ogni file è un array associativo (key => value)
     *
     * @return array<string, mixed> Struttura fusa e consolidata delle traduzioni
     */
    public function execute(array $translationFiles): array
    {
        $merged = [];
        foreach ($translationFiles as $file) {
            $merged = array_merge($merged, $file);
        }

        return $merged;
    }
}
