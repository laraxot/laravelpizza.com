<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\InvalidLocationException;

readonly class ClusterLocationsAction
{
    public function __construct(
        private CalculateDistanceAction $distanceCalculator,
    ) {}

    /**
     * Raggruppa le posizioni in cluster basati sulla distanza.
     *
     * @param  array<LocationData>  $locations  Lista delle posizioni da raggruppare
     * @param  float  $maxDistance  Distanza massima in km tra i punti di un cluster
     * @return array<array{center: LocationData, points: array<LocationData>}>
     *
     * @throws InvalidLocationException Se i dati della posizione non sono validi
     */
    public function execute(array $locations, float $maxDistance = 1.0): array
    {
        $clusters = [];

        foreach ($locations as $location) {
            if (! ($location instanceof LocationData)) {
                throw InvalidLocationException::invalidData();
            }

            $assigned = false;

            foreach ($clusters as &$cluster) {
                $distance = $this->distanceCalculator->execute($cluster['center'], $location);
                $distanceKm = ((float) $distance['distance']['value']) / 1000;

                if ($distanceKm <= $maxDistance) {
                    $cluster['points'][] = $location;
                    $this->updateClusterCenter($cluster);
                    $assigned = true;
                    break;
                }
            }

            if (! $assigned) {
                $clusters[] = [
                    'center' => $location,
                    'points' => [$location],
                ];
            }
        }

        return $clusters;
    }

    /**
     * Aggiorna il centro del cluster calcolando la media delle coordinate.
     *
     * @param  array{center: LocationData, points: array<LocationData>}  $cluster
     */
    private function updateClusterCenter(array &$cluster): void
    {
        $latSum = array_sum(array_map(fn (LocationData $point) => $point->latitude, $cluster['points']));

        $lonSum = array_sum(array_map(fn (LocationData $point) => $point->longitude, $cluster['points']));

        $count = count($cluster['points']);

        $cluster['center'] = new LocationData(
            latitude: $latSum / $count,
            longitude: $lonSum / $count,
        );
    }
}
