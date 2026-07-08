<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

class GetBoundingBoxAction
{
    /**
     * @return array{min_lat: float, max_lat: float, min_lon: float, max_lon: float}
     */
    public function execute(float $latitude, float $longitude, float $distanceKm): array
    {
        $earthRadius = 6371; // km

        $maxLat = $latitude + rad2deg($distanceKm / $earthRadius);
        $minLat = $latitude - rad2deg($distanceKm / $earthRadius);

        $maxLon = $longitude + rad2deg($distanceKm / $earthRadius / cos(deg2rad($latitude)));
        $minLon = $longitude - rad2deg($distanceKm / $earthRadius / cos(deg2rad($latitude)));

        return [
            'min_lat' => $minLat,
            'max_lat' => $maxLat,
            'min_lon' => $minLon,
            'max_lon' => $maxLon,
        ];
    }
}
