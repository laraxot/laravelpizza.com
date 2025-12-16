<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Illuminate\Support\Collection;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\DataTransferObjects\LocationDTO;

/**
 * Classe per raggruppare le posizioni in cluster.
 */
class ClusterLocationsAction
{
    /**
     * Raggruppa le posizioni in cluster in base alla distanza.
     *
     * @param Collection<int, LocationData|LocationDTO> $locations   Lista di posizioni da raggruppare
     * @param float                                     $maxDistance Distanza massima in metri tra i punti di un cluster
     *
     * @return Collection<int, Collection<int, LocationData>> Collezione di cluster di posizioni
     */
    public function execute(Collection $locations, float $maxDistance): Collection
    {
        if ($locations->isEmpty()) {
            return collect();
        }

        /** @var Collection<int, Collection<int, LocationData>> $clusters */
        $clusters = collect([collect([$this->toLocationData($locations->first())])]);

        $locations->skip(1)->each(function ($location) use ($clusters, $maxDistance): void {
            $locationData = $this->toLocationData($location);
            $added = false;

            foreach ($clusters as $cluster) {
                $center = $this->calculateClusterCenter($cluster);
                $distance = $this->calculateDistance($center, $locationData);

                if ($distance <= $maxDistance) {
                    $cluster->push($locationData);
                    $added = true;
                    break;
                }
            }

            if (! $added) {
                /** @var Collection<int, LocationData> $newCluster */
                $newCluster = collect([$locationData]);
                $clusters->push($newCluster);
            }
        });

        return $clusters;
    }

    /**
     * @param Collection<int, LocationData> $cluster
     */
    private function calculateClusterCenter(Collection $cluster): LocationData
    {
        /** @var float $avgLat */
        $avgLat = $cluster->avg(fn (LocationData $location): float => $location->latitude);
        /** @var float $avgLng */
        $avgLng = $cluster->avg(fn (LocationData $location): float => $location->longitude);

        return new LocationData(
            latitude: $avgLat,
            longitude: $avgLng
        );
    }

    private function calculateDistance(LocationData $location1, LocationData $location2): float
    {
        $earthRadius = 6371000; // raggio della Terra in metri

        $lat1 = deg2rad($location1->latitude);
        $lat2 = deg2rad($location2->latitude);
        $lng1 = deg2rad($location1->longitude);
        $lng2 = deg2rad($location2->longitude);

        $latDelta = $lat2 - $lat1;
        $lngDelta = $lng2 - $lng1;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($lat1) * cos($lat2) *
            sin($lngDelta / 2) * sin($lngDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    private function toLocationData(LocationData|LocationDTO $location): LocationData
    {
        if ($location instanceof LocationDTO) {
            return new LocationData(
                latitude: $location->latitude,
                longitude: $location->longitude
            );
        }

        return $location;
    }
}
