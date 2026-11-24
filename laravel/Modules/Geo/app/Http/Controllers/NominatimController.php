<?php

declare(strict_types=1);

namespace Modules\Geo\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Geo\Actions\Osm\QueryNominatimAction;

/**
 * GET /api/geo/nominatim/{search|reverse} — Nominatim passando dal nostro server (QueryNominatimAction).
 *
 * La lingua dei risultati e' quella della pagina (`Accept-Language` del browser o parametro `accept-language`).
 */
final class NominatimController
{
    public function __invoke(Request $request, QueryNominatimAction $query, string $endpoint): JsonResponse
    {
        /** @var 'search'|'reverse' $endpoint */
        $language = $request->query('accept-language');
        $language = is_string($language) && $language !== '' ? $language : (string) $request->getPreferredLanguage();

        /** @var array<string, mixed> $input */
        $input = $request->query();
        $result = $query->execute($endpoint, $input, $language);

        return new JsonResponse($result['data'], $result['status'], $result['status'] === 200 ? ['Cache-Control' => 'public, max-age=3600'] : []);
    }
}
