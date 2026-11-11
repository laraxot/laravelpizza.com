<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Maps;

use Spatie\QueueableAction\QueueableAction;

class GetGeoMapDatasetCategoriesAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(string $path): array
    {
        $features = app(LoadGeoMapDatasetAction::class)->loadFeatures($path);
        $categories = [];

        foreach ($features as $feature) {
            if ($feature['geometry']['type'] !== 'Point') {
                continue;
            }

            $category = $feature['properties']['p'] ?? $feature['properties']['category'] ?? null;

            if (is_string($category) && $category !== '') {
                $categories[] = $category;
            }
        }

        $categories = array_values(array_unique($categories));
        sort($categories);

        return $categories;
    }
}
