<?php

declare(strict_types=1);

namespace Modules\Geo\Transformers;

/*
 *  GEOJSON e' uno standard
 * https://it.wikipedia.org/wiki/GeoJSON
 */
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class GeoJsonCollection.
 */
class GeoJsonCollection extends ResourceCollection
{
    /**
     * Undocumented variable.
     *
     * @var string
     */
    public $collects = GeoJsonResource::class;

    public function toArray(Request $request): array
    {
        return [
            'type' => 'FeatureCollection',
            'features' => $this->collection,
            /*'links' => [
             * 'self' => 'link-value',
             * ],*/
        ];
    }
}
