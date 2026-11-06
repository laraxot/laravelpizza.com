<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Map;

use Spatie\QueueableAction\QueueableAction;

/**
 * Export dati mappa (stub).
 *
 * Sostituisce MapService::exportData().
 */
final class ExportMapDataAction
{
    use QueueableAction;

    public const string FORMAT_JSON = 'json';

    public const string FORMAT_CSV = 'csv';

    public const string FORMAT_GEOJSON = 'geojson';

    public const string FORMAT_KML = 'kml';

    /**
     * @param array<string, mixed> $filters
     */
    public function execute(array $filters = [], string $format = 'json'): string
    {
        return match ($format) {
            self::FORMAT_CSV => '',
            self::FORMAT_GEOJSON => '{"type":"FeatureCollection","features":[]}',
            self::FORMAT_KML => '<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2"></kml>',
            default => '[]',
        };
    }
}
