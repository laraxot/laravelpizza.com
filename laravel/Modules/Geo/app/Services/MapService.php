<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Spatie\QueueableAction\QueueableAction;

/**
 * Service per la gestione dei marker e delle statistiche della mappa.
 */
class MapService
{
    use QueueableAction;

    /**
     * Ottiene i marker in base ai filtri.
     *
<<<<<<< HEAD
     * @param  array<string, mixed>  $filters
=======
     * @param array<string, mixed> $filters
     *
>>>>>>> laraxot/dev
     * @return array<int, array<string, mixed>>
     */
    public function getMarkers(array $filters = []): array
    {
        return [];
    }

    /**
     * Ottiene le statistiche della mappa.
     *
<<<<<<< HEAD
     * @param  array<string, mixed>  $filters
=======
     * @param array<string, mixed> $filters
     *
>>>>>>> laraxot/dev
     * @return array<string, mixed>
     */
    public function getMapStats(array $filters = []): array
    {
        return [];
    }

    /**
     * Esporta i dati della mappa nel formato specificato.
     *
<<<<<<< HEAD
     * @param  array<string, mixed>  $filters
=======
     * @param array<string, mixed> $filters
     *
>>>>>>> laraxot/dev
     * @return array<string, mixed>|string
     */
    public function exportData(array $filters = [], string $format = 'json'): array|string
    {
        return [];
    }

<<<<<<< HEAD
    public function execute(): void {}
=======
    public function execute(): void
    {
    }
>>>>>>> laraxot/dev
}
