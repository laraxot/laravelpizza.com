<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

<<<<<<< HEAD
=======
use Spatie\QueueableAction\QueueableAction;

>>>>>>> 40b96bcd6 (.)
/**
 * Service per geocoding e reverse geocoding.
 */
class GeocodingService
{
<<<<<<< HEAD
=======
    use QueueableAction;

>>>>>>> 40b96bcd6 (.)
    /**
     * Geocodifica un indirizzo.
     *
     * @throws \RuntimeException Se l'indirizzo non viene trovato
     *
     * @return array{latitude: float, longitude: float, address: string}
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
=======

    public function execute(): void
    {
    }
>>>>>>> 40b96bcd6 (.)
}
