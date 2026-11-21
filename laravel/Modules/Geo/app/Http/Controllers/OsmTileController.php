<?php

declare(strict_types=1);

namespace Modules\Geo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Geo\Actions\Osm\FetchOsmTileAction;

/**
 * GET /api/geo/tiles/osm/{z}/{x}/{y}.png — tile OpenStreetMap dal nostro dominio (FetchOsmTileAction).
 *
 * Coordinate fuori dalla griglia del livello di zoom: 404, senza chiedere nulla a OSM. La risposta e' cachabile dal
 * browser (`browser_max_age`) e non porta cookie: la rotta sta in `routes/api.php`, senza sessione.
 */
final class OsmTileController
{
    public function __invoke(Request $request, FetchOsmTileAction $fetch, int $z, int $x, int $y): Response
    {
        $maxZoom = config('geo.config.osm_proxy.tiles.max_zoom');
        $maxZoom = is_numeric($maxZoom) ? (int) $maxZoom : 19;
        $size = 2 ** $z;

        abort_if($z < 0 || $z > $maxZoom || $x < 0 || $y < 0 || $x >= $size || $y >= $size, 404);

        $tile = $fetch->execute($z, $x, $y, $request->headers->get('referer'));
        abort_if($tile === null, 502);

        $maxAge = config('geo.config.osm_proxy.tiles.browser_max_age');
        $maxAge = is_numeric($maxAge) ? (int) $maxAge : 86400;
        $headers = ['Content-Type' => 'image/png', 'Cache-Control' => 'public, max-age='.$maxAge];
        if ($tile['etag'] !== null) {
            $headers['ETag'] = $tile['etag'];
            if ($request->headers->get('if-none-match') === $tile['etag']) {
                return new Response('', 304, $headers);
            }
        }
        if ($tile['last_modified'] !== null) {
            $headers['Last-Modified'] = $tile['last_modified'];
        }

        return new Response($tile['body'], 200, $headers);
    }
}
