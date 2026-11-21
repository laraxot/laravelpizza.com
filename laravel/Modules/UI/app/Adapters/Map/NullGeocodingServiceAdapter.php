<?php

declare(strict_types=1);

namespace Modules\UI\Adapters\Map;

use Modules\UI\Contracts\GeocodingServiceContract;

/**
 * Fallback quando il modulo Geo non è installato.
 */
final class NullGeocodingServiceAdapter implements GeocodingServiceContract
{
    /**
     * @return array<string, mixed>
     */
    public function geocodeAddress(string $address): array
    {
        throw new \RuntimeException('Geocoding non disponibile: modulo Geo assente.');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getSuggestions(string $query): array
    {
        return [];
    }
}
