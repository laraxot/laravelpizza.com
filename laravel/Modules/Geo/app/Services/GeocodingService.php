<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Spatie\QueueableAction\QueueableAction;

/**
 * Service per geocoding e reverse geocoding.
 */
class GeocodingService
{
    use QueueableAction;

    /**
     * Geocodifica un indirizzo.
     *
<<<<<<< HEAD
     *
     * @return array{latitude: float, longitude: float, address: string}
     *
     * @throws \RuntimeException Se l'indirizzo non viene trovato
=======
     * @throws \RuntimeException Se l'indirizzo non viene trovato
     *
     * @return array{latitude: float, longitude: float, address: string}
>>>>>>> laraxot/dev
     */
    public function geocodeAddress(string $address): array
    {
        throw new \RuntimeException('Geocoding non ancora implementato');
    }

    /**
     * Ottiene suggerimenti per la ricerca.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSuggestions(string $query): array
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
