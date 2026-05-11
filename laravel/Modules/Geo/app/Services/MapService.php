<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

/**
 * Service per la gestione dei marker e delle statistiche della mappa.
 */
class MapService
{
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
}
