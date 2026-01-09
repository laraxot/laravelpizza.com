<?php

declare(strict_types=1);

namespace Modules\Geo\Traits;

/**
 * Trait per la gestione delle coordinate geografiche.
 */
trait HandlesCoordinates
{
    /**
     * Valida le coordinate geografiche.
     *
     * @param float|null $latitude  La latitudine da validare
     * @param float|null $longitude La longitudine da validare
     */
    protected function areValidCoordinates(?float $latitude, ?float $longitude): bool
    {
        return $latitude !== null
            && $longitude !== null
            && $latitude >= -90
            && $latitude <= 90
            && $longitude >= -180
            && $longitude <= 180;
    }

    /**
     * Calcola la distanza tra due punti in chilometri.
     *
     * @param float $lat1 Latitudine del primo punto
     * @param float $lon1 Longitudine del primo punto
     * @param float $lat2 Latitudine del secondo punto
     * @param float $lon2 Longitudine del secondo punto
     */
    protected function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // Raggio della Terra in km

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a =
            (sin($latDelta / 2) * sin($latDelta / 2)) +
            (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lonDelta / 2) * sin($lonDelta / 2));

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Formatta le coordinate in una stringa leggibile.
     *
     * @param float $latitude  La latitudine da formattare
     * @param float $longitude La longitudine da formattare
     * @param int   $decimals  Il numero di decimali da mostrare
     */
    protected function formatCoordinates(float $latitude, float $longitude, int $decimals = 6): string
    {
        return sprintf('%s, %s', number_format($latitude, $decimals), number_format($longitude, $decimals));
    }
}
