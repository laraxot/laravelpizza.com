<?php

declare(strict_types=1);

namespace Modules\UI\Services\Map;

use Modules\UI\Contracts\MapServiceContract;

/**
 * Fallback quando il modulo Geo non è installato.
 */
final class NullMapService implements MapServiceContract
{
    /**
     * @param array<string, mixed> $filters
     *
     * @return list<array<string, mixed>>
     */
    public function getMarkers(array $filters): array
    {
        return [];
    }

    /**
     * @param array<string, mixed> $filters
     *
     * @return array<string, mixed>
     */
    public function getMapStats(array $filters): array
    {
        return [];
    }

    /**
     * @param array<string, mixed> $filters
     */
    public function exportData(array $filters, string $format): string
    {
        return match ($format) {
            'csv' => '',
            'geojson' => '{"type":"FeatureCollection","features":[]}',
            'kml' => '<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2"></kml>',
            default => '[]',
        };
    }
}
