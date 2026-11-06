<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Math;

use Spatie\QueueableAction\QueueableAction;

class IsPointInPolygonAction
{
    use QueueableAction;

    /**
     * @param array<mixed> $polygon
     */
    public function execute(float $latitude, float $longitude, array $polygon): bool
    {
        $c = false;
        $points_polygon = \count($polygon) - 1;

        for ($i = 0, $j = $points_polygon; $i < $points_polygon; $j = $i++) {
            if (! is_array($polygon[$i]) || ! is_array($polygon[$j])) {
                continue;
            }

            $pointI = (object) $polygon[$i];
            $pointJ = (object) $polygon[$j];

            if (! isset($pointI->lat, $pointI->lng, $pointJ->lat, $pointJ->lng)) {
                continue;
            }

            $latI = is_float($pointI->lat) || is_int($pointI->lat) ? (float) $pointI->lat : 0.0;
            $lngI = is_float($pointI->lng) || is_int($pointI->lng) ? (float) $pointI->lng : 0.0;
            $latJ = is_float($pointJ->lat) || is_int($pointJ->lat) ? (float) $pointJ->lat : 0.0;
            $lngJ = is_float($pointJ->lng) || is_int($pointJ->lng) ? (float) $pointJ->lng : 0.0;

            if (
                ($latI > $latitude) !== ($latJ > $latitude)
                && $longitude <
                (($lngJ - $lngI) * ($latitude - $latI) /
                            ($latJ - $latI)) +
                    $lngI
            ) {
                $c = ! $c;
            }
        }

        return $c;
    }
}
