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

            if ($geometryType === 'Point') {
                $points++;
            }

            if ($geometryType === 'Polygon' || $geometryType === 'MultiPolygon') {
                $zones++;
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
