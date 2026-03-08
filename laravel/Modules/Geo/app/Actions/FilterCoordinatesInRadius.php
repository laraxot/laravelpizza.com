<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

class FilterCoordinatesInRadius
{
    // filtra Coordinate In Raggio
    public function execute(float $latPartenza, float $lonPartenza, array $coordinateArray, int $raggio): array
    {
        $coordinateInRaggio = [];

        foreach ($coordinateArray as $coordinate) {
            if (! is_array($coordinate)) {
                continue; // Skip non-array elements
            }

            $lat = $coordinate['latitude'] ?? null;
            $lon = $coordinate['longitude'] ?? null;

            if (! is_string($lat) || ! is_string($lon)) {
                continue; // Skip if coordinates are not strings
            }

            $distanza = $this->calcolaDistanzaGeografica($latPartenza, $lonPartenza, $lat, $lon);

            if ($distanza >= $raggio) {
                $coordinateInRaggio[] = $coordinate;
            }
        }

        return $coordinateInRaggio;
    }

    public function calcolaDistanzaGeografica(float $lat1, float $lon1, string $lat2, string $lon2): float
    {
        // Raggio della Terra in chilometri
        $raggioTerra = 6371;

        // Conversione delle latitudini e longitudini da gradi a radianti
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad((float) $lat2);
        $lon2 = deg2rad((float) $lon2);

        // Differenza tra le coordinate
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        // Applicazione della formula dell'Haversine
        $a = (sin($dLat / 2) * sin($dLat / 2)) + (cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2));
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Calcolo della distanza
        return $raggioTerra * $c; // Distanza in chilometri
    }
}

// // Raggio in chilometri
// $raggio = 10; // 10 km

// // Filtra le coordinate all'interno del raggio
// $coordinateInRaggio = filtraCoordinateInRaggio($latPartenza, $lonPartenza, $coordinateArray, $raggio);

// print_r($coordinateInRaggio);
