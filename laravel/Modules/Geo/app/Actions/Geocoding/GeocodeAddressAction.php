<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Geocoding;

use Spatie\QueueableAction\QueueableAction;

/**
 * Geocodifica indirizzo testuale (stub).
 *
 * Sostituisce GeocodingService::geocodeAddress().
 */
final class GeocodeAddressAction
{
    use QueueableAction;

    /**
     * @return array{latitude: float, longitude: float, address: string}
     */
    public function execute(string $address): array
    {
        throw new \RuntimeException('Geocoding non ancora implementato');
    }
}
