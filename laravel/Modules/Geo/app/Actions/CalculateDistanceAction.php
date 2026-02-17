<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Illuminate\Support\Collection;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Contracts\CalculateDistanceActionContract;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\DistanceCalculationException;

/**
 * Classe per calcolare la distanza tra due punti geografici.
 *
 * Questa classe utilizza il servizio Google Maps Distance Matrix per calcolare:
 * - La distanza effettiva tra due punti considerando le strade
 * - Il tempo di percorrenza stimato
 * - Lo stato della richiesta
 *
 * @see https://developers.google.com/maps/documentation/distance-matrix
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
final class CalculateDistanceAction implements CalculateDistanceActionContract
{
    /**
     * @param  CalculateDistanceMatrixAction  $distanceMatrixAction  Servizio per il calcolo delle distanze
     */
    public function __construct(
        private readonly CalculateDistanceMatrixAction $distanceMatrixAction,
    ) {}

    /**
     * Calcola la distanza e il tempo di percorrenza tra due punti.
     *
     * @param  LocationData  $origin  Punto di origine con coordinate valide
     * @param  LocationData  $destination  Punto di destinazione con coordinate valide
     * @return array{
     *     distance: array{text: string, value: int},
     *     duration: array{text: string, value: int},
     *     status: string
     * } Array con distanza, durata e stato
     *
     * @throws DistanceCalculationException Se il calcolo della distanza fallisce o restituisce dati non validi
     * @throws \InvalidArgumentException Se le coordinate non sono valide
     */
    public function execute(LocationData $origin, LocationData $destination): array
    {
        $this->validateCoordinates($origin);
        $this->validateCoordinates($destination);

        try {
            $response = $this->distanceMatrixAction->execute(
                new Collection([$origin]),
                new Collection([$destination])
            );

            if (! isset($response[0][0])) {
                throw DistanceCalculationException::invalidResponse();
            }

            // PHPStan needs assurance or the structure implies it?
            // The previous check was: empty($response) || empty($response[0]) || empty($response[0][0])
            // isset checks definition and null.

            return $response[0][0];
        } catch (\Throwable $e) {
            throw DistanceCalculationException::calculationError('Errore nel calcolo della distanza: '.$e->getMessage(), $e);
        }
    }

    /**
     * Formatta la distanza in metri in una stringa leggibile.
     *
     * @param  int  $meters  Distanza in metri
     *
     * @throws \InvalidArgumentException Se il valore in metri è negativo
     */
    public function formatDistance(int $meters): string
    {
        if ($meters < 0) {
            throw new \InvalidArgumentException('La distanza non può essere negativa');
        }

        if ($meters < 1000) {
            return sprintf('%d m', $meters);
        }

        $kilometers = round($meters / 1000, 1);

        return sprintf('%.1f km', $kilometers);
    }

    /**
     * Valida le coordinate di una posizione.
     *
     * @param  LocationData  $location  Posizione da validare
     *
     * @throws \InvalidArgumentException Se le coordinate non sono valide
     */
    private function validateCoordinates(LocationData $location): void
    {
        if ($location->latitude < -90 || $location->latitude > 90) {
            throw new \InvalidArgumentException(sprintf('Latitudine non valida: %f', $location->latitude));
        }

        if ($location->longitude < -180 || $location->longitude > 180) {
            throw new \InvalidArgumentException(sprintf('Longitudine non valida: %f', $location->longitude));
        }
    }
}
