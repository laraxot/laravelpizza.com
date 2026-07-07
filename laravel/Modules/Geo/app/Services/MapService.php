<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

<<<<<<< HEAD
=======
use Spatie\QueueableAction\QueueableAction;

>>>>>>> 40b96bcd6 (.)
/**
 * Service per la gestione dei marker e delle statistiche della mappa.
 */
class MapService
{
<<<<<<< HEAD
=======
    use QueueableAction;

>>>>>>> 40b96bcd6 (.)
    /**
     * Ottiene i marker in base ai filtri.
     *
     * @param array<string, mixed> $filters
     *
     * @return array<int, array<string, mixed>>
     */
    public function getMarkers(array $filters = []): array
    {
        return [];
    }

    /**
     * Ottiene le statistiche della mappa.
     *
     * @param array<string, mixed> $filters
     *
     * @return array<string, mixed>
     */
    public function getMapStats(array $filters = []): array
    {
        return [];
    }

    /**
     * Esporta i dati della mappa nel formato specificato.
     *
     * @param array<string, mixed> $filters
     *
     * @return array<string, mixed>|string
     */
    public function exportData(array $filters = [], string $format = 'json'): array|string
    {
        return [];
    }
<<<<<<< HEAD
=======

    public function execute(): void
    {
    }
>>>>>>> 40b96bcd6 (.)
}
