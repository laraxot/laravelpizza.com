<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Maps;

use Spatie\QueueableAction\QueueableAction;

class GetGeoMapDatasetStatsAction
{
    use QueueableAction;

    /**
     * @return array{total: int, points: int, zones: int, categories: int}
     */
    public function execute(string $path): array
    {
        $features = app(LoadGeoMapDatasetAction::class)->loadFeatures($path);
        $points = 0;
        $zones = 0;

        foreach ($features as $feature) {
            $geometryType = $feature['geometry']['type'];

            if ('Point' === $geometryType) {
                ++$points;
            }

            if ('Polygon' === $geometryType || 'MultiPolygon' === $geometryType) {
                ++$zones;
            }
        }

        return [
            'total' => count($features),
            'points' => $points,
            'zones' => $zones,
            'categories' => count(app(GetGeoMapDatasetCategoriesAction::class)->execute($path)),
        ];
    }
}
