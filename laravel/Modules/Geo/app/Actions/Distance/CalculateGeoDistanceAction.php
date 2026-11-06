<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Distance;

use Spatie\QueueableAction\QueueableAction;

/**
 * Distanza haversine tra due coordinate (statute miles / km / nautical).
 *
 * Sostituisce GeoService::distance().
 */
final class CalculateGeoDistanceAction
{
    use QueueableAction;

    public function execute(
        ?float $lat1,
        ?float $lon1,
        ?float $lat2,
        ?float $lon2,
        ?string $unit,
    ): ?float {
        if ($lat1 === $lat2 && $lon1 === $lon2) {
            return 0.0;
        }
        if (null === $lat1 || null === $lon1 || null === $lat2 || null === $lon2) {
            return null;
        }

        $theta = $lon1 - $lon2;
        $dist = (sin(deg2rad($lat1)) * sin(deg2rad($lat2)))
            + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        $unit = strtoupper($unit ?? 'K');

        return match ($unit) {
            'K' => $miles * 1.609344,
            'N' => $miles * 0.8684,
            default => $miles,
        };
    }
}
