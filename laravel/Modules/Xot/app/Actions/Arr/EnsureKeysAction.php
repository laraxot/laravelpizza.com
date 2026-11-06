<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Arr;

use Spatie\QueueableAction\QueueableAction;

/**
 * Allinea ogni riga alle chiavi attese dallo schema: le mancanti diventano null,
 * le presenti vengono conservate. Serve a mantenere il file JSON coerente con lo
 * schema del modello anche quando una riga salvata in precedenza e' incompleta.
 */
class EnsureKeysAction
{
    use QueueableAction;

    /**
     * @param  array<int|string, array<string, mixed>|mixed>  $data
     * @param  array<int|string, string|int>  $keys
     * @return array<int|string, array<string, mixed>>
     */
    public function execute(array $data, array $keys): array
    {
        // Convert keys to strings and create template
        /** @var array<string, mixed> $template */
        $template = array_fill_keys(array_map('strval', $keys), null);

        $result = [];
        foreach ($data as $k => $item) {
            if (is_array($item)) {
                /** @var array<string, mixed> $merged */
                $merged = array_replace($template, $item);
                $result[$k] = $merged;
            }
        }

        return $result;
    }
}
