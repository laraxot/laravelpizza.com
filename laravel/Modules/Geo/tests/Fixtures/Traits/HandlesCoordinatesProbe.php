<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Traits\HandlesCoordinates;

/**
 * Espone i metodi protetti di HandlesCoordinates per i test unitari (ray-casting / Haversine helper).
 */
final class HandlesCoordinatesProbe
{
    use HandlesCoordinates;

    public function exposesAreValidCoordinates(?float $latitude, ?float $longitude): bool
    {
        return $this->areValidCoordinates($latitude, $longitude);
    }

    public function exposesCalculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        return $this->calculateDistance($lat1, $lon1, $lat2, $lon2);
    }

    public function exposesFormatCoordinates(float $latitude, float $longitude, int $decimals = 6): string
    {
        return $this->formatCoordinates($latitude, $longitude, $decimals);
    }
}
