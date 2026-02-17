<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Modules\Geo\Datas\LocationData;

/**
 * Action per filtrare le coordinate geografiche all'interno di un raggio specificato.
 *
 * Questa action prende un punto centrale (latitudine e longitudine) e un array di coordinate,
 * e restituisce solo le coordinate che si trovano entro il raggio specificato dal punto centrale.
 *
 * @param  float  $centerLatitude  La latitudine del punto centrale
 * @param  float  $centerLongitude  La longitudine del punto centrale
 * @param  array<array{latitude: string, longitude: string}>  $coordinates  Array di coordinate da filtrare
 * @param  int  $radius  Raggio in metri entro cui filtrare le coordinate
 * @return array<array{latitude: string, longitude: string}> Le coordinate filtrate
 */
readonly class FilterCoordinatesInRadiusAction
{
    public function __construct(
        private CalculateDistanceAction $calculateDistanceAction,
    ) {}

    /**
     * @param  array<array{latitude: string, longitude: string}>  $coordinates
     * @return array<array{latitude: string, longitude: string}>
     */
    public function execute(float $centerLatitude, float $centerLongitude, array $coordinates, int $radius): array
    {
        $centerLocation = new LocationData(
            latitude: $centerLatitude,
            longitude: $centerLongitude,
            address: null,
        );

        return array_filter($coordinates, function (array $coordinate) use ($centerLocation, $radius): bool {
            $targetLocation = new LocationData(
                latitude: (float) $coordinate['latitude'],
                longitude: (float) $coordinate['longitude'],
                address: null,
            );

            $distance = $this->calculateDistanceAction->execute($centerLocation, $targetLocation)['distance']['value'];

            return $distance <= $radius;
        });
    }
}
