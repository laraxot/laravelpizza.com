<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Math;

use Spatie\QueueableAction\QueueableAction;

class CalculateGeoDistanceAction
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
        $dist =
            (sin(deg2rad($lat1)) * sin(deg2rad($lat2)))
            + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        if (null === $unit) {
            $unit = 'K';
        }
        $unit = strtoupper($unit);

        return match ($unit) {
            'K' => $miles * 1.609344,
            'N' => $miles * 0.8684,
            default => $miles,
        };
    }
}
