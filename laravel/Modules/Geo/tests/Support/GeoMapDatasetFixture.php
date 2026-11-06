<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Support;

/**
 * Path al GeoJSON di fixture del widget mappa.
 * Classe (non function globale) per evitare redeclare / bootstrap Pest ambiguo.
 */
final class GeoMapDatasetFixture
{
    public static function path(): string
    {
        return dirname(__DIR__, 2).'/resources/data/geo-map-widget.geojson';
    }
}
