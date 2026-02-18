<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Support\Arr;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per la traduzione di elementi di una collezione.
 */
class TransArrayAction
{
    use QueueableAction;

    public ?string $transKey;

    /**
     * Esegue la traduzione di una collezione.
     *
     * @return array<int|string, string>
     */
    public function execute(array $array, ?string $transKey): array
    {
        if ($transKey === null) {
            $result = Arr::map($array, SafeStringCastAction::cast(...));
            if (is_array($result)) {
                $stringResult = [];
                foreach ($result as $key => $value) {
                    $stringResult[$key] = (string) $value;
                }

                return $stringResult;
            }

            return [];
        }

        $this->transKey = $transKey;

        $result = Arr::map($array, $this->trans(...));
        if (is_array($result)) {
            $stringResult = [];
            foreach ($result as $key => $value) {
                $stringResult[$key] = (string) $value;
            }

            return $stringResult;
        }

        return [];
    }

    /**
     * Traduce un singolo elemento.
     *
     * @param  mixed  $item  L'elemento da tradurre
     * @return string L'elemento tradotto o l'elemento originale se la traduzione non esiste
     */
    public function trans(mixed $item): string
    {
        // Converte l'item in stringa se non lo è già
        if (! \is_string($item)) {
            $item = SafeStringCastAction::cast($item);
        }

        if (empty($item) || $this->transKey === null) {
            return $item;
        }

        // Prima prova la traduzione diretta
        $key = $this->transKey.'.'.$item.'.label';

        $trans = trans($key);

        // Se la traduzione esiste ed è una stringa, la restituisce
        if ($trans !== $key && \is_string($trans)) {
            return $trans;
        }

        // Seconda prova: sostituisce i punti con underscore
        $itemWithUnderscore = str_replace('.', '_', $item);
        $keyWithUnderscore = $this->transKey.'.'.$itemWithUnderscore;
        $transWithUnderscore = trans($keyWithUnderscore);

        // Se la traduzione con underscore esiste ed è una stringa, la restituisce
        if ($transWithUnderscore !== $keyWithUnderscore && \is_string($transWithUnderscore)) {
            return $transWithUnderscore;
        }

        // Se nessuna traduzione è stata trovata, restituisce l'elemento originale
        return $item;
    }
}
