<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Modules\Activity\Datas\FilteredLogEntriesData;
use Modules\Activity\Datas\LogEntryData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Filtra le voci di un log per livello e per testo (senza distinguere maiuscole/minuscole) e le
 * restituisce dalla piu' recente alla piu' vecchia, limitate a un massimo per non appesantire la pagina.
 */
class FilterLogEntriesAction
{
    use QueueableAction;

    // ponytail: massimo 200 voci mostrate per volta, nessuna paginazione;
    // se serve scorrere oltre, aggiungere paginazione per offset sulle voci filtrate.
    public const int DEFAULT_LIMIT = 200;

    /**
     * @param  list<LogEntryData>  $entries  voci in ordine di file (dalla piu' vecchia alla piu' recente)
     */
    public function execute(array $entries, string $level = '', string $search = '', int $limit = self::DEFAULT_LIMIT): FilteredLogEntriesData
    {
        $level = mb_strtoupper(trim($level));
        $search = trim($search);

        $matched = [];
        foreach ($entries as $entry) {
            if ($level !== '' && $entry->level !== $level) {
                continue;
            }

            if ($search !== '' && mb_stripos($entry->body, $search) === false) {
                continue;
            }

            $matched[] = $entry;
        }

        $matched = array_reverse($matched);

        return new FilteredLogEntriesData(
            entries: array_slice($matched, 0, max(1, $limit)),
            total: count($matched),
        );
    }
}
