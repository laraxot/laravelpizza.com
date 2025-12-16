<?php

declare(strict_types=1);

namespace Modules\Geo\Contracts;

interface GeocodingServiceInterface
{
    /**
     * Get coordinates from address.
     *
     * @return array{latitude: float, longitude: float}|null
     */
    public function getCoordinates(string $address): ?array;
}
